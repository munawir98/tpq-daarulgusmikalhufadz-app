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

    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => UstadzResource::collection($this->repo->all())
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data'   => new UstadzResource($this->repo->find($id))
        ]);
    }

    public function store($data)
    {
        $ustadz = $this->repo->create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Ustadz berhasil ditambahkan',
            'data'    => new UstadzResource($ustadz)
        ]);
    }

    public function update($id, $data)
    {
        $ustadz = $this->repo->update($id, $data);

        return response()->json([
            'status'  => true,
            'message' => 'Ustadz berhasil diperbarui',
            'data'    => new UstadzResource($ustadz)
        ]);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return response()->json([
            'status'  => true,
            'message' => 'Ustadz berhasil dihapus'
        ]);
    }
}
