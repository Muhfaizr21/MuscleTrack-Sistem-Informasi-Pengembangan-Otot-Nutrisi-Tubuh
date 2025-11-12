<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkoutPlanSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('workout_plans')->truncate();
        DB::table('workout_schedules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ============================================================
        // 👑 Admin (Plan Umum — Dasar Sistem)
        // ============================================================
        $admin = DB::table('users')->where('role', 'admin')->first();

        DB::table('workout_plans')->insert([
            [
                'title' => 'Full Body Foundation',
                'level' => 'Beginner',
                'description' => 'Program 4 minggu untuk memperkuat otot utama dan memperbaiki postur tubuh. Ideal bagi pemula.',
                'target_fitness' => 'muscle_gain',
                'focus_area' => 'foundation',
                'bmi_category' => null,
                'status' => 'active',
                'difficulty_level' => 'beginner',
                'duration_weeks' => 4,
                'duration_minutes' => 45,
                'user_id' => $admin->id,
                'trainer_id' => null,
                'recommended_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fat Loss Accelerator',
                'level' => 'Intermediate',
                'description' => 'Latihan intensitas tinggi 6 minggu untuk pembakaran lemak optimal dan peningkatan metabolisme.',
                'target_fitness' => 'fat_loss',
                'focus_area' => 'cutting',
                'bmi_category' => null,
                'status' => 'active',
                'difficulty_level' => 'intermediate',
                'duration_weeks' => 6,
                'duration_minutes' => 50,
                'user_id' => $admin->id,
                'trainer_id' => null,
                'recommended_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $foundationId = DB::table('workout_plans')->where('title', 'Full Body Foundation')->value('id');
        $fatlossId = DB::table('workout_plans')->where('title', 'Fat Loss Accelerator')->value('id');

        // ============================================================
        // 🧠 BMI-Based Plans — Evidence-Based & Goal Specific
        // ============================================================
        $bmiPlans = [
            // === UNDERWEIGHT (Goal: Bulking, Strength Gain) ===
            [
                'title' => 'Lean Mass Starter',
                'focus_area' => 'bulking',
                'bmi_category' => 'underweight',
                'difficulty_level' => 'beginner',
                'duration_minutes' => 45,
                'duration_weeks' => 4,
                'description' => 'Latihan compound: squat, bench press, deadlift, dip, dan pull-up. Fokus pada kenaikan berat sehat.',
            ],
            [
                'title' => 'Progressive Strength Gain',
                'focus_area' => 'bulking',
                'bmi_category' => 'underweight',
                'difficulty_level' => 'intermediate',
                'duration_minutes' => 60,
                'duration_weeks' => 6,
                'description' => 'Program split 4 hari dengan progresi beban bertahap (progressive overload).',
            ],

            // === NORMAL (Goal: Maintain & Performance) ===
            [
                'title' => 'Body Balance Routine',
                'focus_area' => 'maintain',
                'bmi_category' => 'normal',
                'difficulty_level' => 'intermediate',
                'duration_minutes' => 50,
                'duration_weeks' => 5,
                'description' => 'Program menjaga komposisi tubuh ideal dengan kombinasi kekuatan, mobilitas, dan HIIT.',
            ],
            [
                'title' => 'Athletic Performance Plan',
                'focus_area' => 'maintain',
                'bmi_category' => 'normal',
                'difficulty_level' => 'advanced',
                'duration_minutes' => 60,
                'duration_weeks' => 6,
                'description' => 'Latihan fungsional dan eksplosif berbasis plyometric untuk peningkatan performa atletik.',
            ],

            // === OVERWEIGHT (Goal: Cutting, Core Strength) ===
            [
                'title' => 'Cardio Burn Starter',
                'focus_area' => 'cutting',
                'bmi_category' => 'overweight',
                'difficulty_level' => 'beginner',
                'duration_minutes' => 40,
                'duration_weeks' => 4,
                'description' => 'HIIT low-impact, bodyweight cardio, dan latihan core aman untuk penurunan berat badan awal.',
            ],
            [
                'title' => 'Core Strength & Fat Loss',
                'focus_area' => 'cutting',
                'bmi_category' => 'overweight',
                'difficulty_level' => 'intermediate',
                'duration_minutes' => 55,
                'duration_weeks' => 6,
                'description' => 'Fokus membakar lemak dengan circuit training dan plank variations untuk core stabil.',
            ],

            // === OBESE (Goal: Safe Weight Reduction) ===
            [
                'title' => 'Low Impact Reboot',
                'focus_area' => 'cutting',
                'bmi_category' => 'obese',
                'difficulty_level' => 'beginner',
                'duration_minutes' => 30,
                'duration_weeks' => 4,
                'description' => 'Latihan sederhana berbasis chair workout dan resistance band, aman untuk sendi dan lutut.',
            ],
            [
                'title' => 'Metabolic Recovery Plan',
                'focus_area' => 'cutting',
                'bmi_category' => 'obese',
                'difficulty_level' => 'intermediate',
                'duration_minutes' => 45,
                'duration_weeks' => 6,
                'description' => 'Program kombinasi jalan cepat, latihan beban ringan, dan peregangan aktif untuk memperbaiki metabolisme.',
            ],
        ];

        foreach ($bmiPlans as $plan) {
            DB::table('workout_plans')->insert([
                'title' => $plan['title'],
                'level' => ucfirst($plan['difficulty_level']),
                'description' => $plan['description'],
                'target_fitness' => $plan['focus_area'],
                'focus_area' => $plan['focus_area'],
                'bmi_category' => $plan['bmi_category'],
                'status' => 'active',
                'difficulty_level' => $plan['difficulty_level'],
                'duration_weeks' => $plan['duration_weeks'],
                'duration_minutes' => $plan['duration_minutes'],
                'user_id' => $admin->id,
                'trainer_id' => null,
                'recommended_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ============================================================
        // 🏋️ Trainer Verified Plans
        // ============================================================
        $trainers = DB::table('users')
            ->where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->get();

        foreach ($trainers as $trainer) {
            DB::table('workout_plans')->insert([
                [
                    'title' => 'Hypertrophy Elite Program',
                    'level' => 'Advanced',
                    'description' => 'Program 8 minggu dengan teknik volume tinggi dan fokus hypertrophy untuk pembentukan otot maksimal.',
                    'target_fitness' => 'muscle_gain',
                    'focus_area' => 'upper_lower_split',
                    'bmi_category' => null,
                    'status' => 'active',
                    'difficulty_level' => 'advanced',
                    'duration_weeks' => 8,
                    'duration_minutes' => 65,
                    'user_id' => $trainer->id,
                    'trainer_id' => $trainer->id,
                    'recommended_by' => 'trainer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Functional Endurance Routine',
                    'level' => 'Intermediate',
                    'description' => 'Latihan 5 minggu untuk peningkatan daya tahan otot dan efisiensi kardiovaskular.',
                    'target_fitness' => 'endurance',
                    'focus_area' => 'core_endurance',
                    'bmi_category' => null,
                    'status' => 'active',
                    'difficulty_level' => 'intermediate',
                    'duration_weeks' => 5,
                    'duration_minutes' => 40,
                    'user_id' => $trainer->id,
                    'trainer_id' => $trainer->id,
                    'recommended_by' => 'trainer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // ============================================================
        // 👤 Auto-assign schedule untuk user tanpa trainer
        // ============================================================
        $usersWithoutTrainer = DB::table('users')
            ->where('role', 'user')
            ->whereNull('trainer_id')
            ->get();

        foreach ($usersWithoutTrainer as $user) {
            DB::table('workout_schedules')->insert([
                [
                    'user_id' => $user->id,
                    'workout_plan_id' => $foundationId,
                    'scheduled_date' => now()->addDay()->toDateString(),
                    'scheduled_time' => '07:30:00',
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $user->id,
                    'workout_plan_id' => $fatlossId,
                    'scheduled_date' => now()->addDays(3)->toDateString(),
                    'scheduled_time' => '09:00:00',
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $this->command->info('🏋️ WorkoutPlanSeeder updated successfully with BMI-based scientific plans!');
    }
}
