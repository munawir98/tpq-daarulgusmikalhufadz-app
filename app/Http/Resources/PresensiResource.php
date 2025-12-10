<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PresensiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'tanggal'   => $this->tanggal,
            'jam'       => $this->jam,
            'tipe'      => $this->tipe,
            'foto'      => $this->foto,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'keterangan'=> $this->keterangan,
        ];
    }
}
