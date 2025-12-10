<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class PresensiDashboardController extends Controller
{
    public function __construct()
    {
        // Semua role bisa melihat dashboard presensi masing-masing
        // $this->middleware('role:superadmin,admin,ustadz,santri');
    }

    public function summary(Request $request)
    {
        $user = $request->user();

        $today = now()->format('Y-m-d');
        $month = now()->format('Y-m');

        // =============================
        // PRESENSI HARI INI
        // =============================
        $hariIni = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->get();

        // =============================
        // PRESENSI BULAN INI
        // =============================
        $bulanan = Presensi::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$month])
            ->get();

        // Jika tidak ada presensi sama sekali
        if ($hariIni->isEmpty() && $bulanan->isEmpty()) {
            return ApiResponse::error("Belum ada data presensi tersedia", 404);
        }

        return ApiResponse::success([
            'hari_ini' => [
                'tanggal'   => $today,
                'hadir'     => $hariIni->where('status_presensi', 'Hadir')->count(),
                'sakit'     => $hariIni->where('status_presensi', 'Sakit')->count(),
                'izin'      => $hariIni->where('status_presensi', 'Izin')->count(),
                'alpha'     => $hariIni->where('status_presensi', 'Alpha')->count(),
                'terlambat' => $hariIni->where('status_presensi', 'Terlambat')->count(),
            ],
            'bulanan' => [
                'bulan'     => $month,
                'hadir'     => $bulanan->where('status_presensi', 'Hadir')->count(),
                'sakit'     => $bulanan->where('status_presensi', 'Sakit')->count(),
                'izin'      => $bulanan->where('status_presensi', 'Izin')->count(),
                'alpha'     => $bulanan->where('status_presensi', 'Alpha')->count(),
                'terlambat' => $bulanan->where('status_presensi', 'Terlambat')->count(),
            ]
        ], "Data dashboard presensi ditemukan");
    }
}
