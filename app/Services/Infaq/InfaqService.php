<?php

namespace App\Services\Infaq;

use App\Repositories\Contracts\InfaqRepositoryInterface;
use App\Helpers\ApiResponse;

class InfaqService
{
    protected $repo;

    public function __construct(InfaqRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil data infaq'
        );
    }

    public function store($data)
    {
        return ApiResponse::success(
            $this->repo->create($data),
            'Infaq berhasil ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail infaq'
        );
    }

    public function update($id, $data)
    {
        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Infaq berhasil diperbarui'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return ApiResponse::success(null, 'Infaq berhasil dihapus');
    }
}
