<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('pengajar'); // dipakai untuk unique saat update

        return [
            'user_id' => 'nullable|exists:users,id',

            'nama' => 'required|string|max:255',

            'nik' => "nullable|string|max:50|unique:pengajar,nik,$id",

            'jenis_kelamin' => 'required|in:L,P',

            'tanggal_lahir' => 'nullable|date|before:today',

            'no_hp' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20'
            ],

            'alamat' => 'nullable|string|min:3',

            'tanggal_mulai_mengajar' => 'nullable|date|before_or_equal:today',

            'status_aktif' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama pengajar wajib diisi.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak boleh di masa depan.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'alamat.min' => 'Alamat minimal 3 karakter.',
        ];
    }
}
