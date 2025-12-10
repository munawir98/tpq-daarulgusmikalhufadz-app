<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Pengguna (boleh null, karena admin bisa input manual)
            'user_id' => 'nullable|exists:users,id',

            // Nominal infaq
            'jumlah' => 'required|numeric|min:1000',

            // Tanggal transaksi
            'tanggal' => 'required|date|before_or_equal:today',

            // Catatan opsional
            'keterangan' => 'nullable|string|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'jumlah.min' => 'Minimal infaq adalah Rp 1.000.',
            'tanggal.before_or_equal' => 'Tanggal infaq tidak boleh di masa depan.',
            'keterangan.min' => 'Keterangan minimal 3 karakter.',
        ];
    }
}
