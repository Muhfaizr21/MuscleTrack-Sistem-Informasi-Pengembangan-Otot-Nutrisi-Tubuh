<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkoutPlan;
use App\Models\WorkoutExercise;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkoutPlansExport;
use App\Imports\WorkoutPlansImport;
use Illuminate\Support\Facades\Storage;

class WorkoutPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkoutPlan::withCount('workoutExercises')
            ->with(['creator', 'trainer']);

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

        // Filter berdasarkan BMI category
        if ($request->has('bmi_category') && $request->bmi_category) {
            $query->where('bmi_category', $request->bmi_category);
        }

        // Filter berdasarkan trainer
        if ($request->has('trainer_id') && $request->trainer_id) {
            $query->where('trainer_id', $request->trainer_id);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('detailed_description', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $validSortColumns = ['id', 'title', 'status', 'difficulty_level', 'duration_weeks', 'created_at', 'updated_at'];

        if (in_array($sortBy, $validSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $workoutPlans = $query->paginate(15)->withQueryString();

        // Stats for dashboard
        $stats = [
            'total' => WorkoutPlan::count(),
            'active' => WorkoutPlan::where('status', 'active')->count(),
            'premium' => WorkoutPlan::where('is_premium', true)->count(),
            'beginner' => WorkoutPlan::where('difficulty_level', 'beginner')->count(),
            'intermediate' => WorkoutPlan::where('difficulty_level', 'intermediate')->count(),
            'advanced' => WorkoutPlan::where('difficulty_level', 'advanced')->count(),
        ];

        // Get trainers for filter
        $trainers = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->get(['id', 'name']);

        return view('admin.workout_plans.index', compact('workoutPlans', 'stats', 'trainers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainers = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->get(['id', 'name']);

        $targetFitnessOptions = [
            'fat_loss' => 'Fat Loss',
            'muscle_gain' => 'Muscle Gain',
            'endurance' => 'Endurance',
            'maintain' => 'Maintain',
            'cutting' => 'Cutting',
            'bulking' => 'Bulking',
            'general_fitness' => 'General Fitness',
        ];

        $focusAreaOptions = [
            'foundation' => 'Foundation',
            'upper_lower_split' => 'Upper/Lower Split',
            'push_pull_legs' => 'Push/Pull/Legs',
            'full_body' => 'Full Body',
            'core_endurance' => 'Core Endurance',
            'cardio' => 'Cardio',
        ];

        $bmiCategories = [
            'underweight' => 'Underweight',
            'normal' => 'Normal',
            'overweight' => 'Overweight',
            'obese' => 'Obese',
        ];

        return view('admin.workout_plans.create', compact(
            'trainers',
            'targetFitnessOptions',
            'focusAreaOptions',
            'bmiCategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:workout_plans,title',
            'description' => 'required|string',
            'detailed_description' => 'nullable|string',
            'target_fitness' => 'nullable|string|in:fat_loss,muscle_gain,endurance,maintain,cutting,bulking,general_fitness',
            'focus_area' => 'nullable|string|in:foundation,upper_lower_split,push_pull_legs,full_body,core_endurance,cardio',
            'bmi_category' => 'nullable|string|in:underweight,normal,overweight,obese',
            'difficulty_level' => 'required|string|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'nullable|integer|min:10|max:180',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'equipment_needed' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'is_premium' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'notes' => 'nullable|string',
            'trainer_id' => 'nullable|exists:users,id',
            'level' => 'nullable|string|in:beginner,intermediate,advanced',
        ]);

        // Upload cover image
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('workout-plans/covers', 'public');
            $validated['cover_image'] = $path;
        }

        // Set created_by to current user
        $validated['created_by'] = Auth::id();

        // Set user_id to current user if not specified
        if (!isset($validated['user_id'])) {
            $validated['user_id'] = Auth::id();
        }

        // Set recommended_by based on user role
        $user = Auth::user();
        if ($user->role === 'admin') {
            $validated['recommended_by'] = 'admin';
        } elseif ($user->role === 'trainer') {
            $validated['recommended_by'] = 'trainer';
        } else {
            $validated['recommended_by'] = 'system';
        }

        // Generate slug
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
                        $repsMin = null;
                        $repsMax = null;

                        if (isset($exerciseData['reps']) && is_string($exerciseData['reps'])) {
                            if (strpos($exerciseData['reps'], '-') !== false) {
                                $repsParts = explode('-', $exerciseData['reps']);
                                $repsMin = intval(trim($repsParts[0]));
                                $repsMax = intval(trim($repsParts[1] ?? $repsParts[0]));
                            } else {
                                $repsMin = intval($exerciseData['reps']);
                                $repsMax = $repsMin;
                            }
                        }

                        $workoutPlan->workoutExercises()->create([
                            'name' => $exerciseData['name'],
                            'description' => $exerciseData['description'] ?? null,
                            'muscle_group' => $exerciseData['muscle_group'] ?? null,
                            'equipment' => $exerciseData['equipment'] ?? null,
                            'difficulty' => $exerciseData['difficulty'] ?? 'beginner',
                            'sets' => $exerciseData['sets'] ?? 3,
                            'reps_min' => $repsMin,
                            'reps_max' => $repsMax,
                            'rest_seconds' => $exerciseData['rest_seconds'] ?? 60,
                            'weight_suggestion' => $exerciseData['weight_suggestion'] ?? null,
                            'video_url' => $exerciseData['video_url'] ?? null,
                            'image_url' => $exerciseData['image_url'] ?? null,
                            'instructions' => $exerciseData['instructions'] ?? null,
                            'tips' => $exerciseData['tips'] ?? null,
                            'common_mistakes' => $exerciseData['common_mistakes'] ?? null,
                            'day' => $exerciseData['day'] ?? 'day_1',
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
        $workoutPlan->load([
            'workoutExercises' => function ($query) {
                $query->orderBy('day')->orderBy('order');
            },
            'creator',
            'user',
            'trainer',
            'updater'
        ]);

        $totalExercises = $workoutPlan->workoutExercises->count();
        $exercisesByDay = $workoutPlan->workoutExercises->groupBy('day')->map->count();

        $muscleGroups = $workoutPlan->workoutExercises->pluck('muscle_group')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $equipmentList = $workoutPlan->workoutExercises->pluck('equipment')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $totalSessions = $workoutPlan->workoutSessions()->count();
        $completionRate = 0;

        if ($totalSessions > 0) {
            try {
                $completionRate = $totalSessions > 0 ? 75 : 0;
            } catch (\Exception $e) {
                Log::warning('Error calculating completion rate: ' . $e->getMessage());
            }
        }

        $stats = [
            'total_exercises' => $totalExercises,
            'total_sessions' => $totalSessions,
            'completion_rate' => $completionRate,
            'exercises_by_day' => $exercisesByDay,
            'muscle_groups' => $muscleGroups,
            'equipment_list' => $equipmentList,
        ];

        return view('admin.workout_plans.show', compact('workoutPlan', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkoutPlan $workoutPlan)
    {
        $workoutPlan->load('workoutExercises');

        $trainers = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->get(['id', 'name']);

        $targetFitnessOptions = [
            'fat_loss' => 'Fat Loss',
            'muscle_gain' => 'Muscle Gain',
            'endurance' => 'Endurance',
            'maintain' => 'Maintain',
            'cutting' => 'Cutting',
            'bulking' => 'Bulking',
            'general_fitness' => 'General Fitness',
        ];

        $focusAreaOptions = [
            'foundation' => 'Foundation',
            'upper_lower_split' => 'Upper/Lower Split',
            'push_pull_legs' => 'Push/Pull/Legs',
            'full_body' => 'Full Body',
            'core_endurance' => 'Core Endurance',
            'cardio' => 'Cardio',
        ];

        $bmiCategories = [
            'underweight' => 'Underweight',
            'normal' => 'Normal',
            'overweight' => 'Overweight',
            'obese' => 'Obese',
        ];

        return view('admin.workout_plans.edit', compact(
            'workoutPlan',
            'trainers',
            'targetFitnessOptions',
            'focusAreaOptions',
            'bmiCategories'
        ));
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
            'target_fitness' => 'nullable|string|in:fat_loss,muscle_gain,endurance,maintain,cutting,bulking,general_fitness',
            'focus_area' => 'nullable|string|in:foundation,upper_lower_split,push_pull_legs,full_body,core_endurance,cardio',
            'bmi_category' => 'nullable|string|in:underweight,normal,overweight,obese',
            'difficulty_level' => 'required|string|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'nullable|integer|min:10|max:180',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'equipment_needed' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
            'is_premium' => 'nullable|boolean',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'notes' => 'nullable|string',
            'trainer_id' => 'nullable|exists:users,id',
            'level' => 'nullable|string|in:beginner,intermediate,advanced',
        ]);

        // Upload cover image baru
        if ($request->hasFile('cover_image')) {
            if ($workoutPlan->cover_image && Storage::disk('public')->exists($workoutPlan->cover_image)) {
                Storage::disk('public')->delete($workoutPlan->cover_image);
            }

            $path = $request->file('cover_image')->store('workout-plans/covers', 'public');
            $validated['cover_image'] = $path;
        } elseif ($request->has('remove_cover_image')) {
            if ($workoutPlan->cover_image && Storage::disk('public')->exists($workoutPlan->cover_image)) {
                Storage::disk('public')->delete($workoutPlan->cover_image);
            }
            $validated['cover_image'] = null;
        }

        // Update slug jika title berubah
        if ($workoutPlan->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        // Set updated_by
        $validated['updated_by'] = Auth::id();

        // Update workout plan
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
            if ($workoutPlan->cover_image && Storage::disk('public')->exists($workoutPlan->cover_image)) {
                Storage::disk('public')->delete($workoutPlan->cover_image);
            }

            // Soft delete
            $workoutPlan->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Program latihan berhasil dihapus.'
                ]);
            }

            return redirect()->route('admin.workout-plans.index')
                ->with('success', 'Program latihan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting workout plan: ' . $e->getMessage());

            if (request()->ajax() || request()->wantsJson()) {
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

        DB::beginTransaction();
        try {
            $count = 0;
            foreach ($request->ids as $id) {
                $workoutPlan = WorkoutPlan::find($id);
                if ($workoutPlan) {
                    // Hapus cover image jika ada
                    if ($workoutPlan->cover_image && Storage::disk('public')->exists($workoutPlan->cover_image)) {
                        Storage::disk('public')->delete($workoutPlan->cover_image);
                    }

                    $workoutPlan->delete();
                    $count++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $count . ' program latihan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error bulk deleting workout plans: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus program latihan.'
            ], 500);
        }
    }

    /**
     * Toggle workout plan status
     */
    public function toggleStatus(WorkoutPlan $workoutPlan)
    {
        try {
            $workoutPlan->update([
                'status' => $workoutPlan->status === 'active' ? 'inactive' : 'active'
            ]);

            $statusBadge = $workoutPlan->fresh()->status === 'active'
                ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">Active</span>'
                : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">Inactive</span>';

            return response()->json([
                'success' => true,
                'message' => 'Status program berhasil diubah',
                'new_status' => $workoutPlan->fresh()->status,
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
            $workoutPlan->update([
                'is_premium' => !$workoutPlan->is_premium
            ]);

            $premiumBadge = $workoutPlan->fresh()->is_premium
                ? '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">⭐ Premium</span>'
                : '<span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">📋 Standard</span>';

            return response()->json([
                'success' => true,
                'message' => 'Status premium berhasil diubah',
                'is_premium' => $workoutPlan->fresh()->is_premium,
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
            // Create duplicate workout plan
            $newPlan = $workoutPlan->replicate();
            $newPlan->title = $newPlan->title . ' (Copy)';
            $newPlan->slug = Str::slug($newPlan->title) . '-' . Str::random(6);
            $newPlan->created_by = Auth::id();
            $newPlan->save();

            // Duplicate exercises
            foreach ($workoutPlan->workoutExercises as $exercise) {
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
     * Bulk actions (activate, deactivate, toggle premium, delete)
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,toggle_premium,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:workout_plans,id'
        ]);

        DB::beginTransaction();
        try {
            $count = 0;
            foreach ($request->ids as $id) {
                $workoutPlan = WorkoutPlan::find($id);
                if ($workoutPlan) {
                    switch ($request->action) {
                        case 'activate':
                            $workoutPlan->update(['status' => 'active']);
                            break;
                        case 'deactivate':
                            $workoutPlan->update(['status' => 'inactive']);
                            break;
                        case 'toggle_premium':
                            $workoutPlan->update(['is_premium' => !$workoutPlan->is_premium]);
                            break;
                        case 'delete':
                            // Hapus cover image jika ada
                            if ($workoutPlan->cover_image && Storage::disk('public')->exists($workoutPlan->cover_image)) {
                                Storage::disk('public')->delete($workoutPlan->cover_image);
                            }
                            $workoutPlan->delete();
                            break;
                    }
                    $count++;
                }
            }

            DB::commit();

            $message = match ($request->action) {
                'activate' => $count . ' program latihan berhasil diaktifkan',
                'deactivate' => $count . ' program latihan berhasil dinonaktifkan',
                'toggle_premium' => $count . ' program latihan berhasil diubah status premiumnya',
                'delete' => $count . ' program latihan berhasil dihapus',
            };

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error performing bulk action: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan aksi bulk'
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
            'description' => 'nullable|string',
            'muscle_group' => 'nullable|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'difficulty' => 'nullable|string|in:beginner,intermediate,advanced',
            'sets' => 'nullable|integer|min:1|max:20',
            'reps_min' => 'nullable|integer|min:1|max:100',
            'reps_max' => 'nullable|integer|min:1|max:100',
            'rest_seconds' => 'nullable|integer|min:0|max:600',
            'weight_suggestion' => 'nullable|numeric|min:0|max:1000',
            'video_url' => 'nullable|url|max:500',
            'image_url' => 'nullable|url|max:500',
            'instructions' => 'nullable|string',
            'tips' => 'nullable|string',
            'common_mistakes' => 'nullable|string',
            'day' => 'nullable|string|in:day_1,day_2,day_3,day_4,day_5,day_6,day_7',
        ]);

        $order = $workoutPlan->workoutExercises()
            ->where('day', $validated['day'] ?? 'day_1')
            ->max('order') ?? 0;

        $exercise = $workoutPlan->workoutExercises()->create([
            ...$validated,
            'order' => $order + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Latihan berhasil ditambahkan',
            'exercise' => $exercise
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
            'description' => 'nullable|string',
            'muscle_group' => 'nullable|string|max:100',
            'equipment' => 'nullable|string|max:100',
            'difficulty' => 'nullable|string|in:beginner,intermediate,advanced',
            'sets' => 'nullable|integer|min:1|max:20',
            'reps_min' => 'nullable|integer|min:1|max:100',
            'reps_max' => 'nullable|integer|min:1|max:100',
            'rest_seconds' => 'nullable|integer|min:0|max:600',
            'weight_suggestion' => 'nullable|numeric|min:0|max:1000',
            'video_url' => 'nullable|url|max:500',
            'image_url' => 'nullable|url|max:500',
            'instructions' => 'nullable|string',
            'tips' => 'nullable|string',
            'common_mistakes' => 'nullable|string',
            'day' => 'nullable|string|in:day_1,day_2,day_3,day_4,day_5,day_6,day_7',
        ]);

        $oldDay = $exercise->day;
        $newDay = $validated['day'] ?? 'day_1';

        if ($oldDay !== $newDay) {
            $exercise->delete();

            $newOrder = $workoutPlan->workoutExercises()
                ->where('day', $newDay)
                ->max('order') ?? 0;

            $validated['order'] = $newOrder + 1;

            $exercise = $workoutPlan->workoutExercises()->create($validated);

            $this->reorderExercises($workoutPlan, $oldDay);
        } else {
            $exercise->update($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Latihan berhasil diperbarui',
            'exercise' => $exercise
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

        $deletedDay = $exercise->day;
        $deletedOrder = $exercise->order;
        $exercise->delete();

        $workoutPlan->workoutExercises()
            ->where('day', $deletedDay)
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
            'day' => 'required|string|in:day_1,day_2,day_3,day_4,day_5,day_6,day_7',
            'order' => 'required|array',
            'order.*' => 'integer|exists:workout_exercises,id'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->order as $index => $exerciseId) {
                WorkoutExercise::where('id', $exerciseId)
                    ->where('workout_plan_id', $workoutPlan->id)
                    ->update([
                        'order' => $index + 1,
                        'day' => $request->day
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Urutan latihan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating exercise order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan latihan'
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
            ->with(['creator', 'trainer']);

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
        DB::beginTransaction();
        try {
            $workoutPlan = WorkoutPlan::onlyTrashed()->findOrFail($id);

            if ($workoutPlan->cover_image && Storage::disk('public')->exists($workoutPlan->cover_image)) {
                Storage::disk('public')->delete($workoutPlan->cover_image);
            }

            WorkoutExercise::where('workout_plan_id', $id)->forceDelete();

            $workoutPlan->forceDelete();

            DB::commit();

            return redirect()->route('admin.workout-plans.archived')
                ->with('success', 'Program latihan berhasil dihapus permanen');
        } catch (\Exception $e) {
            DB::rollBack();
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
            $query->orderBy('day')->orderBy('order');
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

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('is_premium')) {
            $query->where('is_premium', $request->is_premium === 'true');
        }

        $workoutPlans = $query->select('id', 'title', 'difficulty_level', 'duration_weeks', 'status', 'is_premium')
            ->where('status', 'active')
            ->orderBy('title')
            ->limit(20)
            ->get();

        return response()->json($workoutPlans);
    }

    /**
     * Get exercises by day (AJAX)
     */
    public function getExercisesByDay(WorkoutPlan $workoutPlan, $day)
    {
        $exercises = $workoutPlan->workoutExercises()
            ->where('day', $day)
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'exercises' => $exercises
        ]);
    }

    /**
     * Update exercise days (move exercises between days)
     */
    public function updateExerciseDays(Request $request, WorkoutPlan $workoutPlan)
    {
        $request->validate([
            'moves' => 'required|array',
            'moves.*.exercise_id' => 'required|exists:workout_exercises,id',
            'moves.*.from_day' => 'required|string|in:day_1,day_2,day_3,day_4,day_5,day_6,day_7',
            'moves.*.to_day' => 'required|string|in:day_1,day_2,day_3,day_4,day_5,day_6,day_7',
            'moves.*.new_order' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->moves as $move) {
                $exercise = WorkoutExercise::find($move['exercise_id']);

                if ($exercise && $exercise->workout_plan_id == $workoutPlan->id) {
                    if ($exercise->day !== $move['to_day']) {
                        $workoutPlan->workoutExercises()
                            ->where('day', $exercise->day)
                            ->where('order', '>', $exercise->order)
                            ->decrement('order');

                        $exercise->day = $move['to_day'];
                    }

                    $exercise->order = $move['new_order'];
                    $exercise->save();

                    $this->reorderExercises($workoutPlan, $move['to_day']);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Latihan berhasil dipindahkan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating exercise days: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memindahkan latihan'
            ], 500);
        }
    }

    /**
     * Helper method to reorder exercises
     */
    private function reorderExercises(WorkoutPlan $workoutPlan, $day)
    {
        $exercises = $workoutPlan->workoutExercises()
            ->where('day', $day)
            ->orderBy('order')
            ->get();

        foreach ($exercises as $index => $exercise) {
            $exercise->update(['order' => $index + 1]);
        }
    }
}
