<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatPrivateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Semua user login boleh akses
    }

    public function rules(): array
    {
        return [
            // Penerima pesan wajib ada & tidak boleh dirinya sendiri
            'receiver_id' => 'required|exists:users,id|not_in:' . auth()->id(),

            // Pesan teks wajib jika tidak ada gambar/audio
            'message' => 'required_without_all:image,audio|string|max:5000',

            // Upload gambar opsional
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:4096'  // 4MB
            ],

            // Upload audio opsional
            'audio' => [
                'nullable',
                'mimes:mp3,wav,ogg',
                'max:8192' // 8MB
            ],

            // Jenis pesan: text / image / audio
            'type' => 'required|string|in:text,image,audio',
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.required' => 'Penerima pesan wajib diisi.',
            'receiver_id.exists'   => 'User penerima tidak ditemukan.',
            'receiver_id.not_in'   => 'Tidak bisa mengirim pesan ke diri sendiri.',

            'message.required_without_all' => 'Pesan, gambar, atau audio harus diisi.',
            'message.max'                  => 'Pesan maksimal 5000 karakter.',

            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG atau PNG.',
            'image.max'   => 'Ukuran gambar maksimal 4MB.',

            'audio.mimes' => 'Format audio harus MP3/WAV/OGG.',
            'audio.max'   => 'Ukuran audio maksimal 8MB.',

            'type.in'     => 'Tipe pesan tidak valid.',
        ];
    }
}
