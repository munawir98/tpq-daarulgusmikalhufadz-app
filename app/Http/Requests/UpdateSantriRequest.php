<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSantriRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'sometimes|string',
            'jenis_kelamin' => 'sometimes|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'nama_wali' => 'nullable|string',
            'kelas' => 'nullable|string',
            'tanggal_masuk' => 'nullable|date',
            'status_aktif' => 'nullable|boolean'
        ];
    }
}
