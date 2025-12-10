<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMessageRead;

class GroupMessage extends Model
{
    protected $fillable = [
        'group_id',
        'sender_id',
        'message',
        'type',
        'image'
    ];

    // ============================================
    // RELATION: PENGIRIM PESAN
    // ============================================
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // ============================================
    // RELATION: GRUP
    // ============================================
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // ============================================
    // RELATION: SIAPA SAJA YANG SUDAH MEMBACA
    // ============================================
    public function reads()
    {
        return $this->hasMany(GroupMessageRead::class, 'group_message_id');
    }

    // ============================================
    // CEK APAKAH USER SUDAH MEMBACA PESAN INI
    // ============================================
    public function isReadBy($userId)
    {
        return $this->reads()->where('user_id', $userId)->exists();
    }
}
