<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Ustadz;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $ustadz = Ustadz::first();

        $kelas = [
            [
                'kode_kelas'   => 'TPQ-A',
                'nama_kelas'   => 'TPQ A',
                'tipe'         => 'TPQ',
                'tingkat'      => 'Dasar',
                'waktu_mulai'  => '16:00:00',
                'waktu_selesai'=> '17:30:00',
                'keterangan'   => 'Kelas dasar untuk pemula',
            ],
            [
                'kode_kelas'   => 'TPQ-B',
                'nama_kelas'   => 'TPQ B',
                'tipe'         => 'TPQ',
                'tingkat'      => 'Menengah',
                'waktu_mulai'  => '19:00:00',
                'waktu_selesai'=> '20:30:00',
                'keterangan'   => 'Kelas menengah',
            ],
        ];

        foreach ($kelas as $item) {
            Kelas::firstOrCreate(
                ['kode_kelas' => $item['kode_kelas']],
                array_merge($item, [
                    'ustadz_id' => $ustadz?->id,
                    'status'    => 'aktif',
                ])
            );
        }
    }
}
