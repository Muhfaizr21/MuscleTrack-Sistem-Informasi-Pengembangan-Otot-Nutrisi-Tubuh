<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('level')->nullable(); // beginner/intermediate/advanced
            $table->text('description')->nullable();

            // 🎯 Kolom target & fokus latihan
            $table->string('target_fitness')->nullable(); // contoh: fat_loss, muscle_gain
            $table->string('focus_area')->nullable(); // contoh: bulking, cutting, maintain
            $table->string('bmi_category')->nullable(); // contoh: underweight, normal, overweight, obese

            // ⚙️ Status & durasi program
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('difficulty_level')->nullable(); // contoh: beginner, intermediate, advanced
            $table->integer('duration_weeks')->nullable();
            $table->integer('duration_minutes')->nullable(); // opsional

            // 🧑‍🏫 Hubungan dengan trainer/admin
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // pembuat (admin/trainer)
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null'); // jika direkomendasikan oleh trainer
            $table->enum('recommended_by', ['admin', 'trainer'])->nullable(); // sumber rekomendasi

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
