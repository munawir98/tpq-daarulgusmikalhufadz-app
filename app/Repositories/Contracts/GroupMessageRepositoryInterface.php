<?php

namespace App\Repositories\Contracts;

interface GroupMessageRepositoryInterface {
    public function getMessages($groupId);
    public function sendMessage(array $data);
    public function sendImage(array $data);
    public function markAsRead(array $data);
}
