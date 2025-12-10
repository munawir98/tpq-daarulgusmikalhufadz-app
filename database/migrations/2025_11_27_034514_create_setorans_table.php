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
    Schema::create('setoran', function (Blueprint $table) {
        $table->id();
        $table->foreignId('santri_id')->nullable()->constrained('santri')->nullOnDelete();
        $table->integer('juz')->nullable();
        $table->integer('halaman')->nullable();
        $table->date('tanggal')->nullable();
        $table->text('keterangan')->nullable();   // TAMBAH DI SINI
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('setoran');
}

};
