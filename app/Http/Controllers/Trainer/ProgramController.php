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
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgramController extends Controller
{
    /**
     * 📋 Daftar semua member dengan program latihan mereka
     */
    public function index()
    {
        $trainer = Auth::user();

        if ($trainer->role !== 'trainer') {
            return redirect()->route('login')->with('error', 'Silakan login sebagai trainer terlebih dahulu.');
        }

        // ✅ PERBAIKAN: Hapus withCount yang bermasalah, gunakan approach sederhana
        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->with(['workoutPlans' => function ($query) {
                $query->latest()->take(1);
            }])
            ->get()
            ->map(function ($member) {
                // Hitung manual tanpa withCount
                $member->total_completed_workouts = WorkoutSchedule::where('user_id', $member->id)
                    ->where('status', 'completed')
                    ->count();

                $member->total_scheduled_workouts = WorkoutSchedule::where('user_id', $member->id)
                    ->where('status', '!=', 'cancelled')
                    ->count();

                $member->latest_workout = WorkoutSchedule::where('user_id', $member->id)
                    ->where('status', 'completed')
                    ->latest()
                    ->first();

                $member->current_plan = $member->workoutPlans->first();
                $member->completion_rate = $member->total_scheduled_workouts > 0
                    ? round(($member->total_completed_workouts / $member->total_scheduled_workouts) * 100)
                    : 0;

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

        if (!$this->isTrainerVerified($trainer)) {
            return redirect()
                ->route('trainer.verification.status')
                ->with('warning', 'Akun Anda belum diverifikasi sebagai trainer.');
        }

        $member = $this->getAuthorizedMember($trainer, $memberId);

        if (!$member) {
            return redirect()
                ->route('trainer.programs.index')
                ->with('error', 'Member tidak ditemukan atau tidak memiliki akses.');
        }

        $workoutPlan = $member->workoutPlans->first();
        $recommendedPlans = $this->getRecommendedPlansForMember($member);

        return view('trainer.programs.edit', compact('member', 'workoutPlan', 'recommendedPlans'));
    }

    /**
     * 💾 Simpan / update program latihan member
     */
    public function update(Request $request, $memberId)
    {
        $trainer = Auth::user();

        $member = $this->getAuthorizedMember($trainer, $memberId);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak untuk member ini.'
            ], 403);
        }

        // 🧾 Validasi input
        $validated = $request->validate([
            'workout_title' => 'required|string|max:255',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'duration_minutes' => 'required|integer|min:10|max:180',
            'description' => 'nullable|string|max:1000',
            'target_fitness' => 'required|in:muscle_gain,fat_loss,maintain,endurance,flexibility',
            'focus_area' => 'required|string|max:100',
            'exercises' => 'required|array|min:1',
            'exercises.*.name' => 'required|string|max:255',
            'exercises.*.type' => 'required|in:strength,cardio,flexibility,core,warmup,cooldown',
            'exercises.*.sets' => 'required|integer|min:1|max:10',
            'exercises.*.reps' => 'required|string|max:50',
            'exercises.*.rest_seconds' => 'required|integer|min:0|max:300',
        ]);

        // 💾 Gunakan transaction
        DB::transaction(function () use ($trainer, $member, $validated) {
            // 🏋️ Buat atau update workout plan
            $workoutPlan = WorkoutPlan::updateOrCreate(
                [
                    'user_id' => $member->id,
                    'trainer_id' => $trainer->id,
                ],
                [
                    'title' => $validated['workout_title'],
                    'level' => $validated['level'],
                    'duration_weeks' => $validated['duration_weeks'],
                    'duration_minutes' => $validated['duration_minutes'],
                    'description' => $validated['description'],
                    'target_fitness' => $validated['target_fitness'],
                    'focus_area' => $validated['focus_area'],
                    'difficulty_level' => $validated['level'],
                    'status' => 'active',
                    'recommended_by' => 'trainer',
                ]
            );

            // 🏃‍♂️ Hapus exercises lama dan buat yang baru
            WorkoutExercise::where('workout_plan_id', $workoutPlan->id)->delete();

            foreach ($validated['exercises'] as $index => $exercise) {
                WorkoutExercise::create([
                    'workout_plan_id' => $workoutPlan->id,
                    'name' => $exercise['name'],
                    'type' => $exercise['type'],
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                    'rest_seconds' => $exercise['rest_seconds'],
                    // ✅ PERBAIKAN: Tidak pakai 'order' karena kolom tidak ada
                    // 'order' => $index, // DIHAPUS
                ]);
            }

            // 🔔 Buat notifikasi untuk member
            Notification::create([
                'user_id' => $member->id,
                'title' => 'Program Latihan Baru 🏋️',
                'message' => "Trainer {$trainer->name} telah membuat program latihan baru untuk Anda: '{$workoutPlan->title}'. Yuk mulai latihan! 💪",
                'type' => 'trainer',
                'read_status' => false,
            ]);
        });

        return redirect()
            ->route('trainer.programs.index')
            ->with('success', "✅ Program latihan '{$validated['workout_title']}' untuk {$member->name} berhasil dibuat!");
    }

    /**
     * 👀 Lihat detail program member
     */
    public function show($memberId)
    {
        $trainer = Auth::user();

        $member = $this->getAuthorizedMember($trainer, $memberId, [
            'workoutPlans' => function ($query) {
                $query->latest()->with(['workoutExercises']);
                // ✅ PERBAIKAN: Hapus orderBy('order')
            },
            'workoutSchedules' => function ($query) {
                $query->latest()
                      ->with('workoutPlan')
                      ->take(10);
            }
        ]);

        if (!$member) {
            abort(404, 'Member tidak ditemukan.');
        }

        $currentPlan = $member->workoutPlans->first();
        $workoutHistory = $member->workoutSchedules->where('status', 'completed');

        return view('trainer.programs.show', compact('member', 'currentPlan', 'workoutHistory'));
    }

    /**
     * 📊 Progress tracking member
     */
    public function progress($memberId)
    {
        $trainer = Auth::user();

        $member = $this->getAuthorizedMember($trainer, $memberId, [
            'workoutSchedules' => function ($query) {
                $query->where('status', 'completed')
                      ->with('workoutPlan')
                      ->latest()
                      ->take(20);
            },
            'bodyMetrics' => function ($query) {
                $query->latest()->take(5);
            }
        ]);

        if (!$member) {
            abort(404, 'Member tidak ditemukan.');
        }

        // 📈 Hitung statistik
        $stats = $this->calculateMemberStats($member);

        return view('trainer.programs.progress', compact('member', 'stats'));
    }

    // ==================== PRIVATE HELPER METHODS ====================

    /**
     * ✅ Cek verifikasi trainer
     */
    private function isTrainerVerified($trainer): bool
    {
        return $trainer->verification_status === 'approved' &&
            TrainerVerification::where('trainer_id', $trainer->id)
                ->where('status', 'approved')
                ->exists();
    }

    /**
     * 🔒 Dapatkan member yang diotorisasi
     */
    private function getAuthorizedMember($trainer, $memberId, $with = [])
    {
        $defaultWith = [
            'workoutPlans' => function ($query) {
                $query->latest()->take(1);
            }
        ];

        $with = array_merge($defaultWith, $with);

        return User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->with($with)
            ->first();
    }

    /**
     * 🎯 Dapatkan rekomendasi workout plans
     */
    private function getRecommendedPlansForMember($member)
    {
        return WorkoutPlan::where('status', 'active')
            ->whereNull('user_id')
            ->where(function ($query) use ($member) {
                if ($member->goal_id) {
                    $query->orWhere('target_fitness', $this->mapGoalToFitnessTarget($member->goal_id));
                }
                $query->orWhereIn('difficulty_level', ['beginner', 'intermediate']);
            })
            ->orderBy('difficulty_level')
            ->limit(6)
            ->get();
    }

    /**
     * 🗺️ Map goal_id ke target_fitness
     */
    private function mapGoalToFitnessTarget($goalId): string
    {
        $mapping = [
            1 => 'muscle_gain',
            2 => 'fat_loss',
            3 => 'endurance',
            4 => 'maintain',
        ];

        return $mapping[$goalId] ?? 'general';
    }

    /**
     * 📊 Hitung statistik member
     */
    private function calculateMemberStats($member): array
    {
        $workouts = $member->workoutSchedules;
        $completedWorkouts = $workouts->where('status', 'completed');

        $recentWorkouts = $completedWorkouts->where('completed_at', '>=', now()->subDays(30));
        $workoutsPerWeek = $recentWorkouts->count() > 0 ? round($recentWorkouts->count() / 4.3, 1) : 0;

        $totalScheduled = $workouts->count();
        $completionRate = $totalScheduled > 0 ? round(($completedWorkouts->count() / $totalScheduled) * 100) : 0;

        return [
            'total_workouts' => $totalScheduled,
            'completed_workouts' => $completedWorkouts->count(),
            'completion_rate' => $completionRate,
            'workouts_per_week' => $workoutsPerWeek,
            'current_streak' => $this->calculateCurrentStreak($completedWorkouts),
        ];
    }

    /**
     * 🔥 Hitung streak latihan saat ini
     */
    private function calculateCurrentStreak($completedWorkouts): int
    {
        $streak = 0;
        $currentDate = now()->startOfDay();

        $workoutDates = $completedWorkouts->pluck('completed_at')
            ->map(function ($date) {
                return Carbon::parse($date)->startOfDay();
            })
            ->unique()
            ->sortDesc();

        foreach ($workoutDates as $workoutDate) {
            if ($workoutDate->equalTo($currentDate->subDays($streak))) {
                $streak++;
            } else {
                break;
            }
        }

        return $streak;
    }

    /**
     * ❌ HAPUS method daftar() dan ajukan() - pindahkan ke VerificationController
     */
}
