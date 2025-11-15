<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Callback dari Google setelah login/register.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cek apakah user sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Login langsung jika user sudah ada
                Auth::login($user);

                // Redirect sesuai role
                return $this->redirectByRole($user);
            } else {
                // Simpan data sementara di session untuk melengkapi registrasi
                session(['google_user' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                ]]);

                // Redirect ke halaman lengkapi registrasi
                return redirect()->route('register.google.complete');
            }
        } catch (Exception $e) {
            Log::error('Google OAuth Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->route('register')
                ->with('error', 'Login/Register dengan Google gagal! Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan halaman untuk melengkapi registrasi Google.
     */
    public function showCompleteRegistrationForm()
    {
        if (! session('google_user')) {
            return redirect()->route('register')
                ->with('error', 'Sesi Google sudah berakhir. Silakan daftar ulang.');
        }

        $googleUser = session('google_user');

        return view('auth.register-google-complete', [
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
            'avatar' => $googleUser['avatar'] ?? null,
        ]);
    }

    /**
     * Menyimpan data registrasi lengkap dari Google.
     */
    public function completeRegistration(Request $request)
    {
        $request->validate([
            'role' => 'required|in:user,trainer',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted',
        ]);

        $googleData = session('google_user');

        if (! $googleData) {
            return redirect()->route('register')
                ->with('error', 'Sesi Google sudah berakhir. Silakan daftar ulang.');
        }

        // Cek kembali apakah email sudah terdaftar (untuk menghindari race condition)
        $existingUser = User::where('email', $googleData['email'])->first();
        if ($existingUser) {
            Auth::login($existingUser);
            session()->forget('google_user');
            return $this->redirectByRole($existingUser);
        }

        // Buat user baru dengan password yang diinput
        $user = User::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(), // Email Google sudah terverifikasi
        ]);

        // Optional: Simpan avatar jika ada
        if (!empty($googleData['avatar'])) {
            // Anda bisa menambahkan logika untuk menyimpan avatar di sini
            // $user->avatar = $googleData['avatar'];
            // $user->save();
        }

        Auth::login($user);
        session()->forget('google_user');

        return $this->redirectByRole($user)
            ->with('success', 'Registrasi berhasil! Selamat datang di MuscleTrack.');
    }

    /**
     * Redirect user berdasarkan role.
     */
    private function redirectByRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'trainer':
                return redirect()->route('trainer.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Role pengguna tidak dikenali!');
        }
    }
}
