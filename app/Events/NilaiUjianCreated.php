<?php

namespace App\Events;

use App\Models\NilaiUjian;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NilaiUjianCreated
{
    use Dispatchable, SerializesModels;

    public NilaiUjian $nilai;

    public function __construct(NilaiUjian $nilai)
    {
        $this->nilai = $nilai;
    }
}
