<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Carbon\Carbon;

class GajiPengajarRekapController extends Controller
{
    public function __construct()
    {
        // Hanya admin & superadmin boleh lihat rekap gaji
        // $this->middleware('role:superadmin,admin');
    }

    public function rekap(Request $request)
    {
        // ==========================
        // VALIDASI
        // ==========================
        $request->validate([
            'ustadz_id' => 'required|exists:ustadz,id',
            'bulan'     => 'required|date_format:Y-m',
            'tarif'     => 'nullable|numeric|min:1000'
        ]);

        $ustadzId = $request->ustadz_id;
        $bulan    = $request->bulan;
        $tarif    = $request->tarif ?? 20000;

        // ==========================
        // AMBIL USER ID DARI USTADZ
        // ==========================
        $ustadz = Ustadz::with('user')->find($ustadzId);

        if (!$ustadz || !$ustadz->user) {
            return ApiResponse::error("User untuk ustadz ini tidak ditemukan", 404);
        }

        $userId = $ustadz->user->id;

        // ==========================
        // HITUNG PRESENSI BULANAN
        // ==========================
        $presensi = Presensi::where('user_id', $userId)
            ->whereRaw("DATE_FORMAT(tanggal,'%Y-%m') = ?", [$bulan])
            ->get();

        if ($presensi->isEmpty()) {
            return ApiResponse::error("Tidak ada presensi di bulan tersebut", 404);
        }

        $hadir = $presensi->where('status_presensi', 'Hadir')->count();
        $totalGaji = $hadir * $tarif;

        // ==========================
        // RESPONSE
        // ==========================
        return ApiResponse::success([
            'ustadz_id'   => $ustadzId,
            'nama_ustadz' => $ustadz->nama,
            'bulan'       => $bulan,
            'hadir'       => $hadir,
            'tarif'       => $tarif,
            'total_gaji'  => $totalGaji
        ], "Rekap gaji pengajar ditemukan");
    }
}
