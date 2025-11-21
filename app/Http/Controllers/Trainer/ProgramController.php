<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerVerification;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\WorkoutExercise;
use App\Models\WorkoutSchedule;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProgramController extends Controller
{
    /**
     * 📋 Daftar semua member dengan program latihan mereka
     */
    public function index()
    {
        $trainer = Auth::user();

        // 🚫 Pastikan login sebagai trainer
        if (!$trainer || $trainer->role !== 'trainer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai trainer terlebih dahulu.');
        }

        // ✅ Ambil semua member yang dibimbing trainer dengan data lengkap
        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->with(['workoutPlans' => function ($query) {
                $query->latest()->take(1); // Ambil program terbaru
            }, 'workoutSchedules' => function ($query) {
                $query->where('status', 'completed')->latest()->take(5); // Ambil 5 workout terakhir yang selesai
            }])
            ->get()
            ->map(function ($member) {
                // Hitung progress stats untuk setiap member
                $member->total_completed_workouts = $member->workoutSchedules->where('status', 'completed')->count();
                $member->latest_workout = $member->workoutSchedules->where('status', 'completed')->first();
                $member->current_plan = $member->workoutPlans->first();

                return $member;
            });

        return view('trainer.programs.index', compact('trainer', 'members'));
    }

    /**
     * 🧭 Menampilkan form edit program latihan member
     */
    public function edit($memberId)
    {
        $trainer = Auth::user();

        // 🚫 Cek login & role
        if (!$trainer || $trainer->role !== 'trainer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai trainer terlebih dahulu.');
        }

        // ✅ Pastikan trainer sudah diverifikasi
        $isVerified = $trainer->verification_status === 'approved' &&
            TrainerVerification::where('trainer_id', $trainer->id)
            ->where('status', 'approved')
            ->exists();

        if (!$isVerified) {
            return redirect()
                ->route('trainer.quality.verification.status')
                ->with('warning', 'Akun Anda belum diverifikasi sebagai trainer.');
        }

        // 🧍 Ambil member yang benar-benar dibimbing oleh trainer
        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->with(['workoutPlans' => function ($query) {
                $query->latest()->take(1);
            }, 'workoutSchedules' => function ($query) {
                $query->where('status', 'completed')->latest()->take(10);
            }])
            ->first();

        if (!$member) {
            abort(403, 'Anda tidak memiliki akses ke member ini.');
        }

        // ✅ Ambil data program latihan terbaru
        $workoutPlan = $member->workoutPlans->first();

        // 🏋️ Ambil template workout plans untuk rekomendasi
        $recommendedPlans = $this->getRecommendedPlansForMember($member);

        return view('trainer.programs.edit', compact('member', 'workoutPlan', 'recommendedPlans'));
    }

    /**
     * 💾 Simpan / update program latihan member
     */
    public function update(Request $request, $memberId)
    {
        $trainer = Auth::user();

        // 🚫 Pastikan hanya bisa mengedit member miliknya
        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->first();

        if (!$member) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit member ini.');
        }

        // 🧾 Validasi input
        $request->validate([
            'workout_title' => 'required|string|max:255',
            'level' => 'nullable|string|max:50',
            'duration_weeks' => 'nullable|integer|min:1',
            'duration_minutes' => 'nullable|integer|min:5',
            'description' => 'nullable|string|max:1000',
            'target_fitness' => 'nullable|string|max:100',
            'focus_area' => 'nullable|string|max:100',
            'exercises' => 'nullable|array',
            'exercises.*.name' => 'required|string|max:255',
            'exercises.*.sets' => 'nullable|integer|min:1',
            'exercises.*.reps' => 'nullable|string|max:50',
            'exercises.*.rest_seconds' => 'nullable|integer|min:0',
        ]);

        // 🏋️ Buat atau update workout plan
        $workoutPlan = WorkoutPlan::updateOrCreate(
            [
                'user_id' => $member->id,
                'trainer_id' => $trainer->id,
            ],
            [
                'title' => $request->workout_title,
                'level' => $request->level,
                'duration_weeks' => $request->duration_weeks,
                'duration_minutes' => $request->duration_minutes,
                'description' => $request->description,
                'target_fitness' => $request->target_fitness,
                'focus_area' => $request->focus_area,
                'difficulty_level' => $request->level,
                'status' => 'active',
                'recommended_by' => 'trainer',
            ]
        );

        // 🏃‍♂️ Simpan exercises jika ada
        if ($request->has('exercises')) {
            // Hapus exercises lama
            WorkoutExercise::where('workout_plan_id', $workoutPlan->id)->delete();

            // Simpan exercises baru
            foreach ($request->exercises as $index => $exercise) {
                WorkoutExercise::create([
                    'workout_plan_id' => $workoutPlan->id,
                    'name' => $exercise['name'],
                    'type' => $exercise['type'] ?? 'strength',
                    'sets' => $exercise['sets'] ?? 3,
                    'reps' => $exercise['reps'] ?? '10-12',
                    'rest_seconds' => $exercise['rest_seconds'] ?? 60,
                    'order' => $index,
                ]);
            }
        }

        // 🔔 Buat notifikasi untuk member
        Notification::create([
            'user_id' => $member->id,
            'title' => 'Program Latihan Baru 🏋️',
            'message' => "Trainer {$trainer->name} telah membuat program latihan baru untuk Anda: '{$workoutPlan->title}'. Yuk mulai latihan! 💪",
            'type' => 'trainer',
            'read_status' => false,
        ]);

        // ✅ Redirect ke halaman index dengan pesan sukses
        return redirect()
            ->route('trainer.programs.index')
            ->with('success', "✅ Program latihan '{$workoutPlan->title}' untuk {$member->name} berhasil dibuat!");
    }

    /**
     * 🎯 Dapatkan rekomendasi workout plans berdasarkan data member
     */
    private function getRecommendedPlansForMember($member)
    {
        $query = WorkoutPlan::where('status', 'active')
            ->whereNull('user_id') // Template plans
            ->where(function ($q) use ($member) {
                // Rekomendasi berdasarkan BMI jika ada data
                if ($member->weight && $member->height) {
                    $heightInMeter = $member->height / 100;
                    $bmi = $member->weight / ($heightInMeter ** 2);

                    if ($bmi < 18.5) {
                        $q->orWhere('target_fitness', 'muscle_gain')
                            ->orWhere('target_fitness', 'bulking');
                    } elseif ($bmi >= 25) {
                        $q->orWhere('target_fitness', 'fat_loss')
                            ->orWhere('target_fitness', 'cutting');
                    } else {
                        $q->orWhere('target_fitness', 'maintain')
                            ->orWhere('target_fitness', 'toning');
                    }
                }

                // Rekomendasi berdasarkan gender
                if ($member->gender) {
                    if ($member->gender === 'female') {
                        $q->orWhere('focus_area', 'like', '%toning%')
                            ->orWhere('focus_area', 'like', '%full_body%');
                    } else {
                        $q->orWhere('focus_area', 'like', '%strength%')
                            ->orWhere('focus_area', 'like', '%muscle%');
                    }
                }

                // Plan umum untuk semua
                $q->orWhereIn('target_fitness', ['general', 'foundation', 'beginner']);
            });

        return $query->orderBy('difficulty_level')->get();
    }

    /**
     * 👀 Lihat detail program member
     */
    public function show($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->with(['workoutPlans' => function ($query) {
                $query->latest()->with(['workoutExercises', 'exercises']);
            }, 'workoutSchedules' => function ($query) {
                $query->latest()->with('workoutPlan');
            }])
            ->firstOrFail();

        $currentPlan = $member->workoutPlans->first();
        $workoutHistory = $member->workoutSchedules->where('status', 'completed')->take(10);

        return view('trainer.programs.show', compact('member', 'currentPlan', 'workoutHistory'));
    }

    /**
     * 📊 Progress tracking member
     */
    public function progress($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->with(['workoutSchedules' => function ($query) {
                $query->where('status', 'completed')
                    ->with('workoutPlan')
                    ->latest()
                    ->take(20);
            }, 'progressLogs' => function ($query) {
                $query->latest()->take(10);
            }])
            ->firstOrFail();

        // Hitung statistik
        $totalWorkouts = $member->workoutSchedules->count();
        $completedWorkouts = $member->workoutSchedules->where('status', 'completed')->count();
        $completionRate = $totalWorkouts > 0 ? round(($completedWorkouts / $totalWorkouts) * 100) : 0;

        // Workout frequency (per minggu)
        $recentWorkouts = $member->workoutSchedules->where('completed_at', '>=', now()->subDays(30));
        $workoutsPerWeek = $recentWorkouts->count() > 0 ? round($recentWorkouts->count() / 4.3, 1) : 0;

        return view('trainer.programs.progress', compact(
            'member',
            'totalWorkouts',
            'completedWorkouts',
            'completionRate',
            'workoutsPerWeek'
        ));
    }

    /**
     * 📋 Halaman daftar & pengajuan verifikasi trainer
     */
    public function daftar()
    {
        $trainer = Auth::user();
        $request = TrainerVerification::where('trainer_id', $trainer->id)->latest()->first();

        return view('trainer.programs.daftar', compact('trainer', 'request'));
    }

    /**
     * 📨 Kirim pengajuan verifikasi trainer
     */
    public function ajukan(Request $request)
    {
        $trainer = Auth::user();

        $request->validate([
            'bio' => 'required|string|max:1000',
            'certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $path = $request->hasFile('certificate')
            ? $request->file('certificate')->store('certificates', 'public')
            : null;

        TrainerVerification::create([
            'trainer_id' => $trainer->id,
            'certificate' => $path,
            'bio' => $request->bio,
            'status' => 'pending',
        ]);

        $trainer->update(['verification_status' => 'pending']);

        return redirect()
            ->route('trainer.programs.daftar')
            ->with('success', '✅ Pengajuan verifikasi telah dikirim. Tunggu persetujuan admin.');
    }
}
