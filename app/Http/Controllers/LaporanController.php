<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Santri;
use App\Models\KehadiranSantri;
use App\Models\ActivityLogVerification;

class LaporanController extends Controller
{
    public function absensiPdf($santri_id, $bulan)
    {
        /**
         * 1️⃣ Ambil data santri
         */
        $santri = Santri::findOrFail($santri_id);

        /**
         * 2️⃣ Konversi bulan (format: YYYY-MM)
         */
        $carbonBulan = Carbon::createFromFormat('Y-m', $bulan);

        /**
         * 3️⃣ Ambil data absensi
         */
        $absensi = KehadiranSantri::where('santri_id', $santri_id)
            ->whereMonth('tanggal', $carbonBulan->month)
            ->whereYear('tanggal', $carbonBulan->year)
            ->orderBy('tanggal')
            ->get();

        /**
         * 4️⃣ Nama file PDF (aman untuk filesystem)
         */
        $safeName = Str::slug($santri->nama, '-');
        $fileName = "Laporan-Absensi-{$safeName}-{$bulan}.pdf";

        /**
         * =================================================
         * 5️⃣ CONTEXT IDENTIFIER
         * =================================================
         */
        $contextType = 'absensi';
        $contextKey  = "santri_id:$santri_id|bulan:$bulan";

        /**
         * =================================================
         * 6️⃣ TRANSACTION + ROW LOCK (ANTI DUPLIKASI ABSOLUT)
         * =================================================
         */
        $verification = DB::transaction(function () use (
            $contextType,
            $contextKey,
            $fileName
        ) {
            // 🔒 Lock baris context
            $existing = ActivityLogVerification::where('context_type', $contextType)
                ->where('context_key', $contextKey)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                abort(403, 'Laporan absensi sudah pernah digenerate.');
            }

            // 🔢 Generate nomor dokumen (atomic)
            $lastId = ActivityLogVerification::max('id') ?? 0;

            $documentNumber = sprintf(
                'TPQ/DOC/ABS/%s/%05d',
                now()->year,
                $lastId + 1
            );

            return ActivityLogVerification::create([
                'hash'            => Str::uuid(),
                'document_number' => $documentNumber,
                'file_name'       => $fileName,
                'generated_by'    => auth()->id() ?? 1,
                'generated_at'    => now(),
                'context_type'    => $contextType,
                'context_key'     => $contextKey,
            ]);
        });

        /**
         * 7️⃣ HITUNG JUMLAH SCAN QR
         */
        $scanCount = $verification->scans()->count();

        /**
         * 8️⃣ URL verifikasi untuk QR
         */
        $qrUrl = route('verification.show', $verification->hash);

        /**
         * 9️⃣ Generate PDF & kirim ke view
         */
        $pdf = Pdf::loadView('pdf.absensi', [
            'santri'       => $santri,
            'absensi'      => $absensi,
            'bulan'        => $carbonBulan->translatedFormat('F Y'),
            'qrUrl'        => $qrUrl,
            'verification' => $verification,
            'scanCount'    => $scanCount,
        ]);

        return $pdf->download($fileName);
    }
}
