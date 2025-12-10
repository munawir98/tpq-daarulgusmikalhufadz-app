<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ustadz;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class PengajarController extends Controller
{
    public function __construct()
    {
        // Hanya admin/superadmin boleh mengelola pengajar
        // $this->middleware('role:superadmin,admin');
    }

    // GET /api/pengajar
    public function index()
    {
        $data = Ustadz::all();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data pengajar kosong", 404);
        }

        return ApiResponse::success($data, "Data pengajar ditemukan");
    }

    // POST /api/pengajar
    public function store(Request $request)
    {
        $request->validate([
            'nama'                     => 'required|string|max:255',
            'jenis_kelamin'            => 'nullable|in:L,P',
            'tanggal_lahir'            => 'nullable|date',
            'no_hp'                    => 'nullable|string|max:20',
            'alamat'                   => 'nullable|string',
            'tanggal_mulai_mengajar'   => 'nullable|date',
            'status_aktif'             => 'nullable|boolean'
        ]);

        $data = Ustadz::create($request->all());

        return ApiResponse::success($data, "Pengajar berhasil ditambahkan");
    }

    // GET /api/pengajar/{id}
    public function show($id)
    {
        $data = Ustadz::find($id);

        if (!$data) {
            return ApiResponse::error("Pengajar tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail pengajar ditemukan");
    }

    // PUT /api/pengajar/{id}
    public function update(Request $request, $id)
    {
        $pengajar = Ustadz::find($id);

        if (!$pengajar) {
            return ApiResponse::error("Pengajar tidak ditemukan", 404);
        }

        $request->validate([
            'nama'                  => 'sometimes|string|max:255',
            'jenis_kelamin'         => 'sometimes|in:L,P',
            'tanggal_lahir'         => 'sometimes|date',
            'no_hp'                 => 'sometimes|string|max:20',
            'alamat'                => 'sometimes|string',
            'tanggal_mulai_mengajar'=> 'sometimes|date',
            'status_aktif'          => 'sometimes|boolean',
        ]);

        $pengajar->update($request->all());

        return ApiResponse::success($pengajar, "Pengajar berhasil diperbarui");
    }

    // DELETE /api/pengajar/{id}
    public function destroy($id)
    {
        $pengajar = Ustadz::find($id);

        if (!$pengajar) {
            return ApiResponse::error("Pengajar tidak ditemukan", 404);
        }

        $pengajar->delete();

        return ApiResponse::success(null, "Pengajar berhasil dihapus");
    }
}
