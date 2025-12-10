<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user'); // ID user untuk update (ignore unique)

        return [
            // Nama wajib
            'name' => 'required|string|max:255',

            // Email unik, tapi tidak error saat update email dirinya sendiri
            'email' => "required|email|max:255|unique:users,email,$id",

            // Password:
            // Create → wajib
            // Update → opsional
            'password' => $id
                ? 'nullable|string|min:6'
                : 'required|string|min:6',

            // Role / akses
            'role' => 'required|string|in:ADMIN,USTADZ,SANTRI,WALI,OPERATOR',

            // Nomor HP opsional tapi format valid
            'no_hp' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20'
            ],

            // Foto profile opsional
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.in' => 'Role tidak valid.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'photo.image' => 'Foto harus berupa gambar.',
        ];
    }
}
