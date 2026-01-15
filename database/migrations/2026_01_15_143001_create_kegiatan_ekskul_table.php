<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_ekskul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ustadz_id')->constrained('ustadzs')->onDelete('cascade');
            $table->string('nama');
            $table->string('pelatih')->nullable();
            $table->integer('jumlah_peserta')->default(0);
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_ekskul');
    }
};
