<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\TrainerProfile;
use App\Models\TrainerVerification;
use App\Models\TrainerMembership;
use App\Models\WorkoutPlan;
use App\Models\Feedback;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TrainerProfileController extends Controller
{
    /**
     * Menampilkan halaman profil trainer
     */
    public function index()
    {
        $user = Auth::user();
        $trainerProfile = $user->trainerProfile;
        $verification = $user->trainerVerification;

        // Stats untuk dashboard trainer berdasarkan database
        $stats = [
            'total_members' => TrainerMembership::where('trainer_id', $user->id)->count(),
            'active_programs' => WorkoutPlan::where('trainer_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'total_ratings' => Feedback::where('trainer_id', $user->id)->count(),
            'average_rating' => Feedback::where('trainer_id', $user->id)->avg('rating') ?? 0,
        ];

        // Member terbaru (5 member terbaru)
        $recentMembers = User::where('trainer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('trainer.profile.index', compact(
            'user',
            'trainerProfile',
            'verification',
            'stats',
            'recentMembers'
        ));
    }

    /**
     * Menampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        $trainerProfile = $user->trainerProfile;
        $verification = $user->trainerVerification;

        // Jika trainer profile belum ada, buat yang baru
        if (!$trainerProfile) {
            $trainerProfile = new TrainerProfile();
        }

        return view('trainer.profile.edit', compact('user', 'trainerProfile', 'verification'));
    }

    /**
     * Update profil trainer
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $validated = $request->validate([
            // Data user
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'age' => 'nullable|integer|min:18|max:100',
            'gender' => 'nullable|in:male,female',
            'height' => 'nullable|numeric|min:100|max:250',
            'weight' => 'nullable|numeric|min:30|max:200',

            // Data trainer profile
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'certifications' => 'nullable|string|max:1000',

            // File uploads
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'certificate_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        try {
            // Update data user
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'age' => $validated['age'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'height' => $validated['height'] ?? null,
                'weight' => $validated['weight'] ?? null,
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Hapus avatar lama jika ada
                if ($user->avatar && Storage::exists($user->avatar)) {
                    Storage::delete($user->avatar);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->update(['avatar' => $avatarPath]);
            }

            // Update atau create trainer profile
            $trainerProfile = TrainerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => $validated['bio'] ?? null,
                    'specialization' => $validated['specialization'] ?? null,
                    'experience_years' => $validated['experience_years'] ?? 0,
                    'certifications' => $validated['certifications'] ?? null,
                ]
            );

            // Handle certificate upload untuk verifikasi
            if ($request->hasFile('certificate_file')) {
                $certificatePath = $request->file('certificate_file')->store('certificates', 'public');

                // Update atau create trainer verification
                TrainerVerification::updateOrCreate(
                    ['trainer_id' => $user->id],
                    [
                        'certificate' => $certificatePath,
                        'bio' => $validated['bio'] ?? null,
                        'status' => 'pending', // Reset status ke pending jika upload sertifikat baru
                    ]
                );
            }

            return redirect()->route('trainer.profile.index')
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update password trainer
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Update settings trainer
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $settings = $user->settings ?? [];

        // Update settings berdasarkan input
        if ($request->has('notification_workout')) {
            $settings['notifications']['workout'] = $request->boolean('notification_workout');
        }

        if ($request->has('notification_nutrition')) {
            $settings['notifications']['nutrition'] = $request->boolean('notification_nutrition');
        }

        if ($request->has('notification_chat')) {
            $settings['notifications']['chat'] = $request->boolean('notification_chat');
        }

        if ($request->has('language')) {
            $settings['language'] = $request->language;
        }

        if ($request->has('timezone')) {
            $settings['timezone'] = $request->timezone;
        }

        $user->update(['settings' => $settings]);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Hapus avatar
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
    }
}
