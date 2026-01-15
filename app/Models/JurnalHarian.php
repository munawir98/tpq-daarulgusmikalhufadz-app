<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JurnalHarian extends Model
{
    use HasFactory;

    protected $table = 'jurnal_harian';

    protected $fillable = [
        'ustadz_id',
        'kelas_id',
        'tanggal',
        'judul',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(Ustadz::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
}
