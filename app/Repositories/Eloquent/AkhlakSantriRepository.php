<?php

namespace App\Repositories\Eloquent;

use App\Models\AkhlakSantri;
use App\Repositories\Contracts\AkhlakSantriRepositoryInterface;

class AkhlakSantriRepository implements AkhlakSantriRepositoryInterface
{
    public function create(array $data)
    {
        return AkhlakSantri::create($data);
    }

    public function update($id, array $data)
    {
        return AkhlakSantri::findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return AkhlakSantri::destroy($id);
    }

    public function bySantri($santriId)
    {
        return AkhlakSantri::where('santri_id', $santriId)->get();
    }
}
