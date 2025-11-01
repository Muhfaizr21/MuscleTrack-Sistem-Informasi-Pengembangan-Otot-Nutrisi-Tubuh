<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkoutPlan;
use App\Models\WorkoutSchedule;
use App\Models\Notification;
use Carbon\Carbon;

class UserWorkoutController extends Controller
{
    /**
     * 📋 Tampilkan daftar workout plan untuk user
     * Disesuaikan dengan kondisi dan target user.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua workout yang cocok dengan target user
        $workouts = WorkoutPlan::query()
            ->where(function ($q) use ($user) {
                $q->whereNull('target_fitness') // general
                    ->orWhere('target_fitness', $user->target_fitness);
            })
            ->where('status', 'active')
            ->orderBy('difficulty_level', 'asc')
            ->get();

        // Ambil jadwal user (jika sudah diatur)
        $schedules = WorkoutSchedule::where('user_id', $user->id)->get();

        return view('user.workouts.index', compact('workouts', 'schedules'));
    }

    /**
     * 🧠 Detail Workout Plan
     */
    public function show($id)
    {
        $workout = WorkoutPlan::findOrFail($id);
        return view('user.workouts.show', compact('workout'));
    }

    /**
     * 🕒 Atur atau ubah jadwal workout user
     */
    public function store(Request $request)
    {
        $request->validate([
            'workout_id' => 'required|exists:workout_plans,id',
            'day_of_week' => 'required|string|max:15',
            'time' => 'required',
        ]);

        $user = Auth::user();

        // Simpan atau update jadwal latihan
        $schedule = WorkoutSchedule::updateOrCreate(
            [
                'user_id' => $user->id,
                // ===== PERBAIKAN 1 DI SINI =====
                'plan_id' => $request->workout_id, // Ganti dari 'workout_id'
                'day_of_week' => $request->day_of_week,
            ],
            ['time' => $request->time]
        );

        // 🔔 Buat notifikasi reminder workout
        // Pastikan model WorkoutSchedule Anda punya relasi 'workout'
        // yang menunjuk ke 'plan_id'
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Reminder 🏋️',
            'message' => "Jangan lupa latihan '{$schedule->workout->title}' setiap {$schedule->day_of_week} jam {$schedule->time}!",
            'type' => 'reminder',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.index')->with('success', 'Jadwal workout berhasil disimpan!');
    }

    /**
     * ✏️ Edit jadwal workout
     */
    public function edit($id)
    {
        $schedule = WorkoutSchedule::findOrFail($id);
        $workouts = WorkoutPlan::all();
        return view('user.workouts.edit', compact('schedule', 'workouts'));
    }

    /**
     * 🔄 Update jadwal workout
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'workout_id' => 'required|exists:workout_plans,id',
            'day_of_week' => 'required|string|max:15',
            'time' => 'required',
        ]);

        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);

        $schedule->update([
            // ===== PERBAIKAN 2 DI SINI =====
            'plan_id' => $request->workout_id, // Ganti dari 'workout_id'
            'day_of_week' => $request->day_of_week,
            'time' => $request->time,
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Reminder Updated 🔄',
            'message' => "Jadwal latihan '{$schedule->workout->title}' diubah ke {$schedule->day_of_week} jam {$schedule->time}.",
            'type' => 'reminder',
            'read_status' => false,
        ]);

        return redirect()->route('user.workouts.index')->with('success', 'Jadwal workout berhasil diperbarui!');
    }

    /**
     * ❌ Hapus jadwal workout
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $schedule = WorkoutSchedule::where('user_id', $user->id)->findOrFail($id);
        $schedule->delete();

        return redirect()->route('user.workouts.index')->with('success', 'Jadwal workout berhasil dihapus!');
    }

    public function create(Request $request)
    {
        $workouts = WorkoutPlan::all();
        $selectedWorkout = $request->workout_id ? WorkoutPlan::find($request->workout_id) : null;
        return view('user.workouts.create', compact('workouts', 'selectedWorkout'));
    }
}
