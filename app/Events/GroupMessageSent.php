<?php

namespace App\Events;

use App\Http\Resources\GroupMessageResource;
use App\Models\GroupMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class GroupMessageSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public GroupMessage $message;

    public function __construct(GroupMessage $message)
    {
        $this->message = $message->load('sender', 'reads');
    }

    public function broadcastOn()
    {
        return new Channel('group.' . $this->message->group_id);
    }

    public function broadcastAs()
    {
        return 'group.message.sent';
    }

    public function broadcastWith()
    {
        return (new GroupMessageResource($this->message))->toArray(request());
    }
}
