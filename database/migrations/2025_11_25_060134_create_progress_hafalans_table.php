<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress_hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->unsignedTinyInteger('juz')->nullable();
            $table->string('surat', 100)->nullable();
            $table->unsignedInteger('ayat_mulai')->nullable();
            $table->unsignedInteger('ayat_selesai')->nullable();
            $table->enum('nilai', ['A','B','C','D'])->nullable();
            $table->date('tanggal')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_hafalan');
    }
};
