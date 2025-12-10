<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Exports\PresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ApiResponse;

class PresensiExportController extends Controller
{
    public function __construct()
    {
        // Hanya role tertentu yang bisa eksport
        // $this->middleware('role:superadmin,admin,ustadz,santri');
    }

    /**
     * Export presensi ke Excel (XLSX)
     */
    public function export(Request $request)
    {
        $user = $request->user();

        // Validasi input tanggal (opsional)
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $start = $request->start_date;
        $end   = $request->end_date;

        // Ambil data presensi user bersangkutan
        $data = Presensi::where('user_id', $user->id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        // Jika tidak ada data, jangan buat file
        if ($data->isEmpty()) {
            return ApiResponse::error("Tidak ada data presensi untuk diexport", 404);
        }

        // Nama file otomatis
        $filename = 'presensi-' . strtolower($user->role) . '-' . date('Y-m-d') . '.xlsx';

        // Download file excel
        return Excel::download(new PresensiExport($data), $filename);
    }
}
