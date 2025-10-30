<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'Admin Master',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'age' => 30,
            'gender' => 'male',
            'height' => 175,
            'weight' => 70,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer
        DB::table('users')->insert([
            'name' => 'Trainer One',
            'email' => 'trainer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 28,
            'gender' => 'female',
            'height' => 165,
            'weight' => 60,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User
        DB::table('users')->insert([
            'name' => 'User Regular',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 25,
            'gender' => 'male',
            'height' => 170,
            'weight' => 68,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
