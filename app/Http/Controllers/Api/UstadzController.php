<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ustadz\UstadzService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class UstadzController extends Controller
{
    protected UstadzService $service;

    public function __construct(UstadzService $service)
    {
        $this->service = $service;

        // Middleware role (opsional)
        // $this->middleware('role:superadmin,admin');
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/ustadz
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $paginator = $this->service->index($request);

        return ApiResponse::paginate(
            $paginator,
            'Data ustadz berhasil diambil'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/ustadz/{id}
    |--------------------------------------------------------------------------
    */
    public function show(int $id)
    {
        try {
            $data = $this->service->show($id);

            return ApiResponse::success(
                $data,
                'Detail ustadz ditemukan'
            );

        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Data ustadz tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | POST /api/ustadz
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'nullable|exists:users,id',
            'nama'           => 'required|string|max:255',
            'nik'            => 'nullable|string|max:50',
            'jenis_kelamin'  => 'required|in:L,P',
            'tanggal_lahir'  => 'required|date',
            'no_hp'          => 'required|string|max:20',
            'alamat'         => 'required|string',
            'tanggal_mulai_mengajar' => 'nullable|date',
            'status_aktif'   => 'boolean',
        ]);

        $data = $this->service->store($validated);

        return ApiResponse::success(
            $data,
            'Ustadz berhasil ditambahkan',
            Response::HTTP_CREATED
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PUT /api/ustadz/{id}
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'nama'           => 'sometimes|required|string|max:255',
            'nik'            => 'sometimes|nullable|string|max:50',
            'jenis_kelamin'  => 'sometimes|required|in:L,P',
            'tanggal_lahir'  => 'sometimes|required|date',
            'no_hp'          => 'sometimes|required|string|max:20',
            'alamat'         => 'sometimes|required|string',
            'tanggal_mulai_mengajar' => 'sometimes|nullable|date',
            'status_aktif'   => 'sometimes|boolean',
        ]);

        try {
            $data = $this->service->update($id, $validated);

            return ApiResponse::success(
                $data,
                'Ustadz berhasil diperbarui'
            );

        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal memperbarui data ustadz',
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE /api/ustadz/{id}
    |--------------------------------------------------------------------------
    | Soft delete via status_aktif
    */
    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);

            return ApiResponse::success(
                null,
                'Ustadz berhasil dinonaktifkan'
            );

        } catch (\Throwable $e) {
            return ApiResponse::error(
                'Gagal menghapus ustadz',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
