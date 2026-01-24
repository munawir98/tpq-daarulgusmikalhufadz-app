<?php

namespace Database\Seeders;

use App\Models\Ustadz;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UstadzSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user untuk ustadz (kalau belum ada)
        $user = User::firstOrCreate(
            ['email' => 'ustadz1@tpq.test'],
            [
                'name' => 'Ustadz Ahmad',
                'password' => Hash::make('password'),
                'role' => 'ustadz',
            ]
        );

        Ustadz::firstOrCreate(
            ['nama' => 'Ustadz Ahmad'],
            [
                'user_id' => $user->id,
                'nik' => '1234567890',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Contoh No. 1',
                'tanggal_mulai_mengajar' => now()->subYears(2),
                'status_aktif' => true,
            ]
        );

        // Buat user untuk ustadz kedua
        $user2 = User::firstOrCreate(
            ['email' => 'ustadz2@tpq.test'],
            [
                'name' => 'Ustadz Budi (MDT)',
                'password' => Hash::make('password'),
                'role' => 'ustadz',
            ]
        );

        Ustadz::firstOrCreate(
            ['nama' => 'Ustadz Budi'],
            [
                'user_id' => $user2->id,
                'nik' => '0987654321',
                'jenis_kelamin' => 'L',
                'no_hp' => '081298765432',
                'alamat' => 'Jl. Contoh No. 2',
                'tanggal_mulai_mengajar' => now()->subYear(1),
                'status_aktif' => true,
            ]
        );
    }
}
