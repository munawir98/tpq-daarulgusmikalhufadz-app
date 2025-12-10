<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajar extends Model
{
    use HasFactory;

    protected $table = 'ustadz'; // tabel asli di database

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'tanggal_mulai_mengajar',
        'status_aktif',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Presensi (menggunakan kolom pengajar_id)
     */
    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'pengajar_id');
    }

    /**
     * Relasi ke Jadwal Mengajar
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalMengajar::class, 'pengajar_id');
    }
}
