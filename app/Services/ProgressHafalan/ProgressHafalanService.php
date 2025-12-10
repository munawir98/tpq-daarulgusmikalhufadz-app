<?php

namespace App\Services\ProgressHafalan;

use App\Repositories\Contracts\ProgressHafalanRepositoryInterface;
use App\Helpers\ApiResponse;

class ProgressHafalanService
{
    protected $repo;

    public function __construct(ProgressHafalanRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil data progress hafalan'
        );
    }

    public function store($data)
    {
        return ApiResponse::success(
            $this->repo->create($data),
            'Progress hafalan berhasil ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail progress hafalan'
        );
    }

    public function update($id, $data)
    {
        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Progress hafalan berhasil diupdate'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return ApiResponse::success(null, 'Progress hafalan berhasil dihapus');
    }
}
