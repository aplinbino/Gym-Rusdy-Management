<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Mengambil seluruh member.
     */
    public function index()
    {
        $this->ensureAdmin();

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

    /**
     * Menambahkan member baru.
     */
    public function store(Request $request)
    {
        $this->ensureAdmin();

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

    /**
     * Memperbarui data profil member.
     * Status dan periode membership tidak diubah dari form ini.
     */
    public function update(Request $request, $id)
    {
        $this->ensureAdmin();

        $user = User::where('role', 'member')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return response()->json([
            'message' => 'Data member berhasil diperbarui.',
            'user' => $user->only([
                'id', 'name', 'email', 'phone',
                'membership_status', 'membership_start', 'membership_end',
            ]),
        ]);
    }

    /**
     * Menghapus member hanya jika belum memiliki riwayat terkait.
     */
    public function destroy($id)
    {
        $this->ensureAdmin();

        $user = User::where('role', 'member')->findOrFail($id);

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

    /**
     * Memastikan endpoint hanya dapat digunakan oleh Admin.
     */
    private function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }
}
