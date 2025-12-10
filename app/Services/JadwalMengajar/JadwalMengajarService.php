<?php

namespace App\Services\JadwalMengajar;

use App\Repositories\Contracts\JadwalMengajarRepositoryInterface;
use App\Helpers\ApiResponse;

class JadwalMengajarService
{
    protected $repo;

    public function __construct(JadwalMengajarRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil jadwal mengajar'
        );
    }

    public function store($data)
    {
        return ApiResponse::success(
            $this->repo->create($data),
            'Jadwal mengajar berhasil ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail jadwal mengajar'
        );
    }

    public function update($id, $data)
    {
        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Jadwal mengajar berhasil diperbarui'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return ApiResponse::success(null, 'Jadwal mengajar berhasil dihapus');
    }
}
