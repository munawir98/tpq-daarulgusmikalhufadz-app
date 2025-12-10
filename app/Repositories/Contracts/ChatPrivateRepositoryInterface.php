<?php

namespace App\Repositories\Contracts;

interface ChatPrivateRepositoryInterface
{
    public function listMessages($userId, $otherUserId);
    public function sendMessage(array $data);
    public function markAsRead($senderId, $receiverId);
}
