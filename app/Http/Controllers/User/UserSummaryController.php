<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
         * Ambil jadwal workout user minggu ini berdasarkan scheduled_date
         */
        $workouts = DB::table('workout_schedules')
            ->join('workout_plans', 'workout_schedules.workout_plan_id', '=', 'workout_plans.id')
            ->where('workout_schedules.user_id', $user->id)
            ->whereBetween('scheduled_date', [$startOfWeek, $endOfWeek])
            ->select(
                'workout_plans.title as workout_name',
                'workout_schedules.scheduled_date',
                'workout_schedules.scheduled_time',
                'workout_schedules.status'
            )
            ->orderBy('workout_schedules.scheduled_date')
            ->get();

        /**
         * 🥗 NUTRISI MINGGUAN
         * Hitung total kalori dan makronutrien minggu ini
         */
        $nutrition = DB::table('nutrition_plans')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('
                SUM(calories) as total_calories,
                SUM(protein) as total_protein,
                SUM(carbs) as total_carbs,
                SUM(fat) as total_fat
            ')
            ->first();

        /**
         * ⚖️ PROGRES TUBUH MINGGUAN
         * Ambil data terakhir dari body_metrics minggu ini
         */
        $progress = DB::table('body_metrics')
            ->where('user_id', $user->id)
            ->whereBetween('recorded_at', [$startOfWeek, $endOfWeek])
            ->orderBy('recorded_at', 'desc')
            ->first();

        /**
         * 📊 RINGKASAN MINGGUAN
         */
        $weeklySummary = [
            'range' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M Y'),
            'total_workouts' => $workouts->count(),
            'completed_workouts' => $workouts->where('status', 'completed')->count(),
            'total_calories' => $nutrition->total_calories ?? 0,
            'total_protein' => $nutrition->total_protein ?? 0,
            'total_carbs' => $nutrition->total_carbs ?? 0,
            'total_fat' => $nutrition->total_fat ?? 0,
            'latest_weight' => $progress->weight ?? '-',
            'latest_muscle' => $progress->muscle_mass ?? '-',
            'latest_body_fat' => $progress->body_fat ?? '-',
        ];

        /**
         * 🔔 PESAN MOTIVASI MINGGUAN
         */
        $motivationalMessage = $this->getMotivationalMessage($weeklySummary);

        /**
         * 📅 KIRIM DATA KE VIEW
         */
        return view('user.summary.index', compact(
            'workouts',
            'nutrition',
            'progress',
            'weeklySummary',
            'motivationalMessage'
        ));
    }

    /**
     * 🔥 Pesan motivasi berdasarkan performa minggu ini
     */
    private function getMotivationalMessage($summary)
    {
        if ($summary['completed_workouts'] >= 4 && $summary['total_calories'] > 0) {
            return "🔥 Luar biasa, kamu konsisten latihan dan menjaga nutrisi! Pertahankan semangatmu!";
        } elseif ($summary['completed_workouts'] >= 2) {
            return "💪 Bagus! Kamu sedang berada di jalur yang benar — tingkatkan lagi minggu depan!";
        } else {
            return "✨ Yuk semangat lagi minggu depan! Mulai dari langkah kecil, yang penting konsisten!";
        }
    }
}
