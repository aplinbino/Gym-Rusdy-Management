<?php

namespace App\Http\Controllers;

use App\Models\Pt;
use App\Models\Review;
use App\Models\ScheduleLatihan;
use App\Models\PtAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PersonalTrainerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan hanya akun PT yang dapat membuka dashboard ini.
        abort_unless($user && $user->role === 'pt', 403);

        // Ambil profil PT berdasarkan akun yang sedang login.
        $pt = Pt::where('user_id', $user->id)->firstOrFail();

        // Ambil profil PT untuk relasi slot ketersediaan.
        $ptProfile = DB::table('pt_profiles')
            ->where('user_id', $user->id)
            ->first();

        abort_unless($ptProfile, 404, 'Profil PT belum tersedia.');

        // Ambil slot ketersediaan khusus PT yang sedang login.
        $availabilities = PtAvailability::where('pt_profile_id', $ptProfile->id)
            ->orderBy('start_at')
            ->get()
            ->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_at' => $slot->start_at->format('Y-m-d H:i'),
                    'end_at' => $slot->end_at->format('Y-m-d H:i'),
                    'start_input' => $slot->start_at->format('Y-m-d\\TH:i'),
                    'end_input' => $slot->end_at->format('Y-m-d\\TH:i'),
                    'status' => $slot->status,
                ];
            })->values();

        // Ambil jadwal khusus PT yang sedang login beserta waktu slot booking.
        // Jam dari slot ketersediaan menjadi sumber waktu utama jika kolom
        // jam_mulai/jam_selesai pada jadwal lama masih kosong.
        $scheduleModels = ScheduleLatihan::query()
            ->with('user')
            ->leftJoin('pt_availabilities as availability', 'availability.id', '=', 'schedule_latihan.pt_availability_id')
            ->where('schedule_latihan.pt_id', $pt->id)
            ->select(
                'schedule_latihan.*',
                'availability.start_at as availability_start_at',
                'availability.end_at as availability_end_at'
            )
            ->orderBy('schedule_latihan.tanggal')
            ->orderBy('schedule_latihan.jam_mulai')
            ->get();

        $schedules = $scheduleModels->map(function ($schedule) {
            $startDateTime = $schedule->availability_start_at
                ? \Illuminate\Support\Carbon::parse($schedule->availability_start_at)
                : null;

            $endDateTime = $schedule->availability_end_at
                ? \Illuminate\Support\Carbon::parse($schedule->availability_end_at)
                : null;

            $jamMulai = $schedule->jam_mulai
                ? substr((string) $schedule->jam_mulai, 0, 5)
                : ($startDateTime?->format('H:i'));

            $jamSelesai = $schedule->jam_selesai
                ? substr((string) $schedule->jam_selesai, 0, 5)
                : ($endDateTime?->format('H:i'));

            // Kompatibilitas untuk jadwal lama yang belum terhubung ke slot.
            $time = ($jamMulai && $jamSelesai)
                ? "{$jamMulai} - {$jamSelesai}"
                : ($schedule->jam
                    ? substr((string) $schedule->jam, 0, 5)
                    : ($jamMulai ?? '-'));

            // Hitung durasi dari waktu mulai dan selesai yang sebenarnya.
            // Jika memakai slot booking, gunakan datetime slot agar aman
            // untuk sesi yang melewati tengah malam.
            $durationMinutes = 0;

            if ($startDateTime && $endDateTime) {
                $durationMinutes = max(0, $startDateTime->diffInMinutes($endDateTime, false));
            } elseif ($jamMulai && $jamSelesai && $schedule->tanggal) {
                $start = \Illuminate\Support\Carbon::parse(
                    $schedule->tanggal->format('Y-m-d') . ' ' . $jamMulai
                );
                $end = \Illuminate\Support\Carbon::parse(
                    $schedule->tanggal->format('Y-m-d') . ' ' . $jamSelesai
                );

                if ($end->lt($start)) {
                    $end->addDay();
                }

                $durationMinutes = max(0, $start->diffInMinutes($end, false));
            }

            return [
                'id' => $schedule->id,
                'date' => $schedule->tanggal?->format('Y-m-d'),
                'member' => $schedule->user?->name ?? 'Member',
                'time' => $time,
                'duration_hours' => round($durationMinutes / 60, 2),
                'workout' => $schedule->jenis_latihan ?? '-',
                'status' => $schedule->status ?? '-',
                'catatan' => $schedule->catatan,
            ];
        })->values();

        // Anggota yang pernah memiliki jadwal dengan PT ini.
        $members = $scheduleModels
            ->filter(fn ($schedule) => $schedule->user !== null)
            ->pluck('user')
            ->unique('id')
            ->values()
            ->map(function ($member) {
                return [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'initial' => collect(explode(' ', $member->name))
                        ->filter()
                        ->take(2)
                        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                        ->implode(''),
                    'plan' => '-',
                    'goal' => '-',
                    'progress' => 0,
                ];
            });

        // Review khusus PT yang sedang login.
        $reviewModels = Review::with('user')
            ->where('target_type', 'pt')
            ->where('target_id', $pt->id)
            ->latest()
            ->get();

        $reviews = $reviewModels->map(function ($review) {
            $fullName = trim($review->user?->name ?? 'Member');
            $nameParts = collect(preg_split('/\s+/', $fullName) ?: [])->filter()->values();

            // Nama publik hanya nama depan + inisial nama berikutnya.
            $publicName = $nameParts->first() ?: 'Member';
            if ($nameParts->count() > 1) {
                $publicName .= ' ' . strtoupper(substr($nameParts->last(), 0, 1)) . '.';
            }

            $isAnonymous = (bool) ($review->is_anonymous ?? false);
            $displayName = $isAnonymous ? 'Member Anonim' : $publicName;

            return [
                'id' => $review->id,
                'name' => $displayName,
                'initial' => $isAnonymous
                    ? 'M'
                    : collect(explode(' ', $publicName))
                        ->filter()
                        ->take(2)
                        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                        ->implode(''),
                'date' => $review->created_at?->translatedFormat('d F Y'),
                'rating' => (int) $review->rating,
                'program' => 'Personal Training',
                'comment' => $review->comment ?? '',
            ];
        })->values();

        $averageRating = $reviewModels->count()
            ? round($reviewModels->avg('rating'), 1)
            : 0;

        $ratingDistribution = collect([5, 4, 3, 2, 1])
            ->map(fn ($star) => [
                'star' => $star,
                'count' => $reviewModels->where('rating', $star)->count(),
            ]);

        return view('personal_trainer.personal-trainer', [
            'pt' => $pt,
            'user' => $user,
            'schedules' => $schedules,
            'members' => $members,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'ratingDistribution' => $ratingDistribution,
            'availabilities' => $availabilities,
        ]);
    }


    /**
     * Memperbarui profil akun Personal Trainer yang sedang login.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'pt', 403);

        $pt = Pt::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
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
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
            'phone.regex' => 'Format nomor HP tidak valid.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        DB::transaction(function () use ($user, $pt, $validated) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ]);

            $pt->update([
                'pt_name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            DB::table('pt_profiles')
                ->where('user_id', $user->id)
                ->update([
                    'description' => $validated['description'] ?? null,
                    'updated_at' => now(),
                ]);
        });

        return redirect()
            ->route('pt.dashboard')
            ->with('success', 'Profil berhasil diperbarui.')
            ->with('open_pt_profile', true);
    }

    /**
     * Memperbarui password akun Personal Trainer yang sedang login.
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'pt', 403);

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
            ],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'password.different' => 'Password baru harus berbeda dari password saat ini.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('pt.dashboard')
            ->with('success', 'Password berhasil diperbarui.')
            ->with('open_pt_profile', true);
    }

    /**
     * Memperbarui informasi jadwal latihan.
     */
    public function updateSchedule(Request $request, $id)
    {
        $user = $request->user();

        abort_unless($user && $user->role === 'pt', 403);

        $pt = Pt::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'jenis_latihan' => [
                'required',
                'string',
                'max:100',
            ],
            'status' => [
                'required',
                'in:scheduled,pending,approved,completed',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($pt, $id, $validated) {
            // Pastikan jadwal benar-benar milik PT yang login.
            $schedule = ScheduleLatihan::where('pt_id', $pt->id)
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            // Hanya ubah informasi sesi.
            // Tanggal, jam, transaksi, dan slot booking tetap aman.
            $schedule->update([
                'jenis_latihan' => $validated['jenis_latihan'],
                'status' => $validated['status'],
                'catatan' => $validated['catatan'] ?? null,
            ]);
        });

        return redirect()
            ->route('pt.dashboard')
            ->with('success', 'Jadwal latihan berhasil diperbarui.');
    }


    /**
     * Menambahkan slot ketersediaan PT.
     */
    public function storeAvailability(Request $request)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'pt', 403);

        $ptProfile = DB::table('pt_profiles')
            ->where('user_id', $user->id)
            ->first();

        abort_unless($ptProfile, 404, 'Profil PT belum tersedia.');

        $validated = $request->validate([
            'start_at' => ['required', 'date', 'after:now'],
        ], [
            'start_at.required' => 'Tanggal dan jam mulai wajib diisi.',
            'start_at.after' => 'Waktu mulai harus berada di masa depan.',
        ]);

        DB::transaction(function () use ($ptProfile, $validated) {
            $startAt = \Illuminate\Support\Carbon::parse($validated['start_at']);
            // Durasi setiap slot PT ditetapkan satu jam.
            $endAt = $startAt->copy()->addHour();

            // Cegah slot baru bertabrakan dengan slot aktif maupun slot booked.
            $overlap = PtAvailability::where('pt_profile_id', $ptProfile->id)
                ->whereIn('status', ['available', 'booked'])
                ->where('start_at', '<', $endAt)
                ->where('end_at', '>', $startAt)
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'start_at' => 'Slot ini bertabrakan dengan jadwal ketersediaan atau booking yang sudah ada.',
                ]);
            }

            PtAvailability::create([
                'pt_profile_id' => $ptProfile->id,
                'start_at' => $startAt,
                'end_at' => $endAt,
                'status' => 'available',
            ]);
        });

        return redirect()
            ->route('pt.dashboard')
            ->with('success', 'Slot ketersediaan berhasil ditambahkan.');
    }

    /**
     * Menonaktifkan slot yang masih tersedia dan belum dipesan.
     */
    public function deactivateAvailability(Request $request, $id)
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'pt', 403);

        $ptProfile = DB::table('pt_profiles')
            ->where('user_id', $user->id)
            ->first();

        abort_unless($ptProfile, 404, 'Profil PT belum tersedia.');

        DB::transaction(function () use ($ptProfile, $id) {
            $slot = PtAvailability::where('pt_profile_id', $ptProfile->id)
                ->whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $slot->status === 'available' && $slot->start_at->isFuture(),
                422,
                'Slot yang sudah dipesan, sudah lewat, atau nonaktif tidak dapat diubah.'
            );

            $slot->update(['status' => 'inactive']);
        });

        return redirect()
            ->route('pt.dashboard')
            ->with('success', 'Slot berhasil dinonaktifkan.');
    }

}
