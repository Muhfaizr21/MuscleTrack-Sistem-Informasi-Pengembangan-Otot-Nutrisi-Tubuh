<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'trainer_id')) {
                $table->unsignedBigInteger('trainer_id')->nullable()->after('role');
                $table->foreign('trainer_id')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'trainer_id')) {
                try {
                    $table->dropForeign(['trainer_id']);
                } catch (\Exception $e) {
                    // abaikan jika FK sudah terhapus
                }
                $table->dropColumn('trainer_id');
            }
        });
    }
};
