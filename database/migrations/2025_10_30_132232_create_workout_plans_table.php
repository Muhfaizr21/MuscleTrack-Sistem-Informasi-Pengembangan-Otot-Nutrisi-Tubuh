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
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
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
            $table->integer('duration_minutes')->nullable();
            $table->integer('sessions_per_week')->nullable();
            $table->text('equipment_needed')->nullable();
            $table->text('detailed_description')->nullable();
            $table->text('notes')->nullable();

            // 💎 Premium status
            $table->boolean('is_premium')->default(false);

            // 🖼️ Cover image
            $table->string('cover_image')->nullable();

            // 🧑‍🏫 Hubungan dengan trainer/admin
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // pembuat (admin/trainer)
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null'); // jika direkomendasikan oleh trainer
            $table->string('recommended_by')->nullable(); // 'admin', 'trainer', 'system'

            // 👥 Created and updated by
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            // ⏰ Timestamps & soft deletes
            $table->timestamps();
            $table->softDeletes(); // Tambahkan soft deletes
        });

        // Tambahkan index untuk pencarian yang lebih cepat
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->index(['status', 'is_premium']);
            $table->index(['user_id', 'trainer_id']);
            $table->index('difficulty_level');
            $table->index('bmi_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
