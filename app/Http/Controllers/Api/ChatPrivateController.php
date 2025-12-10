<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatPrivateRequest;
use App\Models\ChatPrivate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ApiResponse;

class ChatPrivateController extends Controller
{
    /**
     * =========================================================
     * LIST CONVERSATIONS (Seperti WhatsApp)
     * =========================================================
     */
    public function list()
    {
        $userId = auth()->id();

        // Ambil daftar percakapan unik berdasarkan pasangan chat
        $chats = ChatPrivate::where('sender_id', $userId)
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
            $partner = User::find($partnerId);

            $unread = ChatPrivate::where('sender_id', $partnerId)
                ->where('receiver_id', $userId)
                ->whereNull('read_at')
                ->count();

            $data[] = [
                "user" => [
                    "id"    => $partner->id,
                    "name"  => $partner->name,
                    "foto"  => $partner->foto ? asset('storage/' . $partner->foto) : null,
                ],
                "last_message" => [
                    "type" => $last->type,
                    "message" => $last->message,
                    "time" => $last->created_at->format("H:i"),
                ],
                "unread" => $unread,
            ];
        }

        return ApiResponse::success($data, "Daftar percakapan ditemukan");
    }


    /**
     * =========================================================
     * GET CHAT DETAIL 1–1
     * =========================================================
     */
    public function chatWith($otherUserId)
    {
        $userId = auth()->id();

        $this->markAsReadUser($otherUserId); // otomatis read

        $messages = ChatPrivate::where(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $userId)->where('receiver_id', $otherUserId);
            })
            ->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($userId) {
                return [
                    "id"        => $msg->id,
                    "message"   => $msg->message,
                    "type"      => $msg->type,
                    "file_url"  => $msg->file_path ? asset('storage/' . $msg->file_path) : null,
                    "is_me"     => $msg->sender_id == $userId,
                    "time"      => $msg->created_at->format("H:i"),
                    "read_at"   => $msg->read_at
                ];
            });

        return ApiResponse::success($messages, "Riwayat chat ditemukan");
    }


    /**
     * =========================================================
     * SEND MESSAGE TEXT / IMAGE / AUDIO
     * =========================================================
     */
    public function send(ChatPrivateRequest $request)
    {
        $filePath = null;

        // Upload image
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('chat/private', 'public');
        }

        // Upload audio
        if ($request->hasFile('audio')) {
            $filePath = $request->file('audio')->store('chat/private/audio', 'public');
        }

        $msg = ChatPrivate::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'type'        => $request->type,
            'message'     => $request->message,
            'file_path'   => $filePath,
            'read_at'     => null,
        ]);

        // OPTIONAL → broadcast realtime
        // broadcast(new PrivateMessageSent($msg))->toOthers();

        return ApiResponse::success($msg, "Pesan terkirim");
    }


    /**
     * =========================================================
     * MARK MESSAGE AS READ FOR SPECIFIC USER
     * =========================================================
     */
    public function markAsReadUser($otherUserId)
    {
        ChatPrivate::where('sender_id', $otherUserId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update([
                "read_at" => now()
            ]);
    }


    /**
     * =========================================================
     * MARK MESSAGE AS READ (Manual Endpoint)
     * =========================================================
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            "sender_id" => "required|exists:users,id"
        ]);

        $this->markAsReadUser($request->sender_id);

        return ApiResponse::success(null, "Semua pesan ditandai telah dibaca");
    }
}
