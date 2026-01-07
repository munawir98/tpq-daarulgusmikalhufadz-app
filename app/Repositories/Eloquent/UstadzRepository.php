<?php

namespace App\Repositories\Eloquent;

use App\Models\Ustadz;
use App\Repositories\Contracts\UstadzRepositoryInterface;

class UstadzRepository implements UstadzRepositoryInterface
{
    public function all()
    {
        return Ustadz::with(['kelas'])->orderBy('nama')->get();
    }

    public function paginate(int $perPage = 10)
    {
        return Ustadz::with(['kelas'])
            ->orderBy('nama')
            ->paginate($perPage);
    }

    public function find($id)
    {
        return Ustadz::with(['kelas'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Ustadz::create($data);
    }

    public function update($id, array $data)
    {
        $ustadz = Ustadz::findOrFail($id);
        $ustadz->update($data);
        return $ustadz;
    }

    public function delete($id)
    {
        $ustadz = Ustadz::findOrFail($id);
        $ustadz->update(['status_aktif' => false]);
    }
}
