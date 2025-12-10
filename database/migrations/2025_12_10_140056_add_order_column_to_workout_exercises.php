<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. CEK DULU KOLOM YANG ADA
        Schema::table('workout_exercises', function (Blueprint $table) {
            // Cek apakah kolom notes sudah ada, jika belum tambahkan
            if (!Schema::hasColumn('workout_exercises', 'notes')) {
                $table->text('notes')->nullable()->after('rest_seconds');
            }

            // Cek apakah kolom description sudah ada
            if (!Schema::hasColumn('workout_exercises', 'description')) {
                $table->text('description')->nullable()->after('name');
            }

            // Cek apakah kolom duration_minutes sudah ada
            if (!Schema::hasColumn('workout_exercises', 'duration_minutes')) {
                $table->integer('duration_minutes')->nullable()->after('reps');
            }

            // Cek apakah kolom video_url sudah ada
            if (!Schema::hasColumn('workout_exercises', 'video_url')) {
                $table->string('video_url', 500)->nullable()->after('rest_seconds');
            }

            // Cek apakah kolom instructions sudah ada
            if (!Schema::hasColumn('workout_exercises', 'instructions')) {
                $table->text('instructions')->nullable()->after('video_url');
            }

            // Cek apakah kolom muscle_group sudah ada
            if (!Schema::hasColumn('workout_exercises', 'muscle_group')) {
                $table->string('muscle_group', 100)->nullable()->after('instructions');
            }

            // Cek apakah kolom equipment sudah ada
            if (!Schema::hasColumn('workout_exercises', 'equipment')) {
                $table->string('equipment', 100)->nullable()->after('muscle_group');
            }

            // SEKARANG tambah kolom order
            if (!Schema::hasColumn('workout_exercises', 'order')) {
                // Tambah setelah kolom terakhir yang ada
                $table->integer('order')->default(0)->after('equipment');
            }
        });

        // 2. Update existing records dengan order default
        DB::statement("UPDATE workout_exercises SET `order` = id WHERE `order` IS NULL OR `order` = 0");

        // 3. Set default values untuk kolom yang mungkin NULL
        DB::statement("UPDATE workout_exercises SET type = 'strength' WHERE type IS NULL OR type = ''");
        DB::statement("UPDATE workout_exercises SET sets = 3 WHERE sets IS NULL OR sets = 0");
        DB::statement("UPDATE workout_exercises SET reps = '10-12' WHERE reps IS NULL OR reps = ''");
        DB::statement("UPDATE workout_exercises SET rest_seconds = 60 WHERE rest_seconds IS NULL OR rest_seconds = 0");
    }

    public function down(): void
    {
        Schema::table('workout_exercises', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $columnsToDrop = ['order', 'notes', 'description', 'duration_minutes',
                            'video_url', 'instructions', 'muscle_group', 'equipment'];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('workout_exercises', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
