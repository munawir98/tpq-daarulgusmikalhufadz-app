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
        Schema::table('group_messages', function (Blueprint $table) {
            // Tambah kolom status (sent / delivered / read)
            if (!Schema::hasColumn('group_messages', 'status')) {
                $table->string('status')
                      ->default('sent')   // default ketika pesan dibuat
                      ->after('type');    // setelah kolom "type"
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_messages', function (Blueprint $table) {
            if (Schema::hasColumn('group_messages', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
