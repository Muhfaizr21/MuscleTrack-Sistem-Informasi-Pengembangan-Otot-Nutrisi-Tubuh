<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BodyMetric;
use App\Models\NutritionPlan;
use App\Models\WorkoutSchedule;
use App\Models\WorkoutPlan;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserSummaryController extends Controller
{
    /**
     * Rekap mingguan aktivitas user: workout, nutrisi, dan progres tubuh.
     */
    public function index()
    {
        $user = Auth::user();

        // Tentukan minggu ini (Senin - Minggu)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        /**
         * 🏋️ WORKOUT MINGGUAN
         * Ambil jadwal workout user minggu ini menggunakan model WorkoutSchedule
         */
        $workouts = WorkoutSchedule::with('workoutPlan')
            ->where('user_id', $user->id)
            ->whereBetween('scheduled_date', [$startOfWeek, $endOfWeek])
            ->select([
                'id',
                'workout_plan_id',
                'scheduled_date',
                'scheduled_time',
                'status',
                'completed_at',
                'notes'
            ])
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get()
            ->map(function ($schedule) {
                return (object) [
                    'id' => $schedule->id,
                    'workout_name' => $schedule->workoutPlan->title ?? 'Unknown Workout',
                    'scheduled_date' => $schedule->scheduled_date,
                    'scheduled_time' => $schedule->scheduled_time,
                    'status' => $schedule->status,
                    'completed_at' => $schedule->completed_at,
                    'notes' => $schedule->notes
                ];
            });

        /**
         * 🥗 NUTRISI MINGGUAN - PERBAIKI: Mapping hari Indonesia ke Inggris
         * Karena di database NutritionPlan menggunakan hari Indonesia
         */
        $daysIndonesian = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $daysEnglish = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Mapping hari Indonesia ke Inggris
        $dayMappingToEnglish = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday'
        ];

        // Dapatkan hari dalam minggu ini dalam format Indonesia
        $currentWeekDaysIndonesian = [];
        for ($i = 0; $i < 7; $i++) {
            $currentWeekDaysIndonesian[] = $daysIndonesian[$i];
        }

        // Konversi ke format Inggris untuk query
        $currentWeekDaysEnglish = array_map(function ($day) use ($dayMappingToEnglish) {
            return $dayMappingToEnglish[$day] ?? $day;
        }, $currentWeekDaysIndonesian);

        // Hitung total nutrisi mingguan
        $nutrition = NutritionPlan::where('user_id', $user->id)
            ->whereIn('day_of_week', $currentWeekDaysIndonesian)
            ->selectRaw('
                SUM(calories) as total_calories,
                SUM(protein) as total_protein,
                SUM(carbs) as total_carbs,
                SUM(fat) as total_fat
            ')
            ->first();

        /**
         * ⚖️ PROGRES TUBUH MINGGUAN - DATA TERAKHIR DARI body_metrics
         */
        $latestProgress = BodyMetric::where('user_id', $user->id)
            ->orderBy('recorded_at', 'desc')
            ->first();

        $weeklyProgress = BodyMetric::where('user_id', $user->id)
            ->whereBetween('recorded_at', [$startOfWeek, $endOfWeek])
            ->orderBy('recorded_at', 'desc')
            ->first();

        /**
         * 📊 DATA KALORI PER HARI UNTUK CHART - PERBAIKI: Gunakan hari Indonesia
         */
        $caloriesPerDay = NutritionPlan::where('user_id', $user->id)
            ->whereIn('day_of_week', $currentWeekDaysIndonesian)
            ->selectRaw('
                day_of_week,
                SUM(calories) as daily_calories
            ')
            ->groupBy('day_of_week')
            ->get();

        // Mapping hari Indonesia ke index (Senin=0, Minggu=6)
        $dayMappingToIndex = [
            'Senin' => 0,
            'Selasa' => 1,
            'Rabu' => 2,
            'Kamis' => 3,
            'Jumat' => 4,
            'Sabtu' => 5,
            'Minggu' => 6
        ];

        // Inisialisasi array dengan 7 hari
        $chartData = array_fill(0, 7, 0);
        $chartLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

        // Isi data kalori per hari berdasarkan hari Indonesia
        foreach ($caloriesPerDay as $day) {
            $dayIndex = $dayMappingToIndex[$day->day_of_week] ?? null;
            if ($dayIndex !== null) {
                $chartData[$dayIndex] = $day->daily_calories ?? 0;
            }
        }

        /**
         * 📈 TREN BERAT BADAN MINGGUAN - dari BodyMetric
         */
        $weightTrend = BodyMetric::where('user_id', $user->id)
            ->whereBetween('recorded_at', [$startOfWeek, $endOfWeek])
            ->select('recorded_at', 'weight', 'muscle_mass', 'body_fat')
            ->orderBy('recorded_at')
            ->get();

        $weightData = [];
        $weightDates = [];
        foreach ($weightTrend as $record) {
            $weightData[] = $record->weight;
            $weightDates[] = Carbon::parse($record->recorded_at)->format('d M');
        }

        /**
         * 🎯 RINGKASAN MINGGUAN LENGKAP
         */
        $progressToUse = $weeklyProgress ?? $latestProgress;

        // Hitung workout yang sudah completed (status = 'completed' DAN completed_at tidak null)
        $completedWorkouts = $workouts->filter(function ($workout) {
            return $workout->status === 'completed' && !is_null($workout->completed_at);
        });

        // Hitung workout yang sedang in_progress
        $inProgressWorkouts = $workouts->filter(function ($workout) {
            return $workout->status === 'in_progress';
        });

        // Hitung workout yang missed (jadwal sudah lewat tapi status masih pending)
        $missedWorkouts = $workouts->filter(function ($workout) {
            $scheduledDateTime = Carbon::parse($workout->scheduled_date . ' ' . $workout->scheduled_time);
            return $workout->status === 'pending' && $scheduledDateTime->isPast();
        });

        $weeklySummary = [
            'range' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M Y'),
            'total_workouts' => $workouts->count(),
            'completed_workouts' => $completedWorkouts->count(),
            'in_progress_workouts' => $inProgressWorkouts->count(),
            'missed_workouts' => $missedWorkouts->count(),
            'total_calories' => $nutrition->total_calories ?? 0,
            'total_protein' => $nutrition->total_protein ?? 0,
            'total_carbs' => $nutrition->total_carbs ?? 0,
            'total_fat' => $nutrition->total_fat ?? 0,
            'latest_weight' => $progressToUse->weight ?? '-',
            'latest_muscle' => $progressToUse->muscle_mass ?? '-',
            'latest_body_fat' => $progressToUse->body_fat ?? '-',
            'chart_data' => $chartData,
            'chart_labels' => $chartLabels,
            'weight_data' => $weightData,
            'weight_dates' => $weightDates,
            'has_progress_data' => !empty($progressToUse),
            'workout_completion_rate' => $workouts->count() > 0 ?
                round(($completedWorkouts->count() / $workouts->count()) * 100) : 0,
        ];

        /**
         * 🔔 PESAN MOTIVASI MINGGUAN YANG LEBIH BERAGAM
         */
        $motivationalMessage = $this->getMotivationalMessage($weeklySummary);

        /**
         * 📅 KIRIM DATA KE VIEW
         */
        return view('user.summary.index', compact(
            'workouts',
            'nutrition',
            'weeklySummary',
            'motivationalMessage'
        ));
    }

    /**
     * 🔥 Pesan motivasi berdasarkan performa minggu ini
     */
    private function getMotivationalMessage($summary)
    {
        $completedWorkouts = $summary['completed_workouts'];
        $totalWorkouts = $summary['total_workouts'];
        $completionRate = $summary['workout_completion_rate'];
        $totalCalories = $summary['total_calories'];
        $hasProgress = $summary['has_progress_data'];

        if ($completionRate >= 80 && $totalCalories > 2000 && $hasProgress) {
            return '🎯 Luar biasa! Konsistensi dan tracking progress-mu sangat menginspirasi. Pertahankan energi positif ini!';
        } elseif ($completionRate >= 60 && $hasProgress) {
            return '💚 Progress yang solid! ' . $completedWorkouts . ' dari ' . $totalWorkouts . ' workout berhasil diselesaikan.';
        } elseif ($completedWorkouts >= 1) {
            return '🌱 Langkah awal yang baik! ' . $completedWorkouts . ' workout sudah selesai. Tingkatkan konsistensimu!';
        } elseif ($hasProgress) {
            return '📊 Kamu sudah mulai tracking progress! Sekarang tambahkan workout untuk hasil maksimal!';
        } else {
            return '🌿 Mulailah dengan tracking progress tubuh dan workout ringan. Setiap langkah kecil berarti!';
        }
    }

    /**
     * 🔄 Mark workout as completed
     */
    public function completeWorkout($scheduleId)
    {
        $user = Auth::user();

        $workoutSchedule = WorkoutSchedule::where('id', $scheduleId)
            ->where('user_id', $user->id)
            ->first();

        if (!$workoutSchedule) {
            return redirect()->back()->with('error', 'Workout schedule not found.');
        }

        $workoutSchedule->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Buat notifikasi
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Workout Completed! 🎉',
            'message' => 'Selamat! Kamu telah menyelesaikan workout: ' .
                ($workoutSchedule->workoutPlan->title ?? 'Workout'),
            'type' => 'achievement',
            'read_status' => false,
        ]);

        return redirect()->back()->with('success', 'Workout marked as completed! 🎉');
    }

    /**
     * 🔄 Mark workout as in progress
     */
    public function startWorkout($scheduleId)
    {
        $user = Auth::user();

        $workoutSchedule = WorkoutSchedule::where('id', $scheduleId)
            ->where('user_id', $user->id)
            ->first();

        if (!$workoutSchedule) {
            return redirect()->back()->with('error', 'Workout schedule not found.');
        }

        $workoutSchedule->update([
            'status' => 'in_progress',
        ]);

        return redirect()->back()->with('success', 'Workout started! 💪');
    }

    /**
     * 🔄 Reset workout status to pending
     */
    public function resetWorkout($scheduleId)
    {
        $user = Auth::user();

        $workoutSchedule = WorkoutSchedule::where('id', $scheduleId)
            ->where('user_id', $user->id)
            ->first();

        if (!$workoutSchedule) {
            return redirect()->back()->with('error', 'Workout schedule not found.');
        }

        $workoutSchedule->update([
            'status' => 'pending',
            'completed_at' => null,
        ]);

        return redirect()->back()->with('success', 'Workout status reset to pending! 🔄');
    }

    /**
     * 📝 Add notes to workout
     */
    public function addWorkoutNotes(Request $request, $scheduleId)
    {
        $user = Auth::user();

        $workoutSchedule = WorkoutSchedule::where('id', $scheduleId)
            ->where('user_id', $user->id)
            ->first();

        if (!$workoutSchedule) {
            return redirect()->back()->with('error', 'Workout schedule not found.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $workoutSchedule->update([
            'notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Workout notes updated! 📝');
    }
}
