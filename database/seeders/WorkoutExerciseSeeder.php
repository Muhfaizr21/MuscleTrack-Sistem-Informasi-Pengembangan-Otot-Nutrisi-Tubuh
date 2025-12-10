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

        // Ambil semua workout plans
        $plans = DB::table('workout_plans')->get();

        // Jika belum ada workout plans, buat dulu 1 plan default
        if ($plans->isEmpty()) {
            $defaultPlanId = DB::table('workout_plans')->insertGetId([
                'title' => 'Default Workout Plan',
                'level' => 'beginner',
                'description' => 'Default plan for exercise seeder',
                'target_fitness' => 'general_fitness',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $plans = collect([(object)['id' => $defaultPlanId]]);
        }

        foreach ($plans as $plan) {
            $exercises = [];
            $order = 1;

            // Tentukan kategori berdasarkan judul atau target fitness plan
            $title = strtolower($plan->title ?? '');
            $target = strtolower($plan->target_fitness ?? '');

            // Pilih exercises berdasarkan kategori
            if (str_contains($title, 'bulking') || str_contains($title, 'muscle') || str_contains($target, 'muscle_gain') || str_contains($target, 'strength')) {
                // 💪 MUSCLE GAIN / STRENGTH
                $exercises = [
                    [
                        'name' => 'Barbell Squat',
                        'type' => 'strength',
                        'description' => 'Compound exercise for legs and core strength',
                        'sets' => 4,
                        'reps' => '8-10',
                        'duration_minutes' => null,
                        'rest_seconds' => 90,
                        'video_url' => 'https://www.youtube.com/watch?v=aclHkVaku9U',
                        'instructions' => 'Keep back straight, lower until thighs parallel to floor',
                        'muscle_group' => 'Legs, Glutes, Core',
                        'equipment' => 'Barbell',
                        'notes' => 'Focus on proper form, control the weight',
                    ],
                    [
                        'name' => 'Bench Press',
                        'type' => 'strength',
                        'description' => 'Main chest exercise with barbell',
                        'sets' => 4,
                        'reps' => '8-10',
                        'duration_minutes' => null,
                        'rest_seconds' => 90,
                        'video_url' => 'https://www.youtube.com/watch?v=rT7DgCr-3pg',
                        'instructions' => 'Lower barbell to mid-chest, push back strongly',
                        'muscle_group' => 'Chest, Shoulders, Triceps',
                        'equipment' => 'Barbell, Bench',
                        'notes' => 'Use spotter for safety',
                    ],
                    [
                        'name' => 'Deadlift',
                        'type' => 'strength',
                        'description' => 'Full-body exercise for posterior chain',
                        'sets' => 3,
                        'reps' => '6-8',
                        'duration_minutes' => null,
                        'rest_seconds' => 120,
                        'video_url' => 'https://www.youtube.com/watch?v=op9kVnSso6Q',
                        'instructions' => 'Grip barbell with overhand, lift using leg drive',
                        'muscle_group' => 'Back, Legs, Glutes',
                        'equipment' => 'Barbell',
                        'notes' => 'Keep back neutral, don\'t round',
                    ],
                    [
                        'name' => 'Pull-Up',
                        'type' => 'bodyweight',
                        'description' => 'Best back exercise using bodyweight',
                        'sets' => 3,
                        'reps' => '8-12',
                        'duration_minutes' => null,
                        'rest_seconds' => 60,
                        'video_url' => 'https://www.youtube.com/watch?v=eGo4IYlbE5g',
                        'instructions' => 'Hang with shoulder-width grip, pull until chin over bar',
                        'muscle_group' => 'Back, Biceps',
                        'equipment' => 'Pull-up Bar',
                        'notes' => 'Use resistance band if can\'t do full pull-ups',
                    ],
                    [
                        'name' => 'Plank',
                        'type' => 'core',
                        'description' => 'Isometric exercise for core strength',
                        'sets' => 3,
                        'reps' => '30-60 seconds',
                        'duration_minutes' => 1,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=ASdvN_XEl_c',
                        'instructions' => 'Hold push-up position with elbows on ground',
                        'muscle_group' => 'Core, Abs',
                        'equipment' => 'Mat',
                        'notes' => 'Keep hips level, don\'t sag',
                    ],
                ];
            } elseif (str_contains($title, 'fat') || str_contains($title, 'loss') || str_contains($target, 'fat_loss')) {
                // 🔥 FAT LOSS / CARDIO
                $exercises = [
                    [
                        'name' => 'Jumping Jacks',
                        'type' => 'cardio',
                        'description' => 'Low-impact cardio for warm-up',
                        'sets' => 3,
                        'reps' => '30 seconds',
                        'duration_minutes' => 0.5,
                        'rest_seconds' => 30,
                        'video_url' => 'https://www.youtube.com/watch?v=c4DAnQ6DtF8',
                        'instructions' => 'Jump with feet wide while raising arms',
                        'muscle_group' => 'Full Body, Cardio',
                        'equipment' => 'None',
                        'notes' => 'Start slow, increase speed gradually',
                    ],
                    [
                        'name' => 'Bodyweight Squat',
                        'type' => 'bodyweight',
                        'description' => 'Fundamental leg exercise without weights',
                        'sets' => 3,
                        'reps' => '15-20',
                        'duration_minutes' => null,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=YaXPRqUwItQ',
                        'instructions' => 'Lower body as if sitting on chair, keep chest up',
                        'muscle_group' => 'Legs, Glutes',
                        'equipment' => 'None',
                        'notes' => 'Weight on heels, not toes',
                    ],
                    [
                        'name' => 'Push-Up (Knee)',
                        'type' => 'bodyweight',
                        'description' => 'Modified push-up for beginners',
                        'sets' => 3,
                        'reps' => '12-15',
                        'duration_minutes' => null,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=ZzS2SdWLjis',
                        'instructions' => 'Do push-up with knees on ground for less weight',
                        'muscle_group' => 'Chest, Shoulders, Triceps',
                        'equipment' => 'Mat',
                        'notes' => 'Keep body straight from knees to shoulders',
                    ],
                    [
                        'name' => 'Mountain Climbers',
                        'type' => 'cardio',
                        'description' => 'Dynamic cardio and core exercise',
                        'sets' => 3,
                        'reps' => '30 seconds',
                        'duration_minutes' => 0.5,
                        'rest_seconds' => 30,
                        'video_url' => 'https://www.youtube.com/watch?v=nmwgirgXLYM',
                        'instructions' => 'From plank, alternate pulling knees to chest',
                        'muscle_group' => 'Core, Cardio',
                        'equipment' => 'Mat',
                        'notes' => 'Increase speed for higher intensity',
                    ],
                    [
                        'name' => 'High Knees',
                        'type' => 'cardio',
                        'description' => 'High-intensity cardio exercise',
                        'sets' => 3,
                        'reps' => '30 seconds',
                        'duration_minutes' => 0.5,
                        'rest_seconds' => 30,
                        'video_url' => 'https://www.youtube.com/watch?v=oDdkytliOqE',
                        'instructions' => 'Run in place while lifting knees high',
                        'muscle_group' => 'Legs, Cardio',
                        'equipment' => 'None',
                        'notes' => 'Maintain good posture, pump arms',
                    ],
                ];
            } elseif (str_contains($title, 'home') || str_contains($title, 'no equipment') || str_contains($target, 'general_fitness')) {
                // 🏠 HOME / NO EQUIPMENT
                $exercises = [
                    [
                        'name' => 'Push-Up',
                        'type' => 'bodyweight',
                        'description' => 'Classic exercise for chest, shoulders, and triceps',
                        'sets' => 3,
                        'reps' => '10-15',
                        'duration_minutes' => null,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=IODxDxX7oi4',
                        'instructions' => 'Hands shoulder-width, lower chest almost to floor',
                        'muscle_group' => 'Chest, Shoulders, Triceps',
                        'equipment' => 'Mat',
                        'notes' => 'Variation: knee push-up for beginners',
                    ],
                    [
                        'name' => 'Bodyweight Squat',
                        'type' => 'bodyweight',
                        'description' => 'Fundamental leg exercise',
                        'sets' => 3,
                        'reps' => '15-20',
                        'duration_minutes' => null,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=YaXPRqUwItQ',
                        'instructions' => 'Lower as if sitting, keep chest open',
                        'muscle_group' => 'Legs, Glutes',
                        'equipment' => 'None',
                        'notes' => 'Don\'t let knees cave in',
                    ],
                    [
                        'name' => 'Plank',
                        'type' => 'core',
                        'description' => 'Core strengthening exercise',
                        'sets' => 3,
                        'reps' => '30-45 seconds',
                        'duration_minutes' => 1,
                        'rest_seconds' => 30,
                        'video_url' => 'https://www.youtube.com/watch?v=ASdvN_XEl_c',
                        'instructions' => 'Hold push-up position with elbows on ground',
                        'muscle_group' => 'Core, Abs',
                        'equipment' => 'Mat',
                        'notes' => 'Engage core, don\'t sag',
                    ],
                    [
                        'name' => 'Lunges',
                        'type' => 'bodyweight',
                        'description' => 'Unilateral leg exercise for balance',
                        'sets' => 3,
                        'reps' => '10 each leg',
                        'duration_minutes' => null,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=QOVaHwm-Q6U',
                        'instructions' => 'Step forward, lower back knee almost to ground',
                        'muscle_group' => 'Legs, Glutes',
                        'equipment' => 'None',
                        'notes' => 'Keep torso upright, don\'t lean forward',
                    ],
                    [
                        'name' => 'Burpees',
                        'type' => 'cardio',
                        'description' => 'Full-body high-intensity exercise',
                        'sets' => 3,
                        'reps' => '8-10',
                        'duration_minutes' => null,
                        'rest_seconds' => 45,
                        'video_url' => 'https://www.youtube.com/watch?v=auBLPXO8Fww',
                        'instructions' => 'Push-up, jump feet forward, stand, jump',
                        'muscle_group' => 'Full Body, Cardio',
                        'equipment' => 'Mat',
                        'notes' => 'Modify: skip push-up or jump if needed',
                    ],
                ];
            } else {
                // DEFAULT EXERCISES
                $exercises = [
                    [
                        'name' => 'Warm-Up: Light Jogging',
                        'type' => 'cardio',
                        'description' => '5-minute light cardio to warm up muscles',
                        'sets' => 1,
                        'reps' => '5 minutes',
                        'duration_minutes' => 5,
                        'rest_seconds' => 0,
                        'video_url' => 'https://www.youtube.com/watch?v=ZzS2SdWLjis',
                        'instructions' => 'Jog in place or around the room',
                        'muscle_group' => 'Full Body, Cardio',
                        'equipment' => 'None',
                        'notes' => 'Start slow, gradually increase pace',
                    ],
                    [
                        'name' => 'Dynamic Stretching',
                        'type' => 'flexibility',
                        'description' => 'Prepare muscles with dynamic movements',
                        'sets' => 1,
                        'reps' => '10 each side',
                        'duration_minutes' => 3,
                        'rest_seconds' => 0,
                        'video_url' => 'https://www.youtube.com/watch?v=ZzS2SdWLjis',
                        'instructions' => 'Arm circles, leg swings, torso twists',
                        'muscle_group' => 'Full Body',
                        'equipment' => 'None',
                        'notes' => 'Don\'t force, gentle movements only',
                    ],
                    [
                        'name' => 'Cool Down: Static Stretching',
                        'type' => 'flexibility',
                        'description' => 'Stretch major muscle groups after workout',
                        'sets' => 1,
                        'reps' => '30 seconds each',
                        'duration_minutes' => 5,
                        'rest_seconds' => 0,
                        'video_url' => 'https://www.youtube.com/watch?v=ZzS2SdWLjis',
                        'instructions' => 'Hold stretches for each muscle group',
                        'muscle_group' => 'Full Body',
                        'equipment' => 'Mat',
                        'notes' => 'Hold, don\'t bounce, breathe deeply',
                    ],
                ];
            }

            // Insert exercises for this plan
            foreach ($exercises as $ex) {
                DB::table('workout_exercises')->insert([
                    'workout_plan_id' => $plan->id,
                    'name' => $ex['name'],
                    'type' => $ex['type'],
                    'description' => $ex['description'],
                    'sets' => $ex['sets'],
                    'reps' => $ex['reps'],
                    'duration_minutes' => $ex['duration_minutes'],
                    'rest_seconds' => $ex['rest_seconds'],
                    'video_url' => $ex['video_url'],
                    'instructions' => $ex['instructions'],
                    'muscle_group' => $ex['muscle_group'],
                    'equipment' => $ex['equipment'],
                    'notes' => $ex['notes'],
                    'order' => $order,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $order++;
            }
        }

        $totalExercises = DB::table('workout_exercises')->count();
        $totalPlans = DB::table('workout_plans')->count();

        $this->command->info("✅ WorkoutExerciseSeeder berhasil dijalankan!");
        $this->command->info("📊 Total exercises created: {$totalExercises} exercises");
        $this->command->info("📋 Across {$totalPlans} workout plans");
        $this->command->info("🎯 Exercises tailored to each plan's target fitness");
    }
}
