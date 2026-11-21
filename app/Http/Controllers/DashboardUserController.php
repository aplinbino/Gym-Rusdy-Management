<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $membershipProgress = $membershipActive
            ? max(0, min(100, ($membershipDaysLeft / $membershipTotalDays) * 100))
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
            'recentActivities'
        ));
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
