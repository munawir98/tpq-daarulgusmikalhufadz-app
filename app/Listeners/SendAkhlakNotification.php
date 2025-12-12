<?php

namespace App\Listeners;

use App\Events\AkhlakCreated;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAkhlakNotification implements ShouldQueue
{
    public function handle(AkhlakCreated $event)
    {
        $akhlak = $event->akhlak;

        // Ambil FCM token santri
        $token = optional($akhlak->santri->user->tokens->first())->fcm_token;

        if (!$token) {
            return;
        }

        // Kirim FCM
        app(FcmService::class)->sendToToken(
            $token,
            "Penilaian Akhlak Baru",
            "Penilaian akhlak Anda telah ditambahkan.",
            [
                "akhlak_id"        => $akhlak->id,
                "santri_id"        => $akhlak->santri_id,
                "disiplin"         => $akhlak->disiplin,
                "kerajinan"        => $akhlak->kerajinan,
                "kesopanan"        => $akhlak->kesopanan,
                "tanggal_penilaian"=> $akhlak->tanggal_penilaian,
                "type"             => "akhlak"
            ]
        );
    }
}
