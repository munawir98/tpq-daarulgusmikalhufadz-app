<?php

namespace App\Listeners;

use App\Events\NilaiUjianCreated;
use App\Models\UserToken;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNilaiUjianNotification implements ShouldQueue
{
    public function handle(NilaiUjianCreated $event)
    {
        $nilai = $event->nilai;

        // Ambil token milik santri
        $tokens = $nilai->santri->user->tokens->pluck('fcm_token')->toArray();

        if (empty($tokens)) return;

        app(FcmService::class)->sendToMany(
            $tokens,
            "Nilai Ujian Baru",
            "Anda mendapatkan nilai ujian: {$nilai->nilai}",
            [
                "nilai_id" => $nilai->id,
                "jenis"    => $nilai->jenis_ujian,
                "type"     => "nilai_ujian"
            ]
        );
    }
}
