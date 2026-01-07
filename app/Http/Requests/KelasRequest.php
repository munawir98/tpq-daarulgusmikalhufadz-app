<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // aman untuk {id} atau {kelas}
        $routeParam = $this->route('kelas') ?? $this->route('id');
        $kelasId = is_object($routeParam) ? $routeParam->id : $routeParam;


        return [
            'kode_kelas' => [
                'required',
                'string',
                'max:20',
                Rule::unique('kelas', 'kode_kelas')->ignore($kelasId),
            ],

            'nama_kelas' => 'required|string|max:100',

            // tingkat final
            'tingkat' => 'required|in:ULA,WUSTHA',

            // jam opsional
            'waktu_mulai'   => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',

            // wajib sesuai sistem TPQ
            'ustadz_id' => 'required|exists:ustadz,id',

            'keterangan' => 'nullable|string|min:3',

            // konsistensi status
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_kelas.required' => 'Kode kelas wajib diisi.',
            'kode_kelas.unique'   => 'Kode kelas sudah digunakan.',
            'nama_kelas.required' => 'Nama kelas wajib diisi.',
            'tingkat.required'    => 'Tingkat kelas wajib dipilih.',
            'tingkat.in'          => 'Tingkat hanya boleh ULA atau WUSTHA.',
            'ustadz_id.required'  => 'Ustadz wajib dipilih.',
            'ustadz_id.exists'    => 'Ustadz tidak valid.',
            'waktu_selesai.after' => 'Waktu selesai harus lebih besar dari waktu mulai.',
            'status.required'     => 'Status kelas wajib diisi.',
            'status.boolean'      => 'Status kelas harus true atau false.',
        ];
    }
}
