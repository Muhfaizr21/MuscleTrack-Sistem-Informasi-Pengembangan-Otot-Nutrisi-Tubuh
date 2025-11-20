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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('trainer_id')->nullable()->constrained('users')->nullOnDelete();

            // Midtrans required
            $table->string('order_id')->unique(); // WAJIB untuk Midtrans
            $table->decimal('amount', 10, 2);

            // Payment info
            $table->enum('method', ['transfer', 'ewallet', 'credit_card']);
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_type')->nullable(); // contoh: bank_transfer, gopay, qris

            // Snap fields
            $table->string('snap_token')->nullable();
            $table->string('redirect_url')->nullable();

            // Tracking dari Midtrans
            $table->string('transaction_id')->nullable(); // dari Midtrans (transaction_id)
            $table->string('fraud_status')->nullable();   // untuk CC: accept / challenge / deny
            $table->json('raw_response')->nullable();     // untuk menyimpan full response

            // Payment timestamp
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
