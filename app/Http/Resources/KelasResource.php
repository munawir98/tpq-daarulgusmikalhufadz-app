<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return array_filter([
            'id'            => $this->id,
            'kode_kelas'    => $this->kode_kelas,
            'nama_kelas'    => $this->nama_kelas,
            'tipe'          => $this->tipe,
            'tingkat'       => $this->tingkat,
            'ustadz'        => $this->whenLoaded('ustadz'),
            'waktu_mulai'   => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'keterangan'    => $this->keterangan,
            'status'        => $this->status,
            'created_at'    => $this->created_at,
        ], fn ($value) => !is_null($value));
    }
}
