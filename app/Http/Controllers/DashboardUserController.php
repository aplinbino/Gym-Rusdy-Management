<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_unless($user, 401);

        // Membership aktif hanya jika status dan rentang tanggalnya valid.
        $today = Carbon::today();
        $membershipActive = $user->membership_status === 'active'
            && $user->membership_start
            && $user->membership_end
            && Carbon::parse($user->membership_start)->startOfDay()->lte($today)
            && Carbon::parse($user->membership_end)->endOfDay()->gte($today);

        $membershipDaysLeft = $membershipActive
            ? max(0, $today->diffInDays(Carbon::parse($user->membership_end)->startOfDay(), false))
            : 0;

        $membershipTransaction = DB::table('transaksi')
            ->where('user_id', $user->id)
            ->where('jenis_transaksi', 'membership')
            ->where('status', 'approved')
            ->orderByDesc('tanggal_transaksi')
            ->first();

        $membershipMonths = $membershipTransaction?->membership_months;
        $membershipPlan = $membershipMonths
            ? ($membershipMonths . ' Bulan')
            : null;

        $membershipTotalDays = ($membershipActive && $user->membership_start && $user->membership_end)
            ? max(1, Carbon::parse($user->membership_start)->diffInDays(Carbon::parse($user->membership_end)))
            : 1;
        // Progress menunjukkan masa Membership yang SUDAH berjalan.
        $membershipElapsedDays = ($membershipActive && $user->membership_start)
            ? max(0, Carbon::parse($user->membership_start)->startOfDay()->diffInDays($today))
            : 0;

        $membershipProgress = $membershipActive
            ? max(0, min(100, ($membershipElapsedDays / $membershipTotalDays) * 100))
            : 0;

        // Prioritaskan PT yang dipilih pada profil member.
        $trainer = null;
        if ($user->current_pt_id) {
            $trainer = DB::table('pt')
                ->join('users', 'users.id', '=', 'pt.user_id')
                ->where('pt.id', $user->current_pt_id)
                ->where('pt.status', 'active')
                ->select('pt.*', 'users.name as account_name')
                ->first();
        }

        // Jika current_pt_id belum diisi, ambil PT dari transaksi PT terakhir yang approved.
        if (!$trainer) {
            $trainer = DB::table('pt')
                ->join('users', 'users.id', '=', 'pt.user_id')
                ->join('transaksi', 'transaksi.pt_id', '=', 'pt.id')
                ->where('transaksi.user_id', $user->id)
                ->where('transaksi.jenis_transaksi', 'pt_session')
                ->where('transaksi.status', 'approved')
                ->where('pt.status', 'active')
                ->orderByDesc('transaksi.tanggal_transaksi')
                ->select('pt.*', 'users.name as account_name')
                ->first();
        }

        // Sesi PT yang dibeli melalui transaksi approved.
        $totalSessions = (int) DB::table('transaksi')
            ->where('user_id', $user->id)
            ->where('jenis_transaksi', 'pt_session')
            ->where('status', 'approved')
            ->sum('jumlah_sesi');

        // Sesi completed mengurangi sisa sesi.
        $completedSessions = (int) DB::table('schedule_latihan')
            ->where('user_id', $user->id)
            ->whereNotNull('transaksi_id')
            ->where('status', 'completed')
            ->count();

        $remainingSessions = max(0, $totalSessions - $completedSessions);

        $schedules = DB::table('schedule_latihan')
            ->leftJoin('pt', 'pt.id', '=', 'schedule_latihan.pt_id')
            ->leftJoin('users as pt_users', 'pt_users.id', '=', 'pt.user_id')
            ->where('schedule_latihan.user_id', $user->id)
            ->orderBy('schedule_latihan.tanggal')
            ->orderBy('schedule_latihan.jam')
            ->select(
                'schedule_latihan.*',
                'pt.pt_name',
                'pt_users.name as trainer_account_name'
            )
            ->get();

        $recentActivities = DB::table('schedule_latihan')
            ->leftJoin('pt', 'pt.id', '=', 'schedule_latihan.pt_id')
            ->where('schedule_latihan.user_id', $user->id)
            ->whereIn('schedule_latihan.status', ['completed'])
            ->orderByDesc('schedule_latihan.tanggal')
            ->orderByDesc('schedule_latihan.jam')
            ->limit(5)
            ->select('schedule_latihan.*', 'pt.pt_name')
            ->get();

        // PT yang sudah pernah diberi ulasan oleh member ini.
        $reviewedPtIds = DB::table('reviews')
            ->where('user_id', $user->id)
            ->where('target_type', 'pt')
            ->pluck('target_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        // Riwayat transaksi member (Membership dan sesi PT).
        $transactions = DB::table('transaksi')
            ->leftJoin('pt', 'pt.id', '=', 'transaksi.pt_id')
            ->where('transaksi.user_id', $user->id)
            ->orderByDesc('transaksi.tanggal_transaksi')
            ->orderByDesc('transaksi.id')
            ->limit(10)
            ->select('transaksi.*', 'pt.pt_name')
            ->get();

        return view('user.dashboard_user', compact(
            'user',
            'membershipActive',
            'membershipDaysLeft',
            'membershipPlan',
            'membershipProgress',
            'trainer',
            'totalSessions',
            'completedSessions',
            'remainingSessions',
            'schedules',
            'recentActivities',
            'reviewedPtIds',
            'transactions'
        ));
    }


    /**
     * Memperbarui informasi profil member yang sedang login.
     * Hanya kolom profil yang diubah; data membership dan transaksi tetap aman.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 401);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9+\\-\\s()]*$/',
            ],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'phone.regex' => 'Nomor HP hanya boleh berisi angka dan karakter +, -, spasi, atau tanda kurung.',
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('user.dashboard_user')
            ->with('success', 'Informasi member berhasil diperbarui.');
    }


    /** Memperbarui password akun member yang sedang login. */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 401);

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'password.different' => 'Password baru harus berbeda dari password saat ini.',
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($validated['password']),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('user.dashboard_user')
            ->with('success', 'Password berhasil diperbarui.');
    }

    public function storeSchedule(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 401);

        $validated = $request->validate([
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jam' => ['required', 'date_format:H:i'],
            'jenis_latihan' => [
                'required',
                Rule::in(['Push Day', 'Pull Day', 'Leg Day', 'Upper Body', 'Lower Body', 'Full Body']),
            ],
        ]);

        // Pastikan membership masih aktif sebelum mengajukan jadwal.
        $today = Carbon::today();
        $active = $user->membership_status === 'active'
            && $user->membership_start
            && $user->membership_end
            && Carbon::parse($user->membership_start)->startOfDay()->lte($today)
            && Carbon::parse($user->membership_end)->endOfDay()->gte($today);

        if (!$active) {
            return back()->withErrors(['booking' => 'Membership kamu belum aktif. Aktifkan membership terlebih dahulu.']);
        }

        $trainer = null;
        if ($user->current_pt_id) {
            $trainer = DB::table('pt')
                ->where('id', $user->current_pt_id)
                ->where('status', 'active')
                ->first();
        }

        // Gunakan transaksi PT approved yang masih memiliki sesi tersisa.
        $ptTransaction = null;
        if ($trainer) {
            $transactions = DB::table('transaksi')
                ->where('user_id', $user->id)
                ->where('pt_id', $trainer->id)
                ->where('jenis_transaksi', 'pt_session')
                ->where('status', 'approved')
                ->orderBy('id')
                ->get();

            foreach ($transactions as $transaction) {
                $used = DB::table('schedule_latihan')
                    ->where('transaksi_id', $transaction->id)
                    ->whereIn('status', ['scheduled', 'pending', 'approved', 'completed'])
                    ->count();

                if ($used < (int) $transaction->jumlah_sesi) {
                    $ptTransaction = $transaction;
                    break;
                }
            }
        }

        // Bila member mempunyai PT, jadwal dihubungkan ke transaksi sesi PT yang tersedia.
        // Bila tidak punya PT/sesi PT, jadwal tetap dapat dibuat sebagai latihan mandiri.
        $ptId = $trainer?->id;
        $transactionId = $ptTransaction?->id;

        DB::table('schedule_latihan')->insert([
            'user_id' => $user->id,
            'pt_id' => $ptId,
            'transaksi_id' => $transactionId,
            'tanggal' => $validated['tanggal'],
            'jam' => $validated['jam'] . ':00',
            'jenis_latihan' => $validated['jenis_latihan'],
            'status' => $ptId ? 'pending' : 'scheduled',
            'catatan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('user.dashboard_user')
            ->with('success', 'Jadwal latihan berhasil diajukan.');
    }
}
    