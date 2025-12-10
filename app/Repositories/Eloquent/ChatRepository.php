<?php

namespace App\Repositories\Eloquent;

use App\Models\Chat;
use App\Repositories\Contracts\ChatRepositoryInterface;

class ChatRepository implements ChatRepositoryInterface
{
    public function all()
    {
        return Chat::all();
    }

    public function find($id)
    {
        return Chat::findOrFail($id);
    }

    public function create(array $data)
    {
        return Chat::create($data);
    }

    public function update($id, array $data)
    {
        $chat = Chat::findOrFail($id);
        $chat->update($data);

        return $chat;
    }

    public function delete($id)
    {
        $chat = Chat::findOrFail($id);
        return $chat->delete();
    }

    // Tambahan method khusus untuk private chat
    public function send($data)
    {
        return Chat::create($data);
    }
}
