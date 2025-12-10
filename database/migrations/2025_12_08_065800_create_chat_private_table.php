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
        Schema::create('chat_private', function (Blueprint $table) {
            $table->id();

            // Pengirim pesan
            $table->foreignId('sender_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Penerima pesan
            $table->foreignId('receiver_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Isi pesan (teks bisa kosong jika kirim gambar / audio)
            $table->text('message')->nullable();

            // File path untuk gambar atau audio
            $table->string('file_path')->nullable();

            // Jenis pesan (text, image, audio)
            $table->enum('type', ['text', 'image', 'audio']);

            // Waktu pesan dibaca penerima
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Optimasi query
            $table->index(['sender_id', 'receiver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_private');
    }
};
