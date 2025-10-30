<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('workout_plan_id')->nullable()->constrained('workout_plans')->onDelete('set null');
            $table->foreignId('nutrition_plan_id')->nullable()->constrained('nutrition_plans')->onDelete('set null');
            $table->integer('calories_consumed')->nullable();
            $table->integer('protein_consumed')->nullable();
            $table->integer('carbs_consumed')->nullable();
            $table->integer('fat_consumed')->nullable();
            $table->text('notes')->nullable();
            $table->date('log_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_logs');
    }
};
