<?php

namespace Database\Seeders;

use App\Models\JadwalMengajar;
use App\Models\Kelas;
use App\Models\Ustadz;
use Illuminate\Database\Seeder;

class JadwalMengajarSeeder extends Seeder
{
    public function run(): void
    {
        $ustadz = Ustadz::first();
        $kelasA = Kelas::where('kode_kelas', 'TPQ-A')->first();
        $kelasB = Kelas::where('kode_kelas', 'TPQ-B')->first();

        if (! $ustadz || ! $kelasA || ! $kelasB) {
            return;
        }

        JadwalMengajar::firstOrCreate(
            [
                'ustadz_id' => $ustadz->id,
                'kelas_id' => $kelasA->id,
                'hari' => 'Senin',
            ],
            [
                'waktu_mulai' => '16:00:00',
                'waktu_selesai' => '17:30:00',
                'materi' => 'Iqra & Tajwid Dasar',
                'aktif' => true,
            ]
        );

        JadwalMengajar::firstOrCreate(
            [
                'ustadz_id' => $ustadz->id,
                'kelas_id' => $kelasB->id,
                'hari' => 'Rabu',
            ],
            [
                'waktu_mulai' => '19:00:00',
                'waktu_selesai' => '20:30:00',
                'materi' => 'Tahfidz Juz 30',
                'aktif' => true,
            ]
        );
    }
}
