<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();

            // 📰 Informasi utama artikel
            $table->string('title');
            $table->string('slug')->unique()->nullable(); // URL-friendly title
            $table->string('category')->nullable();       // Fitness, Nutrition, Lifestyle, dll
            $table->string('summary', 300)->nullable();   // Ringkasan singkat artikel
            $table->text('content')->nullable();
            $table->string('image')->nullable();          // Thumbnail artikel
            $table->string('author')->nullable();         // Nama penulis

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
