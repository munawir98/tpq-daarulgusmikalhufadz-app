<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAkhlakSantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'disiplin'         => 'integer|min:1|max:5',
            'kerajinan'        => 'integer|min:1|max:5',
            'kesopanan'        => 'integer|min:1|max:5',
            'catatan'          => 'nullable|string',
            'tanggal_penilaian'=> 'date',
        ];
    }
}
