<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    protected $table = 'setoran';

    protected $fillable = [
    'santri_id',
    'ustadz_id',
    'juz',
    'halaman',
    'ayat_mulai',
    'ayat_selesai',
    'tanggal',
    'nilai',
    'status',
    'keterangan',
];

}
