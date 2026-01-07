<?php

namespace App\Repositories\Eloquent;

use App\Models\Santri;
use App\Repositories\Contracts\SantriRepositoryInterface;

class SantriRepository implements SantriRepositoryInterface
{
    /**
     * =========================
     * WEB / ADMIN (BERAT)
     * =========================
     */
    public function all()
    {
        return Santri::with([
            'kelas.ustadz',
            'user',
            'kehadiran',
            'progressHafalan',
            'presensi',
        ])->get();
    }

    public function paginate($perPage = 10)
    {
        return Santri::with([
            'kelas.ustadz',
            'user',
            'kehadiran',
            'progressHafalan',
            'presensi',
        ])->paginate($perPage);
    }

    /**
     * =========================
     * MOBILE (RINGAN & CEPAT)
     * =========================
     */
    public function listForMobile(int $limit = 50)
    {
        return Santri::query()
            ->select('id', 'nis', 'nama_lengkap', 'kelas_id')
            ->orderBy('nama_lengkap')
            ->limit($limit)
            ->get();
    }

    /**
     * =========================
     * DETAIL
     * =========================
     */
    public function find($id)
    {
        return Santri::with([
            'kelas.ustadz',
            'user',
            'kehadiran',
            'progressHafalan',
            'presensi',
        ])->findOrFail($id);
    }

    public function findWithInactiveKelas($id)
    {
        return Santri::with([
            'user',
            'kehadiran',
            'progressHafalan',
            'presensi',
            'kelas' => function ($q) {
                $q->withoutGlobalScope('aktif')
                  ->with('ustadz');
            },
        ])->findOrFail($id);
    }

    /**
     * =========================
     * CRUD
     * =========================
     */
    public function create(array $data)
    {
        $santri = Santri::create($data);

        return $santri->fresh([
            'kelas.ustadz',
            'user',
        ]);
    }

    public function update($id, array $data)
    {
        $santri = Santri::findOrFail($id);
        $santri->update($data);

        return $santri->fresh([
            'kelas.ustadz',
            'user',
        ]);
    }

    public function delete($id)
    {
        $santri = Santri::findOrFail($id);
        return $santri->delete();
    }
}
