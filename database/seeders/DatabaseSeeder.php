<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder UserSeeder
        $this->call([
            UserSeeder::class,
            WorkoutSeeder::class,
            NutritionSeeder::class,
            BodyMetricSeeder::class,
            ArticleSeeder::class,
            ChatSeeder::class,
        ]);

        // Contoh membuat user tambahan via factory
        // \App\Models\User::factory(10)->create();

        // Contoh membuat user spesifik via factory
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'role' => 'user',
        // ]);
    }
}
