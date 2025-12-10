<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Helpers\ApiResponse;
use PDF;

class PresensiPdfController extends Controller
{
    public function __construct()
    {
        // Hanya ustadz / santri / admin yg boleh export PDF
        // $this->middleware('role:superadmin,admin,ustadz,santri');
    }

    public function export(Request $request)
    {
        $user = $request->user();

        // Validasi tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;

        // Ambil data presensi berdasarkan user login
        $data = Presensi::where('user_id', $user->id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // Jika data kosong → jangan paksa PDF
        if ($data->isEmpty()) {
            return ApiResponse::error("Data presensi tidak ditemukan", 404);
        }

        // Pilih template PDF berdasarkan role
        $view = match (strtoupper($user->role)) {
            'PENGAJAR', 'USTADZ' => 'exports.presensi_pengajar_pdf',
            default              => 'exports.presensi_santri_pdf'
        };

        // Cek apakah template view tersedia
        if (!view()->exists($view)) {
            return ApiResponse::error("Template PDF tidak ditemukan: $view", 500);
        }

        // Tentukan range tanggal untuk ditampilkan
        $tanggalRange = ($start && $end)
            ? date('d/m/Y', strtotime($start)) . ' - ' . date('d/m/Y', strtotime($end))
            : 'Semua Periode';

        // Generate PDF
        $pdf = PDF::loadView($view, [
            'data'         => $data,
            'tanggalRange' => $tanggalRange,
            'user'         => $user
        ])->setPaper('a4', 'portrait');

        // Nama file otomatis
        $filename = 'rekap-presensi-' . strtolower($user->role) . '-' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
        // return $pdf->stream(); // jika ingin preview PDF
    }
}
