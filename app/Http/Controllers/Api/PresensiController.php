<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Presensi\PresensiService;
use App\Helpers\ApiResponse;
use App\Events\PresensiMasukUstadz;
use App\Events\PresensiPulangUstadz;

class PresensiController extends Controller
{
    protected $service;

    public function __construct(PresensiService $service)
    {
        $this->service = $service;
    }

    // =====================================================
    // SANTRI: MASUK
    // =====================================================
    public function masukSantri(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'metode'    => 'nullable|string|in:manual,gps,qr',
            'qr_code'   => 'nullable|string',
        ]);

        // QR Check
        if ($request->metode === 'qr' && !$this->service->validateQR($request->qr_code)) {
            return ApiResponse::error("QR Code tidak valid", 422);
        }

        // Radius Check
        $radius = $this->service->cekRadius($request->latitude, $request->longitude);
        if (!$radius['status']) return ApiResponse::error("Anda berada di luar area presensi", 422);

        $data = [
            'user_id'   => $request->user()->id,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'foto'      => $request->file('foto'),
            'metode'    => $request->metode ?? 'manual',
            'qr_code'   => $request->qr_code,
        ];

        return ApiResponse::success(
            $this->service->masukSantri($data),
            "Presensi masuk santri berhasil"
        );
    }

    // =====================================================
    // SANTRI: PULANG
    // =====================================================
    public function pulangSantri(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $radius = $this->service->cekRadius($request->latitude, $request->longitude);
        if (!$radius['status']) return ApiResponse::error("Anda berada di luar area presensi", 422);

        $data = [
            'user_id'   => $request->user()->id,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'foto'      => $request->file('foto'),
        ];

        return ApiResponse::success(
            $this->service->pulangSantri($data),
            "Presensi pulang santri berhasil"
        );
    }

    // =====================================================
    // USTADZ: MASUK
    // =====================================================
    public function masukUstadz(Request $request)
    {
        if ($request->user()->role !== 'USTADZ') {
            return ApiResponse::error("Akses khusus ustadz", 403);
        }

        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'metode'    => 'nullable|string|in:manual,gps,qr',
            'qr_code'   => 'nullable|string',
        ]);

        if ($request->metode === 'qr' && !$this->service->validateQR($request->qr_code)) {
            return ApiResponse::error("QR Code tidak valid", 422);
        }

        $radius = $this->service->cekRadius($request->latitude, $request->longitude);
        if (!$radius['status']) return ApiResponse::error("Anda berada di luar area presensi", 422);

        $data = [
            'ustadz_id' => $request->user()->id,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'foto'      => $request->file('foto'),
            'metode'    => $request->metode ?? 'manual',
            'qr_code'   => $request->qr_code,
        ];

        // SIMPAN PRESENSI
        $presensi = $this->service->masukUstadz($data);

        // TRIGGER EVENT
        event(new PresensiMasukUstadz($presensi));

        return ApiResponse::success(
            $presensi,
            "Presensi masuk ustadz berhasil"
        );
    }

    // =====================================================
    // USTADZ: PULANG
    // =====================================================
    public function pulangUstadz(Request $request)
    {
        if ($request->user()->role !== 'USTADZ') {
            return ApiResponse::error("Akses khusus ustadz", 403);
        }

        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $radius = $this->service->cekRadius($request->latitude, $request->longitude);
        if (!$radius['status']) return ApiResponse::error("Anda berada di luar area presensi", 422);

        $data = [
            'ustadz_id' => $request->user()->id,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'foto'      => $request->file('foto'),
        ];

        // SIMPAN PRESENSI
        $presensi = $this->service->pulangUstadz($data);

        // TRIGGER EVENT
        event(new PresensiPulangUstadz($presensi));

        return ApiResponse::success(
            $presensi,
            "Presensi pulang ustadz berhasil"
        );
    }

    // =====================================================
    // IZIN
    // =====================================================
    public function izin(Request $request)
    {
        $request->validate(['keterangan' => 'required|string|min:3']);

        return ApiResponse::success(
            $this->service->izin($request->user()->id, $request->keterangan),
            "Izin berhasil dicatat"
        );
    }

    // =====================================================
    // SAKIT
    // =====================================================
    public function sakit(Request $request)
    {
        $request->validate(['keterangan' => 'required|string|min:3']);

        return ApiResponse::success(
            $this->service->sakit($request->user()->id, $request->keterangan),
            "Status sakit berhasil dicatat"
        );
    }

    // =====================================================
    // OFFLINE SYNC
    // =====================================================
    public function syncOffline(Request $request)
    {
        $request->validate(['items' => 'required|array']);
        $this->service->syncOffline($request->items);

        return ApiResponse::success(null, "Sync offline berhasil");
    }

    // =====================================================
    // DETAIL PRESENSI
    // =====================================================
    public function show($id)
    {
        return ApiResponse::success(
            $this->service->show($id),
            "Detail presensi ditemukan"
        );
    }

    // =====================================================
    // HISTORY SANTRI
    // =====================================================
    public function history(Request $request)
    {
        return ApiResponse::success(
            $this->service->history($request->user()->id),
            "History presensi ditemukan"
        );
    }

    // =====================================================
    // REKAP MINGGUAN
    // =====================================================
    public function rekapMingguan(Request $request)
    {
        return ApiResponse::success(
            $this->service->rekapMingguan($request->user()->id),
            "Rekap mingguan ditemukan"
        );
    }

    // =====================================================
    // REKAP BULANAN
    // =====================================================
    public function rekapBulanan(Request $request)
    {
        return ApiResponse::success(
            $this->service->rekapBulanan($request->user()->id),
            "Rekap bulanan ditemukan"
        );
    }

    // =====================================================
    // TODAY SANTRI
    // =====================================================
    public function todaySantri($id)
    {
        return ApiResponse::success(
            $this->service->today($id, false),
            "Presensi santri hari ini"
        );
    }

    // =====================================================
    // TODAY USTADZ
    // =====================================================
    public function todayUstadz($id)
    {
        return ApiResponse::success(
            $this->service->today($id, true),
            "Presensi ustadz hari ini"
        );
    }

    // =====================================================
    // LAPORAN BULANAN PDF
    // =====================================================
    public function downloadBulanan($bulan)
    {
        return ApiResponse::success(
            $this->service->exportLaporanBulanan(auth()->id(), $bulan),
            "Export laporan bulanan berhasil"
        );
    }

    // =====================================================
    // CHART
    // =====================================================
    public function chartBulanan($bulan)
    {
        return ApiResponse::success($this->service->chartBulanan($bulan));
    }

    public function chartTahunan($tahun)
    {
        return ApiResponse::success($this->service->chartTahunan($tahun));
    }

    public function chartRange(Request $request)
    {
        return ApiResponse::success(
            $this->service->chartRange($request->start, $request->end)
        );
    }

    // =====================================================
    // FILTER DATA
    // =====================================================
    public function filter(Request $request)
    {
        return ApiResponse::success(
            $this->service->filterData($request->type, $request->value)
        );
    }
}
