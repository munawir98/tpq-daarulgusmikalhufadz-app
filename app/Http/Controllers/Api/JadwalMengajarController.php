<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\JadwalMengajar\JadwalMengajarService;
use App\Http\Requests\JadwalMengajarRequest;
use App\Helpers\ApiResponse;

class JadwalMengajarController extends Controller
{
    protected $service;

    public function __construct(JadwalMengajarService $service)
    {
        $this->service = $service;

        // Hanya admin & superadmin yang bisa kelola jadwal
        // $this->middleware('role:superadmin,admin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data jadwal mengajar kosong", 404);
        }

        return ApiResponse::success($data, "Data jadwal mengajar ditemukan");
    }

    public function store(JadwalMengajarRequest $request)
    {
        $data = $this->service->store($request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal menambahkan jadwal mengajar", 400);
        }

        return ApiResponse::success($data, "Jadwal mengajar berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Jadwal mengajar tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail jadwal mengajar ditemukan");
    }

    public function update(JadwalMengajarRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui jadwal mengajar", 400);
        }

        return ApiResponse::success($data, "Jadwal mengajar berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus jadwal mengajar", 400);
        }

        return ApiResponse::success(null, "Jadwal mengajar berhasil dihapus");
    }
}
