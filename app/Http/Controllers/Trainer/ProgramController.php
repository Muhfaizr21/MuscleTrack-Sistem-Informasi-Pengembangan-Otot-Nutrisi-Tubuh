<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\NutritionPlan;
use App\Models\TrainerVerification;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    /**
     * 🧭 Menampilkan form edit program latihan & nutrisi member
     */
    public function edit($memberId)
    {
        $trainer = Auth::user();

        // 🔒 Cek status verifikasi
        if ($trainer->verification_status !== 'approved') {
            return redirect()
                ->route('trainer.programs.daftar')
                ->with('warning', 'Akun Anda belum terverifikasi sebagai trainer. Silakan ajukan verifikasi terlebih dahulu.');
        }

        $member = User::findOrFail($memberId);

        if ($member->trainer_id !== $trainer->id) {
            abort(403, 'Anda tidak memiliki akses ke member ini.');
        }

        $workoutPlan = WorkoutPlan::where('user_id', $member->id)->latest()->first();
        $nutritionPlan = NutritionPlan::where('user_id', $member->id)->latest()->first();

        return view('trainer.programs.edit', compact('member', 'workoutPlan', 'nutritionPlan'));
    }

    /**
     * 📋 Halaman pendaftaran trainer
     */
    public function daftar()
    {
        $trainer = Auth::user();

        // Cek apakah sudah pernah ajukan verifikasi
        $request = TrainerVerification::where('trainer_id', $trainer->id)->latest()->first();

        return view('trainer.programs.daftar', compact('trainer', 'request'));
    }

    /**
     * 📨 Kirim pengajuan verifikasi trainer
     */
    public function ajukan(Request $request)
    {
        $trainer = Auth::user();

        $request->validate([
            'bio' => 'required|string|max:1000',
            'certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->hasFile('certificate')
            ? $request->file('certificate')->store('certificates', 'public')
            : null;

        TrainerVerification::create([
            'trainer_id' => $trainer->id,
            'certificate' => $path,
            'bio' => $request->bio,
            'status' => 'pending',
        ]);

        $trainer->update(['verification_status' => 'pending']);

        return redirect()
            ->route('trainer.programs.daftar')
            ->with('success', 'Pengajuan verifikasi telah dikirim. Tunggu persetujuan admin.');
    }
}
