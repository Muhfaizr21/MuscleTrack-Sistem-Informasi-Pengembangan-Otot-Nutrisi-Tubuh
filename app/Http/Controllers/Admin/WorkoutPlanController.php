<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan; // Gunakan model yang baru kita buat
use Illuminate\Http\Request;

class WorkoutPlanController extends Controller
{
    /**
     * Menampilkan daftar semua program latihan.
     */
    public function index()
    {
        $plans = WorkoutPlan::latest()->paginate(10);
        return view('admin.workout_plans.index', compact('plans'));
    }

    /**
     * Menampilkan form untuk membuat program baru.
     */
    public function create()
    {
        return view('admin.workout_plans.create');
    }

    /**
     * Menyimpan program baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_fitness' => 'nullable|string',
            'focus_area' => 'nullable|string',
            'bmi_category' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'difficulty_level' => 'nullable|string',
            'duration_weeks' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        // Model::boot() akan otomatis mengisi user_id
        WorkoutPlan::create($request->all());

        return redirect()->route('admin.workout-plans.index')
                         ->with('success', 'Program latihan baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit program.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        return view('admin.workout_plans.edit', ['plan' => $workoutPlan]);
    }

    /**
     * Update program di database.
     */
    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_fitness' => 'nullable|string',
            'focus_area' => 'nullable|string',
            'bmi_category' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'difficulty_level' => 'nullable|string',
            'duration_weeks' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $workoutPlan->update($request->all());

        return redirect()->route('admin.workout-plans.index')
                         ->with('success', 'Program latihan berhasil diperbarui.');
    }

    /**
     * Hapus program dari database.
     */
    public function destroy(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->delete();
        return redirect()->route('admin.workout-plans.index')
                         ->with('success', 'Program latihan berhasil dihapus.');
    }
}
