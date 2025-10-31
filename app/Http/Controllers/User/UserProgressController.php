<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyMetric;
use App\Models\Notification;
use Carbon\Carbon;

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
            ->orderBy('recorded_at', 'asc')
            ->get(['id', 'weight', 'muscle_mass', 'body_fat', 'recorded_at']);

        // Kirim data ke view (grafik berat, otot, lemak)
        return view('user.progress.index', compact('progress'));
    }

    /**
     * Form tambah progress baru
     */
    public function create()
    {
        return view('user.progress.create');
    }

    /**
     * Simpan data baru dan buat notifikasi jika ada perubahan signifikan
     */
    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:1',
            'muscle_mass' => 'nullable|numeric|min:0',
            'body_fat' => 'nullable|numeric|min:0',
            'recorded_at' => 'required|date',
        ]);

        $user = Auth::user();

        // Ambil data terakhir untuk pembanding
        $lastMetric = BodyMetric::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->first();

        // Simpan data baru
        $metric = BodyMetric::create([
            'user_id' => $user->id,
            'weight' => $request->weight,
            'muscle_mass' => $request->muscle_mass,
            'body_fat' => $request->body_fat,
            'recorded_at' => $request->recorded_at,
        ]);

        // 🔔 Cek perubahan signifikan dan buat notifikasi
        if ($lastMetric) {
            $notifications = [];

            if (abs($request->weight - $lastMetric->weight) >= 2) {
                $notifications[] = "Berat badan berubah dari {$lastMetric->weight} kg ke {$request->weight} kg.";
            }

            if (!is_null($request->muscle_mass) && abs($request->muscle_mass - $lastMetric->muscle_mass) >= 1) {
                $notifications[] = "Massa otot berubah dari {$lastMetric->muscle_mass} kg ke {$request->muscle_mass} kg.";
            }

            if (!is_null($request->body_fat) && abs($request->body_fat - $lastMetric->body_fat) >= 2) {
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
     * Edit progress (opsional)
     */
    public function edit($id)
    {
        $progress = BodyMetric::findOrFail($id);
        return view('user.progress.edit', compact('progress'));
    }

    /**
     * Update progress
     */

    
    public function update(Request $request, $id)
    {
        // Debug: lihat data yang dikirim
    //dd($request->all());
        $request->validate([
            'weight' => 'required|numeric|min:1',
            'muscle_mass' => 'nullable|numeric|min:0',
            'body_fat' => 'nullable|numeric|min:0',
            'recorded_at' => 'required|date',
        ]);

        $user = Auth::user();

        // Pastikan record memang milik user yang login
        $progress = BodyMetric::where('user_id', $user->id)->findOrFail($id);

        // Simpan nilai lama sebelum update
        $oldMetric = clone $progress;

        // ✅ Update data
        $progress->update([
            'weight' => $request->weight,
            'muscle_mass' => $request->muscle_mass,
            'body_fat' => $request->body_fat,
            'recorded_at' => $request->recorded_at,
        ]);

        // 🔔 Buat notifikasi perubahan signifikan
        $notifications = [];

        if (abs($request->weight - $oldMetric->weight) >= 2) {
            $notifications[] = "Berat badan berubah dari {$oldMetric->weight} kg ke {$request->weight} kg.";
        }

        if (!is_null($request->muscle_mass) && abs($request->muscle_mass - $oldMetric->muscle_mass) >= 1) {
            $notifications[] = "Massa otot berubah dari {$oldMetric->muscle_mass} kg ke {$request->muscle_mass} kg.";
        }

        if (!is_null($request->body_fat) && abs($request->body_fat - $oldMetric->body_fat) >= 2) {
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
        $progress = BodyMetric::findOrFail($id);
        $progress->delete();

        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil dihapus!');
    }
}
