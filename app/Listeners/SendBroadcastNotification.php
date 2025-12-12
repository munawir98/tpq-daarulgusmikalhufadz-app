<?php

namespace App\Listeners;

use App\Events\BroadcastCreated;
use App\Models\UserToken;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBroadcastNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(BroadcastCreated $event): void
    {
        // Ambil data broadcast
        $broadcast = $event->broadcast;

        // Ambil semua token user (santri, ustadz, admin, wali santri)
        $tokens = UserToken::pluck('fcm_token')->toArray();

        if (empty($tokens)) {
            return;
        }

        // Kirim banyak FCM
        app(FcmService::class)->sendToMany(
            $tokens,
            $broadcast->title,
            $broadcast->message,
            [
                "id"    => $broadcast->id,
                "image" => $broadcast->image,
                "type"  => "broadcast"
            ]
        );
    }
}
