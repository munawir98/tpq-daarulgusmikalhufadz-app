<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gaji';

    protected $fillable = [
        'ustadz_id',
        'bulan',
        'tahun',
        'jumlah',
        'jumlah_kehadiran',
        'nominal_per_pertemuan', // nominal per pertemuan
        'jumlah',         // hasil perhitungan otomatis
        'keterangan'
    ];
}
