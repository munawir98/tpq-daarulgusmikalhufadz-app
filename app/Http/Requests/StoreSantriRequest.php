<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSantriRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
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
