<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sanctum sudah handle auth
    }

    public function rules(): array
    {
        $route = $this->route()->getName(); // nama route

        return match ($route) {

            // ===============================
            // SANTRI MASUK
            // ===============================
            'presensi.santri.masuk' => [
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
                'foto'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'metode'    => 'nullable|string|in:manual,gps,qr',
                'qr_code'   => 'nullable|string',
            ],

            // ===============================
            // SANTRI PULANG
            // ===============================
            'presensi.santri.pulang' => [
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
                'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],

            // ===============================
            // USTADZ MASUK
            // ===============================
            'presensi.ustadz.masuk' => [
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
                'foto'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'metode'    => 'nullable|string|in:manual,gps,qr',
                'qr_code'   => 'nullable|string',
            ],

            // ===============================
            // USTADZ PULANG
            // ===============================
            'presensi.ustadz.pulang' => [
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
                'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],

            // ===============================
            // IZIN
            // ===============================
            'presensi.izin' => [
                'keterangan' => 'required|string|min:3'
            ],

            // ===============================
            // SAKIT
            // ===============================
            'presensi.sakit' => [
                'keterangan' => 'required|string|min:3'
            ],

            default => []

        };
    }

    public function messages(): array
    {
        return [
            'latitude.required'   => 'Lokasi tidak terbaca.',
            'longitude.required'  => 'Lokasi tidak terbaca.',
            'foto.required'       => 'Foto wajib diambil.',
            'foto.image'          => 'Foto harus berupa gambar.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.min'      => 'Keterangan minimal 3 karakter.',
        ];
    }
}
