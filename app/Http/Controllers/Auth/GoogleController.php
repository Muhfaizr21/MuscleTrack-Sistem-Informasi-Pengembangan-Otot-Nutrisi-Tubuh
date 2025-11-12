<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
     * Callback dari Google setelah login.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cek apakah user sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            if (! $user) {
                // Simpan data sementara di session untuk memilih role
                session(['google_user' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                ]]);

                // Redirect ke halaman pilih role
                return redirect()->route('register.role');
            }

            // Login langsung jika user sudah ada
            Auth::login($user);

            // Redirect sesuai role
            return $this->redirectByRole($user);

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login/Register dengan Google gagal! '.$e->getMessage());
        }
    }

    /**
     * Menampilkan halaman untuk memilih role setelah login Google pertama kali.
     */
    public function showRoleForm()
    {
        if (! session('google_user')) {
            return redirect()->route('register')
                ->with('error', 'Sesi Google sudah berakhir.');
        }

        $googleUser = session('google_user');

        return view('auth.register-role', [
            'name' => $googleUser['name'],
            'email' => $googleUser['email'],
        ]);
    }

    /**
     * Menyimpan role dan buat akun baru.
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:user,trainer,admin',
        ]);

        $googleData = session('google_user');

        if (! $googleData) {
            return redirect()->route('register')
                ->with('error', 'Sesi Google sudah berakhir.');
        }

        // Buat user baru
        $user = User::create([
            'name' => $googleData['name'],
            'email' => $googleData['email'],
            'password' => bcrypt(Str::random(16)),
            'role' => $request->role,
        ]);

        Auth::login($user);
        session()->forget('google_user');

        return $this->redirectByRole($user);
    }

    /**
     * Redirect user berdasarkan role MuscleTrack.
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

                return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali!');
        }
    }
}
