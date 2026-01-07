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
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ustadz_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('surah');
            $table->integer('ayat_awal');
            $table->integer('ayat_akhir');
            $table->string('nilai')->nullable(); // Mumtaz, Jayyid Jiddan, Jayyid, Maqbul, Rasib
            $table->text('catatan')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalan');
    }
};
