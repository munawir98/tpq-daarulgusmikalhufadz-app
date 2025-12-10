<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Grup harus ada
            'group_id' => 'required|exists:groups,id',

            // Text message (required jika image/audio tidak ada)
            'message' => 'required_without_all:image,audio|string|max:500',

            // Image upload
            'image' => [
                'required_without_all:message,audio',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:4096', // 4MB
            ],

            // Audio upload (voice note)
            'audio' => [
                'required_without_all:message,image',
                'nullable',
                'file',
                'mimetypes:audio/mpeg,audio/mp3,audio/wav',
                'max:10240', // 10MB
            ],

            // text / image / audio
            'type' => 'required|string|in:text,image,audio',
        ];
    }

    public function messages(): array
    {
        return [
            'group_id.required' => 'Group ID wajib diisi.',
            'group_id.exists'   => 'Group tidak ditemukan.',

            // Text
            'message.required_without_all' => 'Pesan teks wajib diisi jika tidak mengirim gambar atau audio.',
            'message.max' => 'Pesan maksimal 500 karakter.',

            // Image
            'image.required_without_all' => 'Gambar wajib diisi jika tidak mengirim teks atau audio.',
            'image.image'  => 'File gambar tidak valid.',
            'image.mimes'  => 'Format gambar harus JPG atau PNG.',
            'image.max'    => 'Ukuran gambar maksimal 4MB.',

            // Audio
            'audio.required_without_all' => 'Audio wajib diisi jika tidak mengirim teks atau gambar.',
            'audio.mimetypes' => 'Format audio harus MP3 atau WAV.',
            'audio.max'       => 'Ukuran audio maksimal 10MB.',

            // Type
            'type.in'      => 'Tipe pesan harus: text, image, atau audio.',
        ];
    }
}
