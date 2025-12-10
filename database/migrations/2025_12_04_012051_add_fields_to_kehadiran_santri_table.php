<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kehadiran_santri', function (Blueprint $table) {
            $table->unsignedBigInteger('ustadz_id')->nullable()->after('jadwal_id');
            $table->time('waktu_absen')->nullable()->after('tanggal');
            $table->string('status')->nullable()->change();

            $table->foreign('ustadz_id')->references('id')->on('ustadz')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kehadiran_santri', function (Blueprint $table) {
            $table->dropForeign(['ustadz_id']);
            $table->dropColumn(['ustadz_id', 'waktu_absen']);
        });
    }
};
