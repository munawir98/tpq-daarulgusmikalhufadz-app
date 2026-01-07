<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

// Models
use App\Models\User;
use App\Models\Santri;
use App\Models\Ustadz;
use App\Models\Pengajar;
use App\Models\Kelas;
use App\Models\Setoran;
use App\Models\Infaq;
use App\Models\Presensi;

class DashboardController extends Controller
{
    /**
     * ============================
     * DASHBOARD SUMMARY
     * GET /api/dashboard/summary
     * ============================
     */
    public function summary(Request $request)
    {
        $user = $request->user();

        // ============================
        // GLOBAL SUMMARY
        // ============================
        $data = [
            'total_user'     => User::count(),
            'total_santri'   => Santri::count(),
            'total_ustadz'   => Ustadz::count(),
            'total_pengajar' => Pengajar::count(),
            'total_kelas'    => Kelas::count(),

            // ============================
            // KEUANGAN
            // ============================
            'total_infaq' => Infaq::sum('jumlah'),

            // ============================
            // SETORAN HAFALAN
            // ============================
            'total_setoran' => Setoran::count(),

            // ============================
            // PRESENSI HARI INI
            // ============================
            'presensi_hari_ini' => [
                'santri_masuk' => Presensi::whereDate('tanggal', today())
                    ->where('tipe', 'SANTRI')
                    ->where('status', 'MASUK')
                    ->count(),

                'ustadz_masuk' => Presensi::whereDate('tanggal', today())
                    ->where('tipe', 'USTADZ')
                    ->where('status', 'MASUK')
                    ->count(),
            ],
        ];

        // ============================
        // ROLE-BASED EXTRA DATA
        // ============================
        if ($user->role === 'SANTRI') {
            $data['santri'] = [
                'setoran_saya' => Setoran::where('santri_id', $user->santri?->id)->count(),
                'presensi_saya' => Presensi::where('user_id', $user->id)->count(),
            ];
        }

        if ($user->role === 'USTADZ') {
            $data['ustadz'] = [
                'kelas_diampu' => Kelas::where('ustadz_id', $user->id)->count(),
            ];
        }

        return ApiResponse::success(
            $data,
            'Ringkasan dashboard berhasil dimuat'
        );
    }
}
