<?php

namespace App\Events;

use App\Models\Broadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Data broadcast yang baru dibuat
     *
     * @var \App\Models\Broadcast
     */
    public Broadcast $broadcast;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Broadcast $broadcast
     */
    public function __construct(Broadcast $broadcast)
    {
        $this->broadcast = $broadcast;
    }
}
