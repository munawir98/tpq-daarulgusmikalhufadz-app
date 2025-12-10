<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UstadzRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('ustadz'); // untuk update (unique ignore)

        return [
            // Akun login — optional, karena ustadz bisa dipisah dari user
            'user_id' => 'nullable|exists:users,id',

            // Data identitas
            'nama' => 'required|string|max:255',

            // NIK unik (jika ada)
            'nik' => "nullable|string|max:50|unique:ustadz,nik,$id",

            // Jenis kelamin
            'jenis_kelamin' => 'required|in:L,P',

            // Tanggal lahir
            'tanggal_lahir' => 'nullable|date|before:today',

            // Kontak
            'no_hp' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20'
            ],

            'alamat' => 'nullable|string|min:3',

            // Status aktif mengajar
            'tanggal_mulai_mengajar' => 'nullable|date|before_or_equal:today',

            'status_aktif' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama ustadz wajib diisi.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak boleh di masa depan.',
            'tanggal_mulai_mengajar.before_or_equal' => 'Tanggal mulai mengajar tidak boleh melewati hari ini.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'alamat.min' => 'Alamat minimal 3 karakter.',
        ];
    }
}
