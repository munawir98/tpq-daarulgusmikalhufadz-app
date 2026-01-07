<?php

namespace App\Services\Santri;

use App\Models\Santri;
use Illuminate\Support\Collection;

class SantriService
{
    /**
     * MOBILE LIST (RINGAN)
     */
    public function index(): Collection
    {
        return Santri::query()
            ->select([
                'id',
                'nis',
                'nama_lengkap',
                'kelas_id',
            ])
            ->orderBy('nama_lengkap')
            ->get(); // ⬅️ PASTI Collection
    }

    public function store(array $data): Santri
    {
        return Santri::create($data);
    }

    public function show(int $id): Santri
    {
        return Santri::findOrFail($id);
    }

    public function update(array $data, int $id): Santri
    {
        $santri = Santri::findOrFail($id);
        $santri->update($data);

        return $santri;
    }

    public function destroy(int $id): void
    {
        Santri::findOrFail($id)->delete();
    }

    public function assignKelas(int $id, int $kelasId): Santri
    {
        $santri = Santri::findOrFail($id);
        $santri->kelas_id = $kelasId;
        $santri->save();

        return $santri;
    }
}
