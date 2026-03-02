<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jurnal_harian')) {
            Schema::create('jurnal_harian', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ustadz_id')->constrained('ustadz')->onDelete('cascade');
                $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
                $table->date('tanggal');
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_harian');
    }
};
