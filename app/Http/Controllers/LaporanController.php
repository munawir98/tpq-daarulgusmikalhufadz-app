<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Santri;
use App\Models\KehadiranSantri;

use Carbon\Carbon;

class LaporanController extends Controller
{
    public function absensiPdf($santri_id, $bulan)
    {
        $santri = Santri::findOrFail($santri_id);

        // Konversi bulan (format: 2025-01)
        $carbonBulan = Carbon::createFromFormat('Y-m', $bulan);

        $absensi = KehadiranSantri::where('santri_id', $santri_id)
            ->whereMonth('tanggal', $carbonBulan->month)
            ->whereYear('tanggal',  $carbonBulan->year)
            ->orderBy('tanggal')
            ->get();


        $pdf = Pdf::loadView('pdf.absensi', [
            'santri' => $santri,
            'absensi' => $absensi,
            'bulan' => $carbonBulan->translatedFormat('F Y')
        ]);

        return $pdf->download("Laporan-Absensi-{$santri->nama}-{$bulan}.pdf");
    }
}
