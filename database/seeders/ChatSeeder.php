<?php

namespace Database\Seeders;

use App\Models\TrainerChat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama dengan aman (tanpa error foreign key)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        TrainerChat::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil satu user dan trainer, kalau belum ada buat dummy
        $user = User::where('role', 'user')->first();
        $trainer = User::where('role', 'trainer')->first();

        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Budi',
                'email' => 'budi@example.com',
                'role' => 'user',
                'password' => bcrypt('password'),
            ]);
        }

        if (! $trainer) {
            $trainer = User::factory()->create([
                'name' => 'Coach Arif',
                'email' => 'coach@example.com',
                'role' => 'trainer',
                'password' => bcrypt('password'),
            ]);
        }

        // Masukkan pesan chat simulasi
        TrainerChat::insert([
            [
                'user_id' => $user->id,
                'trainer_id' => $trainer->id,
                'message' => 'Hai Budi! Bagaimana latihan minggu ini?',
                'read_status' => 0,
                'timestamp' => now(),
            ],
            [
                'user_id' => $user->id,
                // 👇 kalau tabel belum nullable, tetap isi trainer_id biar gak error
                'trainer_id' => $trainer->id,
                'message' => 'Baik Coach! Saya latihan 3x minggu ini.',
                'read_status' => 1,
                'timestamp' => now(),
            ],
        ]);
    }
}
