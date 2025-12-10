<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupMessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'group_id'   => $this->group_id,

            'sender' => [
                'id'    => $this->sender->id ?? null,
                'name'  => $this->sender->name ?? null,
                'email' => $this->sender->email ?? null,
            ],

            'message' => $this->message,
            'type'    => $this->type, // text | image | info

            'image_url' => $this->image
                ? asset('storage/chat/group/' . $this->image)
                : null,

            'reads' => $this->reads->map(function ($read) {
                return [
                    'user_id' => $read->user_id,
                    'read_at' => $read->read_at,
                ];
            }),

            'created_at' => $this->created_at?->format("Y-m-d H:i"),
            'is_me'      => auth()->id() == $this->sender_id,
        ];
    }
}
