<?php

namespace App\Listeners;

use App\Events\PresensiMasukUstadz;
use App\Models\UserToken;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPresensiMasukUstadzNotification implements ShouldQueue
{
    public function handle(PresensiMasukUstadz $event)
    {
        $presensi = $event->presensi;

        // Token milik admin
        $tokens = UserToken::whereHas('user', function ($q) {
            $q->where('role', 'ADMIN');
        })->pluck('fcm_token')->toArray();

        if (empty($tokens)) return;

        app(FcmService::class)->sendToMany(
            $tokens,
            "Presensi Ustadz",
            "{$presensi->ustadz->nama} telah melakukan presensi masuk",
            [
                "presensi_id" => $presensi->id,
                "type"        => "presensi_masuk"
            ]
        );
    }
}
