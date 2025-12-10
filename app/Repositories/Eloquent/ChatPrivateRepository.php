<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Repositories\Contracts\ChatPrivateRepositoryInterface;

class ChatPrivateRepository implements ChatPrivateRepositoryInterface
{
    public function listMessages($userId, $otherUserId)
    {
        return Chat::where(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $otherUserId);
        })->orWhere(function ($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $otherUserId)
              ->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    }

    public function sendMessage(array $data)
    {
        return Chat::create($data);
    }

    public function markAsRead($senderId, $receiverId)
    {
        Chat::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->update(['is_read' => true]);
    }
}
