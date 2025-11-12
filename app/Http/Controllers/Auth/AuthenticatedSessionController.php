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
     * Proses login otomatis mendeteksi role
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Coba login
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('Email atau password salah.'),
            ]);
        }

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Ambil role user dari database
        $role = Auth::user()->role;

        // Redirect otomatis berdasarkan role
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'trainer' => redirect()->route('trainer.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect('/dashboard'),
        };
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
