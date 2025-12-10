<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan;
use App\Models\WorkoutExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkoutPlansExport;
use App\Imports\WorkoutPlansImport;

class WorkoutPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkoutPlan::withCount('workoutExercises')
            ->with('creator');

        // Filter berdasarkan status
        if ($request->has('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan level kesulitan
        if ($request->has('difficulty') && in_array($request->difficulty, ['beginner', 'intermediate', 'advanced'])) {
            $query->where('difficulty_level', $request->difficulty);
        }

        // Filter berdasarkan target fitness
        if ($request->has('target_fitness') && $request->target_fitness) {
            $query->where('target_fitness', $request->target_fitness);
        }

        // Filter berdasarkan focus area
        if ($request->has('focus_area') && $request->focus_area) {
            $query->where('focus_area', $request->focus_area);
        }

        // Filter berdasarkan premium status
        if ($request->has('is_premium') && $request->is_premium !== '') {
            $query->where('is_premium', $request->is_premium === '1');
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('detailed_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $workoutPlans = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => WorkoutPlan::count(),
            'active' => WorkoutPlan::where('status', 'active')->count(),
            'premium' => WorkoutPlan::where('is_premium', true)->count(),
            'beginner' => WorkoutPlan::where('difficulty_level', 'beginner')->count(),
        ];

        return view('admin.workout_plans.index', compact('workoutPlans', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.workout_plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:workout_plans,title',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'target_fitness' => 'nullable|string|in:weight_loss,muscle_gain,endurance,flexibility,general',
            'focus_area' => 'nullable|string|in:upper_body,lower_body,full_body,core,cardio,strength',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'nullable|integer|min:10|max:180',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'equipment_needed' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'is_premium' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Upload cover image
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('workout-plans/covers', 'public');
            $validated['cover_image'] = $path;
        }

        $validated['created_by'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);

        // Start database transaction
        DB::beginTransaction();

        try {
            // Create workout plan
            $workoutPlan = WorkoutPlan::create($validated);

            // Create exercises if provided
            if ($request->has('exercises')) {
                $order = 1;
                foreach ($request->exercises as $exerciseData) {
                    if (!empty($exerciseData['name'])) {
                        $workoutPlan->workoutExercises()->create([
                            'name' => $exerciseData['name'],
                            'type' => $exerciseData['type'] ?? 'strength',
                            'description' => $exerciseData['description'] ?? null,
                            'sets' => $exerciseData['sets'] ?? 3,
                            'reps' => $exerciseData['reps'] ?? '10-12',
                            'duration_minutes' => $exerciseData['duration_minutes'] ?? null,
                            'rest_seconds' => $exerciseData['rest_seconds'] ?? 60,
                            'video_url' => $exerciseData['video_url'] ?? null,
                            'instructions' => $exerciseData['instructions'] ?? null,
                            'muscle_group' => $exerciseData['muscle_group'] ?? null,
                            'equipment' => $exerciseData['equipment'] ?? null,
                            'notes' => $exerciseData['notes'] ?? null,
                            'order' => $order,
                        ]);
                        $order++;
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.workout-plans.show', $workoutPlan)
                ->with('success', 'Program latihan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating workout plan: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat program latihan: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load(['workoutExercises' => function ($query) {
            $query->orderBy('order')->orderBy('id');
        }, 'creator', 'user', 'trainer']);

        $stats = [
            'total_exercises' => $workoutPlan->workoutExercises->count(),
            'total_sessions' => $workoutPlan->workoutSessions->count(),
            'completion_rate' => $workoutPlan->getCompletionPercentage(),
        ];

        return view('admin.workout_plans.show', compact('workoutPlan', 'stats'));
    }

    /**
     * Show create exercise form
     */
    public function createExercise(WorkoutPlan $workoutPlan)
    {
        return view('admin.workout_plans.partials.create_exercise_modal', compact('workoutPlan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load('workoutExercises');
        return view('admin.workout_plans.edit', compact('workoutPlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkoutPlan $workoutPlan)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:workout_plans,title,' . $workoutPlan->id,
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'target_fitness' => 'nullable|string|in:weight_loss,muscle_gain,endurance,flexibility,general',
            'focus_area' => 'nullable|string|in:upper_body,lower_body,full_body,core,cardio,strength',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'nullable|integer|min:10|max:180',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'equipment_needed' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'is_premium' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Upload cover image baru
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($workoutPlan->cover_image) {
                \Storage::disk('public')->delete($workoutPlan->cover_image);
            }

            $path = $request->file('cover_image')->store('workout-plans/covers', 'public');
            $validated['cover_image'] = $path;
        }

        // Update slug jika title berubah
        if ($workoutPlan->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        $workoutPlan->update($validated);

        return redirect()->route('admin.workout-plans.show', $workoutPlan)
            ->with('success', 'Program latihan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkoutPlan $workoutPlan)
    {
        try {
            // Hapus cover image jika ada
            if ($workoutPlan->cover_image) {
                \Storage::disk('public')->delete($workoutPlan->cover_image);
            }

            // Soft delete
            $workoutPlan->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Program latihan berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.workout-plans.index')
                ->with('success', 'Program latihan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting workout plan: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus program latihan.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus program latihan.');
        }
    }

    /**
     * Bulk delete workout plans
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:workout_plans,id'
        ]);

        try {
            $count = 0;
            foreach ($request->ids as $id) {
                $workoutPlan = WorkoutPlan::find($id);
                if ($workoutPlan) {
                    if ($workoutPlan->cover_image) {
                        \Storage::disk('public')->delete($workoutPlan->cover_image);
                    }
                    $workoutPlan->delete();
                    $count++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => $count . ' program latihan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error bulk deleting workout plans: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus program latihan.'
            ], 500);
        }
    }

    /**
     * Store new exercise (AJAX)
     */
    public function storeExercise(Request $request, WorkoutPlan $workoutPlan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:strength,cardio,core,flexibility,warmup,cooldown',
            'description' => 'nullable|string',
            'sets' => 'nullable|integer|min:1|max:20',
            'reps' => 'nullable|string|max:50',
            'duration_minutes' => 'nullable|integer|min:1|max:60',
            'rest_seconds' => 'nullable|integer|min:0|max:600',
            'video_url' => 'nullable|url|max:500',
            'instructions' => 'nullable|string',
            'muscle_group' => 'nullable|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        // Calculate order
        $order = $workoutPlan->workoutExercises()->max('order') ?? 0;

        $exercise = $workoutPlan->workoutExercises()->create([
            ...$validated,
            'order' => $order + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Latihan berhasil ditambahkan',
            'exercise' => $exercise,
            'html' => view('admin.workout_plans.partials.exercise_item', [
                'exercise' => $exercise,
                'loop' => (object) ['iteration' => $workoutPlan->workoutExercises()->count()]
            ])->render()
        ]);
    }

    /**
     * Get exercise for editing (AJAX)
     */
    public function getExercise(WorkoutPlan $workoutPlan, $exerciseId)
    {
        $exercise = WorkoutExercise::where('workout_plan_id', $workoutPlan->id)
            ->find($exerciseId);

        if (!$exercise) {
            return response()->json([
                'success' => false,
                'message' => 'Latihan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'exercise' => $exercise
        ]);
    }
    /**
     * Show edit exercise form
     */
    public function editExercise(WorkoutPlan $workoutPlan, WorkoutExercise $exercise)
    {
        if ($exercise->workout_plan_id !== $workoutPlan->id) {
            abort(404);
        }

        return view('admin.workout_plans.partials.edit_exercise_modal', compact('workoutPlan', 'exercise'));
    }

    /**
     * Update exercise (AJAX)
     */
    public function updateExercise(Request $request, WorkoutPlan $workoutPlan, WorkoutExercise $exercise)
    {
        if ($exercise->workout_plan_id !== $workoutPlan->id) {
            return response()->json([
                'success' => false,
                'message' => 'Latihan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|in:strength,cardio,core,flexibility,warmup,cooldown',
            'description' => 'nullable|string',
            'sets' => 'nullable|integer|min:1|max:20',
            'reps' => 'nullable|string|max:50',
            'duration_minutes' => 'nullable|integer|min:1|max:60',
            'rest_seconds' => 'nullable|integer|min:0|max:600',
            'video_url' => 'nullable|url|max:500',
            'instructions' => 'nullable|string',
            'muscle_group' => 'nullable|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $exercise->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Latihan berhasil diperbarui',
            'exercise' => $exercise,
            'html' => view('admin.workout_plans.partials.exercise_item', [
                'exercise' => $exercise,
                'loop' => (object) ['iteration' => $workoutPlan->workoutExercises()
                    ->where('order', '<=', $exercise->order)
                    ->count()]
            ])->render()
        ]);
    }

    /**
     * Delete exercise (AJAX)
     */
    public function destroyExercise(Request $request, WorkoutPlan $workoutPlan, WorkoutExercise $exercise)
    {
        if ($exercise->workout_plan_id !== $workoutPlan->id) {
            return response()->json([
                'success' => false,
                'message' => 'Latihan tidak ditemukan'
            ], 404);
        }

        $deletedOrder = $exercise->order;
        $exercise->delete();

        // Update order for remaining exercises
        $workoutPlan->workoutExercises()
            ->where('order', '>', $deletedOrder)
            ->decrement('order');

        return response()->json([
            'success' => true,
            'message' => 'Latihan berhasil dihapus'
        ]);
    }

    /**
     * Update exercise order (AJAX)
     */
    public function updateExerciseOrder(Request $request, WorkoutPlan $workoutPlan)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:workout_exercises,id'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->order as $index => $exerciseId) {
                WorkoutExercise::where('id', $exerciseId)
                    ->where('workout_plan_id', $workoutPlan->id)
                    ->update(['order' => $index + 1]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan latihan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan latihan'
            ], 500);
        }
    }

    /**
     * Toggle workout plan status
     */
    public function toggleStatus(WorkoutPlan $workoutPlan)
    {
        try {
            $newStatus = $workoutPlan->status === 'active' ? 'inactive' : 'active';
            $workoutPlan->update(['status' => $newStatus]);

            $statusBadge = $newStatus === 'active'
                ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">Active</span>'
                : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">Inactive</span>';

            return response()->json([
                'success' => true,
                'message' => 'Status program berhasil diubah',
                'new_status' => $newStatus,
                'status_badge' => $statusBadge
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling workout plan status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status program'
            ], 500);
        }
    }

    /**
     * Toggle premium status
     */
    public function togglePremium(WorkoutPlan $workoutPlan)
    {
        try {
            $newPremium = !$workoutPlan->is_premium;
            $workoutPlan->update(['is_premium' => $newPremium]);

            $premiumBadge = $newPremium
                ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">⭐ Premium</span>'
                : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">📋 Standard</span>';

            return response()->json([
                'success' => true,
                'message' => 'Status premium berhasil diubah',
                'is_premium' => $newPremium,
                'premium_badge' => $premiumBadge
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling workout plan premium: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status premium'
            ], 500);
        }
    }

    /**
     * Duplicate workout plan
     */
    public function duplicate(WorkoutPlan $workoutPlan)
    {
        DB::beginTransaction();

        try {
            // Duplicate workout plan
            $newPlan = $workoutPlan->replicate();
            $newPlan->title = $workoutPlan->title . ' (Copy)';
            $newPlan->slug = Str::slug($newPlan->title) . '-' . Str::random(6);
            $newPlan->status = 'inactive';
            $newPlan->created_by = auth()->id();
            $newPlan->save();

            // Duplicate exercises
            foreach ($workoutPlan->workoutExercises()->orderBy('order')->get() as $exercise) {
                $newExercise = $exercise->replicate();
                $newExercise->workout_plan_id = $newPlan->id;
                $newExercise->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Program latihan berhasil diduplikasi',
                'redirect_url' => route('admin.workout-plans.show', $newPlan)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating workout plan: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menduplikasi program latihan'
            ], 500);
        }
    }

    /**
     * Export workout plans
     */
    public function export()
    {
        return Excel::download(new WorkoutPlansExport, 'workout-plans-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Import workout plans
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new WorkoutPlansImport, $request->file('file'));

            return redirect()->route('admin.workout-plans.index')
                ->with('success', 'Data workout plans berhasil diimport!');
        } catch (\Exception $e) {
            Log::error('Error importing workout plans: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        $path = resource_path('templates/workout-plans-template.xlsx');

        if (!file_exists($path)) {
            // Create template if doesn't exist
            Excel::store(new WorkoutPlansExport(true), 'templates/workout-plans-template.xlsx', 'local');
        }

        return response()->download($path);
    }

    /**
     * View archived workout plans
     */
    public function archived(Request $request)
    {
        $query = WorkoutPlan::onlyTrashed()
            ->withCount('workoutExercises')
            ->with('creator');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $workoutPlans = $query->paginate(15);

        return view('admin.workout_plans.archived', compact('workoutPlans'));
    }

    /**
     * Restore archived workout plan
     */
    public function restore($id)
    {
        try {
            $workoutPlan = WorkoutPlan::onlyTrashed()->findOrFail($id);
            $workoutPlan->restore();

            // Restore exercises too
            WorkoutExercise::where('workout_plan_id', $id)->onlyTrashed()->restore();

            return redirect()->route('admin.workout-plans.archived')
                ->with('success', 'Program latihan berhasil dipulihkan');
        } catch (\Exception $e) {
            Log::error('Error restoring workout plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memulihkan program latihan');
        }
    }

    /**
     * Force delete workout plan
     */
    public function forceDelete($id)
    {
        try {
            $workoutPlan = WorkoutPlan::onlyTrashed()->findOrFail($id);

            // Hapus cover image
            if ($workoutPlan->cover_image) {
                \Storage::disk('public')->delete($workoutPlan->cover_image);
            }

            // Hapus exercises
            WorkoutExercise::where('workout_plan_id', $id)->forceDelete();

            // Force delete plan
            $workoutPlan->forceDelete();

            return redirect()->route('admin.workout-plans.archived')
                ->with('success', 'Program latihan berhasil dihapus permanen');
        } catch (\Exception $e) {
            Log::error('Error force deleting workout plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus permanen program latihan');
        }
    }

    /**
     * Preview workout plan as user
     */
    public function preview(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load(['workoutExercises' => function ($query) {
            $query->orderBy('order');
        }]);

        return view('admin.workout_plans.preview', compact('workoutPlan'));
    }

    /**
     * Get workout plans for dropdown (AJAX)
     */
    public function getWorkoutPlans(Request $request)
    {
        $query = WorkoutPlan::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        $workoutPlans = $query->select('id', 'title', 'difficulty_level', 'duration_weeks')
            ->orderBy('title')
            ->limit(20)
            ->get();

        return response()->json($workoutPlans);
    }
}
