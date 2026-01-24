<?php

namespace App\Observers;

use App\Models\Ustadz;

class UstadzObserver
{
    /**
     * Handle the Ustadz "created" event.
     */
    public function created(Ustadz $ustadz): void
    {
        // Temukan huruf terakhir yang digunakan
        $lastClass = \App\Models\Kelas::where('nama_kelas', 'like', 'TPQ %')
            ->orderBy('id', 'desc')
            ->first();

        $nextLetter = 'A';
        if ($lastClass) {
            // Ambil huruf dari nama kelas (misal "TPQ A" -> "A")
            $lastLetter = trim(str_replace('TPQ', '', $lastClass->nama_kelas));
            $nextLetter = ++$lastLetter; // PHP magic: 'A'++ = 'B', 'Z'++ = 'AA'
        }

        // Cek apakah kode kelas sudah ada (just in case), loop sampai unik
        while (\App\Models\Kelas::where('kode_kelas', "TPQ-{$nextLetter}")->exists()) {
            $nextLetter++;
        }

        \App\Models\Kelas::create([
            'kode_kelas'    => "TPQ-{$nextLetter}",
            'nama_kelas'    => "TPQ {$nextLetter}",
            'tipe'          => 'TPQ',
            'tingkat'       => 'Dasar',
            'waktu_mulai'   => '16:00:00',
            'waktu_selesai' => '17:30:00',
            'ustadz_id'     => $ustadz->id,
            'keterangan'    => "Kelas otomatis untuk " . $ustadz->nama,
            'status'        => 'aktif',
        ]);
    }

    /**
     * Handle the Ustadz "updated" event.
     */
    public function updated(Ustadz $ustadz): void
    {
        //
    }

    /**
     * Handle the Ustadz "deleted" event.
     */
    public function deleted(Ustadz $ustadz): void
    {
        //
    }

    /**
     * Handle the Ustadz "restored" event.
     */
    public function restored(Ustadz $ustadz): void
    {
        //
    }

    /**
     * Handle the Ustadz "force deleted" event.
     */
    public function forceDeleted(Ustadz $ustadz): void
    {
        //
    }
}
