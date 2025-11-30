<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved'])->default('approved');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_at', 'approved_by']);
        });
    }
};
