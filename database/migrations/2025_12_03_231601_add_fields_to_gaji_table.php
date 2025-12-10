<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->integer('jumlah_kehadiran')->nullable()->after('tahun');
            $table->integer('nominal_per_pertemuan')->nullable()->after('jumlah_kehadiran');
            $table->integer('jumlah')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropColumn(['jumlah_kehadiran', 'nominal_per_pertemuan']);
        });
    }
};
