<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AkhlakSantriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Jika POST (create) → semua field wajib
        if ($this->isMethod('post')) {
            return [
                'santri_id'        => 'required|exists:santris,id',
                'disiplin'         => 'required|integer|min:1|max:5',
                'kerajinan'        => 'required|integer|min:1|max:5',
                'kesopanan'        => 'required|integer|min:1|max:5',
                'catatan'          => 'nullable|string',
                'tanggal_penilaian'=> 'required|date',
            ];
        }

        // Jika PUT/PATCH (update) → semua field opsional
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'santri_id'        => 'sometimes|exists:santris,id',
                'disiplin'         => 'sometimes|integer|min:1|max:5',
                'kerajinan'        => 'sometimes|integer|min:1|max:5',
                'kesopanan'        => 'sometimes|integer|min:1|max:5',
                'catatan'          => 'sometimes|nullable|string',
                'tanggal_penilaian'=> 'sometimes|date',
            ];
        }

        // Default (fallback)
        return [];
    }
}
