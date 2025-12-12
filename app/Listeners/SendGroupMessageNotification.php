<?php

namespace App\Listeners;

use App\Events\GroupMessageSent;
use App\Services\Fcm\FcmService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendGroupMessageNotification implements ShouldQueue
{
    public function handle(GroupMessageSent $event): void
    {
        $msg        = $event->message;
        $group      = $msg->group;
        $recipients = $group->members;

        $fcm     = app(FcmService::class);
        $avatar  = optional($msg->sender->profile)->photo_url;
        $text    = strtolower($msg->message);

        /**
         * ================================================================
         * 1. DETEKSI MENTION BERDASARKAN ID (@id:17)
         * ================================================================
         */
        preg_match_all('/@id:([0-9]+)/', $text, $idMatches);
        $mentionedById = collect($idMatches[1] ?? [])
            ->map(fn($id) => $recipients->firstWhere('id', $id))
            ->filter();

        /**
         * ================================================================
         * 2. DETEKSI MENTION USERNAME (@ustadz_ahmad)
         * ================================================================
         */
        preg_match_all('/@([a-z0-9_]+)/', $text, $userMatches);
        $mentionedByUsername = collect($userMatches[1] ?? [])
            ->map(fn($username) => $recipients->firstWhere('username', $username))
            ->filter();

        /**
         * ================================================================
         * 3. DETEKSI MENTION NAMA LENGKAP (@Ustadz Ahmad)
         * ================================================================
         */
        $mentionedByName = $recipients->filter(function ($user) use ($text) {
            return str_contains($text, '@' . strtolower($user->name));
        });

        /**
         * ================================================================
         * 4. GABUNG SEMUA MENTION (Unique)
         * ================================================================
         */
        $mentionedUsers = $mentionedById
            ->merge($mentionedByUsername)
            ->merge($mentionedByName)
            ->unique('id');

        /**
         * ================================================================
         * 5. NOTIFIKASI UNTUK USER YANG DI-MENTION
         * ================================================================
         */
        foreach ($mentionedUsers as $user) {

            if ($user->id == $msg->sender_id) continue;

            $token = optional($user->tokens->first())->fcm_token;
            if (!$token) continue;

            $fcm->sendToToken(
                $token,
                "Anda disebut di Grup " . $group->name,
                $msg->sender->name . ": " . $msg->message,
                [
                    "group_id"     => $msg->group_id,
                    "mentioned"    => true,
                    "avatar"       => $avatar,
                    "type"         => "group_chat",
                    "collapse_key" => "group_{$msg->group_id}"
                ]
            );
        }

        /**
         * ================================================================
         * 6. NOTIFIKASI UNTUK ANGGOTA LAIN (non-mention)
         * ================================================================
         */
        foreach ($recipients as $user) {

            if ($user->id == $msg->sender_id) continue;
            if ($mentionedUsers->contains('id', $user->id)) continue;

            $token = optional($user->tokens->first())->fcm_token;
            if (!$token) continue;

            $fcm->sendToToken(
                $token,
                "Pesan Baru di Grup " . $group->name,
                $msg->sender->name . ": " . $msg->message,
                [
                    "group_id"     => $msg->group_id,
                    "avatar"       => $avatar,
                    "type"         => "group_chat",
                    "collapse_key" => "group_{$msg->group_id}"
                ]
            );
        }
    }
}
