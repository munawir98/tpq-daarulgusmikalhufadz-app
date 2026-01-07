<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataKelasExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Kelas::select(
            'kode_kelas',
            'nama_kelas',
            'tipe',
            'tingkat',
            'status'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Kelas',
            'Nama Kelas',
            'Tipe',
            'Tingkat',
            'Status',
        ];
    }
}
