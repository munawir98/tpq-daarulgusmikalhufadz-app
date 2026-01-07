<?php

namespace App\Jobs;

use App\Models\Santri;
use App\Models\ImportLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportSantriJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public array $rows,
        public int $logId
    ) {}

    public function handle()
    {
        $log = ImportLog::find($this->logId);

        foreach ($this->rows as $row) {
            $tglLahir = is_numeric($row[3])
                ? ExcelDate::excelToDateTimeObject($row[3])->format('Y-m-d')
                : $row[3];

            $tglMasuk = is_numeric($row[5])
                ? ExcelDate::excelToDateTimeObject($row[5])->format('Y-m-d')
                : $row[5];

            Santri::create([
                'nis' => $row[0],
                'nama_lengkap' => $row[1],
                'jenis_kelamin' => $row[2],
                'tanggal_lahir' => $tglLahir,
                'alamat' => $row[4],
                'tanggal_masuk' => $tglMasuk,
                'kelas_id' => $row[7],
            ]);

            $log->increment('processed');
        }

        $log->update(['status' => 'done']);
    }
}
