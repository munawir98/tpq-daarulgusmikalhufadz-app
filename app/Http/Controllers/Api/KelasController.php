<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KelasRequest;
use App\Http\Resources\KelasResource;
use App\Services\Kelas\KelasService;
use App\Helpers\ApiResponse;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KelasExport;
use App\Imports\KelasImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class KelasController extends Controller
{
    protected KelasService $service;

    public function __construct(KelasService $service)
    {
        $this->service = $service;
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // HARUS paginator (LengthAwarePaginator)
        $paginator = $this->service->paginateAktif($request);

        return ApiResponse::paginate(
            $paginator,
            KelasResource::class,
            'Berhasil mengambil data kelas'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | POST /api/kelas
    |--------------------------------------------------------------------------
    */
    public function store(KelasRequest $request)
    {
        $kelas = $this->service->store($request->validated());

        return ApiResponse::success(
            new KelasResource($kelas),
            'Kelas berhasil ditambahkan',
            Response::HTTP_CREATED
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas/{id}
    |--------------------------------------------------------------------------
    */
    public function show(int $id)
    {
        $kelas = $this->service->find($id);

        return ApiResponse::success(
            new KelasResource($kelas),
            'Detail kelas ditemukan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PUT /api/kelas/{id}
    |--------------------------------------------------------------------------
    */
    public function update(KelasRequest $request, int $id)
    {
        $kelas = $this->service->update(
            $id,
            $request->validated()
        );

        return ApiResponse::success(
            new KelasResource($kelas),
            'Kelas berhasil diperbarui'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE /api/kelas/{id}
    |--------------------------------------------------------------------------
    */
    public function destroy(int $id)
    {
        $kelas = $this->service->nonaktifkan($id);

        return ApiResponse::success(
            new KelasResource($kelas),
            'Kelas berhasil dinonaktifkan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas/search?q=
    |--------------------------------------------------------------------------
    */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string',
        ]);

        return ApiResponse::success(
            KelasResource::collection(
                $this->service->search($request->q)
            ),
            'Hasil pencarian kelas'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas/filter/tingkat/{tingkat}
    |--------------------------------------------------------------------------
    */
    public function filterByTingkat(string $tingkat)
    {
        $tingkat = strtoupper($tingkat);

        if (!in_array($tingkat, ['ULA', 'WUSTHA'])) {
            return ApiResponse::error(
                'Tingkat tidak valid (gunakan ULA atau WUSTHA)',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return ApiResponse::success(
            KelasResource::collection(
                $this->service->filterByTingkat($tingkat)
            ),
            'Hasil filter kelas berdasarkan tingkat'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas/filter/ustadz/{ustadzId}
    |--------------------------------------------------------------------------
    */
    public function filterByUstadz(int $ustadzId)
    {
        return ApiResponse::success(
            KelasResource::collection(
                $this->service->filterByUstadz($ustadzId)
            ),
            'Hasil filter kelas berdasarkan ustadz'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas/{kelasId}/rekap-presensi
    |--------------------------------------------------------------------------
    */
    public function rekapPresensi(Request $request, int $kelasId)
    {
        $request->validate([
            'bulan' => 'required|date_format:Y-m',
        ]);

        return ApiResponse::success(
            $this->service->rekapPresensiBulanan(
                $kelasId,
                $request->bulan
            ),
            'Rekap presensi kelas bulan ' . $request->bulan
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/kelas/{kelasId}/statistik
    |--------------------------------------------------------------------------
    */
    public function statistik(int $kelasId)
    {
        return ApiResponse::success(
            $this->service->statistikKelas($kelasId),
            'Statistik kelas'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel()
    {
        return Excel::download(
            new KelasExport(),
            'data-kelas.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function importExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                $validator->errors()->first(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        try {
            $import = new KelasImport();
            Excel::import($import, $request->file('file'));

            return ApiResponse::success([
                'success'     => $import->success,
                'failed'      => $import->failed,
                'failed_rows' => $import->failedRows ?? [],
                'errors'      => $import->errors ?? [],
            ], 'Import data kelas selesai');

        } catch (\Throwable $e) {
            Log::error('Import Excel Kelas gagal', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return ApiResponse::error(
                'Gagal import data kelas',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
    public function exportPdf(Request $request)
    {
        try {
            $query = Kelas::where('status', 'aktif')->with('ustadz');

            if ($request->filled('tingkat')) {
                $query->where('tingkat', $request->tingkat);
            }

            if ($request->filled('ustadz_id')) {
                $query->where('ustadz_id', $request->ustadz_id);
            }

            $kelas = $query->get();

            if ($kelas->isEmpty()) {
                return ApiResponse::error(
                    'Data kelas tidak ditemukan',
                    Response::HTTP_NOT_FOUND
                );
            }

            $tanggalCetak = now()->translatedFormat('d F Y');

            $pdf = Pdf::loadView(
                'kelas.pdf',
                compact('kelas', 'tanggalCetak')
            )->setPaper('A4', 'portrait');

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'laporan-data-kelas.pdf',
                ['Content-Type' => 'application/pdf']
            );

        } catch (\Throwable $e) {
            Log::error('Export PDF API Kelas gagal', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return ApiResponse::error(
                'Gagal generate PDF',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
