<?php

namespace App\Repositories\Contracts;

interface ChatRepositoryInterface {
    public function all();
    public function find($id);
    public function create(array $data);
    public function delete($id);
}
