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
                        default => 'cutting',
                    };
                    $q->where('bmi_category', $bmiCategory)
                        ->orWhere('focus_area', $focus);
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
            $muscleGroups = json_decode($fitnessProfile->preferred_muscle_groups);

            $focusAreaMap = [
                'chest' => 'upper_body',
                'back' => 'upper_body',
                'arms' => 'upper_body',
                'shoulders' => 'upper_body',
                'legs' => 'lower_body',
                'core' => 'core',
                'glutes' => 'lower_body',
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
                $query->whereIn('target_fitness', ['maintain', 'endurance', 'toning']);
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
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
        ]);

        $user = Auth::user();

        $schedule = WorkoutSchedule::updateOrCreate(
            [
                'user_id' => $user->id,
                'workout_plan_id' => $request->workout_id,
                'scheduled_date' => $request->scheduled_date,
            ],
            [
                'scheduled_time' => $request->scheduled_time,
                'status' => 'pending',
                'notes' => $request->notes ?? null,
            ]
        );

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Reminder 🏋️',
            'message' => "Jangan lupa latihan '{$schedule->workoutPlan->title}' pada tanggal {$schedule->scheduled_date} jam {$schedule->scheduled_time}! 🔥",
            'type' => 'reminder',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.index')->with('success', 'Jadwal workout berhasil disimpan!');
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
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Completed 🎉',
            'message' => "Hebat! Kamu telah menyelesaikan latihan '{$schedule->workoutPlan->title}' pada " .
                Carbon::now()->translatedFormat('l, d F Y H:i'),
            'type' => 'achievement',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.index')->with('success', 'Workout berhasil diselesaikan! 💪');
    }

    /**
     * ✏️ Edit workout schedule
     */
    public function edit($id)
    {
        $schedule = WorkoutSchedule::with('workoutPlan')->findOrFail($id);

        return view('user.workouts.edit', compact('schedule'));
    }

    /**
     * 🗑️ Hapus jadwal workout
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);
        $schedule->delete();

        return redirect()->route('user.workouts.index')->with('success', 'Jadwal workout berhasil dihapus!');
    }

    /**
     * 🔍 Lihat detail workout plan + daftar latihan (Exercises) dengan tutorial
     */
    public function show($id)
    {
        $user = Auth::user();
        $workout = WorkoutPlan::with([
            'exercises' => function ($query) {
                $query->withPivot('sets', 'reps', 'duration', 'order', 'rest_interval');
            }, 
            'trainer:id,name',
            'workoutExercises'
        ])->findOrFail($id);

        $trainerName = $workout->trainer?->name ?? 'Admin / Sistem';
        $exerciseCount = $workout->exercises->count() + $workout->workoutExercises->count();

        // Hitung total estimasi durasi dan kalori
        $totalDuration = $workout->duration_minutes ?? 0;
        $totalCalories = 0;

        // Hitung kalori dari exercises
        foreach ($workout->exercises as $exercise) {
            $exerciseDuration = $exercise->pivot->duration ?? $exercise->duration ?? 0;
            if ($exercise->calories_burned && $exerciseDuration) {
                $totalCalories += $exercise->calories_burned * ($exerciseDuration / 60);
            }
        }

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

        return view('user.workouts.show', compact(
            'workout', 
            'trainerName', 
            'exerciseCount',
            'totalDuration',
            'totalCalories',
            'bmi',
            'bmiCategory',
            'user'
        ));
    }
}