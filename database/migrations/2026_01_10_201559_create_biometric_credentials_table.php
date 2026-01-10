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
        Schema::create('biometric_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('credential_id'); // WebAuthn Credential ID
            $table->string('name')->nullable(); // Friendly name e.g. "Jari Telunjuk Kanan"
            $table->text('public_key')->nullable(); // Public Key for verification
            $table->unsignedInteger('sign_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biometric_credentials');
    }
};
