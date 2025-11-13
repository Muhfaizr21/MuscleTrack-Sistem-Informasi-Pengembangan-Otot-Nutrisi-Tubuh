<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BodyMetric;
use App\Models\Notification;
use App\Models\UserFitnessProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProgressController extends Controller
{
    /**
     * Tampilkan grafik perkembangan user
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua data body_metrics milik user, urutkan berdasarkan tanggal
        $progress = BodyMetric::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->get();

        // Ambil profil fitness user
        $fitnessProfile = UserFitnessProfile::where('user_id', $user->id)->first();

        // Kirim data ke view
        return view('user.progress.index', compact('progress', 'fitnessProfile'));
    }

    /**
     * Form tambah progress baru
     */
    public function create()
    {
        $user = Auth::user();
        $fitnessProfile = UserFitnessProfile::where('user_id', $user->id)->first();

        return view('user.progress.create', compact('fitnessProfile'));
    }

    /**
     * Simpan data baru dan buat notifikasi jika ada perubahan signifikan
     */
    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:1',
            'height' => 'nullable|numeric|min:1',
            'body_fat' => 'nullable|numeric|min:0|max:100',
            'muscle_mass' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'arm' => 'nullable|numeric|min:0',
            'photo_progress' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'recorded_at' => 'required|date',
        ]);

        $user = Auth::user();

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo_progress')) {
            $photoPath = $request->file('photo_progress')->store('progress-photos', 'public');
        }

        // Update weight di tabel users
        $user->update([
            'weight' => $request->weight,
            'height' => $request->height ?? $user->height
        ]);

        // Ambil data terakhir untuk pembanding
        $lastMetric = BodyMetric::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->first();

        // Simpan data baru
        $metric = BodyMetric::create([
            'user_id' => $user->id,
            'weight' => $request->weight,
            'height' => $request->height,
            'body_fat' => $request->body_fat,
            'muscle_mass' => $request->muscle_mass,
            'waist' => $request->waist,
            'chest' => $request->chest,
            'arm' => $request->arm,
            'photo_progress' => $photoPath,
            'recorded_at' => $request->recorded_at,
        ]);

        // 🔔 Cek perubahan signifikan dan buat notifikasi
        if ($lastMetric) {
            $notifications = [];

            if (abs($request->weight - $lastMetric->weight) >= 2) {
                $notifications[] = "Berat badan berubah dari {$lastMetric->weight} kg ke {$request->weight} kg.";
            }

            if (
                $request->muscle_mass && $lastMetric->muscle_mass &&
                abs($request->muscle_mass - $lastMetric->muscle_mass) >= 1
            ) {
                $notifications[] = "Massa otot berubah dari {$lastMetric->muscle_mass} kg ke {$request->muscle_mass} kg.";
            }

            if (
                $request->body_fat && $lastMetric->body_fat &&
                abs($request->body_fat - $lastMetric->body_fat) >= 2
            ) {
                $notifications[] = "Persentase lemak tubuh berubah dari {$lastMetric->body_fat}% ke {$request->body_fat}%.";
            }

            foreach ($notifications as $message) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Progress Update 💪',
                    'message' => $message,
                    'type' => 'info',
                    'read_status' => false,
                ]);
            }
        }

        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil ditambahkan!');
    }

    /**
     * Edit progress
     */
    public function edit($id)
    {
        $user = Auth::user();
        $progress = BodyMetric::where('user_id', $user->id)->findOrFail($id);
        $fitnessProfile = UserFitnessProfile::where('user_id', $user->id)->first();

        return view('user.progress.edit', compact('progress', 'fitnessProfile'));
    }

    /**
     * Update progress
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'weight' => 'required|numeric|min:1',
            'height' => 'nullable|numeric|min:1',
            'body_fat' => 'nullable|numeric|min:0|max:100',
            'muscle_mass' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'arm' => 'nullable|numeric|min:0',
            'photo_progress' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'recorded_at' => 'required|date',
        ]);

        $user = Auth::user();

        // Pastikan record memang milik user yang login
        $progress = BodyMetric::where('user_id', $user->id)->findOrFail($id);

        // Handle photo upload
        $photoPath = $progress->photo_progress;
        if ($request->hasFile('photo_progress')) {
            // Delete old photo if exists
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo_progress')->store('progress-photos', 'public');
        }

        // Update weight di tabel users
        $user->update([
            'weight' => $request->weight,
            'height' => $request->height ?? $user->height
        ]);

        // Simpan nilai lama sebelum update
        $oldMetric = clone $progress;

        // Update data
        $progress->update([
            'weight' => $request->weight,
            'height' => $request->height,
            'body_fat' => $request->body_fat,
            'muscle_mass' => $request->muscle_mass,
            'waist' => $request->waist,
            'chest' => $request->chest,
            'arm' => $request->arm,
            'photo_progress' => $photoPath,
            'recorded_at' => $request->recorded_at,
        ]);

        // 🔔 Buat notifikasi perubahan signifikan
        $notifications = [];

        if (abs($request->weight - $oldMetric->weight) >= 2) {
            $notifications[] = "Berat badan berubah dari {$oldMetric->weight} kg ke {$request->weight} kg.";
        }

        if (
            $request->muscle_mass && $oldMetric->muscle_mass &&
            abs($request->muscle_mass - $oldMetric->muscle_mass) >= 1
        ) {
            $notifications[] = "Massa otot berubah dari {$oldMetric->muscle_mass} kg ke {$request->muscle_mass} kg.";
        }

        if (
            $request->body_fat && $oldMetric->body_fat &&
            abs($request->body_fat - $oldMetric->body_fat) >= 2
        ) {
            $notifications[] = "Persentase lemak tubuh berubah dari {$oldMetric->body_fat}% ke {$request->body_fat}%.";
        }

        foreach ($notifications as $message) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Progress Update 💪',
                'message' => $message,
                'type' => 'info',
                'read_status' => false,
            ]);
        }

        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil diperbarui!');
    }

    /**
     * Hapus progress
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $progress = BodyMetric::where('user_id', $user->id)->findOrFail($id);

        // Delete photo if exists
        if ($progress->photo_progress) {
            Storage::disk('public')->delete($progress->photo_progress);
        }

        $progress->delete();

        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil dihapus!');
    }
}
