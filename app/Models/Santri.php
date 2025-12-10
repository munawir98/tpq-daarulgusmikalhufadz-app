<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ActivityLogDefault;
use Spatie\Activitylog\LogOptions;

class Santri extends Model
{
    use ActivityLogDefault;

    protected $table = 'santri';

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
     * 🔥 Activity Log dengan nama santri + causer + before-after
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('santri')
            ->setDescriptionForEvent(function (string $eventName) {

                $nama = $this->nama_lengkap ?? 'Santri';
                $user = auth()->user();
                $actor = $user ? ($user->name ?? 'User') : 'Sistem';

                return match ($eventName) {
                    'created' => "{$actor} menambahkan data santri {$nama}",
                    'updated' => "{$actor} memperbarui data santri {$nama}",
                    'deleted' => "{$actor} menghapus data santri {$nama}",
                    default => "{$actor} melakukan perubahan pada data santri {$nama}",
                };
            });
    }

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
}
