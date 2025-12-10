<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KelasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'kode_kelas'    => $this->kode_kelas,
            'nama_kelas'    => $this->nama_kelas,
            'tipe'          => $this->tipe,
            'tingkat'       => $this->tingkat,
            'waktu_mulai'   => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'ustadz'        => $this->whenLoaded('ustadz'),
            'keterangan'    => $this->keterangan,
            'created_at'    => $this->created_at,
        ];
    }
}
