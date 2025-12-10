<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewGroupMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $groupId;
    public $message;

    public function __construct($groupId, $message)
    {
        $this->groupId = $groupId;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('group-' . $this->groupId); // ✔ cocok untuk Flutter
    }

    public function broadcastAs()
    {
        return 'new-message'; // ✔ cocok untuk Flutter
    }
}

