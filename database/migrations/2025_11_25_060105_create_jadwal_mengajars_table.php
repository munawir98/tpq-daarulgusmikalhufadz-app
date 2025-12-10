<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_mengajar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ustadz_id')->constrained('ustadz')->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->enum('hari', ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']);
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('materi')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_mengajar');
    }
};
