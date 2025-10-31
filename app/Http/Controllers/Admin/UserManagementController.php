<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Penting untuk validasi Enum

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
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan cek 'password_confirmation'
            'role' => ['required', Rule::in(['admin', 'user', 'trainer'])], // Validasi Enum Role
            'age' => 'nullable|integer|min:15',
            'gender' => ['nullable', Rule::in(['male', 'female'])], // Validasi Enum Gender
            'height' => 'nullable|numeric|min:100',
            'weight' => 'nullable|numeric|min:30',
            'goal_id' => 'nullable|integer', // Sesuai migrasi (tanpa foreign key check)
        ]);

        // Hash password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

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
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
            'role' => ['required', Rule::in(['admin', 'user', 'trainer'])],
            'age' => 'nullable|integer|min:15',
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'height' => 'nullable|numeric|min:100',
            'weight' => 'nullable|numeric|min:30',
            'goal_id' => 'nullable|integer',
        ]);

        // Cek jika admin mengisi password baru
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Jika tidak, hapus password dari array agar tidak menimpa yg lama
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database (DELETE)
     */
    public function destroy(User $user)
    {
        // Proteksi agar admin tidak bisa menghapus diri sendiri
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
