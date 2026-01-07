<?php

namespace App\Services\Kelas;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KelasService
{
    /*
    |--------------------------------------------------------------------------
    | KELAS AKTIF
    |--------------------------------------------------------------------------
    */

    /**
     * Pagination kelas aktif (cached, AMAN untuk page)
     */
    public function paginateAktif(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $page    = (int) $request->get('page', 1);

        $cacheKey = "kelas_aktif_page_{$page}_{$perPage}";

        return Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($perPage) {
                return Kelas::aktif()
                    ->with('ustadz')
                    ->orderBy('tingkat')
                    ->orderBy('nama_kelas')
                    ->paginate($perPage);
            }
        );
    }

    /**
     * Simpan kelas baru
     */
    public function store(array $data): Kelas
    {
        if (isset($data['status'])) {
            $data['status'] = $data['status'] ? 'aktif' : 'nonaktif';
        }

        $kelas = Kelas::create($data);

        Cache::flush(); // aman & simpel

        return $kelas;
    }

    /**
     * Ambil detail kelas aktif
     */
    public function find(int $id): ?Kelas
    {
        return Kelas::aktif()
            ->with(['ustadz', 'santri'])
            ->find($id);
    }

    /**
     * Update kelas
     */
    public function update(int $id, array $data): Kelas
    {
        $kelas = Kelas::findOrFail($id);

        if (isset($data['status'])) {
            $data['status'] = $data['status'] ? 'aktif' : 'nonaktif';
        }

        $kelas->update($data);

        Cache::flush();

        return $kelas->fresh();
    }

    /**
     * Nonaktifkan kelas
     */
    public function nonaktifkan(int $id): Kelas
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'status' => 'nonaktif',
        ]);

        Cache::flush();

        return $kelas->fresh();
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH & FILTER
    |--------------------------------------------------------------------------
    */

    /**
     * Pencarian kelas aktif
     */
    public function search(string $keyword)
    {
        return Kelas::aktif()
            ->with('ustadz')
            ->where(function ($q) use ($keyword) {
                $q->where('nama_kelas', 'like', "%{$keyword}%")
                  ->orWhere('kode_kelas', 'like', "%{$keyword}%");
            })
            ->orderBy('nama_kelas')
            ->get();
    }

    /**
     * Filter kelas berdasarkan tingkat
     */
    public function filterByTingkat(string $tingkat)
    {
        return Kelas::aktif()
            ->with('ustadz')
            ->where('tingkat', $tingkat)
            ->orderBy('nama_kelas')
            ->get();
    }

    /**
     * Filter kelas berdasarkan ustadz
     */
    public function filterByUstadz(int $ustadzId)
    {
        return Kelas::aktif()
            ->with('ustadz')
            ->where('ustadz_id', $ustadzId)
            ->orderBy('nama_kelas')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | KELAS NONAKTIF
    |--------------------------------------------------------------------------
    */

    /**
     * Ambil semua kelas nonaktif
     */
    public function getNonaktif()
    {
        return Kelas::withoutGlobalScope('aktif')
            ->where('status', 'nonaktif')
            ->with('ustadz')
            ->orderBy('nama_kelas')
            ->get();
    }

    /**
     * Restore kelas nonaktif
     */
    public function restore(int $id): Kelas
    {
        $kelas = Kelas::withoutGlobalScope('aktif')->findOrFail($id);

        $kelas->update([
            'status' => 'aktif',
        ]);

        Cache::flush();

        return $kelas->fresh();
    }

    /*
    |--------------------------------------------------------------------------
    | PRESENSI
    |--------------------------------------------------------------------------
    */

    /**
     * Rekap presensi bulanan per kelas
     */
    public function rekapPresensiBulanan(int $kelasId, string $bulan)
    {
        [$tahun, $bulanAngka] = explode('-', $bulan);

        $start = Carbon::create($tahun, $bulanAngka, 1)->startOfMonth();
        $end   = Carbon::create($tahun, $bulanAngka, 1)->endOfMonth();

        $userIds = Santri::where('kelas_id', $kelasId)->pluck('user_id');

        return Presensi::selectRaw("
                user_id,
                COUNT(*) as total_pertemuan,
                SUM(CASE WHEN status_presensi = 'HADIR' THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status_presensi = 'TERLAMBAT' THEN 1 ELSE 0 END) as terlambat,
                SUM(CASE WHEN status_presensi = 'IZIN' THEN 1 ELSE 0 END) as izin,
                SUM(CASE WHEN status_presensi = 'SAKIT' THEN 1 ELSE 0 END) as sakit,
                SUM(CASE WHEN status_presensi = 'ALPHA' THEN 1 ELSE 0 END) as alpha
            ")
            ->whereIn('user_id', $userIds)
            ->whereBetween('tanggal', [$start, $end])
            ->where('tipe', 'masuk')
            ->groupBy('user_id')
            ->with('santri:user_id,nama_lengkap')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | STATISTIK
    |--------------------------------------------------------------------------
    */

    /**
     * Statistik kelas bulan berjalan
     */
    public function statistikKelas(int $kelasId): array
    {
        $bulanIni = Carbon::now()->format('Y-m');
        [$tahun, $bulan] = explode('-', $bulanIni);

        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end   = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $totalSantri = Santri::where('kelas_id', $kelasId)->count();
        $userIds     = Santri::where('kelas_id', $kelasId)->pluck('user_id');

        $presensi = Presensi::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status_presensi = 'HADIR' THEN 1 ELSE 0 END) as hadir,
                SUM(CASE WHEN status_presensi = 'TERLAMBAT' THEN 1 ELSE 0 END) as terlambat,
                SUM(CASE WHEN status_presensi = 'IZIN' THEN 1 ELSE 0 END) as izin,
                SUM(CASE WHEN status_presensi = 'SAKIT' THEN 1 ELSE 0 END) as sakit,
                SUM(CASE WHEN status_presensi = 'ALPHA' THEN 1 ELSE 0 END) as alpha
            ")
            ->whereIn('user_id', $userIds)
            ->whereBetween('tanggal', [$start, $end])
            ->where('tipe', 'masuk')
            ->first();

        return [
            'total_santri' => $totalSantri,
            'bulan'        => $bulanIni,
            'presensi'     => [
                'total'     => (int) ($presensi->total ?? 0),
                'hadir'     => (int) ($presensi->hadir ?? 0),
                'terlambat' => (int) ($presensi->terlambat ?? 0),
                'izin'      => (int) ($presensi->izin ?? 0),
                'sakit'     => (int) ($presensi->sakit ?? 0),
                'alpha'     => (int) ($presensi->alpha ?? 0),
            ],
        ];
    }
}
