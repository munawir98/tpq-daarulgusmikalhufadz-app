<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ActivityLogVerification; // ← PENTING

class VerificationScan extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass-assignment
     */
    protected $fillable = [
        'activity_log_verification_id',
        'ip_address',
        'user_agent',
        'scanned_at',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    /**
     * Relasi:
     * VerificationScan BELONGS TO ActivityLogVerification
     */
    public function verification()
    {
        return $this->belongsTo(
            ActivityLogVerification::class,
            'activity_log_verification_id'
        );
    }

    /**
     * Scope: filter scan hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scanned_at', now()->toDateString());
    }
}
