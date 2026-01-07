<?php

namespace App\Repositories\Eloquent;

use App\Models\Presensi;
use App\Repositories\Contracts\PresensiRepositoryInterface;
use Carbon\Carbon;

class PresensiRepository implements PresensiRepositoryInterface
{
    // ===============================
    // GET ALL PRESENSI
    // ===============================
    public function all()
    {
        return Presensi::with(['user', 'ustadz', 'jadwal'])
            ->orderBy('id', 'desc')
            ->get();
    }

    // ===============================
    // DETAIL PRESENSI
    // ===============================
    public function find($id)
    {
        return Presensi::with(['user', 'ustadz', 'jadwal'])
            ->findOrFail($id);
    }

    // ===============================
    // HISTORY SANTRI
    // ===============================
    public function byUser($userId)
    {
        return Presensi::with(['jadwal'])
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();
    }

    // ===============================
    // HISTORY USTADZ
    // ===============================
    public function byUstadz($ustadzId)
    {
        return Presensi::with(['jadwal'])
            ->where('ustadz_id', $ustadzId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();
    }

    // ===============================
    // PRESENSI HARI INI (SANTRI / USTADZ)
    // ===============================
    public function checkToday($id, $isUstadz = false)
    {
        return Presensi::where('tanggal', today())
            ->where(function ($q) use ($id, $isUstadz) {
                if ($isUstadz) {
                    $q->where('ustadz_id', $id);
                } else {
                    $q->where('user_id', $id);
                }
            })
            ->latest()
            ->first();
    }

    // ===============================
    // REKAP MINGGUAN SANTRI
    // ===============================
    public function rekapMingguan($userId)
    {
        return Presensi::where('user_id', $userId)
            ->whereBetween('tanggal', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    // ===============================
    // REKAP MINGGUAN USTADZ
    // ===============================
    public function rekapMingguanUstadz($ustadzId)
    {
        return Presensi::where('ustadz_id', $ustadzId)
            ->whereBetween('tanggal', [
                Carbon::now()->subDays(7)->toDateString(),
                Carbon::now()->toDateString()
            ])
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    // ===============================
    // REKAP BULANAN SANTRI
    // ===============================
    public function rekapBulanan($userId, $bulan = null)
    {
        $bulan = $bulan ?? now()->format('Y-m');

        return Presensi::where('user_id', $userId)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan])
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    // ===============================
    // REKAP BULANAN USTADZ
    // ===============================
    public function rekapBulananUstadz($ustadzId, $bulan = null)
    {
        $bulan = $bulan ?? now()->format('Y-m');

        return Presensi::where('ustadz_id', $ustadzId)
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulan])
            ->orderBy('tanggal', 'asc')
            ->get();
    }

    // ===============================
    // GET BY TANGGAL
    // ===============================
    public function byDate($date)
    {
        return Presensi::with(['user', 'ustadz', 'jadwal'])
            ->where('tanggal', $date)
            ->orderBy('jam', 'asc')
            ->get();
    }

    // ===============================
    // CREATE
    // ===============================
    public function create(array $data)
    {
        return Presensi::create($data);
    }

    // ===============================
    // UPDATE
    // ===============================
    public function update($id, array $data)
    {
        $presensi = Presensi::findOrFail($id);
        $presensi->update($data);
        return $presensi;
    }

    // ===============================
    // DELETE
    // ===============================
    public function delete($id)
    {
        $presensi = Presensi::findOrFail($id);
        $presensi->delete();
        return true;
    }
}
