<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();

            // PRESENSI SANTRI / USER
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // PRESENSI PENGAJAR (USTADZ)
            $table->foreignId('ustadz_id')
                ->nullable()
                ->constrained('ustadz')   // ← FIX: tabel ustadz
                ->nullOnDelete();

            // Tanggal & Waktu
            $table->date('tanggal');
            $table->time('jam')->nullable();

            // Tipe presensi
            $table->enum('tipe', ['masuk', 'pulang']);

            // Foto
            $table->string('foto')->nullable();

            // Lokasi GPS
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Status presensi
            $table->enum('status_presensi', ['HADIR','TERLAMBAT','IZIN','SAKIT','ALPHA'])
                ->default('HADIR');

            $table->boolean('is_late')->default(false);

            // QR Code & metode
            $table->string('qr_code')->nullable();
            $table->string('metode')->default('manual');

            // Shift / jadwal
            $table->foreignId('jadwal_id')
                ->nullable()
                ->constrained('jadwal_mengajar')
                ->nullOnDelete();

            // Catatan
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
