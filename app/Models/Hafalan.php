<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    protected $table = 'hafalan';

    protected $fillable = [
        'santri_id',
        'ustadz_id',
        'surah',
        'ayat_awal',
        'ayat_akhir',
        'nilai',
        'catatan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke Santri (User)
     */
    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    /**
     * Relasi ke Ustadz (User)
     */
    public function ustadz()
    {
        return $this->belongsTo(User::class, 'ustadz_id');
    }
}
