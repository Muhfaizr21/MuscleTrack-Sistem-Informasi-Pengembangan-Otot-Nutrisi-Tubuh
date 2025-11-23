<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerVerification;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        // Hitung statistik rating
        $averageRating = Feedback::where('trainer_id', $trainer->id)->avg('rating') ?? 0;
        $totalRatings = Feedback::where('trainer_id', $trainer->id)->count();

        // Ambil beberapa rating terbaru untuk ditampilkan
        $ratings = Feedback::with(['user' => function($query) {
                $query->select('id', 'name', 'avatar');
            }])
            ->where('trainer_id', $trainer->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Hitung distribusi rating untuk chart
        $ratingDistribution = [];
        for ($i = 5; $i >= 2; $i--) {
            $ratingDistribution[$i] = Feedback::where('trainer_id', $trainer->id)
                ->where('rating', $i)
                ->count();
        }

        return view('trainer.quality.verification-status', compact(
            'trainer',
            'verification',
            'averageRating',
            'totalRatings',
            'ratings',
            'ratingDistribution'
        ));
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

    /**
     * ⭐ MENAMPILKAN SEMUA RATING & ULASAN UNTUK TRAINER
     */
    public function showRatings()
    {
        $trainer = Auth::user();

        $ratings = Feedback::with(['user' => function($query) {
                $query->select('id', 'name', 'avatar');
            }])
            ->where('trainer_id', $trainer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung statistik rating
        $averageRating = Feedback::where('trainer_id', $trainer->id)->avg('rating') ?? 0;
        $totalRatings = Feedback::where('trainer_id', $trainer->id)->count();

        // Distribusi rating per bintang
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = Feedback::where('trainer_id', $trainer->id)
                ->where('rating', $i)
                ->count();
        }

        return view('trainer.quality.ratings', compact(
            'ratings',
            'averageRating',
            'totalRatings',
            'ratingDistribution',
            'trainer'
        ));
    }

    /**
     * 🔧 Helper method untuk format tanggal yang aman
     */
    private function formatDateSafe($date)
    {
        try {
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('d M Y');
            }

            if (is_string($date)) {
                return Carbon::parse($date)->format('d M Y');
            }

            return 'Date not available';
        } catch (\Exception $e) {
            return 'Invalid date';
        }
    }

    /**
     * 🔧 Helper method untuk format datetime yang aman
     */
    private function formatDateTimeSafe($date)
    {
        try {
            if ($date instanceof \Carbon\Carbon) {
                return $date->format('d F Y, H:i');
            }

            if (is_string($date)) {
                return Carbon::parse($date)->format('d F Y, H:i');
            }

            return 'Date not available';
        } catch (\Exception $e) {
            return 'Invalid date';
        }
    }
}
