<?php

namespace App\Repositories\Eloquent;

use App\Models\Infaq;
use App\Repositories\Contracts\InfaqRepositoryInterface;

class InfaqRepository implements InfaqRepositoryInterface
{
    public function all()
    {
        return Infaq::all();
    }

    public function paginate($perPage = 20)
    {
        return Infaq::paginate($perPage);
    }

    public function find($id)
    {
        return Infaq::findOrFail($id);
    }

    public function create(array $data)
    {
        return Infaq::create($data);
    }

    public function update($id, array $data)
    {
        $infaq = Infaq::findOrFail($id);
        $infaq->update($data);
        return $infaq;
    }

    public function delete($id)
    {
        return Infaq::destroy($id);
    }
}
