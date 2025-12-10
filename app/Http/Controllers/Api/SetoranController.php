<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Setoran\SetoranService;
use App\Http\Requests\SetoranRequest;
use App\Helpers\ApiResponse;

class SetoranController extends Controller
{
    protected $service;

    public function __construct(SetoranService $service)
    {
        $this->service = $service;

        // Jika aturan role:
        // $this->middleware('role:ustadz,admin,superadmin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data setoran belum ada", 404);
        }

        return ApiResponse::success($data, "Data setoran ditemukan");
    }

    public function store(SetoranRequest $request)
    {
        $data = $this->service->store($request->validated());

        return ApiResponse::success($data, "Setoran berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Data setoran tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail setoran ditemukan");
    }

    public function update(SetoranRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui setoran", 400);
        }

        return ApiResponse::success($data, "Setoran berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus setoran", 400);
        }

        return ApiResponse::success(null, "Setoran berhasil dihapus");
    }
}
