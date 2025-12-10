<?php

namespace App\Services\Presensi;

use App\Repositories\Contracts\PresensiRepositoryInterface;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class PresensiExportService
{
    protected $repo;

    public function __construct(PresensiRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function exportPDF($userId, $periode)
    {
        $data = $periode === 'minggu'
            ? $this->repo->rekapMingguan($userId)
            : $this->repo->rekapBulanan($userId);

        $pdf = PDF::loadView('exports.presensi_pdf', ['data' => $data]);
        return $pdf->download('presensi.pdf');
    }

    public function exportExcel($userId, $periode)
    {
        $data = $periode === 'minggu'
            ? $this->repo->rekapMingguan($userId)
            : $this->repo->rekapBulanan($userId);

        return Excel::download(new \App\Exports\PresensiExport($data), 'presensi.xlsx');
    }
}
