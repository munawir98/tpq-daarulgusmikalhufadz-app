<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasActivityLog;


class Kelas extends Model
{
    use HasActivityLog;
    protected $table = 'kelas';

    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'tipe',
        'tingkat',
        'waktu_mulai',
        'waktu_selesai',
        'ustadz_id',
        'keterangan',
    ];

    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(Ustadz::class, 'ustadz_id');
    }

    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'kelas_id');
    }

    public function jadwalMengajar(): HasMany
    {
        return $this->hasMany(JadwalMengajar::class, 'kelas_id');
    }
}
