<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainerMembership;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerMemberController extends Controller
{
    /**
     * Menampilkan daftar semua user premium dan trainernya.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Query dasar dengan relasi
        $memberships = TrainerMembership::with([
                'user' => function($query) {
                    $query->select('id', 'name', 'email', 'avatar', 'created_at');
                },
                'trainer' => function($query) {
                    $query->select('id', 'name', 'email', 'avatar', 'verification_status');
                }
            ])
            ->when($search, function($query) use ($search) {
                return $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('trainer', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); // Pertahankan parameter search di pagination

        return view('admin.trainer_memberships.index', compact('memberships', 'search'));
    }

    /**
     * Menampilkan form untuk menugaskan user ke trainer.
     */
    public function create()
    {
        // Ambil user yang belum memiliki trainer
        $users = User::where('role', 'user')
            ->whereDoesntHave('trainerMembershipsAsUser')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'created_at']);

        // Ambil trainer yang sudah terverifikasi
        $trainers = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('admin.trainer_memberships.create', compact('users', 'trainers'));
    }

    /**
     * Menyimpan penugasan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                'unique:trainer_memberships,user_id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user || $user->role !== 'user') {
                        $fail('User yang dipilih harus memiliki role user.');
                    }
                }
            ],
            'trainer_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $trainer = User::find($value);
                    if (!$trainer || $trainer->role !== 'trainer') {
                        $fail('Trainer yang dipilih harus memiliki role trainer.');
                    }
                    if ($trainer->verification_status !== 'approved') {
                        $fail('Trainer yang dipilih harus sudah terverifikasi.');
                    }
                }
            ],
        ], [
            'user_id.unique' => 'User ini sudah memiliki trainer.',
            'user_id.exists' => 'User yang dipilih tidak ditemukan.',
            'trainer_id.exists' => 'Trainer yang dipilih tidak ditemukan.',
        ]);

        try {
            TrainerMembership::create($request->all());

            // Update trainer_id di user untuk konsistensi
            User::where('id', $request->user_id)->update([
                'trainer_id' => $request->trainer_id
            ]);

            return redirect()->route('admin.trainer-memberships.index')
                ->with('success', 'User berhasil ditugaskan ke trainer.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menghapus penugasan (un-assign).
     */
    public function destroy(TrainerMembership $trainerMembership)
    {
        $userName = $trainerMembership->user->name ?? 'User';
        $trainerName = $trainerMembership->trainer->name ?? 'Trainer';

        try {
            // Hapus trainer_id dari user
            User::where('id', $trainerMembership->user_id)->update([
                'trainer_id' => null
            ]);

            $trainerMembership->delete();

            return redirect()->route('admin.trainer-memberships.index')
                ->with('success', "Penugasan {$userName} ke {$trainerName} berhasil dihapus.");

        } catch (\Exception $e) {
            return redirect()->route('admin.trainer-memberships.index')
                ->with('error', 'Terjadi kesalahan saat menghapus penugasan.');
        }
    }
}
