<?php

namespace App\Repositories\Eloquent;

use App\Models\Gaji;
use App\Models\Presensi;
use App\Repositories\Contracts\GajiRepositoryInterface;

class GajiRepository implements GajiRepositoryInterface
{
    public function all()
    {
        return Gaji::all();
    }

    public function paginate($perPage = 20)
    {
        return Gaji::paginate($perPage);
    }

    public function find($id)
    {
        return Gaji::findOrFail($id);
    }

    public function create(array $data)
    {
        return Gaji::create($data);
    }

    public function update($id, array $data)
    {
        $gaji = Gaji::findOrFail($id);
        $gaji->update($data);
        return $gaji;
    }

    public function delete($id)
    {
        return Gaji::destroy($id);
    }

    // 🔥 Hitung jumlah kehadiran otomatis
    public function hitungKehadiran($ustadzId, $bulan, $tahun)
    {
        return Presensi::where('user_id', $ustadzId)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->count();
    }
}
