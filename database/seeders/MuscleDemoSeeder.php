<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TrainerVerification;
use App\Models\WorkoutPlan;
use App\Models\NutritionPlan;
use App\Models\Supplement;

class MuscleDemoSeeder extends Seeder
{
    public function run(): void
    {
        // =============================
        // 🧑‍🏫 Ambil trainer yang sudah approved
        // =============================
        $trainer = User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->first();

        if (!$trainer) {
            $this->command->warn('⚠️ Tidak ditemukan trainer yang disetujui. Jalankan UserSeeder dulu.');
            return;
        }

        // =============================
        // 🧍 Ambil member yang dimiliki trainer
        // =============================
        $members = User::where('role', 'user')
            ->where('trainer_id', $trainer->id)
            ->get();

        if ($members->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada member yang terhubung ke trainer approved.');
            return;
        }

        // =============================
        // ✅ Verifikasi Trainer
        // =============================
        TrainerVerification::updateOrCreate(
            ['trainer_id' => $trainer->id],
            [
                'certificate' => 'certificates/cert_andika.pdf',
                'bio' => 'Certified Personal Trainer dengan pengalaman 5 tahun dalam pembentukan otot dan nutrisi fitness.',
                'status' => 'approved',
            ]
        );

        // =============================
        // 🏋️ Workout Plans untuk setiap member
        // =============================
        foreach ($members as $index => $member) {
            WorkoutPlan::updateOrCreate(
                ['user_id' => $member->id],
                [
                    'title' => $index === 0 ? 'Upper Body Strength' : 'Cardio & Core Training',
                    'level' => $index === 0 ? 'High' : 'Medium',
                    'description' => $index === 0
                        ? 'Latihan untuk memperkuat otot dada, bahu, dan punggung atas.'
                        : 'Program untuk meningkatkan stamina dan memperkuat otot perut.',
                    'duration_weeks' => $index === 0 ? 6 : 4,
                ]
            );
        }

        // =============================
        // 🥗 Nutrition Plans
        // =============================
        $nutrition1 = NutritionPlan::updateOrCreate(
            ['user_id' => $members[0]->id ?? null],
            [
                'meal_name' => 'Muscle Gain Meal',
                'calories' => 2800,
                'protein' => 180,
                'carbs' => 250,
                'fat' => 90,
                'day_of_week' => 'Monday',
                'target_fitness' => 'Bulking',
                'type' => 'lunch',
            ]
        );

        $nutrition2 = NutritionPlan::updateOrCreate(
            ['user_id' => $members[1]->id ?? null],
            [
                'meal_name' => 'Cardio Energy Meal',
                'calories' => 2000,
                'protein' => 140,
                'carbs' => 200,
                'fat' => 60,
                'day_of_week' => 'Tuesday',
                'target_fitness' => 'Endurance',
                'type' => 'dinner',
            ]
        );

        // =============================
        // 💊 Supplement Recommendations
        // =============================
        if ($nutrition1) {
            Supplement::updateOrCreate(
                ['nutrition_plan_id' => $nutrition1->id, 'name' => 'Whey Protein'],
                [
                    'description' => 'Membantu pembentukan massa otot dan pemulihan pasca latihan.',
                    'recommended_dose' => '1 scoop setelah latihan',
                ]
            );
        }

        if ($nutrition2) {
            Supplement::updateOrCreate(
                ['nutrition_plan_id' => $nutrition2->id, 'name' => 'Multivitamin Complex'],
                [
                    'description' => 'Menunjang daya tahan tubuh dan metabolisme setelah sesi cardio intens.',
                    'recommended_dose' => '1 tablet setiap pagi',
                ]
            );
        }

        // =============================
        // ✅ Done
        // =============================
        $this->command->info('💪 MuscleDemoSeeder sukses! Data latihan, nutrisi, dan suplemen sudah dibuat untuk trainer approved.');
    }
}
