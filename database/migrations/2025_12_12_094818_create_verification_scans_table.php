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
        Schema::create('verification_scans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_log_verification_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->ipAddress('ip_address');
            $table->string('user_agent')->nullable();

            // waktu scan QR
            $table->timestamp('scanned_at')->useCurrent();

            $table->timestamps();

            // index untuk performa
            $table->index('activity_log_verification_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_scans');
    }
};
