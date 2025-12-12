<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAkhlakSantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // izinkan semua request
    }

    public function rules(): array
    {
        return [
            'santri_id'        => 'required|exists:santris,id',
            'disiplin'         => 'required|integer|min:1|max:5',
            'kerajinan'        => 'required|integer|min:1|max:5',
            'kesopanan'        => 'required|integer|min:1|max:5',
            'catatan'          => 'nullable|string',
            'tanggal_penilaian'=> 'required|date',
        ];
    }
}
