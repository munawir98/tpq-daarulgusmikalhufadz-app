<?php

namespace App\Repositories\Eloquent;

use App\Models\NilaiUjian;
use App\Repositories\Contracts\NilaiUjianRepositoryInterface;

class NilaiUjianRepository implements NilaiUjianRepositoryInterface
{
    public function all()
    {
        return NilaiUjian::with('santri')->latest()->get();
    }

    public function find($id)
    {
        return NilaiUjian::with('santri')->findOrFail($id);
    }

    public function create(array $data)
    {
        return NilaiUjian::create($data);
    }

    public function update($id, array $data)
    {
        $record = NilaiUjian::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        return NilaiUjian::destroy($id);
    }

    public function bySantri($santriId)
    {
        return NilaiUjian::with('santri')
            ->where('santri_id', $santriId)
            ->latest()
            ->get();
    }
}
