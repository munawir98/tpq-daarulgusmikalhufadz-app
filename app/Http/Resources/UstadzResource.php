<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UstadzResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'user_id'                => $this->user_id,
            'nama'                   => $this->nama,
            'nik'                    => $this->nik,
            'jenis_kelamin'          => $this->jenis_kelamin,
            'tanggal_lahir'          => $this->tanggal_lahir,
            'no_hp'                  => $this->no_hp,
            'alamat'                 => $this->alamat,
            'tanggal_mulai_mengajar' => $this->tanggal_mulai_mengajar,
            'status_aktif'           => $this->status_aktif,

            // RELASI USER
            'user' => $this->user ? [
                'name'   => $this->user->name,
                'email'  => $this->user->email,
                'foto'   => $this->user->foto,
                'role'   => $this->user->role
            ] : null,

            // RELASI KELAS
            'kelas' => $this->kelas ? $this->kelas->map(function ($k) {
                return [
                    'id'   => $k->id,
                    'nama' => $k->nama_kelas,
                    'kode' => $k->kode_kelas
                ];
            }) : [],
        ];
    }
}
