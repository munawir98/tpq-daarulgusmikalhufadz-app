<?php

namespace App\Events;

use App\Models\AkhlakSantri;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AkhlakCreated
{
    use Dispatchable, SerializesModels;

    public AkhlakSantri $akhlak;

    public function __construct(AkhlakSantri $akhlak)
    {
        $this->akhlak = $akhlak;
    }
}
