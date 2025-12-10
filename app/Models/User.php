<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ActivityLogDefault;
use App\Traits\HasActivityLog;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use ActivityLogDefault;
    use HasActivityLog; // jika Anda memang sudah membuat trait ini

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'foto',
        'status',
        'last_login',
        'fcm_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'        => 'datetime',
    ];

    /**
     * 🔥 Custom Activity Log User
     * - Dynamic name
     * - Actor (siapa yang melakukan aksi)
     * - Before-after log
     * - logOnlyDirty
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('user')
            ->setDescriptionForEvent(function (string $eventName) {

                $namaUser = $this->name ?? 'User';
                $actor = auth()->user()->name ?? 'Sistem';

                return match ($eventName) {
                    'created' => "{$actor} membuat akun user {$namaUser}",
                    'updated' => "{$actor} memperbarui akun user {$namaUser}",
                    'deleted' => "{$actor} menghapus akun user {$namaUser}",
                    default => "{$actor} melakukan perubahan pada akun user {$namaUser}",
                };
            });
    }

    // ============================
    // RELASI USER
    // ============================

    public function ustadz()
    {
        return $this->hasOne(Ustadz::class, 'user_id');
    }

    public function santri()
    {
        return $this->hasOne(Santri::class, 'user_id');
    }

    // ============================
    // HELPER ROLE
    // ============================

    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    public function isUstadz()
    {
        return $this->role === 'USTADZ';
    }

    public function isSantri()
    {
        return $this->role === 'SANTRI';
    }

    public function isWaliSantri()
    {
        return $this->role === 'WALI SANTRI';
    }
}
