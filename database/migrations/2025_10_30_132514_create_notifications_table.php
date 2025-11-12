<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message')->nullable();

            // 🔔 Jenis notifikasi (ditambah 'nutrition_tip' agar tidak error)
            $table->enum('type', [
                'info',          // Informasi umum
                'reminder',      // Pengingat workout/nutrisi
                'alert',         // Peringatan penting
                'achievement',   // Pencapaian (workout completed, goal reached)
                'system',        // Dikirim otomatis oleh sistem
                'trainer',       // Notifikasi dari trainer
                'nutrition_tip',  // 💡 Rekomendasi nutrisi harian
            ])->default('info');

            $table->boolean('read_status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
