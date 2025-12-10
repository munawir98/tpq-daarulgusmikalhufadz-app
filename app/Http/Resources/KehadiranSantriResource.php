<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KehadiranSantriResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'santri'      => $this->whenLoaded('santri'),
            'ustadz'      => $this->whenLoaded('ustadz'),
            'jadwal'      => $this->whenLoaded('jadwal'),
            'tanggal'     => $this->tanggal,
            'waktu_absen' => $this->waktu_absen,
            'status'      => $this->status,
            'catatan'     => $this->catatan,
        ];
    }
}
