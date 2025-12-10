<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'members'     => 'nullable|array',
            'members.*'   => 'exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama grup wajib diisi.',
            'members.array' => 'Format anggota grup tidak valid.',
            'members.*.exists' => 'Terdapat user yang tidak valid di dalam daftar anggota.',
        ];
    }
}
