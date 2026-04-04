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

        // Safe DB independent way to make column nullable
        try {
            Schema::table('chats', function (Blueprint $table) {
                $table->unsignedBigInteger('receiver_id')->nullable()->change();
            });
        } catch (\Exception $e) {
            // Fallback for MySQL if doctrine/dbal is missing
            if (DB::getDriverName() !== 'sqlite') {
                DB::statement('ALTER TABLE chats MODIFY receiver_id BIGINT UNSIGNED NULL');
            }
        }
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });

        try {
            Schema::table('chats', function (Blueprint $table) {
                $table->unsignedBigInteger('receiver_id')->nullable(false)->change();
            });
        } catch (\Exception $e) {
            if (DB::getDriverName() !== 'sqlite') {
                DB::statement('ALTER TABLE chats MODIFY receiver_id BIGINT UNSIGNED NOT NULL');
            }
        }
    }
};
