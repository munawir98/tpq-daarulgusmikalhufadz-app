<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelas extends Model
{
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
        'status',
    ];

    /**
     * Local scope: hanya kelas aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function ustadz(): BelongsTo
    {
        return $this->belongsTo(Ustadz::class, 'ustadz_id');
    }

    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'kelas_id');
    }
}
