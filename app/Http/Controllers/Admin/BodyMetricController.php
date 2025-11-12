<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyMetric;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BodyMetricController extends Controller
{
    /**
     * Menampilkan daftar semua log body metric.
     */
    public function index()
    {
        $metrics = BodyMetric::with('user') // Ambil relasi user
            ->latest('recorded_at')
            ->paginate(15);

        return view('admin.body_metrics.index', compact('metrics'));
    }

    /**
     * Menampilkan form untuk menambah log baru (oleh Admin).
     */
    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.body_metrics.create', compact('users'));
    }

    /**
     * Menyimpan log baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'body_fat' => 'nullable|numeric',
            'muscle_mass' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'arm' => 'nullable|numeric',
            'photo_progress' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'recorded_at' => 'required|date',
        ]);

        $data = $request->except('photo_progress');

        if ($request->hasFile('photo_progress')) {
            // Simpan di 'storage/app/public/progress_photos'
            $data['photo_progress'] = $request->file('photo_progress')->store('progress_photos', 'public');
        }

        BodyMetric::create($data);

        return redirect()->route('admin.body-metrics.index')
            ->with('success', 'Data body metric berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit log.
     */
    public function edit(BodyMetric $bodyMetric)
    {
        $users = User::where('role', 'user')->orderBy('name')->get();

        return view('admin.body_metrics.edit', ['metric' => $bodyMetric, 'users' => $users]);
    }

    /**
     * Update log di database.
     */
    public function update(Request $request, BodyMetric $bodyMetric)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'body_fat' => 'nullable|numeric',
            'muscle_mass' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'arm' => 'nullable|numeric',
            'photo_progress' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'recorded_at' => 'required|date',
        ]);

        $data = $request->except('photo_progress');

        if ($request->hasFile('photo_progress')) {
            // 1. Hapus foto lama (jika ada)
            if ($bodyMetric->photo_progress) {
                Storage::disk('public')->delete($bodyMetric->photo_progress);
            }
            // 2. Upload foto baru
            $data['photo_progress'] = $request->file('photo_progress')->store('progress_photos', 'public');
        }

        $bodyMetric->update($data);

        return redirect()->route('admin.body-metrics.index')
            ->with('success', 'Data body metric berhasil diperbarui.');
    }

    /**
     * Hapus log dari database.
     */
    public function destroy(BodyMetric $bodyMetric)
    {
        // Hapus foto dari storage
        if ($bodyMetric->photo_progress) {
            Storage::disk('public')->delete($bodyMetric->photo_progress);
        }

        $bodyMetric->delete();

        return redirect()->route('admin.body-metrics.index')
            ->with('success', 'Data body metric berhasil dihapus.');
    }
}
