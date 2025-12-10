<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = 'presensi';

    protected $fillable = [
        'user_id',
        'ustadz_id',
        'jadwal_id',
        'tanggal',
        'jam',
        'tipe',
        'foto',
        'latitude',
        'longitude',
        'status_presensi',
        'is_late',
        'qr_code',
        'metode',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class, 'ustadz_id');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalMengajar::class, 'jadwal_id');
    }
}
