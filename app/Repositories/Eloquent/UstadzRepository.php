<?php

namespace App\Repositories\Eloquent;

use App\Models\Ustadz;
use App\Repositories\Contracts\UstadzRepositoryInterface;

class UstadzRepository implements UstadzRepositoryInterface
{
    public function all()
    {
        return Ustadz::with('user')->orderByDesc('id')->get();
    }

    public function find($id)
    {
        return Ustadz::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Ustadz::create($data);
    }

    public function update($id, array $data)
    {
        $ustadz = Ustadz::findOrFail($id);
        $ustadz->update($data);

        return $ustadz;
    }

    public function delete($id)
    {
        return Ustadz::destroy($id);
    }
}
