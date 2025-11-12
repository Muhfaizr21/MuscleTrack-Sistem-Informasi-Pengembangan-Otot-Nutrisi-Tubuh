<?php

namespace Database\Seeders;

use App\Models\NutritionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{
    public function run(): void
    {
        NutritionPlan::query()->delete();
        $user = User::where('role', 'user')->first();

        NutritionPlan::insert([
            [
                'user_id' => $user->id,
                'meal_name' => 'Oatmeal + Telur Rebus',
                'calories' => 350,
                'protein' => 20,
                'carbs' => 45,
                'fat' => 10,
                'day_of_week' => 'Senin',
                'type' => 'breakfast',
                'created_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'meal_name' => 'Ayam Panggang + Nasi Merah',
                'calories' => 550,
                'protein' => 35,
                'carbs' => 60,
                'fat' => 15,
                'day_of_week' => 'Selasa',
                'type' => 'lunch',
                'created_at' => now(),
            ],
        ]);
    }
}
