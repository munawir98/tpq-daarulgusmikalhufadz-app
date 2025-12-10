<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupMessageRequest;
use App\Http\Requests\GroupReadRequest;
use App\Http\Requests\TypingRequest;
use App\Http\Resources\GroupMessageResource;
use App\Models\GroupMessage;
use App\Models\GroupMessageRead;
use App\Events\GroupMessageSent;
use App\Events\TypingEvent;
use App\Helpers\ApiResponse;

class GroupMessageController extends Controller
{
    // ==========================================================
    // GET CHAT HISTORY
    // ==========================================================
    public function getMessages($groupId)
    {
        $messages = GroupMessage::where('group_id', $groupId)
            ->with(['sender', 'reads'])
            ->orderBy('created_at', 'asc')
            ->get();

        return ApiResponse::success(
            GroupMessageResource::collection($messages),
            "Daftar pesan ditemukan"
        );
    }

    // ==========================================================
    // SEND TEXT / IMAGE / AUDIO
    // ==========================================================
    public function send(GroupMessageRequest $request)
    {
        $imageName = null;

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = uniqid() . "." . $request->image->extension();
            $request->image->storeAs("chat/group", $imageName, "public");
        }

        // Simpan pesan
        $message = GroupMessage::create([
            'group_id'  => $request->group_id,
            'sender_id' => auth()->id(),
            'message'   => $request->message,
            'image'     => $imageName,
            'type'      => $request->type,
        ]);

        // Catat bahwa pengirim membaca pesannya sendiri
        GroupMessageRead::create([
            "group_message_id" => $message->id,
            "user_id"          => auth()->id(),
            "read_at"          => now(),
        ]);

        // BROADCAST
        broadcast(new GroupMessageSent($message))->toOthers();

        return ApiResponse::success(
            new GroupMessageResource($message->load('sender')),
            "Pesan berhasil dikirim"
        );
    }

    // ==========================================================
    // MARK ALL MESSAGES AS READ
    // ==========================================================
    public function markAsRead(Request $request)
{
    $request->validate([
        'message_id' => 'required|integer',
        'group_id'   => 'required|integer'
    ]);

    $userId = auth()->id();
    $messageId = $request->message_id;

    // === FIX WAJIB ===
    $this->groupMessageRepository->markAsRead([
        'message_id' => $messageId,
        'user_id'    => $userId
    ]);

    return ApiResponse::success(null, "Pesan sudah ditandai sebagai dibaca");
}


    // ==========================================================
    // TYPING EVENT
    // ==========================================================
    public function typing(TypingRequest $request)
    {
        broadcast(new TypingEvent(
            $request->group_id,
            auth()->id(),
            auth()->user()->name
        ))->toOthers();

        return ApiResponse::success(null, "Typing event dikirim");
    }
}
