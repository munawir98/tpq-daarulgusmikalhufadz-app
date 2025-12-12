<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * ============================================================
 * IMPORT EVENTS
 * ============================================================
 */
use App\Events\PrivateMessageSent;
use App\Events\GroupMessageSent;
use App\Events\AkhlakCreated;
use App\Events\NilaiUjianCreated;
use App\Events\BroadcastCreated;
use App\Events\PresensiMasukUstadz;
use App\Events\PresensiPulangUstadz;

/**
 * ============================================================
 * IMPORT LISTENERS
 * ============================================================
 */
use App\Listeners\SendPrivateMessageNotification;
use App\Listeners\SendGroupMessageNotification;
use App\Listeners\SendAkhlakNotification;
use App\Listeners\SendNilaiUjianNotification;
use App\Listeners\SendBroadcastNotification;
use App\Listeners\SendPresensiMasukUstadzNotification;
use App\Listeners\SendPresensiPulangUstadzNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        /**
         * ======================================================
         * PRIVATE CHAT EVENTS
         * ======================================================
         */
        PrivateMessageSent::class => [
            SendPrivateMessageNotification::class,
        ],

        /**
         * ======================================================
         * GROUP CHAT EVENTS
         * ======================================================
         */
        GroupMessageSent::class => [
            SendGroupMessageNotification::class,
        ],

        /**
         * ======================================================
         * AKHLAK SANTRI EVENTS
         * ======================================================
         */
        AkhlakCreated::class => [
            SendAkhlakNotification::class,
        ],

        /**
         * ======================================================
         * NILAI UJIAN EVENTS
         * ======================================================
         */
        NilaiUjianCreated::class => [
            SendNilaiUjianNotification::class,
        ],

        /**
         * ======================================================
         * PRESENSI USTADZ EVENTS
         * ======================================================
         */
        PresensiMasukUstadz::class => [
            SendPresensiMasukUstadzNotification::class,
        ],

        PresensiPulangUstadz::class => [
            SendPresensiPulangUstadzNotification::class,
        ],

        /**
         * ======================================================
         * BROADCAST EVENTS
         * ======================================================
         */
        BroadcastCreated::class => [
            SendBroadcastNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
