<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiUjian extends Model
{
    protected $table = 'nilai_ujian';

    protected $fillable = [
        'santri_id',
        'jenis_ujian',
        'nilai',
        'keterangan',
        'tanggal',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
