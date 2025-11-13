<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['cardio', 'strength', 'flexibility', 'balance']);
            $table->string('muscle_group');
            $table->string('equipment')->nullable();
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced']);
            $table->text('instructions')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('calories_burned')->default(0);
            $table->integer('duration')->default(0); // dalam menit
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};
