<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ustadz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama');
            $table->string('nik', 30)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_hp', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_mulai_mengajar')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ustadz');
    }
};
