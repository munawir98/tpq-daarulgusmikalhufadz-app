<?php

namespace App\Listeners;

use App\Events\PresensiPulang;
use App\Services\Fcm\FcmService;

class SendPresensiPulangNotification
{
    public function handle(PresensiPulang $event)
    {
        $p = $event->presensi;

        $token = optional($p->santri->user->tokens->first())->fcm_token;
        if (!$token) return;

        $fcm = app(FcmService::class);

        $fcm->sendToToken(
            $token,
            "Presensi Pulang",
            "Anda telah tercatat pulang pada " . $p->jam_pulang,
            [
                "presensi_id" => $p->id
            ]
        );
    }
}
