<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // User sudah login via Sanctum
    }

    public function rules(): array
    {
        $id = $this->user()->id; // Ambil ID user login

        return [
            'name' => 'required|string|max:100',

            // Email harus unik tapi abaikan email miliknya sendiri
            'email' => "required|email|max:255|unique:users,email,$id",

            'no_hp' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20'
            ],

            'alamat' => 'nullable|string|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah digunakan.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'alamat.min' => 'Alamat minimal 3 karakter.',
        ];
    }
}
