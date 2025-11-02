<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_schedules', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi ke user & workout plan
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('workout_plan_id')
                ->nullable()
                ->constrained('workout_plans')
                ->onDelete('set null');

            // 📅 Jadwal latihan
            $table->date('scheduled_date'); // tanggal latihan
            $table->time('scheduled_time')->nullable(); // waktu latihan

            // 📈 Status & catatan progres
            $table->enum('status', ['pending', 'in_progress', 'completed', 'missed'])
                ->default('pending'); // status latihan

            $table->timestamp('completed_at')->nullable(); // waktu latihan selesai (opsional)
            $table->text('notes')->nullable(); // catatan setelah latihan (opsional, untuk evaluasi)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_schedules');
    }
};
