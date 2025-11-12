<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // 🧍 Identitas dasar
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'user', 'trainer'])->default('user');

            // 📊 Data tambahan profil
            $table->integer('age')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->string('avatar')->nullable()->comment('Foto profil user');

            // 🎯 Goal ID (tanpa foreign key dulu)
            $table->unsignedBigInteger('goal_id')->nullable()->comment('ID goal, opsional');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['trainer_id']);
        });

        Schema::dropIfExists('users');
    }
};
