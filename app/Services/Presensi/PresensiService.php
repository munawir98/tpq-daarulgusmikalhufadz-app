<?php

namespace App\Services\Presensi;

use App\Repositories\Contracts\PresensiRepositoryInterface;
use App\Repositories\Contracts\JadwalMengajarRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Ustadz;
use App\Models\Santri;

class PresensiService
{
    protected $repo, $jadwalRepo;

    public function __construct(
        PresensiRepositoryInterface $repo,
        JadwalMengajarRepositoryInterface $jadwalRepo
    ) {
        $this->repo = $repo;
        $this->jadwalRepo = $jadwalRepo;
    }

    // =====================================================
    // GPS RADIUS CHECK
    // =====================================================
    public function cekRadius($lat, $lng)
    {
        // TODO: Ganti dengan Koordinat TPQ yang Real
        // Masjid Albir Brigade Arsy, Jl. P Dan K, Kedung Halang, Bogor
        $centerLat = -6.551824;
        $centerLng = 106.816065;
        $radiusAllowed = 50; // 50 meters

        $distance = $this->haversine($lat, $lng, $centerLat, $centerLng);

        return [
            'status'   => $distance <= $radiusAllowed,
            'distance' => $distance
        ];
    }

    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $earth = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLng / 2) ** 2;

        return $earth * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }

    // =====================================================
    // QR VALIDATION
    // =====================================================
    public function validateQR($qr)
    {
        return $qr === "TPQ-GUSMIK-VALID";
    }

    // =====================================================
    // SHIFT & TERLAMBAT (USTADZ)
    // =====================================================
    public function detectShiftAndLate(int $ustadzId): array
    {
        if (!Ustadz::whereKey($ustadzId)->exists()) {
            return ['jadwal' => null, 'is_late' => false];
        }

        $now = now()->format("H:i");
        $jadwal = $this->jadwalRepo->findShiftForUser($ustadzId, $now);

        if (!$jadwal) {
            return ['jadwal' => null, 'is_late' => false];
        }

        return [
            'jadwal'  => $jadwal,
            'is_late' => $now > $jadwal->waktu_mulai
        ];
    }

    // =====================================================
    // DOUBLE CHECK
    // =====================================================
    private function checkDouble($id, $type, $isUstadz)
    {
        $today = $this->repo->checkToday($id, $isUstadz);
        return $today && $today->tipe === $type;
    }

    // =====================================================
    // VALIDASI SANTRI (HELPER)
    // =====================================================
    private function validateSantri(int $userId)
    {
        $santri = Santri::where('user_id', $userId)->first();

        if (!$santri) {
            return [
                'status'  => false,
                'message' => 'User belum terdaftar sebagai santri'
            ];
        }

        if (!$santri->kelas_id) {
            return [
                'status'  => false,
                'message' => 'Santri belum terdaftar di kelas'
            ];
        }

        return $santri;
    }

    // =====================================================
    // SANTRI MASUK
    // =====================================================
    public function masukSantri(array $data)
    {
        $santri = $this->validateSantri($data['user_id']);
        if (isset($santri['status']) && $santri['status'] === false) {
            return $santri;
        }

        if ($this->checkDouble($data['user_id'], 'masuk', false)) {
            return ['status' => false, 'message' => "Sudah presensi MASUK hari ini"];
        }

        if (!empty($data['foto'])) {
            $data['foto'] = $data['foto']->store('presensi/santri', 'public');
        }

        $data['tanggal']         = today();
        $data['jam']             = now()->format("H:i:s");
        $data['tipe']            = 'masuk';
        $data['status_presensi'] = 'HADIR';

        return $this->repo->create($data);
    }

    // =====================================================
    // SANTRI PULANG
    // =====================================================
    public function pulangSantri(array $data)
    {
        $santri = $this->validateSantri($data['user_id']);
        if (isset($santri['status']) && $santri['status'] === false) {
            return $santri;
        }

        if ($this->checkDouble($data['user_id'], 'pulang', false)) {
            return ['status' => false, 'message' => "Sudah presensi PULANG hari ini"];
        }

        if (!empty($data['foto'])) {
            $data['foto'] = $data['foto']->store('presensi/santri', 'public');
        }

        $data['tanggal'] = today();
        $data['jam']     = now()->format("H:i:s");
        $data['tipe']    = 'pulang';

        return $this->repo->create($data);
    }

    // =====================================================
    // USTADZ MASUK
    // =====================================================
    public function masukUstadz(array $data)
    {
        $ustadzId = (int) $data['ustadz_id'];

        if ($this->checkDouble($ustadzId, 'masuk', true)) {
            return ['status' => false, 'message' => "Sudah presensi MASUK hari ini"];
        }

        if (!empty($data['foto'])) {
            $data['foto'] = $data['foto']->store('presensi/ustadz', 'public');
        }

        $shift = $this->detectShiftAndLate($ustadzId);

        $data['tanggal']         = today();
        $data['jam']             = now()->format("H:i:s");
        $data['tipe']            = 'masuk';
        $data['user_id']         = null;
        $data['jadwal_id']       = $shift['jadwal']->id ?? null;
        $data['is_late']         = $shift['is_late'];
        $data['status_presensi'] = $shift['is_late'] ? 'TERLAMBAT' : 'HADIR';

        return $this->repo->create($data);
    }

    // =====================================================
    // USTADZ PULANG
    // =====================================================
    public function pulangUstadz(array $data)
    {
        $ustadzId = (int) $data['ustadz_id'];

        if ($this->checkDouble($ustadzId, 'pulang', true)) {
            return ['status' => false, 'message' => "Sudah presensi PULANG hari ini"];
        }

        if (!empty($data['foto'])) {
            $data['foto'] = $data['foto']->store('presensi/ustadz', 'public');
        }

        $shift = $this->detectShiftAndLate($ustadzId);

        $data['tanggal']   = today();
        $data['jam']       = now()->format("H:i:s");
        $data['tipe']      = 'pulang';
        $data['user_id']   = null;
        $data['jadwal_id'] = $shift['jadwal']->id ?? null;

        return $this->repo->create($data);
    }

    // =====================================================
    // IZIN
    // =====================================================
    public function izin(int $userId, string $ket)
    {
        $santri = $this->validateSantri($userId);
        if (isset($santri['status']) && $santri['status'] === false) {
            return $santri;
        }

        return $this->repo->create([
            'user_id'         => $userId,
            'tanggal'         => today(),
            'jam'             => now()->format("H:i:s"),
            'tipe'            => 'masuk',
            'status_presensi' => 'IZIN',
            'keterangan'      => $ket
        ]);
    }

    // =====================================================
    // SAKIT
    // =====================================================
    public function sakit(int $userId, string $ket)
    {
        $santri = $this->validateSantri($userId);
        if (isset($santri['status']) && $santri['status'] === false) {
            return $santri;
        }

        return $this->repo->create([
            'user_id'         => $userId,
            'tanggal'         => today(),
            'jam'             => now()->format("H:i:s"),
            'tipe'            => 'masuk',
            'status_presensi' => 'SAKIT',
            'keterangan'      => $ket
        ]);
    }

    // =====================================================
    // OFFLINE SYNC
    // =====================================================
    public function syncOffline(array $items)
    {
        foreach ($items as $item) {
            $this->repo->create($item);
        }
        return true;
    }

    // =====================================================
    // TODAY / HISTORY / REKAP
    // =====================================================
    public function today($id, $isUstadz = false)
    {
        return $this->repo->checkToday($id, $isUstadz);
    }

    public function history($userId)
    {
        return $this->repo->byUser($userId);
    }

    public function rekapMingguan($userId)
    {
        return $this->repo->rekapMingguan($userId);
    }

    public function rekapBulanan($userId, $bulan = null)
    {
        return $this->repo->rekapBulanan($userId, $bulan);
    }

    // =====================================================
    // EXPORT PDF
    // =====================================================
    public function exportLaporanBulanan($userId, $bulan)
    {
        $data = $this->repo->rekapBulanan($userId, $bulan);

        $pdf = Pdf::loadView('pdf.laporan_bulanan', compact('data', 'bulan'));

        $filename = "laporan-presensi-{$userId}-{$bulan}.pdf";

        Storage::disk('public')->put("laporan/$filename", $pdf->output());

        return [
            'status' => true,
            'url'    => asset("storage/laporan/$filename")
        ];
    }

    // =====================================================
    // CHART & FILTER
    // =====================================================
    public function chartBulanan($bulan)
    {
        return DB::select("
            SELECT DATE(tanggal) AS hari,
                   SUM(status_presensi = 'HADIR') AS hadir,
                   SUM(status_presensi = 'TERLAMBAT') AS terlambat,
                   SUM(status_presensi = 'IZIN') AS izin,
                   SUM(status_presensi = 'SAKIT') AS sakit,
                   SUM(status_presensi = 'ALPHA') AS alfa
            FROM presensi
            WHERE DATE_FORMAT(tanggal, '%Y-%m') = ?
            GROUP BY DATE(tanggal)
            ORDER BY hari ASC
        ", [$bulan]);
    }

    public function chartTahunan($tahun)
    {
        return DB::select("
            SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan,
                   COUNT(*) AS total
            FROM presensi
            WHERE YEAR(tanggal) = ?
            GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
            ORDER BY bulan ASC
        ", [$tahun]);
    }

    public function chartRange($start, $end)
    {
        return DB::select("
            SELECT DATE(tanggal) AS hari,
                   SUM(status_presensi = 'HADIR') AS hadir,
                   SUM(status_presensi = 'TERLAMBAT') AS terlambat,
                   SUM(status_presensi = 'IZIN') AS izin,
                   SUM(status_presensi = 'SAKIT') AS sakit,
                   SUM(status_presensi = 'ALPHA') AS alfa
            FROM presensi
            WHERE tanggal BETWEEN ? AND ?
            GROUP BY tanggal
            ORDER BY tanggal ASC
        ", [$start, $end]);
    }

    public function filterData($type, $value)
    {
        $column = match ($type) {
            'kelas'  => 'kelas_id',
            'ustadz' => 'ustadz_id',
            'santri' => 'user_id',
            default  => 'user_id'
        };

        return DB::table('presensi')
            ->where($column, $value)
            ->orderBy('tanggal', 'asc')
            ->get();
    }
}
