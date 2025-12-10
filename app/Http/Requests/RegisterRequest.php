<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sanctum handle auth
    }

    public function rules(): array
    {
        return [
            // Identitas dasar
            'name'  => 'required|string|max:255',

            // Email unik
            'email' => 'required|email|max:255|unique:users,email',

            // Password + konfirmasi
            'password' => 'required|string|min:6|confirmed',

            // Nomor HP opsional tetapi harus valid
            'no_hp' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20'
            ],

            // Role user (opsional, default SANTRI)
            'role' => 'nullable|string|in:SANTRI,USTADZ,ADMIN,OPERATOR,WALI',

            // Foto profil opsional
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.in' => 'Role tidak valid.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
        ];
    }
}
