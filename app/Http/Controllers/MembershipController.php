<?php

namespace App\Http\Controllers;

use App\Models\Pt;
use App\Models\PtProfile;
use App\Models\PtAvailability;
use App\Models\Transaksi;
use App\Models\ScheduleLatihan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MembershipController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'months' => 'required|integer|in:1,3,6,12',
            'pt_id' => 'nullable|integer|exists:pt,id',
            'sessions' => 'nullable|array',
            'sessions.*.availability_id' => 'required|integer|distinct|exists:pt_availabilities,id',
        ]);

        $user = $request->user();

        abort_unless($user->role === 'member', 403);

        $months = (int) $validated['months'];

        $prices = [
            1  => 150000,
            3  => 400000,
            6  => 700000,
            12 => 1200000,
        ];

        $membershipPrice = $prices[$months];

        $sessions = $validated['sessions'] ?? [];
        $pt = null;
        $ptProfile = null;

        if (!empty($validated['pt_id'])) {
            $pt = Pt::where('status', 'active')
                ->find($validated['pt_id']);

            if (!$pt) {
                throw ValidationException::withMessages([
                    'pt_id' => 'Personal Trainer tidak tersedia.',
                ]);
            }

            $ptProfile = PtProfile::where('user_id', $pt->user_id)
                ->first();

            if (!$ptProfile) {
                throw ValidationException::withMessages([
                    'pt_id' => 'Profil ketersediaan Personal Trainer belum tersedia.',
                ]);
            }

            if (empty($sessions)) {
                throw ValidationException::withMessages([
                    'sessions' => 'Pilih minimal satu slot jadwal PT.',
                ]);
            }
        } elseif (!empty($sessions)) {
            throw ValidationException::withMessages([
                'sessions' => 'Pilih Personal Trainer terlebih dahulu.',
            ]);
        }

        DB::transaction(function () use (
            $user,
            $months,
            $membershipPrice,
            $pt,
            $ptProfile,
            $sessions
        ) {
            $today = Carbon::today();

            $isActive = $user->membership_status === 'active'
                && $user->membership_end
                && Carbon::parse($user->membership_end)->gte($today);

            if ($isActive) {
                $startDate = $user->membership_start
                    ? Carbon::parse($user->membership_start)
                    : $today;

                $endDate = Carbon::parse($user->membership_end)
                    ->addMonthsNoOverflow($months);
            } else {
                $startDate = $today;
                $endDate = $today->copy()->addMonthsNoOverflow($months);
            }

            // Simpan transaksi Membership.
            Transaksi::create([
                'user_id' => $user->id,
                'jenis_transaksi' => 'membership',
                'membership_months' => $months,
                'harga_satuan' => $membershipPrice,
                'total_harga' => $membershipPrice,
                'status' => 'approved',
            ]);

            if ($pt) {
                $sessionCount = count($sessions);
                $ptPrice = (float) $pt->price_per_session;
                $ptTotal = $ptPrice * $sessionCount;

                // Simpan transaksi pembelian sesi PT.
                $ptTransaction = Transaksi::create([
                    'user_id' => $user->id,
                    'pt_id' => $pt->id,
                    'jenis_transaksi' => 'pt_session',
                    'jumlah_sesi' => $sessionCount,
                    'harga_satuan' => $ptPrice,
                    'total_harga' => $ptTotal,
                    'status' => 'approved',
                ]);

                foreach ($sessions as $session) {
                    // Kunci slot agar tidak dapat dipesan bersamaan.
                    $availability = PtAvailability::where(
                        'id',
                        $session['availability_id']
                    )
                        ->lockForUpdate()
                        ->first();

                    if (!$availability) {
                        throw ValidationException::withMessages([
                            'sessions' => 'Slot jadwal tidak ditemukan.',
                        ]);
                    }

                    if (
                        $availability->status !== 'available'
                        || $availability->pt_profile_id !== $ptProfile->id
                    ) {
                        throw ValidationException::withMessages([
                            'sessions' => 'Salah satu slot sudah tidak tersedia. Silakan pilih jadwal lain.',
                        ]);
                    }

                    $sessionDate = Carbon::parse($availability->start_at)->startOfDay();

                    if (
                        $sessionDate->lt($startDate->copy()->startOfDay())
                        || $sessionDate->gte($endDate->copy()->addDay()->startOfDay())
                    ) {
                        throw ValidationException::withMessages([
                            'sessions' => 'Tanggal sesi harus berada dalam masa Membership.',
                        ]);
                    }

                    if (Carbon::parse($availability->start_at)->lte(now())) {
                        throw ValidationException::withMessages([
                            'sessions' => 'Slot latihan yang sudah lewat tidak dapat dipesan.',
                        ]);
                    }

                    // Simpan jadwal latihan dengan referensi slot.
                    ScheduleLatihan::create([
                        'user_id' => $user->id,
                        'pt_id' => $pt->id,
                        'transaksi_id' => $ptTransaction->id,
                        'pt_availability_id' => $availability->id,
                        'tanggal' => Carbon::parse($availability->start_at)->toDateString(),
                        'jam' => Carbon::parse($availability->start_at)->format('H:i:s'),
                        'jenis_latihan' => 'Personal Training',
                        'status' => 'scheduled',
                        'catatan' => null,
                    ]);

                    // Tandai slot sebagai sudah dipesan.
                    $availability->update([
                        'status' => 'booked',
                    ]);
                }
            }

            // Aktifkan atau perpanjang Membership.
            $user->update([
                'membership_status' => 'active',
                'membership_start' => $startDate,
                'membership_end' => $endDate,
            ]);
        });

        return redirect()
            ->route('user.dashboard_user')
            ->with('success', 'Checkout berhasil! Membership dan jadwal PT berhasil diproses.');
    }


    /**
     * Halaman booking PT tanpa membeli Membership baru.
     */
    public function bookingPt(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'member', 403);

        $today = Carbon::today();
        $membershipActive = $user->membership_status === 'active'
            && $user->membership_start
            && $user->membership_end
            && Carbon::parse($user->membership_start)->startOfDay()->lte($today)
            && Carbon::parse($user->membership_end)->endOfDay()->gte($today);

        if (!$membershipActive) {
            return redirect()
                ->route('user.dashboard_user')
                ->withErrors(['booking' => 'Membership harus aktif untuk memesan Personal Trainer.']);
        }

        $pts = Pt::where('status', 'active')->orderBy('pt_name')->get();

        $availabilities = DB::table('pt_availabilities as pa')
            ->join('pt_profiles as pp', 'pp.id', '=', 'pa.pt_profile_id')
            ->join('pt as p', 'p.user_id', '=', 'pp.user_id')
            ->where('p.status', 'active')
            ->where('pa.status', 'available')
            ->where('pa.start_at', '>', now())
            ->whereDate('pa.start_at', '<=', Carbon::parse($user->membership_end)->toDateString())
            ->select('pa.id', 'p.id as pt_id', 'pa.start_at', 'pa.end_at')
            ->orderBy('pa.start_at')
            ->get();

        return view('user.booking_pt', compact('user', 'pts', 'availabilities'));
    }

    /**
     * Checkout pembelian sesi PT saja.
     */
    public function storePtBooking(Request $request)
    {
        $validated = $request->validate([
            'pt_id' => ['required', 'integer', 'exists:pt,id'],
            'sessions' => ['required', 'array', 'min:1'],
            'sessions.*.availability_id' => [
                'required',
                'integer',
                'distinct',
                'exists:pt_availabilities,id',
            ],
        ]);

        $user = $request->user();
        abort_unless($user && $user->role === 'member', 403);

        $pt = Pt::where('status', 'active')->find($validated['pt_id']);
        if (!$pt) {
            throw ValidationException::withMessages([
                'pt_id' => 'Personal Trainer tidak tersedia.',
            ]);
        }

        $ptProfile = PtProfile::where('user_id', $pt->user_id)->first();
        if (!$ptProfile) {
            throw ValidationException::withMessages([
                'pt_id' => 'Profil ketersediaan Personal Trainer belum tersedia.',
            ]);
        }

        $sessions = $validated['sessions'];

        DB::transaction(function () use ($user, $pt, $ptProfile, $sessions) {
            // Ambil ulang dan kunci data member agar status Membership dicek saat checkout.
            $lockedUser = DB::table('users')->where('id', $user->id)->lockForUpdate()->first();

            $today = Carbon::today();
            $membershipStart = $lockedUser->membership_start
                ? Carbon::parse($lockedUser->membership_start)->startOfDay()
                : null;
            $membershipEnd = $lockedUser->membership_end
                ? Carbon::parse($lockedUser->membership_end)->endOfDay()
                : null;

            $membershipActive = $lockedUser
                && $lockedUser->membership_status === 'active'
                && $membershipStart
                && $membershipEnd
                && $membershipStart->lte($today)
                && $membershipEnd->gte($today);

            if (!$membershipActive) {
                throw ValidationException::withMessages([
                    'booking' => 'Membership kamu sudah tidak aktif. Aktifkan Membership sebelum booking PT.',
                ]);
            }

            $ptPrice = 100000; // Harga booking PT ditetapkan Rp100.000 per sesi.
            $sessionCount = count($sessions);

            $ptTransaction = Transaksi::create([
                'user_id' => $user->id,
                'pt_id' => $pt->id,
                'jenis_transaksi' => 'pt_session',
                'jumlah_sesi' => $sessionCount,
                'harga_satuan' => $ptPrice,
                'total_harga' => $ptPrice * $sessionCount,
                'status' => 'approved',
            ]);

            foreach ($sessions as $session) {
                $availability = PtAvailability::where(
                    'id',
                    $session['availability_id']
                )->lockForUpdate()->first();

                if (
                    !$availability
                    || $availability->status !== 'available'
                    || (int) $availability->pt_profile_id !== (int) $ptProfile->id
                ) {
                    throw ValidationException::withMessages([
                        'sessions' => 'Salah satu slot sudah tidak tersedia. Silakan pilih jadwal lain.',
                    ]);
                }

                $slotStart = Carbon::parse($availability->start_at);

                if (
                    $slotStart->lte(now())
                    || $slotStart->lt($membershipStart)
                    || $slotStart->gt($membershipEnd)
                ) {
                    throw ValidationException::withMessages([
                        'sessions' => 'Jadwal PT harus berada dalam masa Membership yang masih aktif.',
                    ]);
                }

                ScheduleLatihan::create([
                    'user_id' => $user->id,
                    'pt_id' => $pt->id,
                    'transaksi_id' => $ptTransaction->id,
                    'pt_availability_id' => $availability->id,
                    'tanggal' => $slotStart->toDateString(),
                    'jam' => $slotStart->format('H:i:s'),
                    'jenis_latihan' => 'Personal Training',
                    'status' => 'scheduled',
                    'catatan' => null,
                ]);

                $availability->update(['status' => 'booked']);
            }
        });

        return redirect()
            ->route('user.dashboard_user')
            ->with('success', 'Booking PT berhasil! Membership kamu tetap berjalan seperti biasa.');
    }

}
