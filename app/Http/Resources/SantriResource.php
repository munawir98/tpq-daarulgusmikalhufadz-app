<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\KelasResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\KehadiranResource;
use App\Http\Resources\ProgressHafalanResource;

class SantriResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            // =========================
            // DATA UTAMA SANTRI
            // =========================
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

            // =========================
            // RELASI
            // =========================
            'kelas' => $this->whenLoaded(
                'kelas',
                fn () => new KelasResource($this->kelas)
            ),

            'user' => $this->whenLoaded(
                'user',
                fn () => new UserResource($this->user)
            ),

            'kehadiran' => KehadiranResource::collection(
                $this->whenLoaded('kehadiran')
            ),

            'progress_hafalan' => ProgressHafalanResource::collection(
                $this->whenLoaded('progressHafalan')
            ),

            // =========================
            // META
            // =========================
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }
}
