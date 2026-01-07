<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use App\Traits\ActivityLogDefault;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\KehadiranSantri;
use App\Models\ProgressHafalan;

class Santri extends Model
{
    use ActivityLogDefault;

    protected $table = 'santri';

    /**
     * =========================
     * MASS ASSIGNMENT
     * =========================
     */
    protected $fillable = [
        'nis',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'nama_ayah',
        'nama_ibu',
        'no_hp_orang_tua',
        'tanggal_masuk',
        'status_aktif',
        'kelas_id',
        'user_id',
    ];

    /**
     * =========================
     * CASTING
     * =========================
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'status_aktif'  => 'boolean',
    ];

    /**
     * =========================
     * LOCAL SCOPES
     * =========================
     * ❗ TIDAK pakai Global Scope
     * Supaya tidak menjebak query & resource
     */
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function scopeNonAktif($query)
    {
        return $query->where('status_aktif', false);
    }

    /**
     * =========================
     * ACTIVITY LOG (SPATIE)
     * =========================
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('santri')
            ->setDescriptionForEvent(function (string $eventName) {

                $nama  = $this->nama_lengkap ?? 'Santri';
                $user  = auth()->user();
                $actor = $user?->name ?? 'Sistem';

                return match ($eventName) {
                    'created' => "{$actor} menambahkan data santri {$nama}",
                    'updated' => "{$actor} memperbarui data santri {$nama}",
                    'deleted' => "{$actor} menonaktifkan santri {$nama}",
                    default   => "{$actor} melakukan perubahan pada data santri {$nama}",
                };
            });
    }

    /**
     * =========================
     * RELATIONS
     * =========================
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(KehadiranSantri::class, 'santri_id');
    }

    public function progressHafalan(): HasMany
    {
        return $this->hasMany(ProgressHafalan::class, 'santri_id');
    }

    /**
     * Presensi berdasarkan user_id
     */
    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class, 'user_id', 'user_id');
    }
}
