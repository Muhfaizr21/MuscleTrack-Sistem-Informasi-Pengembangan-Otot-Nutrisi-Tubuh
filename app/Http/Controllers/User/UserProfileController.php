<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    /**
     * Tampilkan profil user
     */
    public function index()
    {
        $user = Auth::user()->load('fitnessProfile');

        return view('user.profile.index', compact('user'));
    }

    /**
     * Halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user()->load('fitnessProfile');

        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update data profil user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'age' => 'nullable|integer|min:10|max:100',
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'height' => 'nullable|numeric|min:100|max:250',
            'weight' => 'nullable|numeric|min:30|max:300',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'activity_level' => 'nullable|in:light,moderate,heavy',
            'activity_description' => 'nullable|string|max:255',
            'daily_calorie_target' => 'nullable|integer|min:1000|max:5000',
            'preferred_muscle_groups' => 'nullable|array',
            'preferred_muscle_groups.*' => 'in:chest,back,arms,shoulders,legs,core,glutes,full_body',
        ]);

        // Jika ada file avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $file = $request->file('avatar');
            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $avatarPath = $file->storeAs('avatars', $filename, 'public');
            $user->avatar = $avatarPath;
        }

        // Update data user
        $user->update($request->only('name', 'email', 'age', 'gender', 'height', 'weight'));

        // Update atau create fitness profile
        $fitnessData = [
            'activity_level' => $request->activity_level,
            'activity_description' => $request->activity_description,
            'daily_calorie_target' => $request->daily_calorie_target,
            'preferred_muscle_groups' => $request->preferred_muscle_groups ? json_encode($request->preferred_muscle_groups) : null,
        ];

        if ($user->fitnessProfile) {
            $user->fitnessProfile->update($fitnessData);
        } else {
            $user->fitnessProfile()->create($fitnessData);
        }

        return redirect()->route('user.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update user avatar secara langsung
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        try {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $file = $request->file('avatar');
            $filename = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $avatarPath = $file->storeAs('avatars', $filename, 'public');

            // Update user avatar
            $user->update([
                'avatar' => $avatarPath,
            ]);

            return redirect()->route('user.profile.index')->with('success', 'Foto profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('user.profile.index')->with('error', 'Gagal memperbarui foto profil. Silakan coba lagi.');
        }
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
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Pastikan password lama cocok
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // Simpan password baru (dengan hashing)
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('user.profile.index')->with('success', 'Password berhasil diperbarui!');
    }
}
