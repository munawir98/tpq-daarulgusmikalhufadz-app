<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetoranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('setoran'); // for update

        return [
            // Relasi wajib
            'santri_id'  => 'required|exists:santri,id',
            'ustadz_id'  => 'nullable|exists:ustadz,id',

            // Juz harus valid 1–30
            'juz'        => 'required|integer|min:1|max:30',

            // Halaman sebaiknya angka (misal halaman 12)
            'halaman'    => 'required|integer|min:1',

            // Ayat mulai / selesai sebaiknya angka
            'ayat_mulai'   => 'nullable|integer|min:1',
            'ayat_selesai' => 'nullable|integer|min:1|gte:ayat_mulai',

            // tanggal setoran
            'tanggal'    => 'required|date|before_or_equal:today',

            // nilai hadits / tartil / hafalan
            'nilai'      => 'nullable|integer|min:0|max:100',

            // status setoran
            'status'     => 'nullable|string|in:Lancar,Mengulang,Kurang,Selesai',

            // catatan ustadz
            'keterangan' => 'nullable|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'ayat_selesai.gte' => 'Ayat selesai harus lebih besar atau sama dengan ayat mulai.',
            'halaman.integer'  => 'Halaman harus berupa angka.',
            'status.in'        => 'Status harus salah satu: Lancar, Mengulang, Kurang, atau Selesai.',
            'tanggal.before_or_equal' => 'Tanggal setoran tidak boleh di masa depan.',
        ];
    }
}
