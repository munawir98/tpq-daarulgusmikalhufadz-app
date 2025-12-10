<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ActivityLogDefault;
use Spatie\Activitylog\LogOptions;
use App\Traits\HasActivityLog;


class Ustadz extends Model
{
    use ActivityLogDefault;
    use HasActivityLog;


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

    /**
     * 🔥 Dynamic Activity Log:
     * - Memakai nama ustadz
     * - Menampilkan siapa yang melakukan aksi (causer)
     * - Menampilkan perubahan detail (before-after)
     * - Hanya field yang berubah (logOnlyDirty)
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()            // log semua kolom
            ->logOnlyDirty()      // hanya log yang berubah
            ->dontSubmitEmptyLogs()
            ->useLogName('ustadz') // kategori log
            ->setDescriptionForEvent(function (string $eventName) {

                // Nama ustadz
                $namaUstadz = $this->nama ?? 'Ustadz';

                // User yang melakukan aksi
                $user = auth()->user();
                $namaUser = $user ? ($user->name ?? 'User') : 'Sistem';

                // Deskripsi berdasarkan event
                $action = match ($eventName) {
                    'created' => "menambahkan data ustadz {$namaUstadz}",
                    'updated' => "memperbarui data ustadz {$namaUstadz}",
                    'deleted' => "menghapus data ustadz {$namaUstadz}",
                    default => "melakukan perubahan pada data ustadz {$namaUstadz}",
                };

                return "{$namaUser} {$action}";
            });
    }

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Ustadz mengajar banyak kelas
     */
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'ustadz_id');
    }

    /**
     * Relasi: Ustadz memiliki banyak jadwal mengajar
     */
    public function jadwalMengajar(): HasMany
    {
        return $this->hasMany(JadwalMengajar::class, 'ustadz_id');
    }
}
