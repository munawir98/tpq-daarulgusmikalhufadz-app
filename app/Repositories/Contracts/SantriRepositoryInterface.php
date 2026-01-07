<?php

namespace App\Repositories\Contracts;

interface SantriRepositoryInterface
{
    // WEB / ADMIN
    public function all();
    public function paginate($perPage = 10);

    // MOBILE (WAJIB)
    public function listForMobile(int $limit = 50);

    // CRUD
    public function find($id);
    public function findWithInactiveKelas($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
