<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class PresensiExport implements FromArray
{
    protected $presensi;

    public function __construct($presensi)
    {
        $this->presensi = $presensi;
    }

    public function array(): array
    {
        // HEADER EXCEL
        $data[] = [
            "Tanggal",
            "Jam",
            "Tipe",
            "Status Presensi",
            "Keterangan",
            "Latitude",
            "Longitude",
            "Metode",
            "QR Code",
        ];

        // ISI DATA
        foreach ($this->presensi as $p) {
            $data[] = [
                $p->tanggal,
                $p->jam,
                ucfirst($p->tipe),
                ucfirst($p->status_presensi),
                $p->keterangan ?? '-',
                $p->latitude ?? '-',
                $p->longitude ?? '-',
                $p->metode ?? '-',
                $p->qr_code ?? '-',
            ];
        }

        return $data;
    }
}
