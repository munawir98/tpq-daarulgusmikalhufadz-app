<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AkhlakSantri;

class AkhlakSantriSeeder extends Seeder
{
    public function run(): void
    {
        AkhlakSantri::create([
            'santri_id' => 1,
            'disiplin' => 4,
            'kerajinan' => 5,
            'kesopanan' => 4,
            'catatan' => 'Sangat rajin dan sopan.',
            'tanggal_penilaian' => now()->toDateString(),
        ]);
    }
}
