<?php

namespace App\Imports;

use App\Models\Santri;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public int $success = 0;
    public int $failed  = 0;

    public array $failedRows = [];
    public array $errors     = [];

    protected int $rowNumber = 2;

    public function model(array $row)
    {
        try {
            $nis           = trim($row['nis'] ?? '');
            $nama          = trim($row['nama_lengkap'] ?? '');
            $jk            = strtoupper(trim($row['jenis_kelamin'] ?? ''));
            $kelasId       = $row['kelas_id'] ?? null;
            $tanggalMasuk  = $row['tanggal_masuk'] ?? null;

            if ($nis === '' || $nama === '' || !in_array($jk, ['L', 'P'])) {
                throw new \Exception('Data wajib tidak valid');
            }

            if (Santri::where('nis', $nis)->exists()) {
                throw new \Exception('NIS sudah terdaftar');
            }

            Santri::create([
                'nis'           => $nis,
                'nama_lengkap'  => $nama,
                'jenis_kelamin' => $jk,
                'kelas_id'      => $kelasId,
                'tanggal_masuk' => $tanggalMasuk,
            ]);

            $this->success++;

        } catch (\Throwable $e) {
            $this->failed++;
            $this->failedRows[] = $this->rowNumber;
            $this->errors[] = "Baris {$this->rowNumber}: {$e->getMessage()}";
        }

        $this->rowNumber++;

        return null;
    }
}
