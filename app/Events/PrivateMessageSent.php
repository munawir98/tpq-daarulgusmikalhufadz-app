<?php

namespace App\Events;

use App\Models\ChatPrivate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PrivateMessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatPrivate $message)
    {
        $this->message = $message->load('sender');
    }

    /**
     * Siapa yang menerima event? → receiver_id
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('private-chat.' . $this->message->receiver_id);
    }

    /**
     * Nama event untuk Flutter
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Data dikirim ke subscriber
     */
    public function broadcastWith(): array
    {
        return [
            'id'         => $this->message->id,
            'message'    => $this->message->message,
            'type'       => $this->message->type,
            'file_url'   => $this->message->file_path ? asset('storage/' . $this->message->file_path) : null,
            'sender'     => [
                'id'   => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ],
            'time'       => $this->message->created_at->format('H:i'),
        ];
    }
}
