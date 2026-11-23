<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pt;
use App\Models\PtProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPtController extends Controller
{
    // Menampilkan seluruh data PT
    public function index()
    {
        $trainers = Pt::with('user')
            ->latest()
            ->get();

        return response()->json($trainers);
    }

    // Menambahkan akun dan profil PT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'pt_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $trainer = DB::transaction(function () use ($validated) {

            // 1. Membuat akun login PT
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password'],
                'role' => 'pt',
                'membership_status' => 'inactive',
            ]);

            // 2. Membuat profil PT utama
            $pt = Pt::create([
                'user_id' => $user->id,
                'pt_name' => $validated['pt_name'],
                'price_per_session' => 100000,
                'description' => $validated['description'] ?? null,
                'status' => 'active',
            ]);

            // 3. Membuat profil ketersediaan PT
            // Menggunakan user_id yang sama agar terhubung
            // dengan profil PT utama.
            PtProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'description' => $validated['description'] ?? null,
                    'price_per_session' => 100000,
                ]
            );

            return $pt->load('user');
        });

        return response()->json([
            'message' => 'Personal Trainer berhasil ditambahkan.',
            'data' => $trainer,
        ], 201);
    }

    // Mengubah data PT
    public function update(Request $request, Pt $pt)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $pt->user_id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'pt_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $trainer = DB::transaction(function () use ($validated, $pt) {

            // 1. Memperbarui akun user
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ];

            // Password hanya diubah jika diisi
            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            $pt->user->update($userData);

            // 2. Memperbarui profil PT utama
            $pt->update([
                'pt_name' => $validated['pt_name'],
                'price_per_session' => 100000,
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            // 3. Sinkronisasi profil ketersediaan PT
            // Jika profil lama belum ada, buat otomatis.
            PtProfile::updateOrCreate(
                [
                    'user_id' => $pt->user_id,
                ],
                [
                    'description' => $validated['description'] ?? null,
                    'price_per_session' => 100000,
                ]
            );

            return $pt->fresh()->load('user');
        });

        return response()->json([
            'message' => 'Data Personal Trainer berhasil diperbarui.',
            'data' => $trainer,
        ]);
    }

    // Menghapus akun dan seluruh profil PT terkait
    public function destroy(Pt $pt)
    {
        DB::transaction(function () use ($pt) {

            // Penghapusan user akan menghapus:
            // - Profil pada tabel pt
            // - Profil pada tabel pt_profiles
            // - Slot pada tabel pt_availabilities
            // sesuai foreign key cascade yang sudah tersedia.
            $pt->user->delete();
        });

        return response()->json([
            'message' => 'Akun Personal Trainer berhasil dihapus.',
        ]);
    }
}
