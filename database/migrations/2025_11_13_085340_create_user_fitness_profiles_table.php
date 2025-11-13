<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('user_fitness_profiles', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi ke tabel users & goals
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('goal_id')
                ->nullable()
                ->constrained('goals')
                ->onDelete('set null');

            // ⚙️ Atribut aktivitas & deskripsi pekerjaan
            $table->enum('activity_level', ['light', 'moderate', 'heavy'])
                ->nullable()
                ->comment('Tingkat aktivitas harian: ringan, sedang, berat');

            $table->string('activity_description')
                ->nullable()
                ->comment('Contoh pekerjaan: kantor, teknisi, pekerja konstruksi, dll');

            // 💪 Fokus otot & target kalori
            $table->json('preferred_muscle_groups')
                ->nullable()
                ->comment('Daftar otot yang ingin difokuskan: chest, arms, legs, dll');

            $table->integer('daily_calorie_target')
                ->nullable()
                ->comment('Target kalori harian user (opsional)');

            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_fitness_profiles');
    }
};
