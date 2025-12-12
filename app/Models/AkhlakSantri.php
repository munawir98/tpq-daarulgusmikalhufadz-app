<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AkhlakSantri extends Model
{
    protected $table = 'akhlak_santri';

    protected $fillable = [
        'santri_id',
        'disiplin',
        'kerajinan',
        'kesopanan',
        'catatan',
        'tanggal_penilaian',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
