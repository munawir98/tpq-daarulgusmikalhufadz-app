<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Models\AkhlakSantri;
use App\Models\NilaiUjian;
use App\Models\Santri;
use Carbon\Carbon;

class NilaiWebController extends Controller
{
    /**
     * Halaman utama menu nilai dengan 4 sub-menu
     */
    public function index()
    {
        return view('ustadz.nilai.index');
    }

    /**
     * Rekap nilai hafalan per santri
     */
    public function hafalan(Request $request)
    {
        $santriId = $request->get('santri_id');

        // Get all santri with their hafalan stats
        $santriList = Santri::with(['user'])->get()->map(function($santri) {
            $hafalanData = Hafalan::where('santri_id', $santri->user_id)->get();

            return [
                'id' => $santri->id,
                'user_id' => $santri->user_id,
                'name' => $santri->user->name ?? $santri->nama ?? 'Unknown',
                'total_setoran' => $hafalanData->count(),
                'avg_rating' => $hafalanData->count() > 0 ? round($hafalanData->avg('nilai'), 1) : 0,
                'total_ayat' => $hafalanData->sum(function($h) {
                    return ($h->ayat_akhir - $h->ayat_awal) + 1;
                }),
                'last_setoran' => $hafalanData->sortByDesc('tanggal')->first(),
            ];
        })->sortByDesc('avg_rating');

        // Detail if santri selected
        $selectedSantri = null;
        $hafalanDetail = collect();

        if ($santriId) {
            $selectedSantri = Santri::with('user')->find($santriId);
            if ($selectedSantri) {
                $hafalanDetail = Hafalan::where('santri_id', $selectedSantri->user_id)
                    ->orderBy('tanggal', 'desc')
                    ->get();
            }
        }

        return view('ustadz.nilai.hafalan', compact('santriList', 'selectedSantri', 'hafalanDetail'));
    }

    /**
     * Form input & rekap nilai tajwid
     */
    public function tajwid(Request $request)
    {
        $santriList = Santri::with('user')->get();

        // Get tajwid scores (using NilaiUjian with jenis_ujian = 'tajwid')
        $nilaiTajwid = NilaiUjian::where('jenis_ujian', 'tajwid')
            ->with('santri.user')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('ustadz.nilai.tajwid', compact('santriList', 'nilaiTajwid'));
    }

    /**
     * Store nilai tajwid
     */
    public function storeTajwid(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'nilai' => 'required|integer|min:1|max:100',
            'keterangan' => 'nullable|string',
        ]);

        NilaiUjian::create([
            'santri_id' => $request->santri_id,
            'jenis_ujian' => 'tajwid',
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
            'tanggal' => now(),
        ]);

        return back()->with('success', 'Nilai tajwid berhasil disimpan');
    }

    /**
     * Form input & rekap nilai akhlak
     */
    public function akhlak(Request $request)
    {
        $santriList = Santri::with('user')->get();

        // Get akhlak scores
        $nilaiAkhlak = AkhlakSantri::with('santri.user')
            ->orderBy('tanggal_penilaian', 'desc')
            ->get();

        return view('ustadz.nilai.akhlak', compact('santriList', 'nilaiAkhlak'));
    }

    /**
     * Store nilai akhlak
     */
    public function storeAkhlak(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'disiplin' => 'required|integer|min:1|max:5',
            'kerajinan' => 'required|integer|min:1|max:5',
            'kesopanan' => 'required|integer|min:1|max:5',
            'catatan' => 'nullable|string',
        ]);

        AkhlakSantri::create([
            'santri_id' => $request->santri_id,
            'disiplin' => $request->disiplin,
            'kerajinan' => $request->kerajinan,
            'kesopanan' => $request->kesopanan,
            'catatan' => $request->catatan,
            'tanggal_penilaian' => now(),
        ]);

        return back()->with('success', 'Nilai akhlak berhasil disimpan');
    }

    /**
     * Rapor / Rekap semua nilai per santri
     */
    public function rapor(Request $request)
    {
        $santriId = $request->get('santri_id');
        $santriList = Santri::with('user')->get();

        $selectedSantri = null;
        $raporData = null;

        if ($santriId) {
            $selectedSantri = Santri::with('user')->find($santriId);

            if ($selectedSantri) {
                // Nilai Hafalan
                $hafalanData = Hafalan::where('santri_id', $selectedSantri->user_id)->get();
                $nilaiHafalan = [
                    'avg_rating' => $hafalanData->count() > 0 ? round($hafalanData->avg('nilai'), 1) : 0,
                    'total_setoran' => $hafalanData->count(),
                    'total_ayat' => $hafalanData->sum(function($h) {
                        return ($h->ayat_akhir - $h->ayat_awal) + 1;
                    }),
                ];

                // Nilai Tajwid
                $tajwidData = NilaiUjian::where('santri_id', $santriId)
                    ->where('jenis_ujian', 'tajwid')
                    ->get();
                $nilaiTajwid = [
                    'avg' => $tajwidData->count() > 0 ? round($tajwidData->avg('nilai'), 1) : 0,
                    'count' => $tajwidData->count(),
                ];

                // Nilai Akhlak
                $akhlakData = AkhlakSantri::where('santri_id', $santriId)->get();
                $nilaiAkhlak = [
                    'disiplin' => $akhlakData->count() > 0 ? round($akhlakData->avg('disiplin'), 1) : 0,
                    'kerajinan' => $akhlakData->count() > 0 ? round($akhlakData->avg('kerajinan'), 1) : 0,
                    'kesopanan' => $akhlakData->count() > 0 ? round($akhlakData->avg('kesopanan'), 1) : 0,
                    'count' => $akhlakData->count(),
                ];

                // Calculate overall average (convert all to 100 scale)
                $hafalanScore = ($nilaiHafalan['avg_rating'] / 5) * 100;
                $tajwidScore = $nilaiTajwid['avg'];
                $akhlakAvg = ($nilaiAkhlak['disiplin'] + $nilaiAkhlak['kerajinan'] + $nilaiAkhlak['kesopanan']) / 3;
                $akhlakScore = ($akhlakAvg / 5) * 100;

                $components = [];
                if ($nilaiHafalan['total_setoran'] > 0) $components[] = $hafalanScore;
                if ($nilaiTajwid['count'] > 0) $components[] = $tajwidScore;
                if ($nilaiAkhlak['count'] > 0) $components[] = $akhlakScore;

                $totalAvg = count($components) > 0 ? round(array_sum($components) / count($components), 1) : 0;

                $raporData = [
                    'hafalan' => $nilaiHafalan,
                    'tajwid' => $nilaiTajwid,
                    'akhlak' => $nilaiAkhlak,
                    'total_avg' => $totalAvg,
                ];
            }
        }

        return view('ustadz.nilai.rapor', compact('santriList', 'selectedSantri', 'raporData'));
    }
}
