<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    public int $success = 0;
    public int $failed  = 0;

    public array $failedRows = [];
    public array $errors     = [];

    // Baris data pertama di Excel (karena heading di baris 1)
    protected int $rowNumber = 2;

    public function model(array $row)
    {
        try {
            // 🔒 Normalisasi data
            $kodeKelas = strtoupper(trim($row['kode_kelas'] ?? ''));
            $namaKelas = trim($row['nama_kelas'] ?? '');
            $tingkat   = strtoupper(trim($row['tingkat'] ?? ''));

            // ⛔ Validasi wajib
            if ($kodeKelas === '' || $namaKelas === '' || $tingkat === '') {
                throw new \Exception('Kolom wajib tidak boleh kosong');
            }

            // ⛔ Validasi tingkat
            if (!in_array($tingkat, ['ULA', 'WUSTHA'])) {
                throw new \Exception('Tingkat harus ULA atau WUSTHA');
            }

            // 🔄 Update / Create (anti duplikat)
            Kelas::updateOrCreate(
                ['kode_kelas' => $kodeKelas],
                [
                    'nama_kelas'    => $namaKelas,
                    'tipe'          => 'TPQ',
                    'tingkat'       => $tingkat,
                    'ustadz_id'     => $row['ustadz_id'] ?? null,
                    'waktu_mulai'   => $row['waktu_mulai'] ?? null,
                    'waktu_selesai' => $row['waktu_selesai'] ?? null,
                    'status'        => 'AKTIF',
                ]
            );

            $this->success++;

        } catch (\Throwable $e) {
            $this->failed++;
            $this->failedRows[] = $this->rowNumber;
            $this->errors[] = "Baris {$this->rowNumber}: {$e->getMessage()}";
        }

        // Naikkan nomor baris setelah diproses
        $this->rowNumber++;

        return null;
    }
}
