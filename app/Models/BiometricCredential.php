<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiometricCredential extends Model
{
    protected $table = 'biometric_credentials';

    protected $fillable = [
        'user_id',
        'credential_id',
        'name',
        'public_key',
        'sign_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
