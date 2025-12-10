<?php

namespace App\Repositories\Eloquent;

use App\Models\Santri;
use App\Repositories\Contracts\SantriRepositoryInterface;

class SantriRepository implements SantriRepositoryInterface
{
    public function all()
    {
        return Santri::with('kelas')->get();
    }

    public function paginate($perPage = 10)
    {
        return Santri::with('kelas')->paginate($perPage);
    }

    public function find($id)
    {
        return Santri::with(['kelas', 'kehadiran', 'progressHafalan'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Santri::create($data);
    }

    public function update($id, array $data)
    {
        $santri = Santri::findOrFail($id);
        $santri->update($data);
        return $santri;
    }

    public function delete($id)
    {
        $santri = Santri::findOrFail($id);
        return $santri->delete();
    }
}
