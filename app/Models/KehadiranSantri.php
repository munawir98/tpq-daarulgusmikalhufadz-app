<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KehadiranSantri extends Model
{
    protected $table = 'kehadiran_santri';

    protected $fillable = [
        'santri_id',
        'jadwal_id',
        'ustadz_id',
        'user_id',
        'tanggal',
        'waktu_absen',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(JadwalMengajar::class, 'jadwal_id');
    }

    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(Ustadz::class, 'ustadz_id');
    }
}
