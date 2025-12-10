<?php

namespace App\Repositories\Eloquent;

use App\Models\JadwalMengajar;
use App\Repositories\Contracts\JadwalMengajarRepositoryInterface;

class JadwalMengajarRepository implements JadwalMengajarRepositoryInterface
{
    public function all()
    {
        return JadwalMengajar::with(['ustadz','kelas'])->get();
    }

    public function paginate($perPage = 20)
    {
        return JadwalMengajar::with(['ustadz','kelas'])->paginate($perPage);
    }

    public function find($id)
    {
        return JadwalMengajar::with(['ustadz','kelas'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return JadwalMengajar::create($data);
    }

    public function update($id, array $data)
    {
        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->update($data);
        return $jadwal;
    }

    public function delete($id)
    {
        return JadwalMengajar::destroy($id);
    }

    // ========================================================
    //  DIBUTUHKAN OLEH PresensiService untuk detect shift
    // ========================================================
    public function findShiftForUser($userId, $time)
    {
        return JadwalMengajar::where('ustadz_id', $userId)
            ->where('waktu_mulai', '<=', $time)
            ->where('waktu_selesai', '>=', $time)
            ->first();
    }
}
