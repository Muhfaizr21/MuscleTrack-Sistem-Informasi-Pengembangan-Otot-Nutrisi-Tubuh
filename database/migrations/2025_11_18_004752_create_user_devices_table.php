<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('fcm_token', 512);
            $table->string('device_name')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'fcm_token']);
        });
    }


    public function down()
    {
        Schema::dropIfExists('user_devices');
    }
};
