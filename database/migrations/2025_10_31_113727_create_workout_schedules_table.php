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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('workout_plan_id')->constrained('workout_plans')->onDelete('cascade');
            $table->date('scheduled_date'); // tanggal latihan
            $table->time('scheduled_time')->nullable(); // waktu latihan
            $table->enum('status', ['pending', 'completed', 'missed'])->default('pending'); // status latihan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_schedules');
    }
};
