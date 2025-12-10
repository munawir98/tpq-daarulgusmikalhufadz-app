<?php

namespace App\Repositories\Eloquent;

use App\Models\GroupMessage;
use App\Repositories\Contracts\GroupMessageRepositoryInterface;

class GroupMessageRepository implements GroupMessageRepositoryInterface
{
    public function getMessages($groupId)
    {
        return GroupMessage::where('group_id', $groupId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function sendMessage($data)
    {
        return GroupMessage::create($data);
    }

    public function sendImage(array $data)
{
    // Simpan pesan gambar (image upload sudah dilakukan di controller)
    return GroupMessage::create([
        'group_id'  => $data['group_id'],
        'user_id'   => $data['user_id'],
        'message'   => $data['message'] ?? null,
        'file_path' => $data['file_path'], // wajib sudah di-upload
        'type'      => 'image',
    ]);
}


   public function markAsRead(array $data)
{
    $messageId = $data['message_id'];
    $userId    = $data['user_id'];

    $message = GroupMessage::find($messageId);
    if (!$message) {
        return null;
    }

    // Tabel pivot read receipts (group_message_reads)
    return $message->reads()->updateOrCreate(
        ['user_id' => $userId],
        ['read_at' => now()]
    );
}


}
