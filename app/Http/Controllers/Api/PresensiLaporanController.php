<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\ApiResponse;

class PresensiLaporanController extends Controller
{
    public function __construct()
    {
        // Semua role bisa melihat laporan presensi masing-masing
        // $this->middleware('role:superadmin,admin,ustadz,santri');
    }

    /**
     * Laporan presensi harian
     */
    public function daily(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');

        $data = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->orderBy('tanggal', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return ApiResponse::error("Tidak ada presensi hari ini", 404);
        }

        return ApiResponse::success([
            'tanggal' => $today,
            'data' => $data
        ], "Laporan presensi harian ditemukan");
    }

    /**
     * Laporan presensi mingguan
     */
    public function weekly(Request $request)
    {
        $user = $request->user();

        $start = now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $end   = now()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');

        $data = Presensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'asc')
            ->get();

        if ($data->isEmpty()) {
            return ApiResponse::error("Tidak ada presensi minggu ini", 404);
        }

        return ApiResponse::success([
            'minggu_mulai' => $start,
            'minggu_selesai' => $end,
            'data' => $data
        ], "Laporan presensi mingguan ditemukan");
    }
}
