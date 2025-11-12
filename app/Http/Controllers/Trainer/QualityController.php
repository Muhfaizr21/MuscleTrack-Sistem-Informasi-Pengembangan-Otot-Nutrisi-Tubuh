<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QualityController extends Controller
{
    /**
     * 🧾 Menampilkan status verifikasi trainer
     */
    public function showVerificationStatus()
    {
        $trainer = Auth::user();
        $verification = TrainerVerification::where('trainer_id', $trainer->id)
            ->latest()
            ->first();

        return view('trainer.quality.verification-status', compact('trainer', 'verification'));
    }

    /**
     * 📤 Form kirim pengajuan verifikasi trainer
     */
    public function feedbackIndex()
    {
        $trainer = Auth::user();
        $verification = TrainerVerification::where('trainer_id', $trainer->id)->latest()->first();

        // Jika sudah diverifikasi -> tampilkan pesan
        if ($verification && $verification->status === 'approved') {
            return redirect()->route('trainer.quality.verification.status')
                ->with('success', 'Kamu sudah terverifikasi sebagai trainer!');
        }

        return view('trainer.quality.daftar', compact('trainer', 'verification'));
    }

    /**
     * 💾 Kirim pengajuan verifikasi baru
     */
    public function sendFeedback(Request $request)
    {
        $trainer = Auth::user();

        $request->validate([
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bio' => 'required|string|max:1000',
        ]);

        $certificatePath = null;
        if ($request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
        }

        TrainerVerification::create([
            'trainer_id' => $trainer->id,
            'certificate' => $certificatePath,
            'bio' => $request->bio,
            'status' => 'pending',
        ]);

        return redirect()->route('trainer.quality.verification.status')
            ->with('success', 'Pengajuan verifikasi telah dikirim. Mohon tunggu konfirmasi dari admin.');
    }
}
