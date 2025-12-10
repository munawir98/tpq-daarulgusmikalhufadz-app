<?php

namespace App\Repositories\Eloquent;

use App\Models\KehadiranSantri;
use App\Repositories\Contracts\KehadiranSantriRepositoryInterface;

class KehadiranSantriRepository implements KehadiranSantriRepositoryInterface
{
    public function all()
    {
        return KehadiranSantri::with(['santri','jadwal','ustadz'])->get();
    }

    public function paginate($perPage = 20)
    {
        return KehadiranSantri::with(['santri','jadwal','ustadz'])->paginate($perPage);
    }

    public function find($id)
    {
        return KehadiranSantri::with(['santri','jadwal','ustadz'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return KehadiranSantri::create($data);
    }

    public function update($id, array $data)
    {
        $absen = KehadiranSantri::findOrFail($id);
        $absen->update($data);
        return $absen;
    }

    public function delete($id)
    {
        return KehadiranSantri::destroy($id);
    }
}
