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
     * Menampilkan daftar semua user & trainer (READ) - DIPERBAIKI DENGAN SEARCH
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role = $request->get('role');
        $status = $request->get('status');

        // Query dengan filter search dan filter lainnya
        $users = User::when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role, function($query) use ($role) {
                return $query->where('role', $role);
            })
            ->when($status, function($query) use ($status) {
                if ($status === 'active') {
                    return $query->where('verification_status', 'approved');
                } elseif ($status === 'inactive') {
                    return $query->where('verification_status', '!=', 'approved');
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Pertahankan parameter di pagination

        return view('admin.users.index', compact('users', 'search', 'role', 'status'));
    }

    /**
     * Menampilkan form untuk membuat user baru (CREATE form)
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru ke database (CREATE logic)
     */
    public function store(Request $request)
    {
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

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

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
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data user di database (UPDATE logic)
     */
    public function update(Request $request, User $user)
    {
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

        if (Auth::id() == $user->id && $request->role != Auth::user()->role) {
            return back()->with('error', 'Anda tidak bisa mengubah role akun Anda sendiri.');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

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
     * Menghapus user dari database (DELETE)
     */
    public function destroy(User $user)
    {
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        if ($user->role === 'admin' && Auth::user()->role === 'admin') {
            return back()->with('error', 'Admin tidak bisa menghapus admin lainnya.');
        }

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
     * Menampilkan detail user (SHOW)
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }
}
