<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            // pastikan kolomnya ada dulu
            if (Schema::hasColumn('workout_plans', 'recommended_by')) {
                $table->string('recommended_by', 100)->nullable()->change();
            } else {
                $table->string('recommended_by', 100)->nullable()->after('trainer_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->dropColumn('recommended_by');
        });
    }
};
