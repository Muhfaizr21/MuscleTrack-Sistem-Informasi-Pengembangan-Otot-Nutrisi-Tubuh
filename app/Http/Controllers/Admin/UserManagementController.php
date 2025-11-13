<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar semua user & trainer (READ)
     */
    public function index()
    {
        // Ambil semua user, urutkan dari yang terbaru, 10 per halaman
        $users = User::latest()->paginate(10);

        // Kirim data users ke view 'admin.users.index'
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru (CREATE form)
     */
    public function create()
    {
        // Hanya menampilkan view 'admin.users.create'
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru ke database (CREATE logic)
     */
    public function store(Request $request)
    {
        // Validasi data (sesuai migrasi Anda)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'user', 'trainer'])],
            'age' => 'nullable|integer|min:15',
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'height' => 'nullable|numeric|min:100',
            'weight' => 'nullable|numeric|min:30',
            'goal_id' => 'nullable|integer',
        ]);

        // Hash password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        // ✅ AUDIT LOG: Admin membuat user baru
        Log::info('Admin created new user', [
            'admin_id' => Auth::id(),
            'admin_email' => Auth::user()->email,
            'new_user_email' => $validated['email'],
            'new_user_role' => $validated['role'],
            'created_at' => now()
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit user (UPDATE form)
     */
    public function edit(User $user)
    {
        // Mengirim data $user yang dipilih ke view 'admin.users.edit'
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user di database (UPDATE logic)
     */
    public function update(Request $request, User $user)
    {
        // Validasi data (Email unik tapi abaikan diri sendiri)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'user', 'trainer'])],
            'age' => 'nullable|integer|min:15',
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'height' => 'nullable|numeric|min:100',
            'weight' => 'nullable|numeric|min:30',
            'goal_id' => 'nullable|integer',
        ]);

        // ✅ PROTECTION: Admin tidak bisa mengubah role sendiri
        if (Auth::id() == $user->id && $request->role != Auth::user()->role) {
            return back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri.');
        }

        // Cek jika admin mengisi password baru
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // ✅ AUDIT LOG: Admin mengupdate user
        Log::info('Admin updated user', [
            'admin_id' => Auth::id(),
            'admin_email' => Auth::user()->email,
            'updated_user_id' => $user->id,
            'updated_user_email' => $user->email,
            'changes' => $validated,
            'updated_at' => now()
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database (DELETE) - DIPERBAIKI
     */
    public function destroy(User $user)
    {
        // ✅ PROTECTION: Admin tidak bisa menghapus diri sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        // ✅ PROTECTION: Admin tidak bisa menghapus sesama admin
        if ($user->role === 'admin' && Auth::user()->role === 'admin') {
            return back()->with('error', 'Admin tidak bisa menghapus admin lainnya.');
        }

        // ✅ AUDIT LOG: Sebelum menghapus
        Log::warning('Admin deleting user', [
            'admin_id' => Auth::id(),
            'admin_email' => Auth::user()->email,
            'admin_role' => Auth::user()->role,
            'deleted_user_id' => $user->id,
            'deleted_user_email' => $user->email,
            'deleted_user_role' => $user->role,
            'deleted_at' => now()
        ]);

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * Menampilkan detail user (SHOW) - TAMBAHAN UNTUK SECURITY
     */
    public function show(User $user)
    {
        // ✅ Authorization implicit dengan route model binding
        return view('admin.users.index', compact('user'));
    }
}
