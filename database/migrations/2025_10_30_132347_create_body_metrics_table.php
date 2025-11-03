<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('body_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Metrik Utama
            $table->float('weight')->nullable(); // (kg)
            $table->float('height')->nullable(); // (cm)
            $table->float('body_fat')->nullable(); // (%)
            $table->float('muscle_mass')->nullable(); // (kg)

            // Metrik Tambahan (Lingkar)
            $table->float('waist')->nullable(); // Lingkar pinggang (cm)
            $table->float('chest')->nullable(); // Lingkar dada (cm)
            $table->float('arm')->nullable(); // Lingkar lengan (cm)

            // Foto & Tanggal
            $table->string('photo_progress')->nullable(); // Path ke foto
            $table->dateTime('recorded_at'); // Tanggal & Waktu pencatatan
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('body_metrics');
    }
};
