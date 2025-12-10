<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('kela'); // untuk update (route model binding)

        return [
            // Kode kelas wajib unik
            'kode_kelas' => "required|string|max:20|unique:kelas,kode_kelas,$id",

            // Nama kelas wajib ada
            'nama_kelas' => 'required|string|max:100',

            // Tipe kelas (opsional tetapi terbatas nilainya agar konsisten)
            'tipe' => 'nullable|string|in:Reguler,Hafalan,Intensif,Tahfidz',

            // Tingkat kelas (opsional)
            'tingkat' => 'nullable|string|in:Dasar,Menengah,Lanjut',

            // Jam mulai & selesai
            'waktu_mulai'   => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',

            // Ustadz pengajar wajib valid
            'ustadz_id' => 'nullable|exists:ustadz,id',

            // Catatan kelas
            'keterangan' => 'nullable|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_kelas.unique' => 'Kode kelas sudah digunakan.',
            'waktu_selesai.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
            'tipe.in' => 'Tipe kelas tidak valid.',
            'tingkat.in' => 'Tingkat kelas tidak valid.',
        ];
    }
}
