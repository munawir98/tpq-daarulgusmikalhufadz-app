<?php

namespace App\Listeners;

use App\Events\PresensiPulangUstadz;
use App\Models\UserToken;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPresensiPulangUstadzNotification implements ShouldQueue
{
    public function handle(PresensiPulangUstadz $event)
    {
        $presensi = $event->presensi;

        $tokens = UserToken::whereHas('user', function ($q) {
            $q->where('role', 'ADMIN');
        })->pluck('fcm_token')->toArray();

        if (empty($tokens)) return;

        app(FcmService::class)->sendToMany(
            $tokens,
            "Presensi Ustadz",
            "{$presensi->ustadz->nama} telah melakukan presensi pulang",
            [
                "presensi_id" => $presensi->id,
                "type"        => "presensi_pulang"
            ]
        );
    }
}
