<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ustadz\UstadzService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class UstadzController extends Controller
{
    protected $service;

    public function __construct(UstadzService $service)
    {
        $this->service = $service;

        // Hanya admin / superadmin boleh CRUD Ustadz
        // $this->middleware('role:superadmin,admin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data ustadz kosong", 404);
        }

        return ApiResponse::success($data, "Data ustadz ditemukan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Data ustadz tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail ustadz ditemukan");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'required|date',
            'no_hp'          => 'required|string|max:20',
            'alamat'         => 'required|string',
            'status_aktif'   => 'required|in:aktif,nonaktif',
        ]);

        $data = $this->service->store($request->all());

        return ApiResponse::success($data, "Ustadz berhasil ditambahkan");
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($id, $request->all());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui data ustadz", 400);
        }

        return ApiResponse::success($data, "Ustadz berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus ustadz", 400);
        }

        return ApiResponse::success(null, "Ustadz berhasil dihapus");
    }
}
