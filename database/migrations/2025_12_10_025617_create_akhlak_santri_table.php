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
        Schema::create('akhlak_santri', function (Blueprint $table) {
            $table->id();

                    // Relasi ke tabel santris
                $table->foreignId('santri_id')
            ->constrained('santri')
            ->onDelete('cascade')
            ->index();


            // Penilaian akhlak (1–5)
            $table->unsignedTinyInteger('disiplin')->comment('1–5');
            $table->unsignedTinyInteger('kerajinan')->comment('1–5');
            $table->unsignedTinyInteger('kesopanan')->comment('1–5');

            // Catatan opsional
            $table->text('catatan')->nullable();

            // Tanggal penilaian
            $table->date('tanggal_penilaian')->index();

            // Jika ingin mencegah duplikasi penilaian di hari yang sama
            // $table->unique(['santri_id', 'tanggal_penilaian']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akhlak_santri');
    }
};
