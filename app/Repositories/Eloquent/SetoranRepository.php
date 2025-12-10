<?php

namespace App\Repositories\Eloquent;

use App\Models\Setoran;
use App\Repositories\Contracts\SetoranRepositoryInterface;

class SetoranRepository implements SetoranRepositoryInterface
{
    public function all()
    {
        return Setoran::all();
    }

    public function paginate($perPage = 20)
    {
        return Setoran::paginate($perPage);
    }

    public function find($id)
    {
        return Setoran::findOrFail($id);
    }

    public function create(array $data)
    {
        return Setoran::create($data);
    }

    public function update($id, array $data)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->update($data);
        return $setoran;
    }

    public function delete($id)
    {
        return Setoran::destroy($id);
    }
}
