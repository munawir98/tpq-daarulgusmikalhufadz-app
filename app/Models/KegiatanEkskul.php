<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KegiatanEkskul extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_ekskul';

    protected $fillable = [
        'ustadz_id',
        'nama',
        'pelatih',
        'jumlah_peserta',
        'foto',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(Ustadz::class);
    }
}
