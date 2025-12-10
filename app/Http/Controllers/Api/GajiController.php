<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Gaji\GajiService;
use App\Http\Requests\GajiRequest;
use App\Helpers\ApiResponse;

class GajiController extends Controller
{
    protected $service;

    public function __construct(GajiService $service)
    {
        $this->service = $service;

        // Aktifkan jika hanya admin & superadmin yang boleh kelola gaji
        // $this->middleware('role:superadmin,admin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data gaji tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "List data gaji ditemukan");
    }

    public function store(GajiRequest $request)
    {
        $data = $this->service->store($request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal menyimpan data gaji", 400);
        }

        return ApiResponse::success($data, "Data gaji berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Data gaji tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail gaji ditemukan");
    }

    public function update(GajiRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui data gaji", 400);
        }

        return ApiResponse::success($data, "Data gaji berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus data gaji", 400);
        }

        return ApiResponse::success(null, "Data gaji berhasil dihapus");
    }
}
