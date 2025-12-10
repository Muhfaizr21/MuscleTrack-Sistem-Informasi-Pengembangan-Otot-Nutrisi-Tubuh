<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            // Tambahkan kolom is_premium setelah status
            $table->boolean('is_premium')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('workout_plans', function (Blueprint $table) {
            $table->dropColumn('is_premium');
        });
    }
};
