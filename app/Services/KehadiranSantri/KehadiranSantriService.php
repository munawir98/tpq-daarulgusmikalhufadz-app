<?php

namespace App\Services\KehadiranSantri;

use App\Repositories\Contracts\KehadiranSantriRepositoryInterface;
use App\Helpers\ApiResponse;

class KehadiranSantriService
{
    protected $repo;

    public function __construct(KehadiranSantriRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil data kehadiran santri'
        );
    }

    public function store($data)
    {
        return ApiResponse::success(
            $this->repo->create($data),
            'Kehadiran santri berhasil ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail kehadiran santri'
        );
    }

    public function update($id, $data)
    {
        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Kehadiran santri berhasil diupdate'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return ApiResponse::success(null, 'Kehadiran santri berhasil dihapus');
    }
}
