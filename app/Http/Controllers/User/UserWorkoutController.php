<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\WorkoutExercise;
use App\Models\WorkoutPlan;
use App\Models\WorkoutSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserWorkoutController extends Controller
{
    /**
     * 📋 Tampilkan daftar workout + auto-assign pertama kali berdasarkan BMI & trainer
     */
    public function index()
    {
        $user = Auth::user()->load('fitnessProfile');

        // 🧮 Hitung BMI (hanya jika tinggi & berat tersedia)
        $bmi = null;
        if (! empty($user->weight) && ! empty($user->height)) {
            $heightInMeter = $user->height / 100;
            $bmi = round($user->weight / ($heightInMeter ** 2), 1);
        }

        // 🔎 Tentukan kategori BMI
        $bmiCategory = match (true) {
            $bmi === null => null,
            $bmi < 18.5 => 'underweight',
            $bmi < 25 => 'normal',
            $bmi < 30 => 'overweight',
            $bmi >= 30 => 'obese',
            default => null,
        };

        // 💡 Ambil plan rekomendasi by BMI
        $recommendedPlans = collect();
        if ($bmiCategory) {
            $recommendedPlans = WorkoutPlan::where('status', 'active')
                ->where(function ($q) use ($bmiCategory) {
                    $focus = match ($bmiCategory) {
                        'underweight' => 'bulking',
                        'normal' => 'maintain',
                        'overweight' => 'cutting',
                        'obese' => 'cutting',
                        default => 'general_fitness',
                    };
                    $q->where('bmi_category', $bmiCategory)
                        ->orWhere('focus_area', 'like', "%{$focus}%")
                        ->orWhere('target_fitness', $focus);
                })
                ->orderBy('difficulty_level')
                ->get();
        }

        // 🏋️‍♂️ Rekomendasi berdasarkan Fitness Profile
        $fitnessProfilePlans = collect();
        if ($user->fitnessProfile) {
            $fitnessProfilePlans = $this->getWorkoutsByFitnessProfile($user->fitnessProfile);
        }

        // 🧑‍🏫 Workout dari trainer user (jika ada)
        $trainerWorkouts = collect();
        if ($user->trainer_id) {
            $trainerWorkouts = WorkoutPlan::where('status', 'active')
                ->where('trainer_id', $user->trainer_id)
                ->where('recommended_by', 'trainer')
                ->get();
        }

        // 🛠️ Workout umum dari Admin/System
        $adminWorkouts = WorkoutPlan::where('status', 'active')
            ->where(function ($q) {
                $q->whereIn('recommended_by', ['admin', 'system'])
                    ->orWhereNull('recommended_by');
            })
            ->get();

        // 🧩 Gabungkan semua sumber plan dengan prioritas
        $workouts = $fitnessProfilePlans
            ->merge($trainerWorkouts)
            ->merge($recommendedPlans)
            ->merge($adminWorkouts)
            ->unique('id')
            ->sortBy('difficulty_level')
            ->values();

        // 🗓️ Cek apakah user sudah punya jadwal aktif
        $hasActiveSchedule = WorkoutSchedule::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        // 🔁 Auto assign plan pertama kali jika belum punya
        if (! $hasActiveSchedule && $workouts->count() > 0) {
            $selectedPlan = $fitnessProfilePlans->first()
                ?? $trainerWorkouts->first()
                ?? $recommendedPlans->first()
                ?? $adminWorkouts->first();

            if ($selectedPlan) {
                WorkoutSchedule::create([
                    'user_id' => $user->id,
                    'workout_plan_id' => $selectedPlan->id,
                    'scheduled_date' => now()->addDay()->toDateString(),
                    'scheduled_time' => '08:00:00',
                    'status' => 'pending',
                    'notes' => 'Auto-assigned by system based on your profile',
                ]);

                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Workout Plan Otomatis 💪',
                    'message' => "Sistem menyiapkan rencana '{$selectedPlan->title}' berdasarkan profile fitness kamu"
                        . ($bmiCategory ? " dan BMI ({$bmiCategory})" : '')
                        . ($user->trainer_id ? ' serta bimbingan trainer kamu.' : '.'),
                    'type' => 'reminder',
                    'read_status' => false,
                ]);
            }
        }

        $schedules = WorkoutSchedule::with('workoutPlan')
            ->where('user_id', $user->id)
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();

        return view('user.workouts.index', compact('workouts', 'schedules', 'bmi', 'bmiCategory', 'user'));
    }

    /**
     * 🎯 Dapatkan workout berdasarkan fitness profile user
     */
    private function getWorkoutsByFitnessProfile($fitnessProfile)
    {
        $query = WorkoutPlan::where('status', 'active');

        // Filter berdasarkan activity level
        if ($fitnessProfile->activity_level) {
            $difficultyMap = [
                'light' => 'beginner',
                'moderate' => 'intermediate',
                'heavy' => 'advanced'
            ];

            if (isset($difficultyMap[$fitnessProfile->activity_level])) {
                $query->where('difficulty_level', $difficultyMap[$fitnessProfile->activity_level]);
            }
        }

        // Filter berdasarkan preferred muscle groups
        if ($fitnessProfile->preferred_muscle_groups) {
            try {
                $muscleGroups = json_decode($fitnessProfile->preferred_muscle_groups, true);

                if (is_array($muscleGroups) && !empty($muscleGroups)) {
                    $focusAreaMap = [
                        'chest' => 'upper',
                        'back' => 'upper',
                        'arms' => 'upper',
                        'shoulders' => 'upper',
                        'legs' => 'lower',
                        'core' => 'core',
                        'abs' => 'core',
                        'glutes' => 'lower',
                        'full_body' => 'full_body'
                    ];

                    $focusAreas = collect($muscleGroups)
                        ->map(fn($group) => $focusAreaMap[$group] ?? null)
                        ->filter()
                        ->unique()
                        ->toArray();

                    if (!empty($focusAreas)) {
                        $query->where(function ($q) use ($focusAreas) {
                            foreach ($focusAreas as $area) {
                                $q->orWhere('focus_area', 'like', "%{$area}%")
                                  ->orWhere('target_fitness', 'like', "%{$area}%");
                            }
                        });
                    }
                }
            } catch (\Exception $e) {
                // Skip if JSON decode fails
            }
        }

        // Filter berdasarkan daily calorie target untuk menentukan intensitas
        if ($fitnessProfile->daily_calorie_target) {
            if ($fitnessProfile->daily_calorie_target > 2500) {
                // High calorie target - muscle gain focus
                $query->whereIn('target_fitness', ['muscle_gain', 'bulking', 'strength']);
            } elseif ($fitnessProfile->daily_calorie_target < 1800) {
                // Low calorie target - fat loss focus
                $query->whereIn('target_fitness', ['fat_loss', 'cutting', 'endurance']);
            } else {
                // Moderate calorie target - maintenance
                $query->whereIn('target_fitness', ['maintain', 'endurance']);
            }
        }

        return $query->orderBy('difficulty_level')->get();
    }

    /**
     * ➕ Form tambah jadwal workout baru
     */
    public function create(Request $request)
    {
        $user = Auth::user()->load('fitnessProfile');

        // Dapatkan rekomendasi berdasarkan fitness profile
        $fitnessProfilePlans = collect();
        if ($user->fitnessProfile) {
            $fitnessProfilePlans = $this->getWorkoutsByFitnessProfile($user->fitnessProfile);
        }

        $trainerWorkouts = collect();
        if ($user->trainer_id) {
            $trainerWorkouts = WorkoutPlan::where('status', 'active')
                ->where('trainer_id', $user->trainer_id)
                ->where('recommended_by', 'trainer')
                ->get();
        }

        $adminWorkouts = WorkoutPlan::where('status', 'active')
            ->where(function ($q) {
                $q->whereIn('recommended_by', ['admin', 'system'])
                    ->orWhereNull('recommended_by');
            })
            ->get();

        $workouts = $fitnessProfilePlans
            ->merge($trainerWorkouts)
            ->merge($adminWorkouts)
            ->unique('id')
            ->values();

        $selectedWorkout = $request->workout_id ? WorkoutPlan::find($request->workout_id) : null;

        return view('user.workouts.create', compact('workouts', 'selectedWorkout', 'user'));
    }

    /**
     * 🕒 Simpan jadwal workout user
     */
    public function store(Request $request)
    {
        $request->validate([
            'workout_id' => 'required|exists:workout_plans,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
        ]);

        $user = Auth::user();

        // Cek apakah sudah ada schedule di tanggal yang sama
        $existingSchedule = WorkoutSchedule::where('user_id', $user->id)
            ->where('workout_plan_id', $request->workout_id)
            ->where('scheduled_date', $request->scheduled_date)
            ->first();

        if ($existingSchedule) {
            $existingSchedule->update([
                'scheduled_time' => $request->scheduled_time,
                'status' => 'pending',
                'notes' => $request->notes ?? $existingSchedule->notes,
            ]);

            $schedule = $existingSchedule;
        } else {
            $schedule = WorkoutSchedule::create([
                'user_id' => $user->id,
                'workout_plan_id' => $request->workout_id,
                'scheduled_date' => $request->scheduled_date,
                'scheduled_time' => $request->scheduled_time,
                'status' => 'pending',
                'notes' => $request->notes ?? null,
            ]);
        }

        // Get workout plan for notification
        $workoutPlan = WorkoutPlan::find($request->workout_id);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Reminder 🏋️',
            'message' => "Jangan lupa latihan '{$workoutPlan->title}' pada tanggal {$schedule->scheduled_date} jam {$schedule->scheduled_time}! 🔥",
            'type' => 'reminder',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.index')
            ->with('success', 'Jadwal workout berhasil disimpan!');
    }

    /**
     * ✅ Tandai workout selesai
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);

        $schedule->update([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
            'notes' => $request->notes ?? $schedule->notes,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Completed 🎉',
            'message' => "Hebat! Kamu telah menyelesaikan latihan '{$schedule->workoutPlan->title}' pada " .
                Carbon::now()->translatedFormat('l, d F Y H:i'),
            'type' => 'achievement',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.index')
            ->with('success', 'Workout berhasil diselesaikan! 💪');
    }

    /**
     * ✏️ Edit workout schedule
     */
    public function edit($id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::with('workoutPlan')
            ->where('user_id', $user->id)
            ->findOrFail($id);

        // Get all available workouts for dropdown
        $workouts = WorkoutPlan::where('status', 'active')
            ->orderBy('difficulty_level')
            ->get();

        return view('user.workouts.edit', compact('schedule', 'workouts'));
    }

    /**
     * 🔄 Update workout schedule
     */
    public function updateSchedule(Request $request, $id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);

        $request->validate([
            'workout_id' => 'required|exists:workout_plans,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $schedule->update([
            'workout_plan_id' => $request->workout_id,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'notes' => $request->notes ?? $schedule->notes,
        ]);

        return redirect()->route('user.workouts.index')
            ->with('success', 'Jadwal workout berhasil diperbarui!');
    }

    /**
     * 🗑️ Hapus jadwal workout
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);

        $workoutTitle = $schedule->workoutPlan->title ?? 'Workout';
        $schedule->delete();

        return redirect()->route('user.workouts.index')
            ->with('success', "Jadwal '{$workoutTitle}' berhasil dihapus!");
    }

    /**
     * 🔍 Lihat detail workout plan + daftar latihan (Exercises) dengan tutorial
     */
    public function show($id)
    {
        $user = Auth::user();
        $workout = WorkoutPlan::with([
            'workoutExercises' => function($query) {
                $query->orderBy('order')->orderBy('id');
            },
            'trainer:id,name,avatar',
            'creator:id,name'
        ])->findOrFail($id);

        $trainerName = $workout->trainer?->name ?? ($workout->creator?->name ?? 'Admin / Sistem');
        $trainerAvatar = $workout->trainer?->avatar ?? $workout->creator?->avatar;
        $exerciseCount = $workout->workoutExercises->count();

        // Hitung total estimasi durasi
        $totalDuration = $workout->duration_minutes ?? 0;

        // Jika workout plan tidak ada duration, hitung dari exercises
        if ($totalDuration === 0) {
            $totalDuration = $workout->workoutExercises->sum('duration_minutes') ?? 0;
        }

        // Hitung total sets dan reps
        $totalSets = $workout->workoutExercises->sum('sets');
        $totalReps = $workout->workoutExercises->reduce(function ($carry, $exercise) {
            if (preg_match('/(\d+)/', $exercise->reps ?? '', $matches)) {
                return $carry + ($exercise->sets * $matches[1]);
            }
            return $carry;
        }, 0);

        // Hitung BMI untuk rekomendasi
        $bmi = null;
        $bmiCategory = null;
        if (! empty($user->weight) && ! empty($user->height)) {
            $heightInMeter = $user->height / 100;
            $bmi = round($user->weight / ($heightInMeter ** 2), 1);
            $bmiCategory = match (true) {
                $bmi < 18.5 => 'underweight',
                $bmi < 25 => 'normal',
                $bmi < 30 => 'overweight',
                $bmi >= 30 => 'obese',
                default => null,
            };
        }

        // Cek apakah user sudah punya schedule untuk workout ini
        $hasSchedule = WorkoutSchedule::where('user_id', $user->id)
            ->where('workout_plan_id', $id)
            ->where('status', 'pending')
            ->exists();

        // Get user's upcoming schedules
        $upcomingSchedules = WorkoutSchedule::where('user_id', $user->id)
            ->where('workout_plan_id', $id)
            ->where('scheduled_date', '>=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();

        return view('user.workouts.show', compact(
            'workout',
            'trainerName',
            'trainerAvatar',
            'exerciseCount',
            'totalDuration',
            'totalSets',
            'totalReps',
            'bmi',
            'bmiCategory',
            'user',
            'hasSchedule',
            'upcomingSchedules'
        ));
    }

    /**
     * 📅 Buat schedule langsung dari detail workout
     */
    public function scheduleFromDetail(Request $request, $id)
    {
        $user = Auth::user();
        $workout = WorkoutPlan::findOrFail($id);

        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required',
        ]);

        WorkoutSchedule::create([
            'user_id' => $user->id,
            'workout_plan_id' => $id,
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'status' => 'pending',
            'notes' => $request->notes ?? null,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Scheduled ✅',
            'message' => "Kamu telah menjadwalkan '{$workout->title}' pada {$request->scheduled_date} jam {$request->scheduled_time}",
            'type' => 'reminder',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.show', $id)
            ->with('success', 'Workout berhasil dijadwalkan!');
    }

    /**
     * 🔄 Toggle status workout schedule
     */
    public function toggleStatus($id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);

        $newStatus = $schedule->status === 'completed' ? 'pending' : 'completed';
        $schedule->update([
            'status' => $newStatus,
            'completed_at' => $newStatus === 'completed' ? Carbon::now() : null,
        ]);

        $statusText = $newStatus === 'completed' ? 'diselesaikan' : 'ditandai belum selesai';

        return redirect()->route('user.workouts.index')
            ->with('success', "Workout berhasil {$statusText}!");
    }

    /**
     * 📊 Dashboard statistik workout user
     */
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'total_workouts' => WorkoutSchedule::where('user_id', $user->id)->count(),
            'completed_workouts' => WorkoutSchedule::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'pending_workouts' => WorkoutSchedule::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count(),
            'streak_days' => $this->calculateWorkoutStreak($user->id),
            'favorite_workout' => $this->getFavoriteWorkout($user->id),
        ];

        $recentWorkouts = WorkoutSchedule::with('workoutPlan')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->limit(5)
            ->get();

        $upcomingWorkouts = WorkoutSchedule::with('workoutPlan')
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('scheduled_date', '>=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->limit(5)
            ->get();

        return view('user.workouts.dashboard', compact('stats', 'recentWorkouts', 'upcomingWorkouts', 'user'));
    }

    /**
     * 📈 Hitung workout streak user
     */
    private function calculateWorkoutStreak($userId)
    {
        $completedWorkouts = WorkoutSchedule::where('user_id', $userId)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->get()
            ->pluck('completed_at')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->values();

        $streak = 0;
        $today = Carbon::today()->format('Y-m-d');

        foreach ($completedWorkouts as $index => $date) {
            if ($date === $today ||
                $date === Carbon::today()->subDays($index)->format('Y-m-d')) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * 🏆 Dapatkan workout favorit user
     */
    private function getFavoriteWorkout($userId)
    {
        return WorkoutSchedule::select('workout_plan_id')
            ->selectRaw('COUNT(*) as count')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->groupBy('workout_plan_id')
            ->orderByDesc('count')
            ->with('workoutPlan')
            ->first();
    }

    /**
     * 🎯 Quick start workout - langsung mulai workout yang sudah dijadwalkan
     */
    public function quickStart($scheduleId)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($scheduleId);

        // Update schedule menjadi in_progress
        $schedule->update([
            'status' => 'in_progress',
            'started_at' => Carbon::now(),
        ]);

        return redirect()->route('user.workouts.show', $schedule->workout_plan_id)
            ->with('info', 'Workout dimulai! Selamat berlatih! 🏋️‍♂️');
    }
}
