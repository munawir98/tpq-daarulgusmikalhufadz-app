<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'role'       => $this->role,

            // Kontak
            'no_hp'      => $this->no_hp,
            'alamat'     => $this->alamat,

            // Foto profil (otomatis jadi full URL)
            'foto'       => $this->foto
                                ? asset('storage/' . $this->foto)
                                : asset('storage/default/profile.png'),

            // Status dan aktivitas
            'status'     => $this->status,
            'last_login' => $this->last_login
                                ? $this->last_login->format('Y-m-d H:i:s')
                                : null,

            // Timestamps rapi
            'created_at' => $this->created_at
                                ? $this->created_at->format('Y-m-d H:i:s')
                                : null,

            'updated_at' => $this->updated_at
                                ? $this->updated_at->format('Y-m-d H:i:s')
                                : null,
        ];
    }
}
