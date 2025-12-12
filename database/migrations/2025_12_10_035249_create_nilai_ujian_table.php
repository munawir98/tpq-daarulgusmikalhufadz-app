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
        Schema::create('nilai_ujian', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel santri
            $table->foreignId('santri_id')
                  ->constrained('santri')
                  ->onDelete('cascade');

            // jenis_ujian: hafalan / teori / praktek, dll.
            $table->string('jenis_ujian');

            // Nilai ujian
            $table->integer('nilai');

            // Keterangan tambahan (opsional)
            $table->string('keterangan')->nullable();

            // Tanggal ujian
            $table->date('tanggal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ujian');
    }
};
