<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exports\KelasExport;
use Maatwebsite\Excel\Facades\Excel;

class KelasExportController extends Controller
{
    /**
     * GET /api/kelas/export/excel
     */
    public function exportExcel()
    {
        return Excel::download(
            new KelasExport,
            'data-kelas.xlsx'
        );
    }
}
