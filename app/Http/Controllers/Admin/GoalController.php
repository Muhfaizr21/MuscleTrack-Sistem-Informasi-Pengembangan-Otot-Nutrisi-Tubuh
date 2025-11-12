<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::latest()->paginate(10); // GANTI get() MENJADI paginate()

        return view('admin.goals.index', compact('goals'));
    }

    public function create()
    {
        return view('admin.goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Goal::create($request->all());

        return redirect()->route('admin.goals.index')->with('success', 'Goal baru berhasil dibuat.');
    }

    public function edit(Goal $goal)
    {
        return view('admin.goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $goal->update($request->all());

        return redirect()->route('admin.goals.index')->with('success', 'Goal berhasil diperbarui.');
    }

    public function destroy(Goal $goal)
    {
        // TODO: Cek dulu jika ada user yang pakai goal ini
        $goal->delete();

        return redirect()->route('admin.goals.index')->with('success', 'Goal berhasil dihapus.');
    }
}
