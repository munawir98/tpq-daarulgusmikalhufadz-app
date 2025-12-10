<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            $table->unsignedBigInteger('ustadz_id')->nullable()->after('santri_id');
            $table->string('ayat_mulai')->nullable()->after('halaman');
            $table->string('ayat_selesai')->nullable()->after('ayat_mulai');
            $table->integer('nilai')->nullable()->after('tanggal');
            $table->string('status')->nullable()->after('nilai');

            // jika butuh relasi
            $table->foreign('ustadz_id')->references('id')->on('ustadz')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            $table->dropForeign(['ustadz_id']);
            $table->dropColumn(['ustadz_id','ayat_mulai','ayat_selesai','nilai','status']);
        });
    }
};
