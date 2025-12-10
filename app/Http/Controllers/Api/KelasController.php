<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Kelas\KelasService;
use App\Http\Requests\KelasRequest;
use App\Helpers\ApiResponse;

class KelasController extends Controller
{
    protected $service;

    public function __construct(KelasService $service)
    {
        $this->service = $service;

        // Role (opsional):
        // Hanya admin & superadmin bisa manage kelas
        // $this->middleware('role:superadmin,admin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data kelas kosong", 404);
        }

        return ApiResponse::success($data, "Data kelas ditemukan");
    }

    public function store(KelasRequest $request)
    {
        $data = $this->service->store($request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal membuat kelas", 400);
        }

        return ApiResponse::success($data, "Kelas berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Kelas tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail kelas ditemukan");
    }

    public function update(KelasRequest $request, $id)
    {
        $data = $this->service->update($id, $request->validated());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui kelas", 400);
        }

        return ApiResponse::success($data, "Kelas berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus kelas", 400);
        }

        return ApiResponse::success(null, "Kelas berhasil dihapus");
    }

    public function search(Request $request)
    {
        $q = $request->q;

        $kelas = Kelas::where('nama_kelas', 'LIKE', "%$q%")
                    ->orWhere('kode_kelas', 'LIKE', "%$q%")
                    ->get();

        return response()->json([
            'status' => true,
            'data' => $kelas
        ]);
    }

}
