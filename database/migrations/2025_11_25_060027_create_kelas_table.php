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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            $table->string('kode_kelas', 50)->unique();
            $table->string('nama_kelas');

            // TPQ, Tahfidz, Iqra, MDT, dll
            $table->string('tipe', 50)->nullable();

            // Dasar, Menengah, Lanjutan
            $table->string('tingkat', 50)->nullable();

            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();

            // Relasi ke tabel ustadz
            $table->foreignId('ustadz_id')
                ->nullable()
                ->constrained('ustadz')
                ->nullOnDelete();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Optional index (disarankan)
            $table->index('nama_kelas');
            $table->index('ustadz_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
