<?php

namespace App\Services\Setoran;

use App\Repositories\Contracts\SetoranRepositoryInterface;
use App\Helpers\ApiResponse;

class SetoranService
{
    protected $repo;

    public function __construct(SetoranRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil data setoran'
        );
    }

    public function store($data)
    {
        return ApiResponse::success(
            $this->repo->create($data),
            'Setoran berhasil ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail setoran'
        );
    }

    public function update($id, $data)
    {
        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Setoran berhasil diupdate'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return ApiResponse::success(null, 'Setoran berhasil dihapus');
    }
}
