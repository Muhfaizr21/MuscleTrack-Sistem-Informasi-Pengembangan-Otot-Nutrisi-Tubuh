<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkoutExerciseSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('workout_exercises')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $plans = DB::table('workout_plans')->get();

        foreach ($plans as $plan) {
            $exercises = [];

            switch ($plan->bmi_category) {
                // ========================================
                // 💪 UNDERWEIGHT (Bulking)
                // ========================================
                case 'underweight':
                    $exercises = [
                        [
                            'name' => 'Barbell Squat',
                            'type' => 'strength',
                            'sets' => 4,
                            'reps' => '8-10',
                            'rest_seconds' => 90,
                        ],
                        [
                            'name' => 'Bench Press',
                            'type' => 'strength',
                            'sets' => 4,
                            'reps' => '8-10',
                            'rest_seconds' => 90,
                        ],
                        [
                            'name' => 'Deadlift',
                            'type' => 'strength',
                            'sets' => 3,
                            'reps' => '6-8',
                            'rest_seconds' => 120,
                        ],
                        [
                            'name' => 'Pull-Up',
                            'type' => 'bodyweight',
                            'sets' => 3,
                            'reps' => '8-12',
                            'rest_seconds' => 60,
                        ],
                        [
                            'name' => 'Plank',
                            'type' => 'core',
                            'sets' => 3,
                            'reps' => '30-60 detik',
                            'rest_seconds' => 45,
                        ],
                    ];
                    break;

                    // ========================================
                    // ⚖️ NORMAL (Maintain)
                    // ========================================
                case 'normal':
                    $exercises = [
                        [
                            'name' => 'Push-Up',
                            'type' => 'bodyweight',
                            'sets' => 3,
                            'reps' => '12-15',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Lunges',
                            'type' => 'bodyweight',
                            'sets' => 3,
                            'reps' => '10 tiap kaki',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Dumbbell Row',
                            'type' => 'strength',
                            'sets' => 3,
                            'reps' => '10-12',
                            'rest_seconds' => 60,
                        ],
                        [
                            'name' => 'Plank to Shoulder Tap',
                            'type' => 'core',
                            'sets' => 3,
                            'reps' => '45 detik',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Mountain Climbers',
                            'type' => 'cardio',
                            'sets' => 3,
                            'reps' => '30 detik',
                            'rest_seconds' => 30,
                        ],
                    ];
                    break;

                    // ========================================
                    // 🔥 OVERWEIGHT (Cutting)
                    // ========================================
                case 'overweight':
                    $exercises = [
                        [
                            'name' => 'Jumping Jack',
                            'type' => 'cardio',
                            'sets' => 3,
                            'reps' => '30 detik',
                            'rest_seconds' => 30,
                        ],
                        [
                            'name' => 'Bodyweight Squat',
                            'type' => 'bodyweight',
                            'sets' => 3,
                            'reps' => '12-15',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Push-Up (Knee)',
                            'type' => 'bodyweight',
                            'sets' => 3,
                            'reps' => '10-12',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Standing Side Crunch',
                            'type' => 'core',
                            'sets' => 3,
                            'reps' => '12-15 tiap sisi',
                            'rest_seconds' => 30,
                        ],
                        [
                            'name' => 'March in Place',
                            'type' => 'cardio',
                            'sets' => 3,
                            'reps' => '60 detik',
                            'rest_seconds' => 30,
                        ],
                    ];
                    break;

                    // ========================================
                    // 🩺 OBESE (Low Impact & Safety Focus)
                    // ========================================
                case 'obese':
                    $exercises = [
                        [
                            'name' => 'Seated March',
                            'type' => 'low_impact',
                            'sets' => 3,
                            'reps' => '60 detik',
                            'rest_seconds' => 30,
                        ],
                        [
                            'name' => 'Wall Push-Up',
                            'type' => 'low_impact',
                            'sets' => 3,
                            'reps' => '8-10',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Resistance Band Row',
                            'type' => 'low_impact',
                            'sets' => 3,
                            'reps' => '10-12',
                            'rest_seconds' => 45,
                        ],
                        [
                            'name' => 'Seated Side Bend',
                            'type' => 'mobility',
                            'sets' => 3,
                            'reps' => '10 tiap sisi',
                            'rest_seconds' => 30,
                        ],
                        [
                            'name' => 'Step Touch',
                            'type' => 'cardio',
                            'sets' => 3,
                            'reps' => '30 detik',
                            'rest_seconds' => 30,
                        ],
                    ];
                    break;

                    // ========================================
                    // 🏋️ PLAN KHUSUS TRAINER / ADMIN
                    // ========================================
                default:
                    $exercises = [
                        [
                            'name' => 'Barbell Deadlift',
                            'type' => 'strength',
                            'sets' => 4,
                            'reps' => '6-8',
                            'rest_seconds' => 120,
                        ],
                        [
                            'name' => 'Overhead Press',
                            'type' => 'strength',
                            'sets' => 3,
                            'reps' => '8-10',
                            'rest_seconds' => 90,
                        ],
                        [
                            'name' => 'Pull-Up / Lat Pulldown',
                            'type' => 'strength',
                            'sets' => 3,
                            'reps' => '8-10',
                            'rest_seconds' => 90,
                        ],
                        [
                            'name' => 'Plank Hold',
                            'type' => 'core',
                            'sets' => 3,
                            'reps' => '45-60 detik',
                            'rest_seconds' => 60,
                        ],
                        [
                            'name' => 'Burpees',
                            'type' => 'cardio',
                            'sets' => 3,
                            'reps' => '10',
                            'rest_seconds' => 45,
                        ],
                    ];
                    break;
            }

            foreach ($exercises as $ex) {
                DB::table('workout_exercises')->insert([
                    'workout_plan_id' => $plan->id,
                    'name' => $ex['name'],
                    'type' => $ex['type'],
                    'sets' => $ex['sets'],
                    'reps' => $ex['reps'],
                    'rest_seconds' => $ex['rest_seconds'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('✅ WorkoutExerciseSeeder sukses! Semua plan telah memiliki latihan sesuai kategori BMI & level.');
    }
}
