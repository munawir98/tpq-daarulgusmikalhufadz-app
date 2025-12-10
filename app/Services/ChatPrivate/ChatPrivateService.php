<?php

namespace App\Services\ChatPrivate;

use App\Repositories\Contracts\ChatPrivateRepositoryInterface;
use App\Helpers\ApiResponse;

class ChatPrivateService
{
    protected $repo;

    public function __construct(ChatPrivateRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list($userId, $otherUserId)
    {
        return ApiResponse::success(
            $this->repo->listMessages($userId, $otherUserId),
            "Chat berhasil diambil"
        );
    }

    public function send($data)
    {
        return ApiResponse::success(
            $this->repo->sendMessage($data),
            "Pesan berhasil dikirim"
        );
    }

    public function markRead($senderId, $receiverId)
    {
        $this->repo->markAsRead($senderId, $receiverId);

        return ApiResponse::success(null, "Pesan dibaca");
    }
}
