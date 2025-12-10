<?php

namespace Database\Seeders;

use App\Models\NutritionPlan;
use App\Models\Supplement;
use App\Models\TrainerVerification;
use App\Models\User;
use App\Models\WorkoutPlan;
use Illuminate\Database\Seeder;

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

        if (! $trainer) {
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
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // =============================
        // 🏋️ Workout Plans untuk setiap member
        // =============================
        foreach ($members as $index => $member) {
            $planData = [
                'user_id' => $member->id,
                'title' => $index === 0 ? 'Upper Body Strength' : 'Cardio & Core Training',
                'level' => $index === 0 ? 'High' : 'Medium',
                'description' => $index === 0
                    ? 'Latihan untuk memperkuat otot dada, bahu, dan punggung atas.'
                    : 'Program untuk meningkatkan stamina dan memperkuat otot perut.',
                'target_fitness' => $index === 0 ? 'strength' : 'endurance',
                'focus_area' => $index === 0 ? 'Upper Body' : 'Core, Cardio',
                'bmi_category' => 'normal',
                'status' => 'active',
                'is_premium' => $index === 0, // Member pertama dapat premium plan
                'difficulty_level' => $index === 0 ? 'advanced' : 'intermediate',
                'duration_weeks' => $index === 0 ? 6 : 4,
                'duration_minutes' => $index === 0 ? 60 : 45,
                'trainer_id' => $trainer->id,
                'recommended_by' => 'Trainer Custom',
                'created_at' => now()->subDays($index === 0 ? 10 : 5),
                'updated_at' => now()->subDays($index === 0 ? 10 : 5),
            ];

            WorkoutPlan::updateOrCreate(
                [
                    'user_id' => $member->id,
                    'title' => $planData['title']
                ],
                $planData
            );
        }

        // =============================
        // 🥗 Nutrition Plans
        // =============================
        $nutrition1 = NutritionPlan::updateOrCreate(
            [
                'user_id' => $members[0]->id ?? null,
                'meal_name' => 'Muscle Gain Meal'
            ],
            [
                'calories' => 2800,
                'protein' => 180,
                'carbs' => 250,
                'fat' => 90,
                'water_intake' => 3.5,
                'hydrogen_level' => 7.2,
                'day_of_week' => 'Monday',
                'target_fitness' => 'Bulking',
                'type' => 'lunch',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ]
        );

        $nutrition2 = null;
        if (isset($members[1])) {
            $nutrition2 = NutritionPlan::updateOrCreate(
                [
                    'user_id' => $members[1]->id,
                    'meal_name' => 'Cardio Energy Meal'
                ],
                [
                    'calories' => 2000,
                    'protein' => 140,
                    'carbs' => 200,
                    'fat' => 60,
                    'water_intake' => 3.0,
                    'hydrogen_level' => 7.0,
                    'day_of_week' => 'Tuesday',
                    'target_fitness' => 'Endurance',
                    'type' => 'dinner',
                    'created_at' => now()->subDays(4),
                    'updated_at' => now()->subDays(4),
                ]
            );
        }

        // =============================
        // 💊 Supplement Recommendations
        // =============================
        if ($nutrition1) {
            Supplement::updateOrCreate(
                [
                    'nutrition_plan_id' => $nutrition1->id,
                    'name' => 'Whey Protein'
                ],
                [
                    'description' => 'Membantu pembentukan massa otot dan pemulihan pasca latihan.',
                    'recommended_dose' => '1 scoop setelah latihan',
                    'created_at' => now()->subDays(7),
                    'updated_at' => now()->subDays(7),
                ]
            );
        }

        if ($nutrition2) {
            Supplement::updateOrCreate(
                [
                    'nutrition_plan_id' => $nutrition2->id,
                    'name' => 'Multivitamin Complex'
                ],
                [
                    'description' => 'Menunjang daya tahan tubuh dan metabolisme setelah sesi cardio intens.',
                    'recommended_dose' => '1 tablet setiap pagi',
                    'created_at' => now()->subDays(3),
                    'updated_at' => now()->subDays(3),
                ]
            );
        }

        // =============================
        // 📊 Summary Output
        // =============================
        $this->command->info('💪 MuscleDemoSeeder sukses!');
        $this->command->info('🧑‍🏫 Trainer: ' . $trainer->name);
        $this->command->info('👥 Members: ' . $members->count() . ' members');
        $this->command->info('🏋️ Workout Plans: ' . WorkoutPlan::count() . ' plans');
        $this->command->info('🥗 Nutrition Plans: ' . NutritionPlan::whereIn('user_id', $members->pluck('id'))->count());
        $this->command->info('💊 Supplements: ' . Supplement::count());

        // Tampilkan info premium plan
        $premiumPlan = WorkoutPlan::where('is_premium', true)->first();
        if ($premiumPlan) {
            $this->command->info('🏆 Premium Plan: "' . $premiumPlan->title . '" untuk ' . ($premiumPlan->user->name ?? 'Unknown'));
        }
    }
}
