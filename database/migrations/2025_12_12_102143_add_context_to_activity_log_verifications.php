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
        Schema::table('activity_log_verifications', function (Blueprint $table) {
            $table->string('context_type', 50)
                  ->after('document_number');

            $table->string('context_key', 191)
                  ->after('context_type');

            // UNIQUE LOCK (ANTI DUPLIKASI DOKUMEN)
            $table->unique(
                ['context_type', 'context_key'],
                'activity_log_verifications_context_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_log_verifications', function (Blueprint $table) {
            $table->dropUnique('activity_log_verifications_context_unique');
            $table->dropColumn(['context_type', 'context_key']);
        });
    }
};
