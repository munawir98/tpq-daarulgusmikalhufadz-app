<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class AkhlakSantriResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'santri' => [
                'id' => $this->santri->id,
                'nama' => $this->santri->nama,
            ],
            'disiplin' => $this->disiplin,
            'kerajinan' => $this->kerajinan,
            'kesopanan' => $this->kesopanan,
            'catatan' => $this->catatan,
            'tanggal_penilaian' => $this->tanggal_penilaian,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
