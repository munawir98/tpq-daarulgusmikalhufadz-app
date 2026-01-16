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
        Schema::create('nilai_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->onDelete('cascade');
            $table->foreignId('ustadz_id')->constrained('ustadz')->onDelete('cascade');
            $table->string('tahun_ajaran');
            $table->string('kategori'); // Monthly, UTS, UAS
            $table->integer('tilawah')->default(0);
            $table->integer('hafalan')->default(0);
            $table->integer('adab')->default(0);
            $table->integer('tajwid')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_santri');
    }
};
