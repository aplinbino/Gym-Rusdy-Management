<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    /**
     * Menampilkan form review untuk PT yang pernah melatih member.
     */
    public function create(int $pt)
    {
        $user = Auth::user();
        abort_unless($user, 401);

        $trainer = DB::table('pt')
            ->join('users', 'users.id', '=', 'pt.user_id')
            ->where('pt.id', $pt)
            ->where('pt.status', 'active')
            ->select('pt.id', 'pt.pt_name', 'users.name as account_name')
            ->first();

        abort_unless($trainer, 404, 'Personal Trainer tidak ditemukan.');

        $hasCompletedSession = DB::table('schedule_latihan')
            ->where('user_id', $user->id)
            ->where('pt_id', $trainer->id)
            ->where('status', 'completed')
            ->exists();

        abort_unless(
            $hasCompletedSession,
            403,
            'Kamu hanya dapat memberi ulasan kepada PT setelah menyelesaikan sesi latihan.'
        );

        $existingReview = DB::table('reviews')
            ->where('user_id', $user->id)
            ->where('target_type', 'pt')
            ->where('target_id', $trainer->id)
            ->first();

        return view('user.review_to_pt', compact('trainer', 'existingReview'));
    }

    /**
     * Menyimpan satu review per member untuk setiap PT.
     */
    public function store(Request $request, int $pt)
    {
        $user = Auth::user();
        abort_unless($user, 401);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:200'],
            'is_anonymous' => ['nullable', 'boolean'],
        ], [
            'rating.required' => 'Silakan pilih rating bintang terlebih dahulu.',
            'rating.integer' => 'Rating tidak valid.',
            'rating.between' => 'Rating harus antara 1 sampai 5 bintang.',
            'comment.required' => 'Ulasan wajib diisi.',
            'comment.max' => 'Ulasan maksimal 200 karakter.',
        ]);

        DB::transaction(function () use ($user, $pt, $validated) {
            // Kunci salah satu sesi selesai agar validasi eligibility konsisten.
            $completedSession = DB::table('schedule_latihan')
                ->where('user_id', $user->id)
                ->where('pt_id', $pt)
                ->where('status', 'completed')
                ->lockForUpdate()
                ->first();

            if (!$completedSession) {
                throw ValidationException::withMessages([
                    'review' => 'Kamu hanya dapat memberi ulasan setelah menyelesaikan sesi dengan PT ini.',
                ]);
            }

            $trainerExists = DB::table('pt')
                ->where('id', $pt)
                ->exists();

            if (!$trainerExists) {
                abort(404, 'Personal Trainer tidak ditemukan.');
            }

            $alreadyReviewed = DB::table('reviews')
                ->where('user_id', $user->id)
                ->where('target_type', 'pt')
                ->where('target_id', $pt)
                ->exists();

            if ($alreadyReviewed) {
                throw ValidationException::withMessages([
                    'review' => 'Kamu sudah memberikan ulasan untuk Personal Trainer ini.',
                ]);
            }

            DB::table('reviews')->insert([
                'user_id' => $user->id,
                'target_type' => 'pt',
                'target_id' => $pt,
                'rating' => $validated['rating'],
                'comment' => trim($validated['comment']),
                'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()
            ->route('user.dashboard_user')
            ->with('success', 'Terima kasih! Ulasan untuk Personal Trainer berhasil dikirim.');
    }
}
