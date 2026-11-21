<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPtController extends Controller
{
    // Menampilkan seluruh data PT
    public function index()
    {
        $trainers = Pt::with('user')->latest()->get();

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
            'split_gym' => 'required|in:Push Day,Pull Day,Leg Day,Upper Body,Lower Body,Full Body',
            'description' => 'nullable|string',
        ]);

        $trainer = DB::transaction(function () use ($validated) {

            // Membuat akun login PT
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password'],
                'role' => 'pt',
                'membership_status' => 'inactive',
            ]);

            // Membuat profil PT
            $pt = Pt::create([
                'user_id' => $user->id,
                'pt_name' => $validated['pt_name'],
                'split_gym' => $validated['split_gym'],
                'price_per_session' => 100000,
                'description' => $validated['description'] ?? null,
                'status' => 'active',
            ]);

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
            'split_gym' => 'required|in:Push Day,Pull Day,Leg Day,Upper Body,Lower Body,Full Body',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $trainer = DB::transaction(function () use ($validated, $pt) {

            // Memperbarui akun user
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

            // Memperbarui profil PT
            $pt->update([
                'pt_name' => $validated['pt_name'],
                'split_gym' => $validated['split_gym'],
                'price_per_session' => 100000,
                'description' => $validated['description'] ?? null,
                'status' => $validated['status'],
            ]);

            return $pt->fresh()->load('user');
        });

        return response()->json([
            'message' => 'Data Personal Trainer berhasil diperbarui.',
            'data' => $trainer,
        ]);
    }

    // Menghapus akun dan profil PT
    public function destroy(Pt $pt)
    {
        DB::transaction(function () use ($pt) {
            // Menghapus akun user.
            // Profil PT ikut terhapus melalui cascadeOnDelete.
            $pt->user->delete();
        });

        return response()->json([
            'message' => 'Akun Personal Trainer berhasil dihapus.',
        ]);
    }
}
