<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Santri\SantriService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class SantriController extends Controller
{
    protected $service;

    public function __construct(SantriService $service)
    {
        $this->service = $service;
        // Jika API ini hanya boleh diakses admin/superadmin:
        // $this->middleware('role:superadmin,admin')->except(['show']);
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data santri kosong", 404);
        }

        return ApiResponse::success($data, "Data santri ditemukan");
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'             => 'required|unique:santri,nis',
            'nama_lengkap'    => 'required|string|max:255',
            'jenis_kelamin'   => 'required|in:L,P',
            'tanggal_lahir'   => 'required|date',
            'alamat'          => 'required|string',
            'tanggal_masuk'   => 'required|date',
            'kelas_id'        => 'required|exists:kelas,id',
        ]);

        $data = $this->service->store($request->all());
        return ApiResponse::success($data, "Santri berhasil ditambahkan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("Santri tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail santri ditemukan");
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($request->all(), $id);

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui santri", 400);
        }

        return ApiResponse::success($data, "Santri berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Santri gagal dihapus", 400);
        }

        return ApiResponse::success(null, "Santri berhasil dihapus");
    }
}
