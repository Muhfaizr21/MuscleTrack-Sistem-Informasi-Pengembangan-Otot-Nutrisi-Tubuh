<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

            // Tentukan hari-hari latihan (distribusikan exercises ke beberapa hari)
            $days = ['day_1', 'day_2', 'day_3', 'day_4', 'day_5'];

            // Pilih exercises berdasarkan kategori
            if (str_contains($title, 'full body') || str_contains($title, 'foundation') || str_contains($target, 'foundation')) {
                // 🏋️‍♂️ FULL BODY FOUNDATION
                $exercises = [
                    [
                        'name' => 'Barbell Squat',
                        'description' => 'Compound exercise for legs and core strength',
                        'muscle_group' => 'Legs',
                        'equipment' => 'Barbell',
                        'difficulty' => 'beginner',
                        'sets' => 4,
                        'reps_min' => 8,
                        'reps_max' => 12,
                        'rest_seconds' => 90,
                        'weight_suggestion' => 20.0,
                        'video_url' => 'https://www.youtube.com/embed/aclHkVaku9U',
                        'image_url' => 'https://images.unsplash.com/photo-1534367507877-0edd93bd013b',
                        'instructions' => "1. Stand with feet shoulder-width apart\n2. Keep chest up and back straight\n3. Lower down as if sitting in a chair\n4. Return to starting position",
                        'tips' => 'Keep knees aligned with toes, don\'t let knees cave inward',
                        'common_mistakes' => 'Rounding the back, knees going past toes',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Bench Press',
                        'description' => 'Main chest exercise with barbell',
                        'muscle_group' => 'Chest',
                        'equipment' => 'Barbell',
                        'difficulty' => 'intermediate',
                        'sets' => 4,
                        'reps_min' => 8,
                        'reps_max' => 10,
                        'rest_seconds' => 90,
                        'weight_suggestion' => 30.0,
                        'video_url' => 'https://www.youtube.com/embed/rT7DgCr-3pg',
                        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
                        'instructions' => "1. Lie on bench with barbell above chest\n2. Lower barbell to mid-chest\n3. Press back to starting position",
                        'tips' => 'Keep elbows at 45-degree angle, arch back slightly',
                        'common_mistakes' => 'Bouncing bar off chest, flaring elbows too wide',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Pull-Up',
                        'description' => 'Best back exercise using bodyweight',
                        'muscle_group' => 'Back',
                        'equipment' => 'Pull-up Bar',
                        'difficulty' => 'intermediate',
                        'sets' => 3,
                        'reps_min' => 6,
                        'reps_max' => 10,
                        'rest_seconds' => 60,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/eGo4IYlbE5g',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Grip bar with palms facing away\n2. Hang with arms fully extended\n3. Pull body up until chin over bar\n4. Lower with control",
                        'tips' => 'Engage back muscles, don\'t just use arms',
                        'common_mistakes' => 'Using momentum, not going through full range',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Overhead Press',
                        'description' => 'Shoulder press with barbell',
                        'muscle_group' => 'Shoulders',
                        'equipment' => 'Barbell',
                        'difficulty' => 'intermediate',
                        'sets' => 3,
                        'reps_min' => 8,
                        'reps_max' => 12,
                        'rest_seconds' => 60,
                        'weight_suggestion' => 15.0,
                        'video_url' => 'https://www.youtube.com/embed/QAy8JYxxd7I',
                        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
                        'instructions' => "1. Stand with barbell at shoulder height\n2. Press barbell overhead until arms straight\n3. Lower back to shoulders",
                        'tips' => 'Keep core tight, don\'t arch back excessively',
                        'common_mistakes' => 'Leaning back too far, using legs for momentum',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Plank',
                        'description' => 'Isometric exercise for core strength',
                        'muscle_group' => 'Core',
                        'equipment' => 'Mat',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 30,
                        'reps_max' => 60,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/ASdvN_XEl_c',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Start in push-up position on elbows\n2. Keep body straight from head to heels\n3. Hold position",
                        'tips' => 'Engage core and glutes, don\'t let hips sag',
                        'common_mistakes' => 'Hips too high or low, holding breath',
                        'day' => 'day_1',
                    ],
                ];
            } elseif (str_contains($title, 'fat') || str_contains($title, 'loss') || str_contains($target, 'fat_loss')) {
                // 🔥 FAT LOSS / HIIT
                $exercises = [
                    [
                        'name' => 'Burpees',
                        'description' => 'Full-body high-intensity exercise',
                        'muscle_group' => 'Full Body',
                        'equipment' => 'Mat',
                        'difficulty' => 'intermediate',
                        'sets' => 4,
                        'reps_min' => 10,
                        'reps_max' => 15,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/dZgVxmf6jkA',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Start standing\n2. Drop into squat position\n3. Kick feet back to plank\n4. Do a push-up\n5. Return to squat and jump up",
                        'tips' => 'Maintain pace, focus on form over speed initially',
                        'common_mistakes' => 'Skipping the push-up, poor landing form',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Mountain Climbers',
                        'description' => 'Dynamic cardio and core exercise',
                        'muscle_group' => 'Core',
                        'equipment' => 'Mat',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 20,
                        'reps_max' => 30,
                        'rest_seconds' => 30,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/nmwgirgXLYM',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Start in plank position\n2. Alternate pulling knees to chest quickly\n3. Keep hips low",
                        'tips' => 'Increase speed for higher intensity',
                        'common_mistakes' => 'Hips too high, not keeping core engaged',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Jumping Jacks',
                        'description' => 'Classic cardio exercise',
                        'muscle_group' => 'Legs',
                        'equipment' => 'None',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 30,
                        'reps_max' => 50,
                        'rest_seconds' => 30,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/c4DAnQ6DtF8',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Stand with feet together, arms at sides\n2. Jump feet out while raising arms overhead\n3. Return to starting position",
                        'tips' => 'Start slow, increase speed gradually',
                        'common_mistakes' => 'Landing with stiff knees, poor coordination',
                        'day' => 'day_2',
                    ],
                    [
                        'name' => 'High Knees',
                        'description' => 'High-intensity cardio exercise',
                        'muscle_group' => 'Legs',
                        'equipment' => 'None',
                        'difficulty' => 'intermediate',
                        'sets' => 3,
                        'reps_min' => 30,
                        'reps_max' => 40,
                        'rest_seconds' => 30,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/oDdkytliOqE',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Run in place while lifting knees high\n2. Pump arms actively\n3. Maintain good posture",
                        'tips' => 'Focus on lifting knees to hip height',
                        'common_mistakes' => 'Leaning too far back, not using arms',
                        'day' => 'day_2',
                    ],
                    [
                        'name' => 'Bodyweight Squat',
                        'description' => 'Fundamental leg exercise',
                        'muscle_group' => 'Legs',
                        'equipment' => 'None',
                        'difficulty' => 'beginner',
                        'sets' => 4,
                        'reps_min' => 15,
                        'reps_max' => 20,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/YaXPRqUwItQ',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Stand with feet shoulder-width apart\n2. Lower as if sitting in a chair\n3. Return to standing position",
                        'tips' => 'Weight on heels, chest up',
                        'common_mistakes' => 'Knees caving in, leaning too far forward',
                        'day' => 'day_2',
                    ],
                ];
            } elseif (str_contains($title, 'lean') || str_contains($title, 'mass') || str_contains($target, 'muscle_gain')) {
                // 💪 LEAN MASS / MUSCLE BUILDING
                $exercises = [
                    [
                        'name' => 'Deadlift',
                        'description' => 'Full-body strength exercise',
                        'muscle_group' => 'Back',
                        'equipment' => 'Barbell',
                        'difficulty' => 'advanced',
                        'sets' => 3,
                        'reps_min' => 6,
                        'reps_max' => 8,
                        'rest_seconds' => 120,
                        'weight_suggestion' => 40.0,
                        'video_url' => 'https://www.youtube.com/embed/op9kVnSso6Q',
                        'image_url' => 'https://images.unsplash.com/photo-1534367507877-0edd93bd013b',
                        'instructions' => "1. Stand with feet hip-width, barbell over mid-foot\n2. Bend at hips and knees, grip barbell\n3. Lift bar by extending hips and knees\n4. Lower with control",
                        'tips' => 'Keep back flat, chest up throughout movement',
                        'common_mistakes' => 'Rounding the back, lifting with arms not legs',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Barbell Row',
                        'description' => 'Back thickness exercise',
                        'muscle_group' => 'Back',
                        'equipment' => 'Barbell',
                        'difficulty' => 'intermediate',
                        'sets' => 4,
                        'reps_min' => 8,
                        'reps_max' => 12,
                        'rest_seconds' => 90,
                        'weight_suggestion' => 25.0,
                        'video_url' => 'https://www.youtube.com/embed/9efgcAjQe7E',
                        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
                        'instructions' => "1. Bend at hips, torso near parallel to floor\n2. Pull barbell to lower chest\n3. Squeeze shoulder blades together\n4. Lower with control",
                        'tips' => 'Keep back straight, don\'t use momentum',
                        'common_mistakes' => 'Rounding back, using too much weight',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Incline Dumbbell Press',
                        'description' => 'Upper chest development',
                        'muscle_group' => 'Chest',
                        'equipment' => 'Dumbbells',
                        'difficulty' => 'intermediate',
                        'sets' => 4,
                        'reps_min' => 8,
                        'reps_max' => 12,
                        'rest_seconds' => 90,
                        'weight_suggestion' => 15.0,
                        'video_url' => 'https://www.youtube.com/embed/SrqOu55lrYU',
                        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
                        'instructions' => "1. Lie on incline bench with dumbbells\n2. Press dumbbells upward\n3. Lower with control",
                        'tips' => 'Control the weight, focus on chest contraction',
                        'common_mistakes' => 'Bouncing weights, not using full range',
                        'day' => 'day_2',
                    ],
                    [
                        'name' => 'Leg Press',
                        'description' => 'Machine exercise for legs',
                        'muscle_group' => 'Legs',
                        'equipment' => 'Machine',
                        'difficulty' => 'beginner',
                        'sets' => 4,
                        'reps_min' => 10,
                        'reps_max' => 15,
                        'rest_seconds' => 90,
                        'weight_suggestion' => 50.0,
                        'video_url' => 'https://www.youtube.com/embed/IZxyjW7MPJQ',
                        'image_url' => 'https://images.unsplash.com/photo-1534367507877-0edd93bd013b',
                        'instructions' => "1. Sit on machine with feet on platform\n2. Lower weight until knees at 90 degrees\n3. Push back to starting position",
                        'tips' => 'Don\'t lock knees, control the descent',
                        'common_mistakes' => 'Going too deep, lifting hips off seat',
                        'day' => 'day_2',
                    ],
                    [
                        'name' => 'Bicep Curl',
                        'description' => 'Arm isolation exercise',
                        'muscle_group' => 'Arms',
                        'equipment' => 'Dumbbells',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 10,
                        'reps_max' => 15,
                        'rest_seconds' => 60,
                        'weight_suggestion' => 10.0,
                        'video_url' => 'https://www.youtube.com/embed/sAq_ocpRh_I',
                        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
                        'instructions' => "1. Stand holding dumbbells at sides\n2. Curl dumbbells to shoulders\n3. Lower with control",
                        'tips' => 'Keep elbows close to body, don\'t swing',
                        'common_mistakes' => 'Using momentum, not fully extending',
                        'day' => 'day_2',
                    ],
                ];
            } else {
                // DEFAULT EXERCISES (GENERAL FITNESS)
                $exercises = [
                    [
                        'name' => 'Push-Up',
                        'description' => 'Classic bodyweight exercise for upper body',
                        'muscle_group' => 'Chest',
                        'equipment' => 'Mat',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 10,
                        'reps_max' => 15,
                        'rest_seconds' => 60,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/IODxDxX7oi4',
                        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b',
                        'instructions' => "1. Start in plank position\n2. Lower body until chest nearly touches floor\n3. Push back up to starting position",
                        'tips' => 'Keep body in straight line, engage core',
                        'common_mistakes' => 'Sagging hips, not going deep enough',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Bodyweight Squat',
                        'description' => 'Fundamental leg exercise without weights',
                        'muscle_group' => 'Legs',
                        'equipment' => 'None',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 15,
                        'reps_max' => 20,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/YaXPRqUwItQ',
                        'image_url' => 'https://images.unsplash.com/photo-1534367507877-0edd93bd013b',
                        'instructions' => "1. Stand with feet shoulder-width apart\n2. Lower body as if sitting on chair\n3. Keep chest up and back straight\n4. Return to starting position",
                        'tips' => 'Weight on heels, knees over toes',
                        'common_mistakes' => 'Leaning too far forward, knees caving in',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Plank',
                        'description' => 'Core strengthening exercise',
                        'muscle_group' => 'Core',
                        'equipment' => 'Mat',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 30,
                        'reps_max' => 60,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/ASdvN_XEl_c',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Hold push-up position with elbows on ground\n2. Keep body straight from head to heels\n3. Engage core muscles",
                        'tips' => 'Breathe normally, don\'t hold breath',
                        'common_mistakes' => 'Hips sagging or too high',
                        'day' => 'day_1',
                    ],
                    [
                        'name' => 'Lunges',
                        'description' => 'Unilateral leg exercise for balance',
                        'muscle_group' => 'Legs',
                        'equipment' => 'None',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 10,
                        'reps_max' => 12,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/QOVaHwm-Q6U',
                        'image_url' => 'https://images.unsplash.com/photo-1534367507877-0edd93bd013b',
                        'instructions' => "1. Step forward with one leg\n2. Lower back knee almost to ground\n3. Push back to starting position\n4. Repeat on other leg",
                        'tips' => 'Keep torso upright, don\'t lean forward',
                        'common_mistakes' => 'Front knee going past toes, leaning forward',
                        'day' => 'day_2',
                    ],
                    [
                        'name' => 'Glute Bridge',
                        'description' => 'Hip thrust exercise for glutes',
                        'muscle_group' => 'Glutes',
                        'equipment' => 'Mat',
                        'difficulty' => 'beginner',
                        'sets' => 3,
                        'reps_min' => 12,
                        'reps_max' => 15,
                        'rest_seconds' => 45,
                        'weight_suggestion' => null,
                        'video_url' => 'https://www.youtube.com/embed/OUBS3oYcZgU',
                        'image_url' => 'https://images.unsplash.com/photo-1598974357801-cbca100e5d10',
                        'instructions' => "1. Lie on back with knees bent\n2. Lift hips toward ceiling\n3. Squeeze glutes at top\n4. Lower back down",
                        'tips' => 'Focus on using glutes, not lower back',
                        'common_mistakes' => 'Arching back too much, not squeezing glutes',
                        'day' => 'day_2',
                    ],
                ];
            }

            // Insert exercises for this plan
            foreach ($exercises as $ex) {
                // Parse reps untuk menentukan reps_min dan reps_max
                $repsMin = $ex['reps_min'] ?? null;
                $repsMax = $ex['reps_max'] ?? null;
                
                // Jika ada string reps, parse menjadi min dan max
                if (isset($ex['reps']) && is_string($ex['reps'])) {
                    if (strpos($ex['reps'], '-') !== false) {
                        $repsParts = explode('-', $ex['reps']);
                        $repsMin = intval(trim($repsParts[0]));
                        $repsMax = intval(trim($repsParts[1] ?? $repsParts[0]));
                    } elseif (str_contains(strtolower($ex['reps']), 'seconds') || str_contains(strtolower($ex['reps']), 'sec')) {
                        // Jika berupa durasi waktu
                        $repsMin = intval(filter_var($ex['reps'], FILTER_SANITIZE_NUMBER_INT));
                        $repsMax = $repsMin;
                    } else {
                        $repsMin = intval($ex['reps']);
                        $repsMax = $repsMin;
                    }
                }

                DB::table('workout_exercises')->insert([
                    'workout_plan_id' => $plan->id,
                    'name' => $ex['name'],
                    'description' => $ex['description'] ?? null,
                    'muscle_group' => $ex['muscle_group'] ?? null,
                    'equipment' => $ex['equipment'] ?? null,
                    'difficulty' => $ex['difficulty'] ?? 'beginner',
                    'sets' => $ex['sets'] ?? 3,
                    'reps_min' => $repsMin,
                    'reps_max' => $repsMax,
                    'rest_seconds' => $ex['rest_seconds'] ?? 60,
                    'weight_suggestion' => $ex['weight_suggestion'] ?? null,
                    'video_url' => $ex['video_url'] ?? null,
                    'image_url' => $ex['image_url'] ?? null,
                    'instructions' => $ex['instructions'] ?? null,
                    'tips' => $ex['tips'] ?? null,
                    'common_mistakes' => $ex['common_mistakes'] ?? null,
                    'order' => $order,
                    'day' => $ex['day'] ?? 'day_1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $order++;
            }
        }

        $totalExercises = DB::table('workout_exercises')->count();
        $totalPlans = DB::table('workout_plans')->count();

        $this->command->info("✅ WorkoutExerciseSeeder berhasil dijalankan!");
        $this->command->info("📊 Total exercises created: {$totalExercises} exercises");
        $this->command->info("📋 Across {$totalPlans} workout plans");
        $this->command->info("🎯 Exercises tailored to each plan's category");
        $this->command->info("🏷️  Structure: muscle_group, equipment, reps_min/reps_max, weight_suggestion");
        $this->command->info("📹 Includes: video_url, image_url, instructions, tips, common_mistakes");
    }
}