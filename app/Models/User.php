<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ============================
// TRAIT CUSTOM
// ============================
use App\Traits\ActivityLogDefault;
use App\Traits\HasActivityLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use ActivityLogDefault, HasActivityLog;

    /**
     * ============================
     * TABLE
     * ============================
     */
    protected $table = 'users';

    /**
     * ============================
     * MASS ASSIGNMENT
     * ============================
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis',
        'no_hp',
        'alamat',
        'foto',
        'status',
        'last_login',
        'fcm_token',
        'instansi',
        'nip',
        'pembimbing_nip',

        // RELASI
        'kelas_id',
        'biometric_credential', // WebAuthn Credential ID
    ];

    /**
     * ============================
     * HIDDEN ATTRIBUTE
     * ============================
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ============================
     * CAST ATTRIBUTE
     * ============================
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'        => 'datetime',
        // Note: password hashing handled manually with Hash::make()
    ];

    /**
     * ============================
     * ACTIVITY LOG (SPATIE)
     * ============================
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
                $actor    = auth()->check()
                    ? auth()->user()->name
                    : 'Sistem';

                return match ($eventName) {
                    'created' => "{$actor} membuat akun user {$namaUser}",
                    'updated' => "{$actor} memperbarui akun user {$namaUser}",
                    'deleted' => "{$actor} menghapus akun user {$namaUser}",
                    default   => "{$actor} melakukan perubahan pada akun user {$namaUser}",
                };
            });
    }

    /**
     * ============================
     * RELASI
     * ============================
     */

    /**
     * 🔹 USER → KELAS
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * 🔹 USER → USTADZ
     */
    public function ustadz()
    {
        return $this->hasOne(Ustadz::class, 'user_id');
    }

    /**
     * 🔹 USER → SANTRI
     */
    public function santri()
    {
        return $this->hasOne(Santri::class, 'user_id');
    }

    /**
     * 🔑 USER → BIOMETRIC CREDENTIALS
     */
    public function biometricCredentials(): HasMany
    {
        return $this->hasMany(BiometricCredential::class);
    }

    /**
     * 🔔 USER → FCM TOKENS (MULTI DEVICE)
     */
    public function fcmTokens()
    {
        return $this->hasMany(UserToken::class, 'user_id');
    }

    /**
     * ============================
     * HELPER ROLE
     * ============================
     */
    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function isUstadz(): bool
    {
        return $this->role === 'USTADZ';
    }

    public function isSantri(): bool
    {
        return $this->role === 'SANTRI';
    }

    public function isWali(): bool
    {
        return $this->role === 'WALI';
    }

    /**
     * ============================
     * HELPER STATUS
     * ============================
     */
    public function isActive(): bool
    {
        return $this->status === 'AKTIF';
    }
}
