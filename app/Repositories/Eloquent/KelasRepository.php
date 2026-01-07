<?php

namespace App\Repositories\Eloquent;

use App\Models\Kelas;
use App\Repositories\Contracts\KelasRepositoryInterface;

class KelasRepository implements KelasRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | BASIC
    |--------------------------------------------------------------------------
    */

    public function all()
    {
        return Kelas::with('ustadz')
            ->orderBy('nama_kelas')
            ->get();
    }

    public function find(int $id)
    {
        return Kelas::with('ustadz')->find($id);
    }

    public function findAktif(int $id)
    {
        return Kelas::with(['ustadz', 'santri'])
            ->where('status', 'aktif')
            ->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    public function paginate(int $perPage = 10)
    {
        return Kelas::with('ustadz')
            ->orderBy('nama_kelas')
            ->paginate($perPage);
    }

    public function paginateAktif(int $perPage = 10)
    {
        return Kelas::with('ustadz')
            ->where('status', 'aktif')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH & FILTER
    |--------------------------------------------------------------------------
    */

    public function searchAktif(string $keyword)
    {
        return Kelas::with('ustadz')
            ->where('status', 'aktif')
            ->where(function ($q) use ($keyword) {
                $q->where('nama_kelas', 'LIKE', "%{$keyword}%")
                  ->orWhere('kode_kelas', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('nama_kelas')
            ->get();
    }

    public function filterByTingkat(string $tingkat)
    {
        return Kelas::with('ustadz')
            ->where('status', 'aktif')
            ->where('tingkat', $tingkat)
            ->orderBy('nama_kelas')
            ->get();
    }

    public function filterByUstadz(int $ustadzId)
    {
        return Kelas::with('ustadz')
            ->where('status', 'aktif')
            ->where('ustadz_id', $ustadzId)
            ->orderBy('nama_kelas')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    */

    public function create(array $data)
    {
        return Kelas::create($data);
    }

    /**
     * Update dan kembalikan model
     */
    public function updateAndGet(int $id, array $data)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return null;
        }

        $kelas->update($data);
        return $kelas->fresh();
    }

    /**
     * Update boolean (nonaktif / restore)
     */
    public function updateBool(int $id, array $data): bool
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return false;
        }

        return $kelas->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Kelas::destroy($id);
    }
}
