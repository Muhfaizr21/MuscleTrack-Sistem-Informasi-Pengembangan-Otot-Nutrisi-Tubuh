<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan;
use App\Models\WorkoutExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkoutPlanController extends Controller
{
    /**
     * Menampilkan daftar semua program latihan.
     */
    public function index()
    {
        $plans = WorkoutPlan::withCount('workoutExercises')
                           ->latest()
                           ->paginate(10);

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
        Log::info('=== STORE REQUEST START ===');
        Log::info('Request Data:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_fitness' => 'nullable|string',
            'focus_area' => 'nullable|string',
            'bmi_category' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced,expert',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'required|integer|min:10|max:180',
            'sessions_per_week' => 'nullable|integer|min:1|max:14',
            'equipment_needed' => 'nullable|string|max:255',
            'detailed_description' => 'nullable|string',
            'notes' => 'nullable|string',
            'exercises' => 'required|array|min:1',
            'exercises.*.name' => 'required|string|max:255',
            'exercises.*.type' => 'nullable|string|in:strength,cardio,core,flexibility,warmup,cooldown',
            'exercises.*.description' => 'nullable|string',
            'exercises.*.sets' => 'nullable|integer|min:1|max:20',
            'exercises.*.reps' => 'nullable|string|max:50',
            'exercises.*.duration_minutes' => 'nullable|integer|min:1|max:60',
            'exercises.*.rest_seconds' => 'nullable|integer|min:0|max:600',
            'exercises.*.video_url' => 'nullable|url|max:500',
            'exercises.*.instructions' => 'nullable|string',
            'exercises.*.muscle_group' => 'nullable|string|max:100',
            'exercises.*.equipment' => 'nullable|string|max:100',
            'exercises.*.notes' => 'nullable|string',
        ]);

        Log::info('Validation passed:', $validated);

        DB::beginTransaction();

        try {
            // 1. Simpan workout plan utama
            $workoutPlan = new WorkoutPlan();
            $workoutPlan->title = $validated['title'];
            $workoutPlan->description = $validated['description'] ?? null;
            $workoutPlan->target_fitness = $validated['target_fitness'] ?? null;
            $workoutPlan->focus_area = $validated['focus_area'] ?? null;
            $workoutPlan->bmi_category = $validated['bmi_category'] ?? null;
            $workoutPlan->status = $validated['status'];
            $workoutPlan->difficulty_level = $validated['difficulty_level'];
            $workoutPlan->duration_weeks = $validated['duration_weeks'];
            $workoutPlan->duration_minutes = $validated['duration_minutes'];
            $workoutPlan->sessions_per_week = $validated['sessions_per_week'] ?? null;
            $workoutPlan->equipment_needed = $validated['equipment_needed'] ?? null;
            $workoutPlan->detailed_description = $validated['detailed_description'] ?? null;
            $workoutPlan->notes = $validated['notes'] ?? null;
            $workoutPlan->is_premium = $request->has('is_premium');
            $workoutPlan->created_by = auth()->id();

            $workoutPlan->save();

            Log::info('Workout plan created - ID: ' . $workoutPlan->id);

            // 2. Simpan exercises
            $order = 1;
            foreach ($validated['exercises'] as $index => $exerciseData) {
                $exercise = new WorkoutExercise();
                $exercise->workout_plan_id = $workoutPlan->id;
                $exercise->name = $exerciseData['name'];
                $exercise->type = $exerciseData['type'] ?? 'strength';
                $exercise->description = $exerciseData['description'] ?? null;
                $exercise->sets = $exerciseData['sets'] ?? 3;
                $exercise->reps = $exerciseData['reps'] ?? '10-12';
                $exercise->duration_minutes = $exerciseData['duration_minutes'] ?? null;
                $exercise->rest_seconds = $exerciseData['rest_seconds'] ?? 60;
                $exercise->video_url = $exerciseData['video_url'] ?? null;
                $exercise->instructions = $exerciseData['instructions'] ?? null;
                $exercise->muscle_group = $exerciseData['muscle_group'] ?? null;
                $exercise->equipment = $exerciseData['equipment'] ?? null;
                $exercise->notes = $exerciseData['notes'] ?? null;
                $exercise->order = $order;

                $exercise->save();

                Log::info("Exercise {$index} created - ID: " . $exercise->id);
                $order++;
            }

            DB::commit();
            Log::info('=== STORE TRANSACTION COMMITTED ===');

            // Clear session cache
            session()->forget('_old_input');

            return redirect()->route('admin.workout-plans.index')
                ->with('success', 'Program latihan baru berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());

            return back()
                ->withInput()
                ->with('error', 'Gagal membuat program latihan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail program.
     */
    public function show(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load(['workoutExercises' => function($query) {
            $query->orderBy('order')->orderBy('id');
        }]);
        return view('admin.workout_plans.show', compact('workoutPlan'));
    }

    /**
     * Menampilkan form untuk mengedit program.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load(['workoutExercises' => function($query) {
            $query->orderBy('order')->orderBy('id');
        }]);
        return view('admin.workout_plans.edit', compact('workoutPlan'));
    }

    /**
     * Update program di database.
     */
    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        Log::info('=== UPDATE REQUEST START ===');
        Log::info('Workout Plan ID: ' . $workoutPlan->id);
        Log::info('All Request Data:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_fitness' => 'nullable|string',
            'focus_area' => 'nullable|string',
            'bmi_category' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced,expert',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'required|integer|min:10|max:180',
            'sessions_per_week' => 'nullable|integer|min:1|max:14',
            'equipment_needed' => 'nullable|string|max:255',
            'detailed_description' => 'nullable|string',
            'notes' => 'nullable|string',
            'exercises' => 'required|array|min:1',
            'exercises.*.id' => 'nullable|integer',
            'exercises.*.name' => 'required|string|max:255',
            'exercises.*.type' => 'nullable|string|in:strength,cardio,core,flexibility,warmup,cooldown',
            'exercises.*.description' => 'nullable|string',
            'exercises.*.sets' => 'nullable|integer|min:1|max:20',
            'exercises.*.reps' => 'nullable|string|max:50',
            'exercises.*.duration_minutes' => 'nullable|integer|min:1|max:60',
            'exercises.*.rest_seconds' => 'nullable|integer|min:0|max:600',
            'exercises.*.video_url' => 'nullable|url|max:500',
            'exercises.*.instructions' => 'nullable|string',
            'exercises.*.muscle_group' => 'nullable|string|max:100',
            'exercises.*.equipment' => 'nullable|string|max:100',
            'exercises.*.notes' => 'nullable|string',
            'exercises.*.order' => 'required|integer|min:1',
        ]);

        Log::info('Validation passed:', $validated);

        DB::beginTransaction();

        try {
            // 1. Update workout plan utama
            $workoutPlan->title = $validated['title'];
            $workoutPlan->description = $validated['description'] ?? null;
            $workoutPlan->target_fitness = $validated['target_fitness'] ?? null;
            $workoutPlan->focus_area = $validated['focus_area'] ?? null;
            $workoutPlan->bmi_category = $validated['bmi_category'] ?? null;
            $workoutPlan->status = $validated['status'];
            $workoutPlan->difficulty_level = $validated['difficulty_level'];
            $workoutPlan->duration_weeks = $validated['duration_weeks'];
            $workoutPlan->duration_minutes = $validated['duration_minutes'];
            $workoutPlan->sessions_per_week = $validated['sessions_per_week'] ?? null;
            $workoutPlan->equipment_needed = $validated['equipment_needed'] ?? null;
            $workoutPlan->detailed_description = $validated['detailed_description'] ?? null;
            $workoutPlan->notes = $validated['notes'] ?? null;
            $workoutPlan->is_premium = $request->has('is_premium');
            $workoutPlan->updated_by = auth()->id();

            $workoutPlan->save();
            Log::info('Workout plan updated - ID: ' . $workoutPlan->id);

            // 2. Handle exercises
            $exerciseIds = [];

            foreach ($validated['exercises'] as $exerciseData) {
                if (!empty($exerciseData['id'])) {
                    // Update existing exercise
                    $exercise = WorkoutExercise::where('id', $exerciseData['id'])
                        ->where('workout_plan_id', $workoutPlan->id)
                        ->first();

                    if ($exercise) {
                        $exercise->name = $exerciseData['name'];
                        $exercise->type = $exerciseData['type'] ?? 'strength';
                        $exercise->description = $exerciseData['description'] ?? null;
                        $exercise->sets = $exerciseData['sets'] ?? 3;
                        $exercise->reps = $exerciseData['reps'] ?? '10-12';
                        $exercise->duration_minutes = $exerciseData['duration_minutes'] ?? null;
                        $exercise->rest_seconds = $exerciseData['rest_seconds'] ?? 60;
                        $exercise->video_url = $exerciseData['video_url'] ?? null;
                        $exercise->instructions = $exerciseData['instructions'] ?? null;
                        $exercise->muscle_group = $exerciseData['muscle_group'] ?? null;
                        $exercise->equipment = $exerciseData['equipment'] ?? null;
                        $exercise->notes = $exerciseData['notes'] ?? null;
                        $exercise->order = $exerciseData['order'];

                        $exercise->save();
                        $exerciseIds[] = $exercise->id;
                        Log::info('Updated exercise ID: ' . $exercise->id);
                    }
                } else {
                    // Create new exercise
                    $exercise = new WorkoutExercise();
                    $exercise->workout_plan_id = $workoutPlan->id;
                    $exercise->name = $exerciseData['name'];
                    $exercise->type = $exerciseData['type'] ?? 'strength';
                    $exercise->description = $exerciseData['description'] ?? null;
                    $exercise->sets = $exerciseData['sets'] ?? 3;
                    $exercise->reps = $exerciseData['reps'] ?? '10-12';
                    $exercise->duration_minutes = $exerciseData['duration_minutes'] ?? null;
                    $exercise->rest_seconds = $exerciseData['rest_seconds'] ?? 60;
                    $exercise->video_url = $exerciseData['video_url'] ?? null;
                    $exercise->instructions = $exerciseData['instructions'] ?? null;
                    $exercise->muscle_group = $exerciseData['muscle_group'] ?? null;
                    $exercise->equipment = $exerciseData['equipment'] ?? null;
                    $exercise->notes = $exerciseData['notes'] ?? null;
                    $exercise->order = $exerciseData['order'];

                    $exercise->save();
                    $exerciseIds[] = $exercise->id;
                    Log::info('Created new exercise ID: ' . $exercise->id);
                }
            }

            // 3. Delete exercises not in the list
            $deleted = WorkoutExercise::where('workout_plan_id', $workoutPlan->id)
                ->whereNotIn('id', $exerciseIds)
                ->delete();

            Log::info('Deleted exercises: ' . $deleted);

            DB::commit();
            Log::info('=== UPDATE TRANSACTION COMMITTED ===');

            // Clear any cached data
            cache()->forget('workout_plan_' . $workoutPlan->id);
            session()->forget('_old_input');

            return redirect()->route('admin.workout-plans.index')
                ->with('success', 'Program latihan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in update method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());

            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate program latihan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus program dari database.
     */
    public function destroy(WorkoutPlan $workoutPlan)
    {
        DB::beginTransaction();

        try {
            // Hapus semua exercises terkait
            $workoutPlan->workoutExercises()->delete();

            // Hapus workout plan
            $workoutPlan->delete();

            DB::commit();

            return redirect()->route('admin.workout-plans.index')
                ->with('success', 'Program latihan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting workout plan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus program latihan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status program (active/inactive)
     */
    public function toggleStatus(WorkoutPlan $workoutPlan)
    {
        try {
            $workoutPlan->update([
                'status' => $workoutPlan->status === 'active' ? 'inactive' : 'active'
            ]);

            return back()->with('success', 'Status program berhasil diubah.');

        } catch (\Exception $e) {
            Log::error('Error toggling workout plan status: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengubah status program.');
        }
    }

    /**
     * Duplicate program latihan
     */
    public function duplicate(WorkoutPlan $workoutPlan)
    {
        DB::beginTransaction();

        try {
            // Duplicate workout plan
            $newPlan = $workoutPlan->replicate();
            $newPlan->title = $workoutPlan->title . ' (Copy)';
            $newPlan->status = 'inactive';
            $newPlan->created_by = auth()->id();
            $newPlan->save();

            // Duplicate exercises dengan order yang sama
            foreach ($workoutPlan->workoutExercises()->orderBy('order')->get() as $exercise) {
                $newExercise = $exercise->replicate();
                $newExercise->workout_plan_id = $newPlan->id;
                $newExercise->save();
            }

            DB::commit();

            return redirect()->route('admin.workout-plans.edit', $newPlan)
                ->with('success', 'Program latihan berhasil diduplikasi.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error duplicating workout plan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menduplikasi program latihan: ' . $e->getMessage());
        }
    }

    /**
     * Debug: Cek apakah data tersimpan di database
     */
    public function checkData(WorkoutPlan $workoutPlan = null)
    {
        try {
            $data = [];

            if ($workoutPlan) {
                $data['workout_plan'] = $workoutPlan->toArray();
                $data['exercises'] = $workoutPlan->workoutExercises()->get()->toArray();
            } else {
                $data['all_plans'] = WorkoutPlan::with('workoutExercises')->get()->toArray();
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'count' => WorkoutPlan::count(),
                'exercises_count' => WorkoutExercise::count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Test database connection
     */
    public function testConnection()
    {
        try {
            DB::connection()->getPdo();
            $tables = DB::select('SHOW TABLES');

            return response()->json([
                'success' => true,
                'connected' => true,
                'database' => DB::connection()->getDatabaseName(),
                'tables' => $tables,
                'workout_plans_count' => WorkoutPlan::count(),
                'workout_exercises_count' => WorkoutExercise::count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'connected' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
