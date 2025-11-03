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
    public function index()
    {
        // Ambil semua data + relasi user dan trainernya
        $memberships = TrainerMembership::with(['user', 'trainer'])
                                        ->latest()
                                        ->paginate(15);

        return view('admin.trainer_memberships.index', compact('memberships'));
    }

    /**
     * Menampilkan form untuk menugaskan user ke trainer.
     */
    public function create()
    {
        // Ambil semua user (role 'user')
        $users = User::where('role', 'user')->orderBy('name')->get();

        // Ambil semua trainer (role 'trainer')
        $trainers = User::where('role', 'trainer')->orderBy('name')->get();

        return view('admin.trainer_memberships.create', compact('users', 'trainers'));
    }

    /**
     * Menyimpan penugasan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:trainer_memberships,user_id',
            'trainer_id' => 'required|exists:users,id',
        ], [
            'user_id.unique' => 'User ini sudah memiliki trainer.'
        ]);

        TrainerMembership::create($request->all());

        return redirect()->route('admin.trainer-memberships.index')
                         ->with('success', 'User berhasil ditugaskan ke trainer.');
    }

    /**
     * Menghapus penugasan (un-assign).
     */
    public function destroy(TrainerMembership $trainerMembership)
    {
        $trainerMembership->delete();
        return redirect()->route('admin.trainer-memberships.index')
                         ->with('success', 'Penugasan user ke trainer berhasil dihapus.');
    }
}
