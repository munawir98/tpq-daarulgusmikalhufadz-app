<?php

namespace App\Repositories\Eloquent;

use App\Models\Kelas;
use App\Repositories\Contracts\KelasRepositoryInterface;

class KelasRepository implements KelasRepositoryInterface
{
    public function all()
    {
        return Kelas::with(['ustadz'])->get();
    }

    public function paginate($perPage = 20)
    {
        return Kelas::with(['ustadz'])->paginate($perPage);
    }

    public function find($id)
    {
        return Kelas::with(['ustadz'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Kelas::create($data);
    }

    public function update($id, array $data)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update($data);
        return $kelas;
    }

    public function delete($id)
    {
        return Kelas::destroy($id);
    }
}
