<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Tampilkan profil user
     */
    public function index()
    {
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    /**
     * Halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update data profil user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'age'    => 'nullable|integer|min:10|max:100',
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'height' => 'nullable|numeric|min:100|max:250',
            'weight' => 'nullable|numeric|min:30|max:300',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada file avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists('profile_pictures/' . $user->avatar)) {
                Storage::disk('public')->delete('profile_pictures/' . $user->avatar);
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profile_pictures', $filename, 'public');
            $user->avatar = $filename;
        }

        // Update data user
        $user->update($request->only('name', 'email', 'age', 'gender', 'height', 'weight'));

        // Simpan avatar jika ada
        if ($request->hasFile('avatar')) {
            $user->save();
        }

        return redirect()->route('user.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Halaman ubah password
     */
    public function editPassword()
    {
        return view('user.profile.password');
    }

    /**
     * Proses ubah password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // validasi Laravel 'confirmed'
        ]);

        $user = Auth::user();

        // Pastikan password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // Simpan password baru (dengan hashing)
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user.profile.index')->with('success', 'Password berhasil diperbarui!');
    }
}
