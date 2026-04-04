<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->longText('foto')->nullable()->change();
            });
        } catch (\Exception $e) {
            // Ignore for SQLite
        }
    }

    public function down(): void
    {
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->string('foto')->nullable()->change();
            });
        } catch (\Exception $e) {
            // Ignore for SQLite
        }
    }
};
