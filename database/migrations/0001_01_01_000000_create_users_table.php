<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Informasi dasar
            $table->string('name');                        // Nama user
            $table->string('email')->unique();             // Email unik
            $table->string('password');                    // Password hash
            $table->enum('role', ['admin', 'user', 'trainer'])->default('user'); // Role

            // Informasi tambahan
            $table->integer('age')->nullable();            // Usia
            $table->enum('gender', ['male', 'female'])->nullable(); // Jenis kelamin
            $table->float('height')->nullable();           // Tinggi badan
            $table->float('weight')->nullable();           // Berat badan
            $table->string('avatar')->nullable();          // 🆕 Foto profil (nama file / path)
            $table->unsignedBigInteger('goal_id')->nullable(); // ID goal, hanya kolom

            $table->timestamps();
        });

        // ⚠️ Foreign key ke tabel goals dapat ditambahkan di migrasi terpisah
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
