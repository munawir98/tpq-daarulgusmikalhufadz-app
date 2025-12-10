<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GajiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('gaji'); // ID untuk update

        return [
            // Validasi ustadz
            'ustadz_id' => 'required|exists:ustadz,id',

            // Bulan & Tahun
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',

            // Anti DOBEL GAJI
            'ustadz_id' => [
                'required',
                'exists:ustadz,id',
                "unique:gaji,ustadz_id,$id,id,bulan," . $this->bulan . ",tahun," . $this->tahun,
            ],

            // Nominal
            'nominal_per_pertemuan' => 'required|integer|min:1000',

            // Catatan
            'keterangan' => 'nullable|string|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'ustadz_id.unique' => 'Gaji ustadz untuk bulan dan tahun ini sudah pernah dicatat.',
            'nominal_per_pertemuan.min' => 'Nominal minimal Rp 1.000.',
        ];
    }
}
