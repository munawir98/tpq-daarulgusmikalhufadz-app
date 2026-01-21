<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanKehadiranExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $monthName;
    protected $kelasName;

    public function __construct($data, $monthName, $kelasName)
    {
        $this->data = collect($data);
        $this->monthName = $monthName;
        $this->kelasName = $kelasName;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['LAPORAN REKAP KEHADIRAN SANTRI'],
            ['TPQ Daarul Gusmikal Hufadz'],
            ['Periode: ' . $this->monthName . ' | Kelas: ' . ($this->kelasName ?? 'Semua Kelas')],
            [''], // Empty row
            [
                'No',
                'Nama Santri',
                'Hadir',
                'Izin',
                'Sakit',
                'Alpa',
                'Persentase (%)'
            ]
        ];
    }

    public function map($row): array
    {
        // Add row number loop in controller or just use index here if data is simple array
        static $no = 0;
        $no++;

        return [
            $no,
            $row['nama'],
            $row['hadir'],
            $row['izin'],
            $row['sakit'],
            $row['alpa'],
            $row['persentase'] . '%'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first 3 rows as header info
            1 => ['font' => ['bold' => true, 'size' => 14]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
            3 => ['font' => ['italic' => true, 'size' => 11]],

            // Style the table header (Row 5)
            5 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '059669'] // Green
                ]
            ],
        ];
    }
}
