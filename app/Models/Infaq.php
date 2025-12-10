<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    protected $table = 'infaq'; // karena tabel kamu bernama 'infaq'

    protected $fillable = [
        'santri_id',
        'jumlah',
        'tanggal',
        'keterangan',
    ];

    /**
     * Relasi ke tabel santri
     * Setiap infaq dimiliki oleh satu santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
