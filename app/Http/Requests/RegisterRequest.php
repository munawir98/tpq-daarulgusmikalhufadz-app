<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Identitas dasar
            'name' => ['required', 'string', 'max:255'],

            // Email unik
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],

            // Password + konfirmasi
            'password' => ['required', 'string', 'min:6', 'confirmed'],

            // Nomor HP opsional
            'no_hp' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20',
            ],

            // Role user
            'role' => [
                'nullable',
                'string',
                Rule::in(['SANTRI', 'USTADZ', 'ADMIN', 'OPERATOR', 'WALI']),
            ],

            /**
             * KELAS
             * ✅ BOLEH KOSONG SAAT REGISTER
             * ✅ TETAP VALIDASI JIKA ADA
             */
            'kelas_id' => [
                'nullable',          // 🔥 PERUBAHAN UTAMA
                'integer',
                'exists:kelas,id',
            ],

            // Foto profil opsional
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'       => 'Email ini sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 6 karakter.',
            'role.in'            => 'Role tidak valid.',
            'no_hp.regex'        => 'Format nomor HP tidak valid.',
            'kelas_id.exists'    => 'Kelas tidak ditemukan.',
        ];
    }
}
