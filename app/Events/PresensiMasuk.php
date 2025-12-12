<?php

namespace App\Events;

use App\Models\Presensi;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PresensiMasuk
{
    use Dispatchable, SerializesModels;

    public Presensi $presensi;

    public function __construct(Presensi $presensi)
    {
        $this->presensi = $presensi;
    }
}
