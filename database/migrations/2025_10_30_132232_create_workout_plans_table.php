<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('level');
            $table->text('description')->nullable();
            
            // Kolom tambahan sesuai dokumen
            $table->string('target_fitness')->nullable(); // contoh: fat_loss, muscle_gain
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('difficulty_level')->nullable(); // contoh: beginner, intermediate, advanced
            $table->integer('duration_weeks')->nullable();
            $table->integer('duration_minutes')->nullable(); // opsional

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
