<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveFcmTokenRequest extends FormRequest
{
    /**
     * Izinkan semua user mengakses request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi request.
     */
    public function rules(): array
    {
        return [
            'fcm_token' => 'required|string',
        ];
    }

    /**
     * Pesan error custom (opsional).
     */
    public function messages(): array
    {
        return [
            'fcm_token.required' => 'Token FCM wajib dikirim.',
            'fcm_token.string'   => 'Token FCM harus berupa teks.',
        ];
    }
}
