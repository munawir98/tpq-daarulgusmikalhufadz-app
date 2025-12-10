<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;

        // Hanya Admin & Superadmin bisa manage user
        // $this->middleware('role:superadmin,admin');
    }

    public function index()
    {
        $data = $this->service->index();

        if ($data->isEmpty()) {
            return ApiResponse::error("Data user kosong", 404);
        }

        return ApiResponse::success($data, "Data user ditemukan");
    }

    public function show($id)
    {
        $data = $this->service->show($id);

        if (!$data) {
            return ApiResponse::error("User tidak ditemukan", 404);
        }

        return ApiResponse::success($data, "Detail user ditemukan");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:superadmin,admin,ustadz,santri',
        ]);

        $data = $this->service->store($request->all());

        return ApiResponse::success($data, "User berhasil ditambahkan");
    }

    public function update(Request $request, $id)
    {
        // Unique email harus mengabaikan email lama user
        $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => "sometimes|email|unique:users,email,$id",
            'password' => 'sometimes|min:6',
            'role'     => 'sometimes|in:superadmin,admin,ustadz,santri',
        ]);

        $data = $this->service->update($id, $request->all());

        if (!$data) {
            return ApiResponse::error("Gagal memperbarui user", 400);
        }

        return ApiResponse::success($data, "User berhasil diperbarui");
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return ApiResponse::error("Gagal menghapus user", 400);
        }

        return ApiResponse::success(null, "User berhasil dihapus");
    }
}
