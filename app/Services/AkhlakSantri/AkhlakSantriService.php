<?php

namespace App\Services\AkhlakSantri;

use App\Repositories\Contracts\AkhlakSantriRepositoryInterface;

class AkhlakSantriService
{
    protected AkhlakSantriRepositoryInterface $repo;

    public function __construct(AkhlakSantriRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function listBySantri($santriId)
    {
        return $this->repo->bySantri($santriId);
    }
    public function listAll()
    {
        return $this->repo->all();
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

}
