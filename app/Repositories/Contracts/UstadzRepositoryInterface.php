<?php

namespace App\Repositories\Contracts;

interface UstadzRepositoryInterface
{
    /**
     * Ambil semua ustadz (tanpa pagination)
     * ⚠️ Sebaiknya jarang dipakai di API
     */
    public function all();

    /**
     * Pagination ustadz + eager loading
     */
    public function paginate(int $perPage = 10);

    /**
     * Ambil detail ustadz berdasarkan ID
     */
    public function find(int $id);

    /**
     * Simpan data ustadz baru
     */
    public function create(array $data);

    /**
     * Update data ustadz
     */
    public function update(int $id, array $data);

    /**
     * Nonaktifkan ustadz (soft delete via status_aktif)
     */
    public function delete(int $id);
}
