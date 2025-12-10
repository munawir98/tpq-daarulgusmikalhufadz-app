<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('infaq', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->nullable()->constrained('santri')->nullOnDelete();
            $table->integer('jumlah');
            $table->date('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('infaq');
    }
};
