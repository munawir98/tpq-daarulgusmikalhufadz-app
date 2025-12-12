<?php

namespace App\Events;

use App\Models\ChatPrivate;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateMessageCreated
{
    use Dispatchable, SerializesModels;

    public ChatPrivate $message;

    public function __construct(ChatPrivate $message)
    {
        $this->message = $message;
    }
}
