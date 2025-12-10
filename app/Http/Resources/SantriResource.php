<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SantriResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'nis'             => $this->nis,
            'nama_lengkap'    => $this->nama_lengkap,
            'nama_panggilan'  => $this->nama_panggilan,
            'jenis_kelamin'   => $this->jenis_kelamin,
            'tanggal_lahir'   => $this->tanggal_lahir,
            'tempat_lahir'    => $this->tempat_lahir,
            'alamat'          => $this->alamat,
            'nama_ayah'       => $this->nama_ayah,
            'nama_ibu'        => $this->nama_ibu,
            'no_hp_orang_tua' => $this->no_hp_orang_tua,
            'tanggal_masuk'   => $this->tanggal_masuk,
            'status_aktif'    => $this->status_aktif,

            // RELASI: KELAS
            'kelas' => $this->kelas ? [
                'id'   => $this->kelas->id,
                'nama' => $this->kelas->nama_kelas,
                'kode' => $this->kelas->kode_kelas,
            ] : null,

            // RELASI: KEHADIRAN
            'kehadiran' => $this->whenLoaded('kehadiran'),

            // RELASI: PROGRESS HAFALAN
            'progress_hafalan' => $this->whenLoaded('progressHafalan'),
        ];
    }
}
