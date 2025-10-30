<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();          // ID session (primary key)
            $table->foreignId('user_id')->nullable()->index(); // ID user yang login
            $table->string('ip_address', 45)->nullable();      // IP address user
            $table->text('user_agent')->nullable();            // User agent browser
            $table->text('payload');                           // Data session
            $table->integer('last_activity')->index();         // Timestamp aktivitas terakhir
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
