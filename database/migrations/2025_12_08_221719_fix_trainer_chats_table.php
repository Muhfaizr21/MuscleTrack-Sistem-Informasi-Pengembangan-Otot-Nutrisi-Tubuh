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

        // 2. Update data yang ada dengan timestamp saat ini
        DB::table('trainer_chats')->whereNull('created_at')->update([
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 3. PERBAIKAN: Tambahkan default value sebelum membuat NOT NULL
        Schema::table('trainer_chats', function (Blueprint $table) {
            // Gunakan useCurrent() untuk default value
            $table->timestamp('created_at')
                ->useCurrent()  // ← INI YANG PERLU DITAMBAHKAN
                ->nullable(false)
                ->change();

            $table->timestamp('updated_at')
                ->useCurrent()  // ← INI YANG PERLU DITAMBAHKAN
                ->nullable(false)
                ->change();
        });
    }

    public function down()
    {
        Schema::table('trainer_chats', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
}
