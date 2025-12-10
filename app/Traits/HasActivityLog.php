<?php

namespace App\Traits;

use Spatie\Activitylog\Models\Activity;

trait HasActivityLog
{
    /**
     * Log aktivitas khusus user.
     * Contoh:
     * $user->logActivity("Login ke sistem");
     * $user->logActivity("Mengubah profil");
     */
    public function logActivity(string $message, array $properties = []): Activity
    {
        return activity()
            ->causedBy($this)
            ->performedOn($this)
            ->withProperties($properties)
            ->event('custom')
            ->log($message);
    }

    /**
     * Log login user.
     */
    public function logLogin(): Activity
    {
        return $this->logActivity("User {$this->name} melakukan login", [
            'ip' => request()->ip(),
            'agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log logout user.
     */
    public function logLogout(): Activity
    {
        return $this->logActivity("User {$this->name} melakukan logout", [
            'ip' => request()->ip(),
            'agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log perubahan password.
     */
    public function logPasswordChange(): Activity
    {
        return $this->logActivity("User {$this->name} mengganti password");
    }

    /**
     * Log update profil user.
     */
    public function logProfileUpdate(array $changes): Activity
    {
        return $this->logActivity("User {$this->name} memperbarui profil", [
            'changes' => $changes,
        ]);
    }

    /**
     * Log akses menu tertentu.
     * Bisa dipakai untuk monitoring admin.
     */
    public function logAccess(string $menuName): Activity
    {
        return $this->logActivity("User {$this->name} mengakses menu: {$menuName}");
    }
}
