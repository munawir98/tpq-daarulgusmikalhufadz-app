<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Santri;
use App\Models\Kelas;
use App\Imports\SantriPreviewImport;
use Maatwebsite\Excel\Facades\Excel;

class SantriImportController extends Controller
{
    /**
     * =========================
     * IMPORT FINAL (ROLLBACK JIKA ERROR > X)
     * =========================
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $spreadsheet = IOFactory::load(
            $request->file('file')->getPathname()
        );

        $sheet = $spreadsheet->getSheetByName('santri');

        if (!$sheet) {
            return response()->json([
                'success' => false,
                'message' => 'Sheet santri tidak ditemukan'
            ], 422);
        }

        $rows = $sheet->toArray();

        $errors = [];
        $success = 0;

        $maxError = 5; // 🔥 BATAS ERROR (UBAH SESUAI KEBUTUHAN)

        DB::beginTransaction();

        foreach ($rows as $index => $row) {
            // Skip header
            if ($index === 0) continue;

            $nis        = $row[0] ?? null;
            $nama       = $row[1] ?? null;
            $jk         = $row[2] ?? null;
            $tglLahir   = $this->normalizeDate($row[3] ?? null);
            $alamat     = $row[4] ?? null;
            $tglMasuk   = $this->normalizeDate($row[5] ?? null);
            $kelasNama  = $row[6] ?? null;

            $kelasId = Kelas::where('nama', $kelasNama)->value('id');

            $rowErrors = $this->validateRow(
                $nis,
                $nama,
                $jk,
                $tglLahir,
                $tglMasuk,
                $kelasId
            );

            if ($rowErrors) {
                $errors[] = [
                    'baris' => $index + 1,
                    'error' => $rowErrors
                ];

                // 🚨 STOP CEPAT JIKA ERROR MELEBIHI BATAS
                if (count($errors) > $maxError) {
                    DB::rollBack();

                    return response()->json([
                        'success' => false,
                        'message' => "Import dibatalkan. Error melebihi batas ({$maxError})",
                        'errors'  => $errors
                    ], 422);
                }

                continue;
            }

            Santri::create([
                'nis' => $nis,
                'nama_lengkap' => $nama,
                'jenis_kelamin' => $jk,
                'tanggal_lahir' => $tglLahir,
                'alamat' => $alamat,
                'tanggal_masuk' => $tglMasuk,
                'kelas_id' => $kelasId
            ]);

            $success++;
        }

        // 🔑 DOUBLE SAFETY
        if (count($errors) > $maxError) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => "Import dibatalkan. Error melebihi batas ({$maxError})",
                'errors'  => $errors
            ], 422);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Import santri berhasil',
            'total_success' => $success,
            'total_error' => count($errors),
        ]);
    }

    /**
     * =========================
     * PREVIEW IMPORT (TANPA SIMPAN DB)
     * =========================
     */
    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $preview = new SantriPreviewImport();
        Excel::import($preview, $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Preview import santri',
            'data' => [
                'total' => count($preview->rows),
                'rows'  => $preview->rows,
            ],
        ]);
    }

    /* =========================
     * HELPER
     * ========================= */

    private function normalizeDate($value)
    {
        if (!$value) return null;

        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)
                ->format('Y-m-d');
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value;
        }

        return null;
    }

    private function validateRow(
        $nis,
        $nama,
        $jk,
        $tglLahir,
        $tglMasuk,
        $kelasId
    ) {
        $errors = [];

        if (!$nis) {
            $errors[] = 'NIS wajib diisi';
        } elseif (Santri::where('nis', $nis)->exists()) {
            $errors[] = 'NIS sudah terdaftar';
        }

        if (!$nama) {
            $errors[] = 'Nama wajib diisi';
        }

        if (!in_array($jk, ['L', 'P'])) {
            $errors[] = 'Jenis kelamin harus L / P';
        }

        if (!$tglLahir) {
            $errors[] = 'Tanggal lahir tidak valid';
        }

        if (!$tglMasuk) {
            $errors[] = 'Tanggal masuk tidak valid';
        }

        if (!$kelasId) {
            $errors[] = 'Kelas tidak valid';
        }

        return count($errors) ? $errors : null;
    }
}
