<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelas', 50)->unique();
            $table->string('nama_kelas');
            $table->string('tipe', 50)->nullable(); // TPQ, Tahfidz, Iqra, dll
            $table->string('tingkat', 50)->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->foreignId('ustadz_id')->nullable()->constrained('ustadz')->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
