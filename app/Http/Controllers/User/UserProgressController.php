<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProgressController extends Controller
{
    public function index()
    {
        $progress = []; // nanti ambil dari tabel progress_user
        return view('user.progress.index', compact('progress'));
    }

    public function create()
    {
        return view('user.progress.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric',
            'muscle_mass' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);

        // contoh simpan (belum ada model)
        // Progress::create([...]);

        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $progress = []; // cari berdasarkan id
        return view('user.progress.edit', compact('progress'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'weight' => 'required|numeric',
            'muscle_mass' => 'required|numeric',
        ]);

        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil diperbarui!');
    }

    public function destroy($id)
    {
        return redirect()->route('user.progress.index')->with('success', 'Progress berhasil dihapus!');
    }
}
