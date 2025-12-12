<?php

namespace App\Listeners;

use App\Events\PresensiMasuk;
use App\Services\Fcm\FcmService;

class SendPresensiMasukNotification
{
    public function handle(PresensiMasuk $event)
    {
        $p = $event->presensi;

        $token = optional($p->santri->user->tokens->first())->fcm_token;
        if (!$token) return;

        $fcm = app(FcmService::class);

        $fcm->sendToToken(
            $token,
            "Presensi Masuk",
            "Anda telah tercatat masuk pada " . $p->jam_masuk,
            [
                "presensi_id" => $p->id
            ]
        );
    }
}
