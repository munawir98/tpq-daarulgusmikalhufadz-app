<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kehadiran_santri', function (Blueprint $table) {
            // Tambahkan kolom user_id
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->after('santri_id'); // letakkan setelah kolom santri_id
        });
    }

    public function down(): void
    {
        Schema::table('kehadiran_santri', function (Blueprint $table) {
            // Hapus foreign key & kolom
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
