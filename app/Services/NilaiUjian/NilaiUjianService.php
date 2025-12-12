<?php

namespace App\Services\NilaiUjian;

use App\Repositories\Contracts\NilaiUjianRepositoryInterface;

class NilaiUjianService
{
    protected NilaiUjianRepositoryInterface $repo;

    public function __construct(NilaiUjianRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function listAll()
    {
        return $this->repo->all();
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function listBySantri($santriId)
    {
        return $this->repo->bySantri($santriId);
    }
}
