<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PengajarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nama' => $this->nama,
            'nik' => $this->nik,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tanggal_lahir' => $this->tanggal_lahir,
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
            'tanggal_mulai_mengajar' => $this->tanggal_mulai_mengajar,
            'status_aktif' => $this->status_aktif,
        ];
    }
}
