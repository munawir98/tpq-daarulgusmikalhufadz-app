<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Santri;
use Illuminate\Database\Seeder;

class SantriSeeder extends Seeder
{
    public function run(): void
    {
        $kelasA = Kelas::where('kode_kelas', 'TPQ-A')->first();
        $kelasB = Kelas::where('kode_kelas', 'TPQ-B')->first();

        Santri::firstOrCreate(
            ['nis' => 'S001'],
            [
                'nama_lengkap' => 'Muhammad Ali',
                'nama_panggilan' => 'Ali',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2015-01-10',
                'tempat_lahir' => 'Bandung',
                'alamat' => 'Jl. Santri No. 1',
                'nama_ayah' => 'Pak Ahmad',
                'nama_ibu' => 'Bu Aisyah',
                'no_hp_orang_tua' => '081111111111',
                'tanggal_masuk' => now()->subYear(),
                'status_aktif' => true,
                'kelas_id' => $kelasA?->id,
            ]
        );

        Santri::firstOrCreate(
            ['nis' => 'S002'],
            [
                'nama_lengkap' => 'Aisyah Zahra',
                'nama_panggilan' => 'Zahra',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2014-05-20',
                'tempat_lahir' => 'Bandung',
                'alamat' => 'Jl. Santri No. 2',
                'nama_ayah' => 'Pak Yusuf',
                'nama_ibu' => 'Bu Fatimah',
                'no_hp_orang_tua' => '082222222222',
                'tanggal_masuk' => now()->subYears(2),
                'status_aktif' => true,
                'kelas_id' => $kelasB?->id,
            ]
        );
    }
}
