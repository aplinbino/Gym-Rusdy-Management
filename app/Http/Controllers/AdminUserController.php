<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Mengambil seluruh member
    public function index()
    {
        $users = User::where('role', 'member')
            ->orderBy('id', 'asc')
            ->get([
                'id',
                'name',
                'email',
                'phone',
                'membership_status',
                'membership_start',
                'membership_end',
                'created_at',
            ]);

        return response()->json($users);
    }

    // Menambahkan member baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'role' => 'member',
            'membership_status' => 'inactive',
        ]);

        return response()->json([
            'message' => 'Member berhasil ditambahkan.',
            'user' => $user,
        ], 201);
    }

    // Menghapus member
    public function destroy($id)
    {
        $user = User::where('role', 'member')->findOrFail($id);

        // Jangan hapus member yang masih memiliki riwayat.
        if (
            $user->transaksi()->exists() ||
            $user->scheduleLatihan()->exists() ||
            $user->reviews()->exists()
        ) {
            return response()->json([
                'message' => 'Member tidak dapat dihapus karena masih memiliki riwayat transaksi, jadwal, atau review.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'Member berhasil dihapus.',
        ]);
    }
}
