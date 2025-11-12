<?php

namespace Database\Seeders;

use App\Models\BodyMetric;
use App\Models\User;
use Illuminate\Database\Seeder;

class BodyMetricSeeder extends Seeder
{
    public function run(): void
    {
        BodyMetric::truncate();
        $user = User::where('role', 'user')->first();

        BodyMetric::create([
            'user_id' => $user->id,
            'weight' => 72.5,
            'height' => 175,
            'body_fat' => 18.5,
            'muscle_mass' => 35.2,
            'recorded_at' => now(),
        ]);
    }
}
