<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50)->unique();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('no_hp_orang_tua', 30)->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};
