<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KehadiranSantriRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'santri_id'   => 'required|exists:santri,id',
            'jadwal_id'   => 'required|exists:jadwal_mengajar,id',
            'ustadz_id'   => 'nullable|exists:ustadz,id',
            'tanggal'     => 'required|date',
            'waktu_absen' => 'nullable|date_format:H:i',
            'status'      => 'required|in:HADIR,SAKIT,IZIN,ALFA,TELAT,PULANG_AWAL',
            'catatan'     => 'nullable|string',
        ];
    }
}
