<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalMengajar extends Model
{
    protected $table = 'jadwal_mengajar';

    protected $fillable = [
        'ustadz_id',
        'kelas_id',
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'materi',
        'aktif',
    ];

    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(Ustadz::class, 'ustadz_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kehadiranSantri(): HasMany
    {
        return $this->hasMany(KehadiranSantri::class, 'jadwal_id');
    }
}
