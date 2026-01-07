<?php

namespace App\Services\Ustadz;

use App\Repositories\Contracts\UstadzRepositoryInterface;
use App\Http\Resources\UstadzResource;

class UstadzService
{
    protected $repo;

    public function __construct(UstadzRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index($request)
    {
        $perPage = $request->get('per_page', 10);

        return $this->repo->paginate($perPage);
    }

    public function show($id)
    {
        return new UstadzResource(
            $this->repo->find($id)
        );
    }

    public function store(array $data)
    {
        return new UstadzResource(
            $this->repo->create($data)
        );
    }

    public function update($id, array $data)
    {
        return new UstadzResource(
            $this->repo->update($id, $data)
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return true;
    }
}
