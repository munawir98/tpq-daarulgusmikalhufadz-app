<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PrivateTypingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $senderId;
    public $receiverId;
    public $isTyping;

    public function __construct($senderId, $receiverId, $isTyping)
    {
        $this->senderId   = $senderId;     // yg mengetik
        $this->receiverId = $receiverId;   // yg menerima typing
        $this->isTyping   = $isTyping;     // true/false
    }

    /**
     * PRIVATE CHANNEL → private-chat.{receiverId}
     */
    public function broadcastOn()
    {
        return new PrivateChannel('private-chat.' . $this->receiverId);
    }

    /**
     * Event name untuk client
     */
    public function broadcastAs()
    {
        return 'typing';
    }

    /**
     * Data yang dikirim ke Flutter
     */
    public function broadcastWith(): array
    {
        return [
            'sender_id' => $this->senderId,
            'is_typing' => (bool) $this->isTyping
        ];
    }
}
