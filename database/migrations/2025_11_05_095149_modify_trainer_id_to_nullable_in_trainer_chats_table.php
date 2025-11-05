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
        Schema::table('trainer_chats', function (Blueprint $table) {
            // Ini akan mengubah kolom 'trainer_id' agar BOLEH diisi NULL
            $table->unsignedBigInteger('trainer_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainer_chats', function (Blueprint $table) {
            // Ini untuk rollback (mengembalikan)
            $table->unsignedBigInteger('trainer_id')->nullable(false)->change();
        });
    }
};
