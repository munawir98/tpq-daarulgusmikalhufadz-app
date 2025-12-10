<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class ChatController extends Controller
{
    /**
     * GET /api/chat
     * List conversation (terakhir chat per user)
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Ambil semua pesan yang melibatkan user
        $messages = Chat::with('sender:id,name', 'receiver:id,name')
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($messages->isEmpty()) {
            return ApiResponse::error("Belum ada percakapan", 404);
        }

        // Group percakapan berdasarkan user lawan
        $conversations = $messages->groupBy(function ($msg) use ($userId) {
            return $msg->sender_id == $userId ? $msg->receiver_id : $msg->sender_id;
        });

        // Format untuk Flutter
        $result = $conversations->map(function ($msgs, $otherUserId) use ($userId) {

            $last = $msgs->first(); // pesan terbaru

            return [
                "user_id"       => (int) $otherUserId,
                "user_name"     => $last->sender_id == $otherUserId
                    ? $last->sender->name
                    : $last->receiver->name,

                "last_message"  => $last->message,
                "type"          => $last->type,
                "time"          => $last->created_at->format("H:i"),

                "unread"        => $msgs->whereNull('read_at')
                                         ->where('receiver_id', $userId)
                                         ->count()
            ];
        })->values();

        return ApiResponse::success($result, "Daftar percakapan ditemukan");
    }

    /**
     * Kirim pesan private
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required|string',
            'type'        => 'nullable|string|in:text,image,audio'
        ]);

        $chat = Chat::create([
            'sender_id'   => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
            'type'        => $request->type ?? 'text'
        ]);

        return ApiResponse::success($chat, "Pesan berhasil dikirim");
    }
}
