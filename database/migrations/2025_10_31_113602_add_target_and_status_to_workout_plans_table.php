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
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->string('target_fitness')->nullable()->after('description'); // ex: 'fat_loss', 'muscle_gain'
            $table->enum('status', ['active', 'inactive'])->default('active')->after('target_fitness');
            $table->string('difficulty_level')->nullable()->after('status'); // ex: 'beginner', 'intermediate', 'advanced'
            $table->integer('duration_minutes')->nullable()->after('difficulty_level'); // optional
        });
    }

    public function down(): void
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->dropColumn(['target_fitness', 'status', 'difficulty_level', 'duration_minutes']);
        });
    }
};
