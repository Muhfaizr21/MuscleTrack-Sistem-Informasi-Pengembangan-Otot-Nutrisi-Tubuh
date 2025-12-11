<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_plan_id')->constrained('workout_plans')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('muscle_group')->nullable(); // chest, back, legs, arms, shoulders, core
            $table->string('equipment')->nullable(); // barbell, dumbbell, bodyweight, machine, etc.
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('sets')->nullable();
            $table->integer('reps_min')->nullable();
            $table->integer('reps_max')->nullable();
            $table->integer('rest_seconds')->nullable();
            $table->decimal('weight_suggestion', 5, 2)->nullable();
            $table->string('video_url')->nullable();
            $table->string('image_url')->nullable();
            $table->text('instructions')->nullable(); // Step-by-step instructions
            $table->text('tips')->nullable(); // Tips for proper form
            $table->text('common_mistakes')->nullable(); // Common mistakes to avoid
            $table->integer('order')->default(0); // Untuk mengurutkan exercises dalam satu plan
            $table->enum('day', ['day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6', 'day_7'])->nullable(); // Hari latihan dalam program
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
    }
};
