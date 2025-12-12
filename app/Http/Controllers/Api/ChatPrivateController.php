<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatPrivateRequest;
use App\Models\ChatPrivate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Events\PrivateMessageCreated;
use App\Events\PrivateMessageSent;

class ChatPrivateController extends Controller
{
    /**
     * =========================================================
     * LIST CONVERSATIONS (Like WhatsApp)
     * =========================================================
     */
    public function list()
    {
        $userId = auth()->id();

        $chats = ChatPrivate::with(['sender.profile', 'receiver.profile'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get()
            ->groupBy(function ($chat) use ($userId) {
                return $chat->sender_id == $userId
                    ? $chat->receiver_id
                    : $chat->sender_id;
            });

        $data = [];

        foreach ($chats as $partnerId => $messages) {
            $last = $messages->first();
            $partner = User::with('profile')->find($partnerId);

            $unread = ChatPrivate::where('sender_id', $partnerId)
                ->where('receiver_id', $userId)
                ->whereNull('read_at')
                ->count();

            $data[] = [
                "user" => [
                    "id"    => $partner->id,
                    "name"  => $partner->name,
                    "foto"  => optional($partner->profile)->photo_url,
                ],
                "last_message" => [
                    "type"    => $last->type,
                    "message" => $last->message,
                    "time"    => $last->created_at->format("H:i"),
                ],
                "unread" => $unread,
            ];
        }

        return ApiResponse::success($data, "Daftar percakapan ditemukan");
    }


    /**
     * =========================================================
     * GET CHAT 1–1
     * =========================================================
     */
    public function chatWith($otherUserId)
    {
        $userId = auth()->id();

        // Tandai pesan sudah dibaca
        $this->markAsReadUser($otherUserId);

        $messages = ChatPrivate::where(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $otherUserId);
            })
            ->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)
                  ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($userId) {
                return [
                    "id"       => $msg->id,
                    "message"  => $msg->message,
                    "type"     => $msg->type,
                    "file_url" => $msg->file_path ? asset('storage/' . $msg->file_path) : null,
                    "is_me"    => $msg->sender_id == $userId,
                    "time"     => $msg->created_at->format("H:i"),
                    "read_at"  => $msg->read_at,
                ];
            });

        return ApiResponse::success($messages, "Riwayat chat ditemukan");
    }


    /**
     * =========================================================
     * SEND MESSAGE (Text, Image, Audio)
     * =========================================================
     */
    public function send(ChatPrivateRequest $request)
    {
        $filePath = null;

        if ($request->hasFile('file')) {
            $ext = strtolower($request->file('file')->getClientOriginalExtension());

            $folder = match (true) {
                in_array($ext, ['mp3', 'aac', 'm4a', 'wav']) => 'chat/private/audio',
                default => 'chat/private',
            };

            $filePath = $request->file('file')->store($folder, 'public');
        }

        $msg = ChatPrivate::create([
            "sender_id"   => auth()->id(),
            "receiver_id" => $request->receiver_id,
            "type"        => $request->type,
            "message"     => $request->message,
            "file_path"   => $filePath,
            "read_at"     => null,
        ]);

        // Event internal
        event(new PrivateMessageCreated($msg));

        // Event broadcast + listener FCM
        event(new PrivateMessageSent($msg));

        return ApiResponse::success($msg, "Pesan terkirim");
    }


    /**
     * =========================================================
     * MARK AS READ AUTO
     * =========================================================
     */
    public function markAsReadUser($otherUserId)
    {
        ChatPrivate::where('sender_id', $otherUserId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update([
                "read_at" => now(),
            ]);
    }


    /**
     * =========================================================
     * ENDPOINT MARK AS READ MANUAL
     * =========================================================
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            "sender_id" => "required|exists:users,id",
        ]);

        $this->markAsReadUser($request->sender_id);

        return ApiResponse::success(null, "Semua pesan ditandai telah dibaca");
    }
}
