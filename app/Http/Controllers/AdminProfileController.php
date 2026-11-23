<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    public function edit()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        return view('admin.profile', [
            'admin' => auth()->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $admin = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($admin->id),
            ],
        ], [
            'name.required' => 'Nama admin wajib diisi.',
            'email.required' => 'Email admin wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan akun lain.',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->save();

        return back()->with('profile_success', 'Informasi profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $admin = $request->user();
        $admin->password = Hash::make($validated['password']);
        $admin->save();

        return back()->with('password_success', 'Password berhasil diperbarui.');
    }
}
