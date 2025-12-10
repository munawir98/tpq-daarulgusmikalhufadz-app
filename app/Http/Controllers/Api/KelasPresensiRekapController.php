<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Santri;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Carbon\Carbon;

class KelasPresensiRekapController extends Controller
{
    public function __construct()
    {
        // Hanya admin / ustadz boleh akses rekap kelas
        // $this->middleware('role:superadmin,admin,ustadz');
    }

    public function rekap(Request $request)
    {
        // ============================
        // VALIDASI INPUT
        // ============================
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan'    => 'nullable|date_format:Y-m',
        ]);

        $kelasId = $request->kelas_id;
        $bulan   = $request->bulan ?? Carbon::now()->format('Y-m');

        // ============================
        // AMBIL SANTRI DALAM KELAS
        // ============================
        $santri = Santri::where('kelas_id', $kelasId)
            ->with('user')
            ->get();

        if ($santri->isEmpty()) {
            return ApiResponse::error("Tidak ada santri dalam kelas ini", 404);
        }

        // ============================
        // REKAP PRESENSI PER SANTRI
        // ============================
        $result = [];

        foreach ($santri as $s) {

            // Gunakan user_id yang benar
            if (!$s->user) continue; // Santri tanpa user → skip

            $presensi = Presensi::where('user_id', $s->user->id)
                ->whereRaw("DATE_FORMAT(tanggal,'%Y-%m') = ?", [$bulan])
                ->get();

            $result[] = [
                'nama_lengkap' => $s->nama_lengkap,
                'user_id'      => $s->user->id,
                'santri_id'    => $s->id,
                'hadir'        => $presensi->where('status_presensi', 'Hadir')->count(),
                'izin'         => $presensi->where('status_presensi', 'Izin')->count(),
                'sakit'        => $presensi->where('status_presensi', 'Sakit')->count(),
                'alpha'        => $presensi->where('status_presensi', 'Alpha')->count(),
                'terlambat'    => $presensi->where('status_presensi', 'Terlambat')->count(),
            ];
        }

        if (empty($result)) {
            return ApiResponse::error("Data presensi tidak ditemukan untuk bulan ini", 404);
        }

        return ApiResponse::success([
            'kelas_id' => $kelasId,
            'bulan'    => $bulan,
            'rekap'    => $result
        ], "Rekap presensi kelas berhasil diambil");
    }
}
