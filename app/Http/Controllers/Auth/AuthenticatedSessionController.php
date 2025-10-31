<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create()
    {
        return view('auth.login'); // pastikan resources/views/auth/login.blade.php ada
    }

    /**
     * Proses login dengan validasi role
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:admin,user,trainer', // sesuaikan role di DB
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek apakah role sesuai
            if (Auth::user()->role !== $role) {
                Auth::logout();

                // Kirim pesan error ke form login
                return back()->withErrors([
                    'role' => 'Role yang dipilih tidak sesuai dengan akun Anda.',
                ])->withInput($request->only('email', 'role'));
            }

            // Redirect sesuai role
            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'trainer' => redirect()->route('trainer.dashboard'),
                'user' => redirect()->route('user.dashboard'),
                default => redirect('/dashboard'),
            };
        }

        // Jika gagal login (email/password salah)
        throw ValidationException::withMessages([
            'email' => __('Email atau password salah.'),
        ]);
    }

    /**
     * Logout user
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
