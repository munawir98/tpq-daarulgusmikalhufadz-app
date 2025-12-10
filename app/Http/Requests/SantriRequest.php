<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('santri'); // untuk update agar NIS tidak bentrok

        return [
            'nis' => "required|string|max:50|unique:santri,nis,$id",

            'nama_lengkap'  => 'required|string|max:255',
            'nama_panggilan'=> 'nullable|string|max:100',

            'jenis_kelamin' => 'required|in:L,P',

            'tanggal_lahir' => 'required|date|before:today',
            'tempat_lahir'  => 'required|string|max:255',

            'alamat' => 'required|string|min:3',

            'nama_ayah' => 'required|string|max:255',
            'nama_ibu'  => 'required|string|max:255',

            'no_hp_orang_tua' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'max:20'
            ],

            'tanggal_masuk' => 'required|date|before_or_equal:today',

            'status_aktif' => 'required|boolean',

            'kelas_id'     => 'required|exists:kelas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nis.unique' => 'NIS sudah terdaftar.',
            'tanggal_lahir.before' => 'Tanggal lahir tidak boleh di masa depan.',
            'tanggal_masuk.before_or_equal' => 'Tanggal masuk tidak boleh lebih dari hari ini.',
            'alamat.min' => 'Alamat minimal 3 karakter.',
            'no_hp_orang_tua.regex' => 'Format nomor HP tidak valid.',
        ];
    }
}
