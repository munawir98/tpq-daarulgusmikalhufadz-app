<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Carbon\Carbon;

class PresensiChartController extends Controller
{
    public function __construct()
    {
        // Semua role bisa lihat grafik presensi masing-masing
        // $this->middleware('role:superadmin,admin,ustadz,santri');
    }

    public function chart(Request $request)
    {
        $user = $request->user();
        $month = Carbon::now()->format('Y-m');

        // Ambil semua presensi bulan ini
        $data = Presensi::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(tanggal,'%Y-%m') = ?", [$month])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Jika bulan ini tidak ada presensi
        if ($data->isEmpty()) {
            return ApiResponse::error("Tidak ada data presensi bulan ini", 404);
        }

        // ================================
        // PIE CHART — SUMMARY STATUS
        // ================================
        $summary = [
            'hadir'     => $data->where('status_presensi', 'Hadir')->count(),
            'izin'      => $data->where('status_presensi', 'Izin')->count(),
            'sakit'     => $data->where('status_presensi', 'Sakit')->count(),
            'alpha'     => $data->where('status_presensi', 'Alpha')->count(),
            'terlambat' => $data->where('status_presensi', 'Terlambat')->count(),
        ];

        // ================================
        // LINE CHART — PRESENSI PER HARI
        // ================================
        $lineChart = $data->groupBy('tanggal')->map(function ($item) {
            return $item->count();
        });

        // ================================
        // BAR CHART — REKAP MINGGUAN
        // ================================
        $startMonth = Carbon::now()->startOfMonth();
        $weekly = [
            'week_1' => $data->whereBetween('tanggal', [
                $startMonth,
                $startMonth->copy()->addDays(6)
            ])->count(),

            'week_2' => $data->whereBetween('tanggal', [
                $startMonth->copy()->addDays(7),
                $startMonth->copy()->addDays(13)
            ])->count(),

            'week_3' => $data->whereBetween('tanggal', [
                $startMonth->copy()->addDays(14),
                $startMonth->copy()->addDays(20)
            ])->count(),

            'week_4' => $data->whereBetween('tanggal', [
                $startMonth->copy()->addDays(21),
                Carbon::now()->endOfMonth()
            ])->count(),
        ];

        return ApiResponse::success([
            'bulan'      => $month,
            'summary'    => $summary,
            'line_chart' => $lineChart,
            'weekly'     => $weekly,
        ], "Data grafik presensi ditemukan");
    }
}
