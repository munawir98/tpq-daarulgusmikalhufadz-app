<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriPreviewImport implements OnEachRow, WithHeadingRow
{
    public array $rows = [];
    protected int $rowNumber = 2;

    public function onRow(Row $row): void
    {
        $data = $row->toArray();
        $errors = [];

        if (empty($data['nis'])) {
            $errors[] = 'NIS wajib diisi';
        } elseif (Santri::where('nis', $data['nis'])->exists()) {
            $errors[] = 'NIS sudah terdaftar';
        }

        if (!in_array($data['jenis_kelamin'] ?? '', ['L', 'P'])) {
            $errors[] = 'Jenis kelamin harus L atau P';
        }

        $this->rows[] = [
            'row'    => $this->rowNumber,
            'data'   => $data,
            'errors' => $errors,
        ];

        $this->rowNumber++;
    }
}
