<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        Log::info('Accessed registration page');
        return view('auth.register-role');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Log data yang diterima (tambah password fields dengan masking)
            $inputData = $request->all();
            if (isset($inputData['password'])) {
                $inputData['password'] = '***masked***';
            }
            if (isset($inputData['password_confirmation'])) {
                $inputData['password_confirmation'] = '***masked***';
            }

            Log::info('Registration attempt started', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'data_received' => $inputData
            ]);

            // Validasi dengan debugging
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['nullable', 'in:user,trainer'], // Tambah validasi role
                'terms' => ['accepted', 'required'], // Ubah dari 'accepted' saja
            ]);

            Log::info('Validation passed', ['email' => $validated['email']]);

            // Cek apakah kolom role ada di tabel users
            try {
                $user = new User();
                $columns = $user->getConnection()->getSchemaBuilder()->getColumnListing($user->getTable());

                Log::info('User table columns', ['columns' => $columns]);

                if (!in_array('role', $columns)) {
                    Log::error('Column "role" not found in users table');
                    throw new \Exception('Database column "role" is missing. Please run migration.');
                }
            } catch (\Exception $e) {
                Log::error('Database check failed', ['error' => $e->getMessage()]);
                throw $e;
            }

            // Create user dengan role
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ];

            // Tambah role jika ada dalam request, default 'user'
            $userData['role'] = $validated['role'] ?? 'user';

            $user = User::create($userData);

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            event(new Registered($user));

            // Login user
            Auth::login($user);

            Log::info('User logged in successfully', ['user_id' => $user->id]);

            // Redirect berdasarkan role
            $redirectRoute = $this->determineRedirectRoute($user->role);

            Log::info('Redirecting user', [
                'user_id' => $user->id,
                'role' => $user->role,
                'route' => $redirectRoute
            ]);

            return redirect()->route($redirectRoute);
        } catch (ValidationException $e) {
            // Log validation errors
            Log::warning('Registration validation failed', [
                'errors' => $e->errors(),
                'input' => $inputData ?? $request->except(['password', 'password_confirmation'])
            ]);

            // Kembalikan ke form dengan error (ini akan otomatis dihandle Laravel)
            return redirect()->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            // Log semua jenis error
            Log::error('Registration failed', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'input_data' => $inputData ?? $request->except(['password', 'password_confirmation']),
            ]);

            // Return back dengan error message
            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['error' => 'Registration failed. Please try again or contact support.']);
        }
    }

    /**
     * Determine redirect route based on user role
     */
    private function determineRedirectRoute(?string $role): string
    {
        // Default route jika role null atau tidak dikenali
        $defaultRoute = 'user.dashboard';

        if ($role === 'trainer') {
            // Cek apakah route trainer.dashboard ada
            if (\Route::has('trainer.dashboard')) {
                return 'trainer.dashboard';
            }
            Log::warning('trainer.dashboard route not found, falling back to default');
        }

        // Cek apakah user.dashboard ada
        if (\Route::has('user.dashboard')) {
            return 'user.dashboard';
        }

        // Fallback ke dashboard umum
        if (\Route::has('dashboard')) {
            return 'dashboard';
        }

        // Fallback ke home
        Log::warning('No dashboard routes found, falling back to home');
        return 'home';
    }
}
