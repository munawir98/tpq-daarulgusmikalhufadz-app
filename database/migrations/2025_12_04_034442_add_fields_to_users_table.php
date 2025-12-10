<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // JANGAN hapus 'role' lama, cukup ubah default jadi 'SANTRI'
            $table->string('role', 20)->default('SANTRI')->change();

            $table->string('no_hp', 20)->nullable()->after('role');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->string('foto')->nullable()->after('alamat');
            $table->string('status', 20)->default('aktif')->after('foto');
            $table->timestamp('last_login')->nullable()->after('status');
            $table->string('fcm_token')->nullable()->after('last_login');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'no_hp',
                'alamat',
                'foto',
                'status',
                'last_login',
                'fcm_token'
            ]);
        });
    }
};
