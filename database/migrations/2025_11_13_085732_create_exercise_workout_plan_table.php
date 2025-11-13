<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercise_workout_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->foreignId('workout_plan_id')->constrained()->onDelete('cascade');
            $table->integer('sets')->default(3);
            $table->integer('reps')->default(10);
            $table->integer('duration')->nullable()->comment('Duration in seconds for timed exercises');
            $table->integer('order')->default(0);
            $table->integer('rest_interval')->default(60)->comment('Rest in seconds between sets');
            $table->timestamps();

            $table->unique(['exercise_id', 'workout_plan_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercise_workout_plan');
    }
};