<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiUjianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'santri_id'    => 'required|exists:santris,id',
                'jenis_ujian'  => 'required|string',
                'nilai'        => 'required|integer|min:0|max:100',
                'keterangan'   => 'nullable|string',
                'tanggal'      => 'required|date',
            ];
        }

        return [
            'santri_id'    => 'sometimes|exists:santris,id',
            'jenis_ujian'  => 'sometimes|string',
            'nilai'        => 'sometimes|integer|min:0|max:100',
            'keterangan'   => 'sometimes|string|nullable',
            'tanggal'      => 'sometimes|date',
        ];
    }
}
