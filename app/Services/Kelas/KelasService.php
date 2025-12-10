<?php

namespace App\Services\Kelas;

use App\Repositories\Contracts\KelasRepositoryInterface;
use App\Helpers\ApiResponse;

class KelasService
{
    protected $repo;

    public function __construct(KelasRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil data kelas'
        );
    }

    public function store($data)
    {
        return ApiResponse::success(
            $this->repo->create($data),
            'Kelas berhasil ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail kelas'
        );
    }

    public function update($id, $data)
    {
        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Kelas berhasil diperbarui'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return ApiResponse::success(null, 'Kelas berhasil dihapus');
    }
}
