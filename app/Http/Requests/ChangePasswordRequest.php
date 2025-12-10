<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'different:old_password'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Password lama wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password.different' => 'Password baru tidak boleh sama dengan password lama.',
        ];
    }
}
