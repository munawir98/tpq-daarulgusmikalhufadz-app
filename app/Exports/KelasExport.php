<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;

class KelasExport implements FromCollection
{
    public function __construct(
        public ?string $tingkat = null,
        public ?int $ustadzId = null
    ) {}

    public function collection()
    {
        $query = Kelas::with('ustadz')
            ->where('status', 'aktif');

        if ($this->tingkat !== null) {
            $query->where('tingkat', $this->tingkat);
        }

        if ($this->ustadzId !== null) {
            $query->where('ustadz_id', $this->ustadzId);
        }

        return $query
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get([
                'kode_kelas',
                'nama_kelas',
                'tingkat',
                'status',
                'ustadz_id',
            ]);
    }
}
