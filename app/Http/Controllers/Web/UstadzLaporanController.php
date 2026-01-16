<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ustadz;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Infaq; // Assuming model exists
use App\Models\Gaji; // Assuming model exists
use App\Models\Presensi;

class UstadzLaporanController extends Controller
{
    public function index()
    {
        return view('ustadz.laporan.index');
    }

    public function keuangan(Request $request)
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->ustadz) {
            abort(403, 'Profil Ustadz tidak ditemukan.');
        }
        $ustadz = $user->ustadz;

        // Determine Period
        // Default to current month if not specified
        $selectedPeriod = $request->input('period', Carbon::now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $selectedPeriod)->startOfMonth();
        $month = $date->month;
        $year = $date->year;

        // Format for View (e.g. October 2023)
        $monthName = $date->locale('id')->translatedFormat('F');
        $fullPeriodName = $date->locale('id')->translatedFormat('F Y');

        // 1. Data Gaji (Bisyaroh)
        // Find Gaji record for this ustadz, month, year
        // Month in DB is string (based on migration), likely 'Oktober' or '10'. Let's check or assume standard.
        // Usually safer to use integer if possible, but schema said string.
        // Let's assume schema stores Indonesian month name or numeric string.
        // I'll try matching both or just name.
        $gaji = Gaji::where('ustadz_id', $ustadz->id)
                    ->where('tahun', $year)
                    ->where(function($q) use ($monthName, $month) {
                        $q->where('bulan', $monthName)
                          ->orWhere('bulan', str_pad($month, 2, '0', STR_PAD_LEFT));
                    })
                    ->first();

        // Gaji Pokok per Pertemuan (default Rp 50.000)
        $gajiPerPertemuan = 50000;

        // Count Presensi - Hanya hitung hari yang memiliki MASUK dan PULANG (status lengkap)
        $presensiQuery = Presensi::where('user_id', $user->id)
                                ->whereMonth('tanggal', $month)
                                ->whereYear('tanggal', $year)
                                ->where('status_presensi', 'HADIR');

        $tanggalMasuk = (clone $presensiQuery)->where('tipe', 'masuk')->pluck('tanggal')->map(fn($t) => $t instanceof \Carbon\Carbon ? $t->format('Y-m-d') : $t)->toArray();
        $tanggalPulang = (clone $presensiQuery)->where('tipe', 'pulang')->pluck('tanggal')->map(fn($t) => $t instanceof \Carbon\Carbon ? $t->format('Y-m-d') : $t)->toArray();

        // Hitung tanggal yang ada di KEDUA array (memiliki masuk DAN pulang)
        $tanggalLengkap = array_intersect($tanggalMasuk, $tanggalPulang);
        $presensiCount = count(array_unique($tanggalLengkap));

        // Total Bisyaroh = Gaji Pokok per Pertemuan × Jumlah Kehadiran
        $totalBisyaroh = $gajiPerPertemuan * $presensiCount;

        // Get Presensi Details for Calendar
        $presensiDetails = Presensi::where('user_id', $user->id)
                                ->whereMonth('tanggal', $month)
                                ->whereYear('tanggal', $year)
                                ->get(['tanggal', 'jam', 'status_presensi']);

        // 2. Infaq Santri di Kelas
        // Get Kelas IDs for this Ustadz
        $kelasIds = Kelas::where('ustadz_id', $ustadz->id)->pluck('id');

        // Get Santris in these classes
        // Use 'santri' table directly
        $santriIds = Santri::whereIn('kelas_id', $kelasIds)->pluck('id');

        $infaqList = DB::table('infaq')
                        ->join('santri', 'infaq.santri_id', '=', 'santri.id')
                        ->whereIn('infaq.santri_id', $santriIds)
                        ->whereMonth('infaq.tanggal', $month)
                        ->whereYear('infaq.tanggal', $year)
                        ->select('infaq.*', 'santri.nama_lengkap as nama_santri')
                        ->get();

        $totalInfaq = $infaqList->sum('jumlah');
        $santriCount = $santriIds->count();

        // 3. Generate Period Options (Previous 6 months)
        $periods = [];
        for ($i = 0; $i < 6; $i++) {
            $d = Carbon::now()->subMonths($i);
            $periods[] = [
                'value' => $d->format('Y-m'),
                'label' => $d->locale('id')->translatedFormat('F Y')
            ];
        }

        return view('ustadz.laporan.keuangan', compact(
            'ustadz',
            'periods',
            'selectedPeriod',
            'fullPeriodName',
            'totalBisyaroh',
            'gajiPerPertemuan',
            'presensiCount',
            'infaqList',
            'totalInfaq',
            'santriCount',
            'presensiDetails',
            'month',
            'year'
        ));
    }

    /**
     * Display the Laporan Kegiatan (Jurnal & Ekskul) page.
     */
    public function kegiatan()
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->ustadz) {
            return redirect()->route('login');
        }

        $ustadz = $user->ustadz;

        // Fetch Jurnal Harian for this ustadz (handle if table doesn't exist yet)
        try {
            $jurnals = \App\Models\JurnalHarian::where('ustadz_id', $ustadz->id)
                ->orderBy('tanggal', 'desc')
                ->get();
        } catch (\Exception $e) {
            $jurnals = collect(); // Empty collection if table doesn't exist
        }

        // Fetch Kegiatan Ekskul for this ustadz (handle if table doesn't exist yet)
        try {
            $ekskuls = \App\Models\KegiatanEkskul::where('ustadz_id', $ustadz->id)
                ->orderBy('tanggal', 'desc')
                ->get();
        } catch (\Exception $e) {
            $ekskuls = collect(); // Empty collection if table doesn't exist
        }

        return view('ustadz.laporan.kegiatan', compact('jurnals', 'ekskuls'));
    }

    /**
     * Show form to create new Jurnal Harian.
     */
    public function createJurnal()
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->ustadz) {
            return redirect()->route('login');
        }

        $kelasList = Kelas::where('ustadz_id', $user->ustadz->id)->get();

        return view('ustadz.laporan.jurnal_form', compact('kelasList'));
    }

    /**
     * Store new Jurnal Harian.
     */
    public function storeJurnal(Request $request)
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->ustadz) {
            return redirect()->route('login');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'nullable|exists:kelas,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = [
            'ustadz_id' => $user->ustadz->id,
            'tanggal' => $request->tanggal,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas_id' => $request->kelas_id,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('jurnal', 'public');
        }

        $jurnal = \App\Models\JurnalHarian::create($data);

        return redirect()->route('ustadz.laporan.jurnal.success', $jurnal->id);
    }

    /**
     * Show success page after storing Jurnal.
     */
    public function jurnalSuccess($id)
    {
        $jurnal = \App\Models\JurnalHarian::with('kelas')->findOrFail($id);
        return view('ustadz.laporan.jurnal_success', compact('jurnal'));
    }

    /**
     * Show form to create new Kegiatan Ekskul.
     */
    public function createEkskul()
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->ustadz) {
            return redirect()->route('login');
        }

        return view('ustadz.laporan.ekskul_form');
    }

    /**
     * Store new Kegiatan Ekskul.
     */
    public function storeEkskul(Request $request)
    {
        $userId = session('user.id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->ustadz) {
            return redirect()->route('login');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:255',
            'pelatih' => 'nullable|string|max:255',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = [
            'ustadz_id' => $user->ustadz->id,
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'pelatih' => $request->pelatih,
            'jumlah_peserta' => $request->jumlah_peserta ?? 0,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ekskul', 'public');
        }

        \App\Models\KegiatanEkskul::create($data);

        return redirect()->route('ustadz.laporan.kegiatan')->with('success', 'Kegiatan Ekskul berhasil ditambahkan!');
    }
}
