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
        Schema::table('presensi', function (Blueprint $table) {
            $table->index(['user_id', 'tanggal']); // For querying user's daily records
            $table->index('tanggal'); // For date range queries
            $table->index('tipe'); // For filtering 'masuk'/'pulang'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->dropIndex(['presensi_user_id_tanggal_index']); // Default generic name might differ, but Laravel usually uses table_column_index
            $table->dropIndex(['presensi_tanggal_index']);
            $table->dropIndex(['presensi_tipe_index']);
        });
    }
};
