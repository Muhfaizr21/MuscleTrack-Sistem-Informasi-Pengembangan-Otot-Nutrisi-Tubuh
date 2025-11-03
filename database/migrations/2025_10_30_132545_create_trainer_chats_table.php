<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trainer_chats', function (Blueprint $table) {
            $table->id();

            // 🔗 Relasi ke user (trainer dan member)
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 💬 Pesan
            $table->text('message');

            // 🧩 Jenis pengirim (trainer / user)
            $table->enum('sender_type', ['trainer', 'user'])->default('user');

            // ⏰ Waktu dikirim
            $table->timestamp('timestamp')->useCurrent();

            // 👀 Status baca
            $table->boolean('read_status')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainer_chats');
    }
};
