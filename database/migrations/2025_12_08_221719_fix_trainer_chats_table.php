<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixTrainerChatsTable extends Migration
{
    public function up()
    {
        // 1. Tambahkan timestamps jika belum ada
        if (!Schema::hasColumn('trainer_chats', 'created_at')) {
            Schema::table('trainer_chats', function (Blueprint $table) {
                $table->timestamp('created_at')->nullable()->after('read_status');
                $table->timestamp('updated_at')->nullable()->after('created_at');
            });
        }

        // 2. Update data yang ada dengan timestamp
        DB::table('trainer_chats')->whereNull('created_at')->update([
            'created_at' => DB::raw('timestamp'),
            'updated_at' => DB::raw('timestamp')
        ]);

        // 3. Pastikan kolom timestamp tidak nullable
        Schema::table('trainer_chats', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable(false)->change();
            $table->timestamp('updated_at')->nullable(false)->change();
        });
    }

    public function down()
    {
        // Tidak perlu rollback yang kompleks
        Schema::table('trainer_chats', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}
