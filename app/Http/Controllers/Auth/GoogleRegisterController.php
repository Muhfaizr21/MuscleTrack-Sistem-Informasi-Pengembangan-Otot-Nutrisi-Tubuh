<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleRegisterController extends Controller
{
    /**
     * Redirect user ke Google OAuth untuk registrasi/login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Callback dari Google OAuth
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            // Cek apakah user sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            if (! $user) {
                // Simpan data sementara di session untuk pemilihan role dan password
                session([
                    'google_name' => $googleUser->getName(),
                    'google_email' => $googleUser->getEmail(),
                ]);

                // Redirect ke halaman pilih role & set password
                return redirect()->route('register.role');
            }

            // Login langsung jika user sudah ada
            Auth::login($user);

            // Redirect ke dashboard sesuai role
            return $this->redirectByRole($user);

        } catch (\Exception $e) {
            Log::error('Register/Login Google gagal: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect('/register')->with('error', 'Register/Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    /**
     * Halaman pilih role untuk user baru
     */
    public function showRoleForm()
    {
        $name = session('google_name');
        $email = session('google_email');

        if (! $name || ! $email) {
            return redirect('/register')->with('error', 'Data Google tidak ditemukan.');
        }

        return view('auth.register-role', compact('name', 'email'));
    }

    /**
     * Simpan user baru setelah pilih role dan password
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:user,trainer',
            'password' => 'required|string|min:6|confirmed', // harus dikonfirmasi
        ]);

        $user = User::create([
            'name' => session('google_name'),
            'email' => session('google_email'),
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Hapus session sementara
        session()->forget(['google_name', 'google_email']);

        // Login user
        Auth::login($user);

        // Redirect sesuai role
        return $this->redirectByRole($user);
    }

    /**
     * Redirect user sesuai role
     */
    private function redirectByRole(User $user)
    {
        switch ($user->role) {
            case 'trainer':
                return redirect()->route('trainer.dashboard');
            case 'user':
            default:
                return redirect()->route('user.dashboard');
        }
    }
}
