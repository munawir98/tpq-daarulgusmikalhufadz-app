<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. DATA CLEANUP & NORMALIZATION
        // Pastikan setiap ustadz punya kelas unik dan nama kelas dinormalisasi
        $ustadzs = \App\Models\Ustadz::where('status_aktif', true)->orderBy('id')->get();
        $letter = 'A';

        // Reset semua ustadz_id di kelas yang mungkin duplikat (opsional, tapi lebih aman kita assign ulang)
        // Strategi: Iterate Ustadz, temukan kelasnya. Jika kelas dipakai >1 ustadz, kita harus bertindak.
        // Tapi logic 'normalize' sebelumnya, dia cuma check "does this ustadz have a class?".
        // If Ustadz A and Ustadz B both point to "TPQ A" (id=1), relation is belongsTo Ustadz.
        // Wait, Kelas belongsTo Ustadz. So on 'kelas' table, 'ustadz_id' is the column.
        // If 'ustadz_id' is unique, then 1 ustadz -> 1 kelas.
        // But what if 2 Kelas point to 1 Ustadz?
        // "TPQ A" -> Ustadz A. "TPQ B" -> Ustadz A.
        // This VIOLATES unique(ustadz_id) on 'kelas' table. Ustadz A appears twice in 'kelas' table.
        // So we must fix DUPLICATE ustadz_id in 'kelas' table.

        // Fix Strategy:
        // Group by ustadz_id. If count > 1, keep one, detach/delete others or reassign?
        // User rule: "Satu guru satu kelas".
        // Solution: Create new classes for them or simply update their ustadz_id to null? No, we need to assign them classes.
        // Actually, the previous normalization logic was: "Iterate Ustadz -> Find Class -> Update/Create".
        // But it didn't explicitly handle "Ustadz A has 2 classes".
        // Let's refine:
        // Find existing classes grouped by ustadz_id having count > 1.

        $duplicateAssignments = \Illuminate\Support\Facades\DB::table('kelas')
            ->select('ustadz_id')
            ->whereNotNull('ustadz_id')
            ->groupBy('ustadz_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicateAssignments as $dup) {
            // Get all classes for this ustadz
            $classes = \App\Models\Kelas::where('ustadz_id', $dup->ustadz_id)->get();
            // Keep the first one, nullify others
            $first = true;
            foreach ($classes as $cls) {
                if ($first) {
                    $first = false;
                    continue;
                }
                $cls->update(['ustadz_id' => null]);
            }
        }

        // Now runs the previous normalization to fill gaps and rename
        foreach ($ustadzs as $ustadz) {
            $kelas = \App\Models\Kelas::where('ustadz_id', $ustadz->id)->first();

            if ($kelas) {
                $kelas->update([
                    'kode_kelas' => "TPQ-{$letter}",
                    'nama_kelas' => "TPQ {$letter}",
                ]);
            } else {
                if (\App\Models\Kelas::where('kode_kelas', "TPQ-{$letter}")->exists()) {
                    \App\Models\Kelas::where('kode_kelas', "TPQ-{$letter}")->update(['kode_kelas' => "TEMP-{$letter}"]);
                }
                \App\Models\Kelas::create([
                    'kode_kelas'    => "TPQ-{$letter}",
                    'nama_kelas'    => "TPQ {$letter}",
                    'tipe'          => 'TPQ',
                    'tingkat'       => 'Dasar',
                    'waktu_mulai'   => '16:00:00',
                    'waktu_selesai' => '17:30:00',
                    'ustadz_id'     => $ustadz->id,
                    'keterangan'    => "Kelas otomatis untuk " . $ustadz->nama,
                    'status'        => 'aktif',
                ]);
            }
            $letter++;
        }

        // 2. ADD UNIQUE CONSTRAINT
        Schema::table('kelas', function (Blueprint $table) {
            $table->unique('ustadz_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropUnique(['ustadz_id']);
        });
    }
};
