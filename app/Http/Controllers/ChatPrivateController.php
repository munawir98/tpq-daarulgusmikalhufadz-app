<?php

namespace App\Http\Controllers;

use App\Models\ChatPrivate;
use App\Events\PrivateMessageCreated;
use App\Events\PrivateMessageSent;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class ChatPrivateController extends Controller
{
    /**
     * Kirim pesan private.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'sender_id'   => 'required|integer',
            'receiver_id' => 'required|integer',
            'message'     => 'nullable|string',
        ]);

        // Simpan pesan
        $message = ChatPrivate::create([
            'sender_id'   => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        // Event internal (non-broadcast)
        event(new PrivateMessageCreated($message));

        // Event broadcast ke Flutter (real-time via websocket)
        event(new PrivateMessageSent($message));

        return response()->json([
            'status'  => true,
            'message' => 'Message sent',
            'data'    => $message
        ]);
    }

    /**
     * Hitung jumlah pesan yang belum dibaca oleh user login.
     */
    public function unreadCount()
    {
        $count = ChatPrivate::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return ApiResponse::success([
            "unread" => $count
        ]);
    }

    public function setStatusChat(Request $request)
    {
        $request->validate([
            "chatting_with" => "nullable|integer"
        ]);

        // Simpan status chat user ke cache selama 2 menit
        cache()->put("chat_active_" . auth()->id(), $request->chatting_with, 120);

        return ApiResponse::success(null, "Status chat updated");
    }

    public function typing(Request $request)
{
    $request->validate([
        "to_user_id" => "required|exists:users,id",
        "is_typing"  => "required|boolean",
    ]);

    $from = auth()->id();

    // Simpan status di cache (lebih cepat dari DB)
    cache()->put("typing_{$from}_{$request->to_user_id}", $request->is_typing, 10);

    // Broadcast ke user tujuan
    broadcast(new \App\Events\PrivateTypingEvent(
        $from,
        $request->to_user_id,
        $request->is_typing
    ))->toOthers();

    return ApiResponse::success(null, "Typing updated");
}


}
