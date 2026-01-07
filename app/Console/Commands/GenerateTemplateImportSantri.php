<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class GenerateTemplateImportSantri extends Command
{
    protected $signature = 'template:import-santri';
    protected $description = 'Generate template_import_santri.xlsx';

    public function handle()
    {
        $spreadsheet = new Spreadsheet();

        /*
        |----------------------------------------------------
        | Sheet 1: santri
        |----------------------------------------------------
        */
        $sheetSantri = $spreadsheet->getActiveSheet();
        $sheetSantri->setTitle('santri');

        $headers = [
            'nis',
            'nama_lengkap',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'tanggal_masuk',
            'kelas_id',
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheetSantri->setCellValue($col . '1', $header);
            $col++;
        }

        /*
        |----------------------------------------------------
        | Sheet 2: PETUNJUK
        |----------------------------------------------------
        */
        $sheetPetunjuk = $spreadsheet->createSheet();
        $sheetPetunjuk->setTitle('PETUNJUK');

        $rules = <<<TEXT
ATURAN IMPORT SANTRI

1. Jangan ubah nama header
2. Jenis kelamin hanya L atau P
3. Format tanggal: YYYY-MM-DD
4. kelas_id boleh dikosongkan
5. Baris pertama adalah header
TEXT;

        $sheetPetunjuk->setCellValue('A1', $rules);
        $sheetPetunjuk->getColumnDimension('A')->setWidth(100);
        $sheetPetunjuk->getStyle('A1')->getAlignment()->setWrapText(true);

        /*
        |----------------------------------------------------
        | Simpan File
        |----------------------------------------------------
        */
        $path = storage_path('app/templates');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filePath = $path . '/template_import_santri.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $this->info('Template berhasil dibuat di: ' . $filePath);
    }
}
