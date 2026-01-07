<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;

class SantriTemplateController extends Controller
{
    public function download()
    {
        $spreadsheet = new Spreadsheet();

        /* ========= SHEET SANTRI ========= */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('santri');

        $sheet->fromArray([
            ['NIS','Nama','JK','Tgl Lahir','Alamat','Tgl Masuk','Nama Kelas','Kelas ID']
        ]);

        // Dropdown JK
        $jk = new DataValidation();
        $jk->setType(DataValidation::TYPE_LIST);
        $jk->setFormula1('"L,P"');
        $sheet->setDataValidation('C2:C1000', $jk);

        /* ========= SHEET REF KELAS ========= */
        $kelasSheet = $spreadsheet->createSheet();
        $kelasSheet->setTitle('ref_kelas');
        $kelasSheet->fromArray(['ID','Nama'], null, 'A1');

        $row = 2;
        foreach (Kelas::all() as $kelas) {
            $kelasSheet->setCellValue("A$row", $kelas->id);
            $kelasSheet->setCellValue("B$row", $kelas->nama);
            $row++;
        }

        $kelasSheet->setSheetState('hidden');

        // Named range
        $spreadsheet->addNamedRange(
            new NamedRange(
                'KELAS_LIST',
                $kelasSheet,
                "B2:B" . ($row - 1)
            )
        );

        // Dropdown kelas
        $kelasValidation = new DataValidation();
        $kelasValidation->setType(DataValidation::TYPE_LIST);
        $kelasValidation->setFormula1('=KELAS_LIST');
        $sheet->setDataValidation('G2:G1000', $kelasValidation);

        // VLOOKUP kelas_id
        for ($i = 2; $i <= 1000; $i++) {
            $sheet->setCellValue(
                "H$i",
                "=IFERROR(VLOOKUP(G$i,ref_kelas!B:A,2,FALSE),\"\")"
            );
        }

        // Hide kolom ID
        $sheet->getColumnDimension('H')->setVisible(false);

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(
            fn () => $writer->save('php://output'),
            'template_import_santri.xlsx'
        );
    }
}
