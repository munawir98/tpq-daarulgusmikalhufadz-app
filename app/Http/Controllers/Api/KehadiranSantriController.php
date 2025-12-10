<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KehadiranSantri\KehadiranSantriService;
use App\Http\Requests\KehadiranSantriRequest;
use App\Helpers\ApiResponse;

class KehadiranSantriController extends Controller
{
    protected $service;

    public function __construct(KehadiranSantriService $service)
    {
        $this->service = $service;

        // Role yang diperbolehkan
        // $this->middleware('role:superadmin,admin,ustadz');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data kehadiran santri kosong", 404);
        }

        return ApiResponse::success($data, "Data kehadiran santri ditemukan");
    }

    public function store(KehadiranSantriRequest $request)
    {
        $data = $this->service->store($request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal menambahkan kehadiran santri", 400);
        }

        return ApiResponse::success($data, "Kehadiran santri berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Kehadiran santri tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail kehadiran santri ditemukan");
    }

    public function update(KehadiranSantriRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui kehadiran santri", 400);
        }

        return ApiResponse::success($data, "Kehadiran santri berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus kehadiran santri", 400);
        }

        return ApiResponse::success(null, "Kehadiran santri berhasil dihapus");
    }
}
