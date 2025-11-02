<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkoutPlan;
use App\Models\WorkoutSchedule;
use App\Models\WorkoutExercise;
use App\Models\Notification;
use Carbon\Carbon;

class UserWorkoutController extends Controller
{
    /**
     * 📋 Tampilkan daftar workout + auto-assign pertama kali berdasarkan BMI & trainer
     */
    public function index()
    {
        $user = Auth::user();

        // 🧮 Hitung BMI (hanya jika tinggi & berat tersedia)
        $bmi = null;
        if (!empty($user->weight) && !empty($user->height)) {
            $heightInMeter = $user->height / 100;
            $bmi = round($user->weight / ($heightInMeter ** 2), 1);
        }

        // 🔎 Tentukan kategori BMI
        $bmiCategory = match (true) {
            $bmi === null => null,
            $bmi < 18.5   => 'underweight',
            $bmi < 25     => 'normal',
            $bmi < 30     => 'overweight',
            $bmi >= 30    => 'obese',
            default       => null,
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

        // 🧩 Gabungkan semua sumber plan
        $workouts = $recommendedPlans
            ->merge($trainerWorkouts)
            ->merge($adminWorkouts)
            ->unique('id')
            ->sortBy('difficulty_level')
            ->values();

        // 🗓️ Cek apakah user sudah punya jadwal aktif
        $hasActiveSchedule = WorkoutSchedule::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        // 🔁 Auto assign plan pertama kali jika belum punya
        if (! $hasActiveSchedule) {
            $selectedPlan = $trainerWorkouts->first()
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
                    'message' => "Sistem menyiapkan rencana '{$selectedPlan->title}' berdasarkan BMI kamu"
                        . ($bmiCategory ? " ({$bmiCategory})" : "")
                        . ($user->trainer_id ? " dan bimbingan trainer kamu." : "."),
                    'type' => 'reminder',
                    'read_status' => false,
                ]);
            }
        }

        $schedules = WorkoutSchedule::with('workoutPlan')
            ->where('user_id', $user->id)
            ->orderBy('scheduled_date')
            ->get();

        return view('user.workouts.index', compact('workouts', 'schedules', 'bmi', 'bmiCategory'));
    }

    /**
     * ➕ Form tambah jadwal workout baru
     */
    public function create(Request $request)
    {
        $user = Auth::user();

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

        $workouts = $trainerWorkouts->merge($adminWorkouts)->unique('id')->values();
        $selectedWorkout = $request->workout_id ? WorkoutPlan::find($request->workout_id) : null;

        return view('user.workouts.create', compact('workouts', 'selectedWorkout'));
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
     * 🔍 Lihat detail workout plan + daftar latihan (WorkoutExercise)
     */
    public function show($id)
    {
        $workout = WorkoutPlan::with(['exercises', 'trainer:id,name'])->findOrFail($id);

        $trainerName = $workout->trainer?->name ?? 'Admin / Sistem';
        $exerciseCount = $workout->exercises->count();

        return view('user.workouts.show', compact('workout', 'trainerName', 'exerciseCount'));
    }
}
