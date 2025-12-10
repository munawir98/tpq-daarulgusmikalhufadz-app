<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfaqResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'jumlah'     => $this->jumlah,
            'tanggal'    => $this->tanggal,
            'keterangan' => $this->keterangan,
        ];
    }
}
