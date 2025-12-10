<?php

namespace App\Repositories\Contracts;

interface GroupRepositoryInterface {
    public function all();
    public function find($id);
    public function create(array $data);
    public function rename($id, array $data);
    public function delete($id);
}
