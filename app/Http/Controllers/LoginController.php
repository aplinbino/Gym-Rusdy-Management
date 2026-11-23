<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Login Member
    public function loginMember(Request $request)
    {
        return $this->authenticate($request, 'member');
    }

    // Login Admin dan PT
    public function loginStaff(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,pt',
        ]);

        return $this->authenticate($request, $request->role);
    }

    // Proses autentikasi
    private function authenticate(Request $request, string $expectedRole)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['role'] = $expectedRole;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Login Member
            if ($expectedRole === 'member') {
                return redirect('/dashboard_user');
            }

            // Login Admin
            if ($expectedRole === 'admin') {
                return redirect('/admin/dashboard');
            }

            // Login Personal Trainer
            if ($expectedRole === 'pt') {
                return redirect('/personal-trainer');
            }
        }

        return back()->withErrors([
            'email' => 'Email, password, atau role tidak sesuai.',
        ])->onlyInput('email');
    }

    // Logout
  
// Logout
    public function logout(Request $request)
    {
        // Simpan role sebelum session logout
        $role = Auth::user()?->role;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect berdasarkan role sebelumnya
        if ($role === 'admin' || $role === 'pt') {
            return redirect('/login-with-role')
                ->with('success', 'Berhasil logout.');
        }

        // Default untuk Member
        return redirect('/login')
            ->with('success', 'Berhasil logout.');
    }

}
