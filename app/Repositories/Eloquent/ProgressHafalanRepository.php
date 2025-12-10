<?php

namespace App\Repositories\Eloquent;

use App\Models\ProgressHafalan;
use App\Repositories\Contracts\ProgressHafalanRepositoryInterface;

class ProgressHafalanRepository implements ProgressHafalanRepositoryInterface
{
    public function all()
    {
        return ProgressHafalan::all();
    }

    public function paginate($perPage = 20)
    {
        return ProgressHafalan::paginate($perPage);
    }

    public function find($id)
    {
        return ProgressHafalan::findOrFail($id);
    }

    public function create(array $data)
    {
        return ProgressHafalan::create($data);
    }

    public function update($id, array $data)
    {
        $progress = ProgressHafalan::findOrFail($id);
        $progress->update($data);
        return $progress;
    }

    public function delete($id)
    {
        return ProgressHafalan::destroy($id);
    }
}
