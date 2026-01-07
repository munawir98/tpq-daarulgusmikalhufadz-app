<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KelasExport;
use Barryvdh\DomPDF\Facade\Pdf;

class DataKelasController extends Controller
{
    /**
     * =========================
     * Export Excel Data Kelas
     * =========================
     */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'tingkat'   => 'nullable|in:ULA,WUSTHA',
            'ustadz_id' => 'nullable|integer|exists:ustadz,id',
        ]);

        $cacheKey = 'kelas_excel_' . md5(json_encode($request->only([
            'tingkat',
            'ustadz_id',
        ])));

        try {
            return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {
                return Excel::download(
                    new KelasExport(
                        $request->tingkat,
                        $request->ustadz_id
                    ),
                    'data-kelas.xlsx'
                );
            });
        } catch (\Throwable $e) {
            Log::error('Export Excel Data Kelas gagal', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            abort(500, 'Gagal export Excel');
        }
    }

    /**
     * =========================
     * Export PDF Data Kelas
     * =========================
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'tingkat'   => 'nullable|in:ULA,WUSTHA',
            'ustadz_id' => 'nullable|integer|exists:ustadz,id',
        ]);

        $cacheKey = 'kelas_pdf_' . md5(json_encode($request->only([
            'tingkat',
            'ustadz_id',
        ])));

        try {
            return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($request) {

                $query = Kelas::with('ustadz')
                    ->where('status', 'aktif');

                if ($request->filled('tingkat')) {
                    $query->where('tingkat', $request->tingkat);
                }

                if ($request->filled('ustadz_id')) {
                    $query->where('ustadz_id', $request->ustadz_id);
                }

                $kelas = $query
                    ->orderBy('tingkat')
                    ->orderBy('nama_kelas')
                    ->get();

                if ($kelas->isEmpty()) {
                    abort(404, 'Data kelas tidak ditemukan');
                }

                $tanggalCetak = now()->translatedFormat('d F Y');

                $pdf = Pdf::loadView(
                    'kelas.pdf',
                    compact('kelas', 'tanggalCetak')
                )->setPaper('A4', 'portrait');

                return $pdf->download('laporan-data-kelas.pdf');
            });
        } catch (\Throwable $e) {
            Log::error('Export PDF Data Kelas gagal', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            abort(500, 'Gagal generate PDF');
        }
    }
}
