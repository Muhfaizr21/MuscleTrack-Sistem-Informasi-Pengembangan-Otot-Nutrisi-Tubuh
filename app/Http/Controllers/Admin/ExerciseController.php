<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Menampilkan daftar semua exercise.
     */
    public function index()
    {
        $exercises = Exercise::with('workoutPlans:id,title')
            ->latest()
            ->paginate(10);

        return view('admin.exercises.index', compact('exercises'));
    }

    /**
     * Menampilkan form untuk membuat exercise baru.
     */
    public function create()
    {
        $plans = WorkoutPlan::active()->get(['id', 'title']);
        return view('admin.exercises.create', compact('plans'));
    }

    /**
     * Simpan exercise baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'muscle_group' => 'nullable|string|max:255',
            'equipment' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
            'video_url' => 'nullable|url',
            'image_url' => 'nullable|url',
            'calories_burned' => 'nullable|integer|min:0',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'workout_plan_id' => 'nullable|exists:workout_plans,id'
        ]);

        $exercise = Exercise::create($request->except('workout_plan_id'));

        // Hubungkan ke workout plan jika dipilih
        if ($request->filled('workout_plan_id')) {
            $exercise->workoutPlans()->attach($request->workout_plan_id);
        }

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise baru berhasil dibuat.');
    }

    /**
     * Form edit exercise.
     */
    public function edit(Exercise $exercise)
    {
        $plans = WorkoutPlan::active()->get(['id', 'title']);
        $attachedPlans = $exercise->workoutPlans->pluck('id')->toArray();

        return view('admin.exercises.edit', compact('exercise', 'plans', 'attachedPlans'));
    }

    /**
     * Update exercise.
     */
    public function update(Request $request, Exercise $exercise)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
            'muscle_group' => 'nullable|string|max:255',
            'equipment' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
            'video_url' => 'nullable|url',
            'image_url' => 'nullable|url',
            'calories_burned' => 'nullable|integer|min:0',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
            'workout_plan_ids' => 'nullable|array',
            'workout_plan_ids.*' => 'exists:workout_plans,id',
        ]);

        $exercise->update($request->except('workout_plan_ids'));

        // Sinkronisasi hubungan dengan workout plans
        $exercise->workoutPlans()->sync($request->workout_plan_ids ?? []);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise berhasil diperbarui.');
    }

    /**
     * Hapus exercise.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->workoutPlans()->detach();
        $exercise->delete();

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise berhasil dihapus.');
    }

    /**
     * Form untuk menambahkan exercise ke workout plan.
     */
    public function attachForm(Exercise $exercise)
    {
        $plans = WorkoutPlan::active()->get(['id', 'title']);
        return view('admin.exercises.attach', compact('exercise', 'plans'));
    }

    /**
     * Menyimpan hubungan exercise → workout plan.
     */
    public function attach(Request $request, Exercise $exercise)
    {
        $request->validate([
            'workout_plan_id' => 'required|exists:workout_plans,id'
        ]);

        $exercise->workoutPlans()->syncWithoutDetaching($request->workout_plan_id);

        return redirect()->route('admin.exercises.index')
            ->with('success', 'Exercise berhasil ditambahkan ke workout plan.');
    }
}
