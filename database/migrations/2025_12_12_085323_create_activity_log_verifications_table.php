<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_log_verifications', function (Blueprint $table) {
            $table->id();

            // Hash unik untuk QR / verifikasi
            $table->string('hash')->unique();

            // Nama file PDF
            $table->string('file_name');

            // Relasi admin/user yang generate
            $table->foreignId('generated_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Waktu generate PDF
            $table->timestamp('generated_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_log_verifications');
    }
};
