<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Infaq;
use App\Helpers\ApiResponse;

class InfaqController extends Controller
{
    public function __construct()
    {
        // Boleh kamu aktifkan jika perlu
        // $this->middleware('role:superadmin,admin,ustadz');
    }

    /**
     * Menampilkan seluruh data infaq
     */
    public function index()
    {
        $data = Infaq::all();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data infaq kosong", 404);
        }

        return ApiResponse::success($data, "List data infaq");
    }

    /**
     * Menampilkan detail infaq berdasarkan id
     */
    public function show($id)
    {
        $data = Infaq::find($id);

        if (!$data) {
            return ApiResponse::error("Data infaq tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail infaq ditemukan");
    }

    /**
     * Menambahkan data infaq
     */
    public function store(Request $request)
    {
        // Validasi termasuk keterangan
        $request->validate([
            'santri_id'  => 'required|exists:santri,id',
            'jumlah'     => 'required|numeric|min:100',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $data = Infaq::create([
            'santri_id'  => $request->santri_id,
            'jumlah'     => $request->jumlah,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return ApiResponse::success($data, "Infaq berhasil dicatat");
    }

    /**
     * Mengupdate data infaq
     */
    public function update(Request $request, $id)
    {
        $data = Infaq::find($id);

        if (!$data) {
            return ApiResponse::error("Data infaq tidak ditemukan", 404);
        }

        $request->validate([
            'santri_id'  => 'sometimes|exists:santri,id',
            'jumlah'     => 'sometimes|numeric|min:100',
            'tanggal'    => 'sometimes|date',
            'keterangan' => 'sometimes|string|max:255',
        ]);

        $data->update($request->all());

        return ApiResponse::success($data, "Infaq berhasil diperbarui");
    }

    /**
     * Menghapus data infaq
     */
    public function destroy($id)
    {
        $data = Infaq::find($id);

        if (!$data) {
            return ApiResponse::error("Data infaq tidak ditemukan", 404);
        }

        $data->delete();

        return ApiResponse::success(null, "Infaq berhasil dihapus");
    }
}
