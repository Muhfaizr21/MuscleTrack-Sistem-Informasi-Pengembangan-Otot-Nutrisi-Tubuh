    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('nutrition_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('meal_name'); // nama makanan atau menu
                $table->integer('calories')->default(0); // total kalori per porsi
                $table->float('protein')->default(0); // gram protein
                $table->float('carbs')->default(0); // gram karbohidrat
                $table->float('fat')->default(0); // gram lemak
                $table->string('day_of_week')->nullable(); // Senin, Selasa, dst
                $table->string('target_fitness')->nullable(); // 'fat_loss', 'muscle_gain', 'maintenance'
                $table->enum('type', ['breakfast', 'lunch', 'dinner', 'snack'])->nullable();
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('nutrition_plans');
        }
    };
