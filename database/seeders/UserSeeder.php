<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 🚫 Nonaktifkan foreign key check dulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel yang bergantung
        DB::table('feedbacks')->truncate();
        DB::table('premium_access_logs')->truncate();
        DB::table('trainer_memberships')->truncate();
        DB::table('program_requests')->truncate();
        DB::table('payments')->truncate();
        DB::table('trainer_chats')->truncate();
        DB::table('trainer_verifications')->truncate();
        DB::table('trainer_profiles')->truncate();
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
            'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 🧑‍🏫 TRAINER - 5 TERVERIFIKASI
        // =============================
        $trainerApprovedIds = [];

        // Avatar URLs untuk trainer male
        $maleTrainerAvatars = [
            'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1614289371518-722f2615943d?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1590086782957-93c06ef21604?w=150&h=150&fit=crop&crop=face',
        ];

        // Avatar URLs untuk trainer female
        $femaleTrainerAvatars = [
            'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1554151228-14d9def656e4?w=150&h=150&fit=crop&crop=face',
        ];

        // Trainer 1 - Specialization: Weight Loss
        $trainerApprovedIds[] = DB::table('users')->insertGetId([
            'name' => 'Coach Andika Pratama',
            'email' => 'coach.andika@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 32,
            'gender' => 'male',
            'height' => 178,
            'weight' => 75,
            'avatar' => $maleTrainerAvatars[0],
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 2 - Specialization: Muscle Building
        $trainerApprovedIds[] = DB::table('users')->insertGetId([
            'name' => 'Sarah Fitriani',
            'email' => 'sarah.fitriani@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 28,
            'gender' => 'female',
            'height' => 165,
            'weight' => 58,
            'avatar' => $femaleTrainerAvatars[0],
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 3 - Specialization: Bodybuilding
        $trainerApprovedIds[] = DB::table('users')->insertGetId([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 35,
            'gender' => 'male',
            'height' => 180,
            'weight' => 85,
            'avatar' => $maleTrainerAvatars[1],
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 4 - Specialization: Calisthenics
        $trainerApprovedIds[] = DB::table('users')->insertGetId([
            'name' => 'Maya Sari',
            'email' => 'maya.sari@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 26,
            'gender' => 'female',
            'height' => 162,
            'weight' => 55,
            'avatar' => $femaleTrainerAvatars[1],
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 5 - Specialization: Functional Training
        $trainerApprovedIds[] = DB::table('users')->insertGetId([
            'name' => 'Rizki Ramadhan',
            'email' => 'rizki.ramadhan@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 31,
            'gender' => 'male',
            'height' => 175,
            'weight' => 72,
            'avatar' => $maleTrainerAvatars[2],
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 🧑‍🏫 TRAINER - 5 BELUM TERVERIFIKASI
        // =============================
        $trainerPendingIds = [];

        // Trainer 6 - Pending
        $trainerPendingIds[] = DB::table('users')->insertGetId([
            'name' => 'Dewi Anggraini',
            'email' => 'dewi.anggraini@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 29,
            'gender' => 'female',
            'height' => 160,
            'weight' => 58,
            'avatar' => $femaleTrainerAvatars[2],
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 7 - Pending
        $trainerPendingIds[] = DB::table('users')->insertGetId([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad.fauzi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 27,
            'gender' => 'male',
            'height' => 170,
            'weight' => 68,
            'avatar' => $maleTrainerAvatars[3],
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 8 - Pending
        $trainerPendingIds[] = DB::table('users')->insertGetId([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 24,
            'gender' => 'female',
            'height' => 158,
            'weight' => 52,
            'avatar' => $femaleTrainerAvatars[3],
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 9 - Pending
        $trainerPendingIds[] = DB::table('users')->insertGetId([
            'name' => 'Joko Widodo',
            'email' => 'joko.widodo@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 33,
            'gender' => 'male',
            'height' => 176,
            'weight' => 74,
            'avatar' => $maleTrainerAvatars[4],
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trainer 10 - Pending
        $trainerPendingIds[] = DB::table('users')->insertGetId([
            'name' => 'Linda Pratiwi',
            'email' => 'linda.pratiwi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'trainer',
            'age' => 30,
            'gender' => 'female',
            'height' => 163,
            'weight' => 57,
            'avatar' => $femaleTrainerAvatars[4],
            'verification_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 🧍 USERS - 5 USERS
        // =============================
        $userIds = [];

        // Avatar URLs untuk user
        $userAvatars = [
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1534751516642-a1af1ef26a56?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&h=150&fit=crop&crop=face',
            'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?w=150&h=150&fit=crop&crop=face',
        ];

        // User 1 - Punya trainer approved
        $userIds[] = DB::table('users')->insertGetId([
            'name' => 'Rian Fitrianto',
            'email' => 'rian.fit@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 25,
            'gender' => 'male',
            'height' => 172,
            'weight' => 68,
            'avatar' => $userAvatars[0],
            'trainer_id' => $trainerApprovedIds[0], // Coach Andika
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User 2 - Punya trainer approved
        $userIds[] = DB::table('users')->insertGetId([
            'name' => 'Lina Susanti',
            'email' => 'lina.susanti@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 24,
            'gender' => 'female',
            'height' => 165,
            'weight' => 56,
            'avatar' => $userAvatars[1],
            'trainer_id' => $trainerApprovedIds[1], // Sarah Fitriani
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User 3 - Punya trainer pending
        $userIds[] = DB::table('users')->insertGetId([
            'name' => 'Ari Wibowo',
            'email' => 'ari.wibowo@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 27,
            'gender' => 'male',
            'height' => 174,
            'weight' => 70,
            'avatar' => $userAvatars[2],
            'trainer_id' => $trainerPendingIds[0], // Dewi Anggraini (pending)
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User 4 - Tanpa trainer
        $userIds[] = DB::table('users')->insertGetId([
            'name' => 'Santi Dewi',
            'email' => 'santi.dewi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 22,
            'gender' => 'female',
            'height' => 160,
            'weight' => 54,
            'avatar' => $userAvatars[3],
            'trainer_id' => null,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User 5 - Tanpa trainer
        $userIds[] = DB::table('users')->insertGetId([
            'name' => 'Fajar Nugroho',
            'email' => 'fajar.nugroho@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'age' => 29,
            'gender' => 'male',
            'height' => 178,
            'weight' => 76,
            'avatar' => $userAvatars[4],
            'trainer_id' => null,
            'verification_status' => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // =============================
        // 📝 TRAINER PROFILES (Untuk trainer approved)
        // =============================
        $specializations = [
            'Weight Loss & Fat Burning',
            'Muscle Building & Strength',
            'Bodybuilding Competition',
            'Calisthenics & Bodyweight',
            'Functional Training & Mobility',
        ];

        $bios = [
            'Spesialis program penurunan berat badan dengan pendekatan ilmiah. Fokus pada transformasi tubuh yang sehat dan berkelanjutan.',
            'Expert dalam pembentukan otot dan peningkatan kekuatan. Menggunakan metode progressive overload untuk hasil maksimal.',
            'Coach berpengalaman di kompetisi bodybuilding dengan banyak atlet juara. Spesialisasi dalam cutting dan bulking.',
            'Master dalam training menggunakan berat badan sendiri. Mengajarkan kontrol tubuh dan kekuatan fungsional.',
            'Spesialis training fungsional untuk kehidupan sehari-hari. Fokus pada mobilitas, stabilitas, dan pencegahan cedera.',
        ];

        foreach ($trainerApprovedIds as $index => $trainerId) {
            DB::table('trainer_profiles')->insert([
                'user_id' => $trainerId,
                'specialization' => $specializations[$index] ?? 'Personal Training',
                'experience_years' => rand(3, 8),
                'certifications' => 'NASM CPT, ACE Certified, First Aid CPR',
                'bio' => $bios[$index] ?? 'Trainer profesional dengan pengalaman luas di bidang fitness.',
                'rating' => rand(40, 50) / 10, // Rating 4.0 - 5.0
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Trainer Verifications untuk approved trainers
            DB::table('trainer_verifications')->insert([
                'trainer_id' => $trainerId,
                'certificate' => 'certificates/trainer_'.$trainerId.'.pdf',
                'bio' => $bios[$index] ?? 'Trainer profesional terverifikasi.',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Trainer Profiles untuk pending trainers
        foreach ($trainerPendingIds as $index => $trainerId) {
            DB::table('trainer_profiles')->insert([
                'user_id' => $trainerId,
                'specialization' => 'General Fitness Training',
                'experience_years' => rand(1, 3),
                'certifications' => 'Basic Fitness Certification',
                'bio' => 'Trainer baru yang sedang menunggu proses verifikasi.',
                'rating' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Trainer Verifications untuk pending trainers
            DB::table('trainer_verifications')->insert([
                'trainer_id' => $trainerId,
                'certificate' => 'certificates/trainer_'.$trainerId.'.pdf',
                'bio' => 'Sedang menunggu proses verifikasi oleh admin.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // =============================
        // ⭐ FEEDBACK & RATINGS
        // =============================
        $comments = [
            'Trainer yang sangat profesional dan perhatian! Programnya sangat efektif.',
            'Hasilnya luar biasa dalam waktu 2 bulan. Recommended banget!',
            'Metode pengajarannya mudah dipahami dan disiplin.',
            'Motivator yang handal, selalu memberikan semangat saat latihan.',
            'Program yang diberikan sangat personalized sesuai kebutuhan saya.',
            'Hasil lebih cepat dari yang saya kira. Terima kasih coach!',
            'Teknik yang diajarkan sangat detail dan aman dari cedera.',
            'Selalu memberikan feedback yang membangun setiap sesi.',
            'Nutrisi dan workout plan-nya sangat balance dan efektif.',
            'Progress saya meningkat signifikan sejak bergabung.',
        ];

        // User 1 memberikan rating ke trainernya
        DB::table('feedbacks')->insert([
            'user_id' => $userIds[0],
            'trainer_id' => $trainerApprovedIds[0],
            'rating' => 5,
            'comment' => $comments[0],
            'created_at' => now()->subDays(10),
        ]);

        // User 2 memberikan rating ke trainernya
        DB::table('feedbacks')->insert([
            'user_id' => $userIds[1],
            'trainer_id' => $trainerApprovedIds[1],
            'rating' => 4,
            'comment' => $comments[1],
            'created_at' => now()->subDays(15),
        ]);

        // Beberapa rating tambahan untuk trainer
        DB::table('feedbacks')->insert([
            'user_id' => $userIds[4], // User tanpa trainer memberikan rating
            'trainer_id' => $trainerApprovedIds[2],
            'rating' => 5,
            'comment' => $comments[2],
            'created_at' => now()->subDays(20),
        ]);

        // =============================
        // 💳 PREMIUM ACCESS LOGS
        // =============================
        foreach ($userIds as $index => $userId) {
            if ($index < 3) { // Hanya user 1, 2, 3 yang punya trainer
                DB::table('premium_access_logs')->insert([
                    'user_id' => $userId,
                    'trainer_id' => $userIds[$index] == $userIds[2] ? $trainerPendingIds[0] : $trainerApprovedIds[$index],
                    'start_date' => now()->subDays(30),
                    'end_date' => now()->addDays($userIds[$index] == $userIds[2] ? 5 : 30), // User dengan trainer pending hampir berakhir
                    'payment_status' => 'paid',
                    'created_at' => now()->subDays(30),
                    'updated_at' => now()->subDays(30),
                ]);

                // Trainer Memberships
                DB::table('trainer_memberships')->insert([
                    'trainer_id' => $userIds[$index] == $userIds[2] ? $trainerPendingIds[0] : $trainerApprovedIds[$index],
                    'user_id' => $userId,
                    'created_at' => now()->subDays(30),
                    'updated_at' => now()->subDays(30),
                ]);

                // Program Requests
                DB::table('program_requests')->insert([
                    'trainer_id' => $userIds[$index] == $userIds[2] ? $trainerPendingIds[0] : $trainerApprovedIds[$index],
                    'user_id' => $userId,
                    'status' => 'approved',
                    'note' => 'Program training untuk user '.($index + 1),
                    'created_at' => now()->subDays(30),
                    'updated_at' => now()->subDays(30),
                ]);

                // Payments
                DB::table('payments')->insert([
                    'user_id' => $userId,
                    'trainer_id' => $userIds[$index] == $userIds[2] ? $trainerPendingIds[0] : $trainerApprovedIds[$index],
                    'amount' => 150000,
                    'method' => 'transfer',
                    'status' => 'paid',
                    'transaction_id' => 'TRX-'.strtoupper(uniqid()),
                    'created_at' => now()->subDays(30),
                    'updated_at' => now()->subDays(30),
                ]);

                // Trainer Chats
                DB::table('trainer_chats')->insert([
                    'trainer_id' => $userIds[$index] == $userIds[2] ? $trainerPendingIds[0] : $trainerApprovedIds[$index],
                    'user_id' => $userId,
                    'message' => 'Halo! Selamat bergabung di program training saya. Mari kita diskusikan goals Anda.',
                    'sender_type' => 'trainer',
                    'timestamp' => now()->subDays(30),
                    'read_status' => true,
                ]);

                DB::table('trainer_chats')->insert([
                    'trainer_id' => $userIds[$index] == $userIds[2] ? $trainerPendingIds[0] : $trainerApprovedIds[$index],
                    'user_id' => $userId,
                    'message' => 'Halo coach! Saya ingin menurunkan berat badan dan membentuk otot.',
                    'sender_type' => 'user',
                    'timestamp' => now()->subDays(29),
                    'read_status' => true,
                ]);
            }
        }

        // =============================
        // 📊 UPDATE RATINGS DI TRAINER PROFILES
        // =============================
        foreach ($trainerApprovedIds as $trainerId) {
            $averageRating = DB::table('feedbacks')
                ->where('trainer_id', $trainerId)
                ->avg('rating');

            if ($averageRating) {
                DB::table('trainer_profiles')
                    ->where('user_id', $trainerId)
                    ->update(['rating' => round($averageRating, 2)]);
            }
        }

        $this->command->info('💪 UserSeeder berhasil!');
        $this->command->info('👑 Admin: admin@example.com / password123');
        $this->command->info('🧑‍🏫 Trainer Approved: 5 trainer dengan avatar');
        $this->command->info('🧑‍🏫 Trainer Pending: 5 trainer dengan avatar');
        $this->command->info('🧍 Users: 5 users dengan avatar');
        $this->command->info('⭐ Feedback: Sample ratings dan comments');
        $this->command->info('💳 Premium Access: Riwayat akses premium');
        $this->command->info('💬 Chats: Percakapan sample trainer-user');
        $this->command->info('🖼️ Semua user dan trainer sudah memiliki avatar!');
    }
}
