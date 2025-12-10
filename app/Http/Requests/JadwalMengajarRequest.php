<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JadwalMengajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('jadwal'); // dipakai saat update

        return [
            // Relasi wajib valid
            'ustadz_id' => 'required|exists:ustadz,id',
            'kelas_id'  => 'required|exists:kelas,id',

            // Hari terbatas agar tidak input sembarangan
            'hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',

            // Validasi jam
            'waktu_mulai'   => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',

            // Materi (opsional tapi minimal 3 karakter jika diisi)
            'materi' => 'nullable|string|min:3',

            // Status aktif
            'aktif' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'hari.in' => 'Hari harus salah satu dari: Senin–Minggu.',
            'waktu_selesai.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
            'materi.min' => 'Materi minimal 3 karakter.',
        ];
    }
}
