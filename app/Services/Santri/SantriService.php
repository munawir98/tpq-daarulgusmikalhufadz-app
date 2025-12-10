<?php

namespace App\Services\Santri;

use App\Repositories\Contracts\SantriRepositoryInterface;
use App\Http\Resources\SantriResource;

class SantriService
{
    protected $santriRepo;

    public function __construct(SantriRepositoryInterface $santriRepo)
    {
        $this->santriRepo = $santriRepo;
    }

    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => SantriResource::collection($this->santriRepo->all())
        ]);
    }

    public function store($data)
    {
        $santri = $this->santriRepo->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Santri berhasil ditambahkan',
            'data' => new SantriResource($santri)
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data' => new SantriResource($this->santriRepo->find($id))
        ]);
    }

    public function update($data, $id)
    {
        $santri = $this->santriRepo->update($id, $data);

        return response()->json([
            'status' => true,
            'message' => 'Santri berhasil diperbarui',
            'data' => new SantriResource($santri)
        ]);
    }

    public function destroy($id)
    {
        $this->santriRepo->delete($id);

        return response()->json([
            'status' => true,
            'message' => 'Santri berhasil dihapus'
        ]);
    }
}
