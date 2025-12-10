<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_id');
    }

    public function messages()
    {
        return $this->hasMany(GroupMessage::class, 'group_id');
    }

    // ======================================
    // LAST MESSAGE (WAJIB latestOfMany)
    // ======================================
    public function latestMessage()
    {
        return $this->hasOne(GroupMessage::class, 'group_id')->latestOfMany();
    }

    // ======================================
    // UNREAD COUNT (pesan belum dibaca)
    // ======================================
    public function unreadCount($userId)
    {
        return $this->messages()
            ->where(function ($q) use ($userId) {
                $q->whereNull('read_by')
                  ->orWhereRaw("JSON_CONTAINS(read_by, '\"$userId\"') = 0");
            })
            ->count();
    }
}
