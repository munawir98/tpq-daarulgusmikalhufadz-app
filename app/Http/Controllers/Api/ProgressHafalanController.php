<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProgressHafalan\ProgressHafalanService;
use App\Http\Requests\ProgressHafalanRequest;
use App\Helpers\ApiResponse;

class ProgressHafalanController extends Controller
{
    protected $service;

    public function __construct(ProgressHafalanService $service)
    {
        $this->service = $service;

        // Jika hanya ustadz/admin/superadmin yang boleh input hafalan:
        // $this->middleware('role:ustadz,admin,superadmin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data progres hafalan kosong", 404);
        }

        return ApiResponse::success($data, "Data progres hafalan ditemukan");
    }

    public function store(ProgressHafalanRequest $request)
    {
        $data = $this->service->store($request->validated());

        return ApiResponse::success($data, "Progres hafalan berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Progres hafalan tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail progres hafalan ditemukan");
    }

    public function update(ProgressHafalanRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui progres hafalan", 400);
        }

        return ApiResponse::success($data, "Progres hafalan berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus progres hafalan", 400);
        }

        return ApiResponse::success(null, "Progres hafalan berhasil dihapus");
    }
}
