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
        // Ambil semua ustadz aktif
        $ustadzs = \App\Models\Ustadz::where('status_aktif', true)->orderBy('id')->get();
        $letter = 'A';

        foreach ($ustadzs as $ustadz) {
            // Cek apakah ustadz sudah punya kelas
            $kelas = \App\Models\Kelas::where('ustadz_id', $ustadz->id)->first();

            if ($kelas) {
                // Update nama kelas agar sesuai format "TPQ [Huruf]"
                $kelas->update([
                    'kode_kelas' => "TPQ-{$letter}",
                    'nama_kelas' => "TPQ {$letter}",
                ]);
            } else {
                // Buat kelas baru jika belum punya
                // Cek konflik kode kelas (meskipun seharusnya bersih jika kita rename semua, tapi jaga-jaga)
                if (\App\Models\Kelas::where('kode_kelas', "TPQ-{$letter}")->exists()) {
                    // Jika konflik, kita asumsikan yang konflik itu milik orang lain yang akan di-update nanti
                    // atau kita lewati update kelas orang lain.
                    // Strategi aman: Update yang conflict sementara agar unik
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu reverse spesifik karena datanya dinamis
    }
};
