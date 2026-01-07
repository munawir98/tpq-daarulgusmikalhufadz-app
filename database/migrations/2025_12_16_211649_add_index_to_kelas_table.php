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
        Schema::table('kelas', function (Blueprint $table) {
            // Get existing indexes
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $existingIndexes = collect(Schema::getIndexes('kelas'))->pluck('name')->toArray();

            if (!in_array('kelas_status_index', $existingIndexes)) {
                $table->index('status');
            }
            if (!in_array('kelas_tingkat_index', $existingIndexes)) {
                $table->index('tingkat');
            }
            if (!in_array('kelas_ustadz_id_index', $existingIndexes)) {
                $table->index('ustadz_id');
            }
        });
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
