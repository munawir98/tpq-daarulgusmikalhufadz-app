<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgressHafalanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'santri_id'     => $this->santri_id,
            'ustadz_id'     => $this->ustadz_id,
            'juz'           => $this->juz,
            'halaman'       => $this->halaman,
            'ayat_mulai'    => $this->ayat_mulai,
            'ayat_selesai'  => $this->ayat_selesai,
            'tanggal'       => $this->tanggal,
            'nilai'         => $this->nilai,
            'status'        => $this->status,
            'keterangan'    => $this->keterangan,
        ];
    }
}
