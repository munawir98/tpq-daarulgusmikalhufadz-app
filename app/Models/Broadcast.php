<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $table = 'broadcasts';

    protected $fillable = [
        'title',
        'message',
        'image',
        'sent_by',   // user_id admin yang mengirim broadcast
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
