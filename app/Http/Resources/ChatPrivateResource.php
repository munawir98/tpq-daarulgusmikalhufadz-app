<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatPrivateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'sender_id'  => $this->sender_id,
            'receiver_id'=> $this->receiver_id,
            'message'    => $this->message,
            'type'       => $this->type,

            'file_url'   => $this->file_path
                ? asset('storage/' . $this->file_path)
                : null,

            'is_me'      => auth()->id() == $this->sender_id,
            'read_at'    => $this->read_at,
            'time'       => $this->created_at->format('H:i'),
            'date'       => $this->created_at->toDateString(),

            'sender' => [
                'id'    => $this->sender->id,
                'name'  => $this->sender->name,
                'foto'  => $this->sender->foto ? asset('storage/' . $this->sender->foto) : null,
            ]
        ];
    }
}
