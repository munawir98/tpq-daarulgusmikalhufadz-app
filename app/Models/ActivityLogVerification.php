<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogVerification extends Model
{
    use HasFactory;

    protected $table = 'activity_log_verifications';

    /**
     * Kolom yang boleh diisi mass-assignment
     */
    protected $fillable = [
        'hash',
        'document_number',
        'file_name',
        'generated_by',
        'generated_at',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'generated_at' => 'datetime',
    ];

    /**
     * User yang meng-generate dokumen
     */
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Riwayat scan QR dokumen
     */
    public function scans()
    {
        return $this->hasMany(VerificationScan::class);
    }

    /**
     * Helper: total scan
     */
    public function getScanCountAttribute()
    {
        return $this->scans()->count();
    }
}
