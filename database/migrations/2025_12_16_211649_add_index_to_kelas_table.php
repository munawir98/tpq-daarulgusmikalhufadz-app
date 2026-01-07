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
        // Skip if indexes already exist (using try-catch for SQLite compatibility)
        try {
            Schema::table('kelas', function (Blueprint $table) {
                $table->index('status', 'kelas_status_index');
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }

        try {
            Schema::table('kelas', function (Blueprint $table) {
                $table->index('tingkat', 'kelas_tingkat_index');
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }

        try {
            Schema::table('kelas', function (Blueprint $table) {
                $table->index('ustadz_id', 'kelas_ustadz_id_index');
            });
        } catch (\Exception $e) {
            // Index already exists, skip
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tingkat']);
            $table->dropIndex(['ustadz_id']);
        });
    }
};
