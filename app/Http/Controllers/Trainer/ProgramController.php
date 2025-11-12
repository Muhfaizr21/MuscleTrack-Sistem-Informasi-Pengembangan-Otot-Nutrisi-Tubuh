<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerVerification;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    /**
     * 📋 Daftar semua member di bawah bimbingan trainer
     */
    public function index()
    {
        $trainer = Auth::user();

        // 🚫 Pastikan login sebagai trainer
        if (! $trainer || $trainer->role !== 'trainer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai trainer terlebih dahulu.');
        }

        // ✅ Ambil semua member yang dibimbing trainer
        $members = User::where('trainer_id', $trainer->id)
            ->with('workoutPlans') // pastikan relasi di model User
            ->get();

        return view('trainer.programs.index', compact('trainer', 'members'));
    }

    /**
     * 🧭 Menampilkan form edit program latihan member
     */
    public function edit($memberId)
    {
        $trainer = Auth::user();

        // 🚫 Cek login & role
        if (! $trainer || $trainer->role !== 'trainer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai trainer terlebih dahulu.');
        }

        // ✅ Pastikan trainer sudah diverifikasi
        $isVerified = $trainer->verification_status === 'approved' &&
            TrainerVerification::where('trainer_id', $trainer->id)
                ->where('status', 'approved')
                ->exists();

        if (! $isVerified) {
            return redirect()
                ->route('trainer.quality.verification.status')
                ->with('warning', 'Akun Anda belum diverifikasi sebagai trainer.');
        }

        // 🧍 Ambil member yang benar-benar dibimbing oleh trainer
        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->first();

        if (! $member) {
            abort(403, 'Anda tidak memiliki akses ke member ini.');
        }

        // ✅ Ambil data program latihan
        $workoutPlan = WorkoutPlan::where('user_id', $member->id)->latest()->first();

        return view('trainer.programs.edit', compact('member', 'workoutPlan'));
    }

    /**
     * 💾 Simpan / update program latihan member
     */
    public function update(Request $request, $memberId)
    {
        $trainer = Auth::user();

        // 🚫 Pastikan hanya bisa mengedit member miliknya
        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->first();

        if (! $member) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit member ini.');
        }

        // 🧾 Validasi input
        $request->validate([
            'workout_title' => 'required|string|max:255',
            'level' => 'nullable|string|max:50',
            'duration_weeks' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        // 🏋️ Simpan atau perbarui workout plan
        WorkoutPlan::updateOrCreate(
            ['user_id' => $member->id],
            [
                'title' => $request->workout_title,
                'level' => $request->level,
                'duration_weeks' => $request->duration_weeks,
                'description' => $request->description,
            ]
        );

        // ✅ Redirect ke halaman index dengan pesan sukses
        return redirect()
            ->route('trainer.programs.index')
            ->with('success', "✅ Program latihan untuk {$member->name} berhasil diperbarui!");
    }

    /**
     * 📋 Halaman daftar & pengajuan verifikasi trainer
     */
    public function daftar()
    {
        $trainer = Auth::user();
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
            ->with('success', '✅ Pengajuan verifikasi telah dikirim. Tunggu persetujuan admin.');
    }
}
