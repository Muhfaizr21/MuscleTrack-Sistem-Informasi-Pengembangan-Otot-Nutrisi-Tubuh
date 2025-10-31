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
        Schema::create('meal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_id')->constrained('nutrition_plans')->cascadeOnDelete();
            $table->string('meal_name');
            $table->integer('calories')->default(0);
            $table->decimal('protein', 5, 2)->default(0);
            $table->decimal('carbs', 5, 2)->default(0);
            $table->decimal('fat', 5, 2)->default(0);
            $table->enum('time_of_day', ['breakfast', 'lunch', 'dinner', 'snack'])->default('lunch');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_items');
    }
};
