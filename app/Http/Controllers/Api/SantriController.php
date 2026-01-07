<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Santri\SantriService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\AssignSantriKelasRequest;
use App\Http\Resources\SantriResource;
use App\Http\Resources\SantriListResource;
use App\Imports\SantriImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SantriController extends Controller
{
    protected SantriService $service;

    public function __construct(SantriService $service)
    {
        $this->service = $service;
    }

    /**
     * =========================
     * GET /api/santri
     * MOBILE LIST (RINGAN)
     * =========================
     */
    public function index()
    {
        try {
            $data = $this->service->index();

            // SAFETY NET: pastikan Collection
            if (!($data instanceof Collection)) {
                $data = collect($data);
            }

            return ApiResponse::success(
                SantriListResource::collection($data),
                'Data santri'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal memuat data santri',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * POST /api/santri
     * =========================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis'           => 'required|unique:santri,nis',
            'nama_lengkap'  => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'tanggal_masuk' => 'required|date',
            'kelas_id'      => 'required|exists:kelas,id',
        ]);

        try {
            $santri = $this->service->store($validated);

            return ApiResponse::success(
                new SantriResource($santri),
                'Santri berhasil ditambahkan'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal menambahkan santri',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * GET /api/santri/{id}
     * DETAIL (LENGKAP)
     * =========================
     */
    public function show(int $id)
    {
        try {
            $santri = $this->service->show($id);

            return ApiResponse::success(
                new SantriResource($santri),
                'Detail santri ditemukan'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Santri tidak ditemukan',
                404,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * PUT /api/santri/{id}
     * =========================
     */
    public function update(Request $request, int $id)
    {
        try {
            $santri = $this->service->update($request->all(), $id);

            return ApiResponse::success(
                new SantriResource($santri),
                'Santri berhasil diperbarui'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal memperbarui santri',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * DELETE /api/santri/{id}
     * =========================
     */
    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);

            return ApiResponse::success(
                null,
                'Santri berhasil dihapus'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal menghapus santri',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * PUT /api/santri/{id}/assign-kelas
     * =========================
     */
    public function assignKelas(
        AssignSantriKelasRequest $request,
        int $id
    ) {
        try {
            $santri = $this->service->assignKelas(
                $id,
                $request->kelas_id
            );

            return ApiResponse::success(
                new SantriResource($santri),
                'Santri berhasil ditetapkan ke kelas'
            );
        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal menetapkan kelas santri',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * POST /api/santri/import
     * =========================
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $import = new SantriImport();
            Excel::import($import, $request->file('file'));

            DB::commit();

            return ApiResponse::success([
                'success' => $import->success,
                'failed'  => $import->failed,
                'errors'  => $import->errors,
            ], 'Import santri selesai');

        } catch (\Throwable $e) {
            DB::rollBack();

            return ApiResponse::error(
                'Import santri gagal',
                500,
                config('app.debug') ? $e->getMessage() : null
            );
        }
    }

    /**
     * =========================
     * GET /api/santri/template
     * =========================
     */
    public function downloadTemplate()
    {
        $path = storage_path('app/templates/template_import_santri.xlsx');

        if (!file_exists($path)) {
            return ApiResponse::error(
                'Template import santri tidak ditemukan',
                404
            );
        }

        return response()->download(
            $path,
            'template_import_santri.xlsx',
            [
                'Content-Type' =>
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        );
    }
}
