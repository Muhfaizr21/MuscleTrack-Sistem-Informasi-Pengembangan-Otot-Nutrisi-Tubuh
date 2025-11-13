<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TrainerProfile;
use App\Models\TrainerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerManagementController extends Controller
{
    /**
     * Menampilkan daftar semua trainer.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $trainers = User::where('role', 'trainer')
            ->with(['trainerProfile', 'trainerVerification'])
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, function($query) use ($status) {
                return $query->where('verification_status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.trainers.index', compact('trainers', 'search', 'status'));
    }

    /**
     * Menampilkan detail trainer.
     */
    public function show(User $trainer)
    {
        // Pastikan user adalah trainer
        if ($trainer->role !== 'trainer') {
            abort(404);
        }

        $trainer->load([
            'trainerProfile',
            'trainerVerification',
            'trainerMembershipsAsTrainer.user',
            'feedbacksReceived.user'
        ]);

        return view('admin.trainers.show', compact('trainer'));
    }

    /**
     * Menampilkan form verifikasi trainer.
     */
    public function editVerification(User $trainer)
    {
        if ($trainer->role !== 'trainer') {
            abort(404);
        }

        $trainer->load('trainerVerification');

        return view('admin.trainers.verification', compact('trainer'));
    }

    /**
     * Update status verifikasi trainer.
     */
    public function updateVerification(Request $request, User $trainer)
    {
        if ($trainer->role !== 'trainer') {
            abort(404);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_feedback' => 'nullable|string|max:500'
        ]);

        try {
            // Update verification status
            $trainer->update([
                'verification_status' => $request->status
            ]);

            // Update trainer verification record
            TrainerVerification::updateOrCreate(
                ['trainer_id' => $trainer->id],
                [
                    'status' => $request->status,
                    'admin_feedback' => $request->admin_feedback,
                    'verified_at' => $request->status === 'approved' ? now() : null
                ]
            );

            $statusText = $request->status === 'approved' ? 'disetujui' : 'ditolak';

            return redirect()->route('admin.trainers.index')
                ->with('success', "Verifikasi trainer {$trainer->name} berhasil {$statusText}.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus trainer.
     */
    public function destroy(User $trainer)
    {
        if ($trainer->role !== 'trainer') {
            abort(404);
        }

        $trainerName = $trainer->name;

        try {
            // Hapus data terkait
            TrainerProfile::where('user_id', $trainer->id)->delete();
            TrainerVerification::where('trainer_id', $trainer->id)->delete();

            // Hapus user (trainer)
            $trainer->delete();

            return redirect()->route('admin.trainers.index')
                ->with('success', "Trainer {$trainerName} berhasil dihapus.");

        } catch (\Exception $e) {
            return redirect()->route('admin.trainers.index')
                ->with('error', 'Terjadi kesalahan saat menghapus trainer.');
        }
    }

    /**
     * Mengaktifkan/nonaktifkan trainer.
     */
    public function toggleStatus(User $trainer)
    {
        if ($trainer->role !== 'trainer') {
            abort(404);
        }

        $newStatus = $trainer->verification_status === 'approved' ? 'pending' : 'approved';
        $trainer->update(['verification_status' => $newStatus]);

        $statusText = $newStatus === 'approved' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Trainer {$trainer->name} berhasil {$statusText}.");
    }
}
