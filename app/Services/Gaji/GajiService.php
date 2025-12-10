<?php

namespace App\Services\Gaji;

use App\Repositories\Contracts\GajiRepositoryInterface;
use App\Helpers\ApiResponse;

class GajiService
{
    protected $repo;

    public function __construct(GajiRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return ApiResponse::success(
            $this->repo->paginate(20),
            'Berhasil mengambil data gaji'
        );
    }

    public function store($data)
    {
        // Hitung kehadiran otomatis
        $jumlahKehadiran = $this->repo->hitungKehadiran(
            $data['ustadz_id'],
            $data['bulan'],
            $data['tahun']
        );

        // Hitung total gaji
        $data['jumlah_kehadiran'] = $jumlahKehadiran;
        $data['jumlah'] = $jumlahKehadiran * $data['nominal_per_pertemuan'];

        return ApiResponse::success(
            $this->repo->create($data),
            'Gaji berhasil dihitung & ditambahkan'
        );
    }

    public function show($id)
    {
        return ApiResponse::success(
            $this->repo->find($id),
            'Detail gaji'
        );
    }

    public function update($id, $data)
    {
        // Hitung ulang kehadiran
        $jumlahKehadiran = $this->repo->hitungKehadiran(
            $data['ustadz_id'],
            $data['bulan'],
            $data['tahun']
        );

        $data['jumlah_kehadiran'] = $jumlahKehadiran;
        $data['jumlah'] = $jumlahKehadiran * $data['nominal_per_pertemuan'];

        return ApiResponse::success(
            $this->repo->update($id, $data),
            'Gaji berhasil diperbarui'
        );
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return ApiResponse::success(null, 'Gaji berhasil dihapus');
    }
}
