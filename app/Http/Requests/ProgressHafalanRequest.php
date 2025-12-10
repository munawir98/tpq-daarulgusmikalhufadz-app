<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgressHafalanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'santri_id'     => 'required|exists:santri,id',
            'ustadz_id'     => 'nullable|exists:ustadz,id',
            'juz'           => 'required|integer|min:1|max:30',
            'halaman'       => 'required|string',
            'ayat_mulai'    => 'nullable|string',
            'ayat_selesai'  => 'nullable|string',
            'tanggal'       => 'required|date',
            'nilai'         => 'nullable|integer|min:0|max:100',
            'status'        => 'nullable|string|max:50',
            'keterangan'    => 'nullable|string',
        ];
    }
}
