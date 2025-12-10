<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JadwalMengajarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'ustadz'        => $this->whenLoaded('ustadz'),
            'kelas'         => $this->whenLoaded('kelas'),
            'hari'          => $this->hari,
            'waktu_mulai'   => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'materi'        => $this->materi,
            'aktif'         => $this->aktif,
        ];
    }
}
