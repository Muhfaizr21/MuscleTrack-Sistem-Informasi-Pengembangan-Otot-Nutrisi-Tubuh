<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 🚫 Nonaktifkan foreign key check dulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel yang bergantung
        DB::table('trainer_verifications')->truncate();
        DB::table('workout_plans')->truncate();
        DB::table('nutrition_plans')->truncate();
        DB::table('supplements')->truncate();
        DB::table('users')->truncate();

        // ✅ Aktifkan kembali constraint
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =============================
        // 👑 ADMIN
        // =============================
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin Master',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'age' => 30,
            'gender' => 'male',
            'height' => 175,
            'weight' => 70,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 🧑‍🏫 TRAINER — PENDING
        // =============================
        $trainerPendingId = DB::table('users')->insertGetId([
            'name' => 'Trainer Pending',
            'email' => 'trainer.pending@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 29,
            'gender' => 'female',
            'height' => 160,
            'weight' => 58,
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('trainer_verifications')->insert([
            'trainer_id' => $trainerPendingId,
            'certificate' => 'certificates/trainer_pending.pdf',
            'bio' => 'Masih dalam proses verifikasi oleh admin.',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 🧑‍🏫 TRAINER — APPROVED
        // =============================
        $trainerApprovedId = DB::table('users')->insertGetId([
            'name' => 'Coach Andika',
            'email' => 'coach.andika@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 32,
            'gender' => 'male',
            'height' => 178,
            'weight' => 75,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('trainer_verifications')->insert([
            'trainer_id' => $trainerApprovedId,
            'certificate' => 'certificates/coach_andika.pdf',
            'bio' => 'Certified Personal Trainer dengan pengalaman 5 tahun dalam pembentukan otot dan nutrisi fitness.',
            'status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 🧍 USER — PUNYA TRAINER APPROVED
        // =============================
        DB::table('users')->insert([
            'name' => 'Rian Fit',
            'email' => 'rian.fit@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 25,
            'gender' => 'male',
            'height' => 172,
            'weight' => 68,
            'trainer_id' => $trainerApprovedId,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 🧍 USER — PUNYA TRAINER PENDING
        DB::table('users')->insert([
            'name' => 'Lina Strong',
            'email' => 'lina.strong@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 24,
            'gender' => 'female',
            'height' => 165,
            'weight' => 56,
            'trainer_id' => $trainerPendingId,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 🧍 USER — TANPA TRAINER
        DB::table('users')->insert([
            'name' => 'Solo User',
            'email' => 'solo.user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 27,
            'gender' => 'male',
            'height' => 174,
            'weight' => 70,
            'trainer_id' => null,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('💪 UserSeeder sukses! Semua role, verifikasi, dan relasi trainer-user sudah bersih & konsisten.');
    }
}
