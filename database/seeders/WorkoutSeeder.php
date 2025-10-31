<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Models\WorkoutSchedule;
use Carbon\Carbon;

class WorkoutSeeder extends Seeder
{
    public function run(): void
    {
        WorkoutPlan::query()->delete();
        WorkoutSchedule::truncate();

        $trainer = User::where('role', 'trainer')->first();
        $user = User::where('role', 'user')->first();

        $plan = WorkoutPlan::create([
            'user_id' => $trainer->id,
            'title' => 'Full Body Strength Beginner',
            'level' => 'Beginner',
            'description' => 'Latihan seluruh tubuh untuk pemula dengan teknik dasar.',
            'duration_weeks' => 4,
        ]);

        foreach (['Senin', 'Rabu', 'Jumat'] as $i => $day) {
            WorkoutSchedule::create([
                'user_id' => $user->id,
                'workout_plan_id' => $plan->id,
                'scheduled_date' => Carbon::now()->startOfWeek()->addDays($i),
                'scheduled_time' => '07:00:00',
                'status' => 'pending',
            ]);
        }
    }
}
