<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SantriListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'nis'      => $this->nis,
            'nama'     => $this->nama_lengkap,
            'kelas_id' => $this->kelas_id,
        ];
    }
}
