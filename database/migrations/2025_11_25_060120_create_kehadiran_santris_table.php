<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('jadwal_id')->constrained('jadwal_mengajar')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['Hadir','Sakit','Izin','Alpa'])->default('Hadir');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['santri_id','jadwal_id','tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran_santri');
    }
};
