<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * ==================================================
     * DASHBOARD ENTRY POINT
     * → auto redirect sesuai role user
     * ==================================================
     */
    public function index()
    {
        $user = session('user');

        // jika belum login / session rusak
        if (! $user || ! isset($user['role'])) {
            return redirect()->route('login.form');
        }

        return match ($user['role']) {
            'ADMIN'  => redirect()->route('admin.dashboard'),
            'USTADZ' => redirect()->route('ustadz.dashboard'),
            'SANTRI' => redirect()->route('santri.dashboard'),
            default  => redirect()->route('login.form'),
        };
    }

    /**
     * ==================================================
     * ADMIN DASHBOARD
     * ==================================================
     */
    public function admin()
    {
        return view('admin.dashboard');
    }

    /**
     * ==================================================
     * USTADZ DASHBOARD
     * ==================================================
     */
    public function ustadz()
    {
        $userId = session('user.id');
        $today = now()->format('Y-m-d');

        $pMasuk = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->where('tipe', 'masuk')
            ->first();

        $pPulang = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->where('tipe', 'pulang')
            ->first();

        $presensiHariIni = (object) [
            'jam_masuk' => $pMasuk ? $pMasuk->jam : null,
            'jam_pulang' => $pPulang ? $pPulang->jam : null,
        ];

        return view('ustadz.dashboard', [
            'presensiHariIni' => $presensiHariIni
        ]);
    }

    /**
     * ==================================================
     * SANTRI DASHBOARD
     * ==================================================
     */
    public function santri()
    {
        $userId = session('user.id');

        // Get latest hafalan for this santri (only 1)
        $latestHafalan = \App\Models\Hafalan::where('santri_id', $userId)
            ->with('ustadz')
            ->orderBy('created_at', 'desc')
            ->first();

        // Count total setoran this month
        $totalSetoran = \App\Models\Hafalan::where('santri_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Weekly target calculation
        $weeklyTarget = 3; // Target 3 setoran per minggu
        $thisWeekSetoran = \App\Models\Hafalan::where('santri_id', $userId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        $weeklyProgress = min(100, round(($thisWeekSetoran / $weeklyTarget) * 100));

        // Get last surah memorized this week
        $lastSurah = \App\Models\Hafalan::where('santri_id', $userId)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->orderBy('created_at', 'desc')
            ->first();

        return view('santri.dashboard', [
            'latestHafalan' => $latestHafalan,
            'totalSetoran' => $totalSetoran,
            'weeklyTarget' => $weeklyTarget,
            'thisWeekSetoran' => $thisWeekSetoran,
            'weeklyProgress' => $weeklyProgress,
            'lastSurah' => $lastSurah,
        ]);
    }

    /**
     * ==================================================
     * HAFALAN HISTORY (SANTRI)
     * ==================================================
     */
    public function hafalanHistory()
    {
        $userId = session('user.id');

        $hafalans = \App\Models\Hafalan::where('santri_id', $userId)
            ->with('ustadz')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('santri.hafalan.index', [
            'hafalans' => $hafalans,
        ]);
    }
}
