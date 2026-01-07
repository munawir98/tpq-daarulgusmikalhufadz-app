<?php

namespace App\Repositories\Contracts;

interface KelasRepositoryInterface
{
    public function all();

    public function paginate(int $perPage = 20);

    public function paginateAktif(int $perPage = 20);

    public function findAktif(int $id);

    public function searchAktif(string $q);

    public function find(int $id);

    public function create(array $data);

    /**
     * ✅ Update & return boolean
     */
    public function updateBool(int $id, array $data): bool;

    /**
     * ✅ Update & return model
     */
    public function updateAndGet(int $id, array $data);

    public function delete(int $id);
}
