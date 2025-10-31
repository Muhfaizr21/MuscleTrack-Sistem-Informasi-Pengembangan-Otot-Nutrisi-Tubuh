<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserWorkoutController extends Controller
{
    public function index()
    {
        $workouts = []; // nanti ambil dari tabel workouts
        return view('user.workouts.index', compact('workouts'));
    }

    public function create() { return view('user.workouts.create'); }
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        return redirect()->route('user.workouts.index')->with('success', 'Workout berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $workout = [];
        return view('user.workouts.edit', compact('workout'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required']);
        return redirect()->route('user.workouts.index')->with('success', 'Workout diperbarui!');
    }
    public function destroy($id)
    {
        return redirect()->route('user.workouts.index')->with('success', 'Workout dihapus!');
    }
}
