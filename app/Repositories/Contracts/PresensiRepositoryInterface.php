<?php

namespace App\Repositories\Contracts;

interface PresensiRepositoryInterface
{
    // ==========================================
    // DATA DASAR
    // ==========================================
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    // ==========================================
    // SANTRI (user_id)
    // ==========================================
    public function byUser($userId);
    public function rekapMingguan($userId);
    public function rekapBulanan($userId, $bulan = null);

    // ==========================================
    // USTADZ (ustadz_id)
    // ==========================================
    public function byUstadz($ustadzId);
    public function rekapMingguanUstadz($ustadzId);
    public function rekapBulananUstadz($ustadzId, $bulan = null);

    // ==========================================
    // GENERAL
    // ==========================================
    public function byDate($date);

    // PRESENSI HARI INI (bisa santri atau ustadz)
    public function checkToday($id, $isUstadz = false);
}
