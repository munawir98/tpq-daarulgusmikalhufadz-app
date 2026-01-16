<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiSantri extends Model
{
    use HasFactory;

    protected $table = 'nilai_santri';

    protected $fillable = [
        'santri_id',
        'ustadz_id',
        'tahun_ajaran',
        'kategori',
        'tilawah',
        'hafalan',
        'adab',
        'tajwid',
        'catatan',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class); // Assuming Ustadz model exists and is linked to users table via ustadz_id or similar
    }
}
