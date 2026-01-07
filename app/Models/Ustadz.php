<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use App\Traits\ActivityLogDefault;
use App\Traits\HasActivityLog;

class Ustadz extends Model
{
    use ActivityLogDefault, HasActivityLog;

    protected $table = 'ustadz';

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

    /*
    |--------------------------------------------------------------------------
    | GLOBAL SCOPE
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::addGlobalScope('aktif', function ($query) {
            $query->where('status_aktif', true);
        });
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVITY LOG
    |--------------------------------------------------------------------------
    */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('ustadz')
            ->setDescriptionForEvent(function (string $eventName) {

                $nama = $this->nama ?? 'Ustadz';
                $user = auth()->user();
                $namaUser = $user?->name ?? 'Sistem';

                return match ($eventName) {
                    'created' => "{$namaUser} menambahkan ustadz {$nama}",
                    'updated' => "{$namaUser} memperbarui data ustadz {$nama}",
                    'deleted' => "{$namaUser} menonaktifkan ustadz {$nama}",
                    default   => "{$namaUser} melakukan aksi pada ustadz {$nama}",
                };
            });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS (N+1 SAFE)
    |--------------------------------------------------------------------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'ustadz_id')
            ->select(['id', 'ustadz_id', 'nama_kelas', 'tingkat', 'status']);
    }

    public function jadwalMengajar(): HasMany
    {
        return $this->hasMany(JadwalMengajar::class, 'ustadz_id');
    }
}
