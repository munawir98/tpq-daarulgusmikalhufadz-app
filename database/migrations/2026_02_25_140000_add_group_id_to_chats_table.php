<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->string('group_id')->nullable()->after('id');
        });

        // Make receiver_id nullable using raw SQL (no doctrine/dbal needed)
        DB::statement('ALTER TABLE chats MODIFY receiver_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });

        DB::statement('ALTER TABLE chats MODIFY receiver_id BIGINT UNSIGNED NOT NULL');
    }
};
