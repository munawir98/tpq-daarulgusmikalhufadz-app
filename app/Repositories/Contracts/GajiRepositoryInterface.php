<?php

namespace App\Repositories\Contracts;

interface GajiRepositoryInterface
{
    public function all();
    public function paginate($perPage);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function hitungKehadiran($ustadzId, $bulan, $tahun);
}
