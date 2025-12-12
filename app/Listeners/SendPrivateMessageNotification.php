<?php

namespace App\Listeners;

use App\Events\PrivateMessageSent;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPrivateMessageNotification implements ShouldQueue
{
    public function handle(PrivateMessageSent $event): void
    {
        $msg = $event->message;

        // Cek apakah receiver sedang membuka chat ini
        $activeChat = cache()->get("chat_active_" . $msg->receiver_id);

        if ($activeChat == $msg->sender_id) {
            // Penerima sedang aktif membuka chat dengan pengirim → tidak kirim FCM
            return;
        }

        // Ambil FCM token penerima
        $token = optional($msg->receiver->user->tokens->first())->fcm_token;
        if (!$token) return;

        // Hitung jumlah pesan belum dibaca
        $unreadCount = \App\Models\ChatPrivate::where('receiver_id', $msg->receiver_id)
            ->whereNull('read_at')
            ->count();

        // FCM Service
        $fcm = app(FcmService::class);

        // Kirim push notification
        $fcm->sendToToken(
        $token,
        "Pesan Baru dari " . $msg->sender->name,
        $msg->message,
        [
            "chat_id"     => $msg->id,
            "sender_id"   => $msg->sender_id,
            "receiver_id" => $msg->receiver_id,
            "badge"       => $unreadCount,
            "avatar"      => $avatar,
            "type"        => "private_chat",
            "collapse_key" => "private_{$msg->sender_id}"
        ]
    );


    }
}
