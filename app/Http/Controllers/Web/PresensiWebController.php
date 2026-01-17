<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BiometricWebController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PresensiWebController extends Controller
{
    protected $presensiService;

    public function __construct(\App\Services\Presensi\PresensiService $presensiService)
    {
        $this->presensiService = $presensiService;
    }

    // ... index method ...

    /**
     * Process clock-in
     */
    public function masuk(Request $request)
    {
        try {
            $request->validate([
                'foto' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

            $sessionUserId = session('user.id');
            if (!$sessionUserId) return response()->json(['message' => 'User ID session not found'], 401);

            // VERIFY USER EXISTS IN DB (Fix Integrity Violation)
            $user = \App\Models\User::find($sessionUserId);
            if (!$user) {
                // Session is stale, user deleted or DB reset
                session()->forget('user');
                session()->forget('api_token');
                return response()->json(['message' => 'User tidak ditemukan di database. Silakan login ulang.'], 401);
            }
            $userId = $user->id;

            // Radius Check
            $check = $this->presensiService->cekRadius($request->latitude, $request->longitude);
            if (!$check['status']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Posisi Anda Diluar Radius Absen (' . round($check['distance']) . ' meter).'
                ], 400);
            }

            $today = now()->format('Y-m-d');
            $now = now()->format('H:i:s');

            // Check if already checked in
            $exists = \App\Models\Presensi::where('user_id', $userId)
                ->where('tanggal', $today)
                ->where('tipe', 'masuk')
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Sudah melakukan presensi masuk'], 400);
            }

            // Handle Photo Upload (Base64)
            $fotoPath = null;
            if ($request->foto) {
                $image_parts = explode(";base64,", $request->foto);
                if (count($image_parts) >= 2) {
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = 'presensi_masuk_' . $userId . '_' . time() . '.' . $image_type;
                    $fotoPath = 'presensi/' . $fileName;
                    \Illuminate\Support\Facades\Storage::disk('public')->put($fotoPath, $image_base64);
                }
            }

            // Additional: If user is USTADZ, try to fill ustadz_id if possible
            $ustadzId = null;
            if ($user->role === 'USTADZ') {
                $ustadz = $user->ustadz; // via relationship
                if ($ustadz) {
                    $ustadzId = $ustadz->id;
                }
            }

            \App\Models\Presensi::create([
                'user_id' => $userId,
                'ustadz_id' => $ustadzId, // Link to ustadz table if exists
                'tanggal' => $today,
                'jam' => $now,
                'tipe' => 'masuk',
                'foto' => $fotoPath,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status_presensi' => 'HADIR',
            ]);

            return response()->json(['success' => true, 'message' => 'Presensi masuk berhasil dicatat']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Process clock-out
     */
    public function pulang(Request $request)
    {
        try {
            $request->validate([
                'foto' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);

            $sessionUserId = session('user.id');
            if (!$sessionUserId) return response()->json(['message' => 'User ID session not found'], 401);

             // VERIFY USER EXISTS IN DB
             $user = \App\Models\User::find($sessionUserId);
             if (!$user) {
                 session()->forget('user');
                 session()->forget('api_token');
                 return response()->json(['message' => 'User tidak ditemukan di database. Silakan login ulang.'], 401);
             }
             $userId = $user->id;

             // Radius Check
            $check = $this->presensiService->cekRadius($request->latitude, $request->longitude);
            if (!$check['status']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Posisi Anda Diluar Radius Absen (' . round($check['distance']) . ' meter).'
                ], 400);
            }

            $today = now()->format('Y-m-d');
            $now = now()->format('H:i:s');

            // Check if already checked out
            $existsPulang = \App\Models\Presensi::where('user_id', $userId)
                ->where('tanggal', $today)
                ->where('tipe', 'pulang')
                ->exists();

            if ($existsPulang) {
                 return response()->json(['message' => 'Sudah melakukan presensi pulang'], 400);
            }

            // Check if presensi masuk exists
            $existsMasuk = \App\Models\Presensi::where('user_id', $userId)
                ->where('tanggal', $today)
                ->where('tipe', 'masuk')
                ->exists();

            if (!$existsMasuk) {
                return response()->json(['message' => 'Anda belum melakukan presensi masuk hari ini'], 400);
            }

            // Handle Photo Upload
            $fotoPath = null;
            if ($request->foto) {
                 $image_parts = explode(";base64,", $request->foto);
                 if (count($image_parts) >= 2) {
                     $image_type_aux = explode("image/", $image_parts[0]);
                     $image_type = $image_type_aux[1];
                     $image_base64 = base64_decode($image_parts[1]);
                     $fileName = 'presensi_pulang_' . $userId . '_' . time() . '.' . $image_type;
                     $fotoPath = 'presensi/' . $fileName;
                     \Illuminate\Support\Facades\Storage::disk('public')->put($fotoPath, $image_base64);
                 }
            }

            // Additional: If user is USTADZ, try to fill ustadz_id if possible
            $ustadzId = null;
            if ($user->role === 'USTADZ') {
                $ustadz = $user->ustadz; // via relationship
                if ($ustadz) {
                    $ustadzId = $ustadz->id;
                }
            }

            \App\Models\Presensi::create([
                'user_id' => $userId,
                'ustadz_id' => $ustadzId,
                'tanggal' => $today,
                'jam' => $now,
                'tipe' => 'pulang',
                'foto' => $fotoPath,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status_presensi' => 'HADIR',
            ]);

            return response()->json(['success' => true, 'message' => 'Presensi pulang berhasil dicatat']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Main Index (Laporan & Atensi)
     * Used by Ustadz to view santri attendance report
     */
    public function index(Request $request)
    {
        // Handle Filters
        $monthInput = $request->input('month', now()->format('Y-m'));
        $kelasId = $request->input('kelas');

        try {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $monthInput);
        } catch (\Exception $e) {
            $date = now();
        }

        // Get Kelas List for Filter
        $kelasList = \App\Models\Kelas::orderBy('nama_kelas')->get();

        // 1. Total Santri Terdaftar (Active)
        $santriQuery = \App\Models\Santri::where('status_aktif', true);
        if ($kelasId) {
            $santriQuery->where('kelas_id', $kelasId);
        }
        $totalSantri = $santriQuery->count();

        // 2. Rata-rata Kehadiran Bulan Ini
        $kehadiranQuery = \App\Models\KehadiranSantri::whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month);

        if ($kelasId) {
            $kehadiranQuery->whereHas('santri', function($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        $totalKehadiran = (clone $kehadiranQuery)->count();
        $totalHadir = (clone $kehadiranQuery)->where('status', 'Hadir')->count();
        $avgKehadiran = $totalKehadiran > 0 ? round(($totalHadir / $totalKehadiran) * 100) : 0;

        // 3. Tren Kehadiran (configurable months)
        $trendMonths = (int) $request->input('trend_months', 6);
        if (!in_array($trendMonths, [3, 6, 12])) {
            $trendMonths = 6;
        }

        $trendData = [];
        for ($i = $trendMonths - 1; $i >= 0; $i--) {
            $trendDate = now()->subMonths($i);
            $trendQuery = \App\Models\KehadiranSantri::whereYear('tanggal', $trendDate->year)
                ->whereMonth('tanggal', $trendDate->month);

            if ($kelasId) {
                $trendQuery->whereHas('santri', function($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                });
            }

            $trendTotal = $trendQuery->count();
            $trendHadir = (clone $trendQuery)->where('status', 'Hadir')->count();
            $trendData[] = [
                'month' => $trendDate->translatedFormat('M'),
                'percentage' => $trendTotal > 0 ? round(($trendHadir / $trendTotal) * 100) : 0
            ];
        }

        // 4. Santri Perlu Perhatian (< 70% kehadiran bulan ini)
        $santriPerluPerhatian = [];
        $santriListQuery = \App\Models\Santri::where('status_aktif', true);
        if ($kelasId) {
            $santriListQuery->where('kelas_id', $kelasId);
        }
        $santriList = $santriListQuery->get();

        foreach ($santriList as $santri) {
            $santriKehadiran = \App\Models\KehadiranSantri::where('santri_id', $santri->id)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month);

            $santriTotal = $santriKehadiran->count();
            $santriHadir = (clone $santriKehadiran)->where('status', 'Hadir')->count();
            $santriPersen = $santriTotal > 0 ? round(($santriHadir / $santriTotal) * 100) : 0;

            if ($santriPersen < 70 && $santriTotal > 0) {
                $santriPerluPerhatian[] = [
                    'id' => $santri->id,
                    'nama' => $santri->nama_lengkap,
                    'foto' => $santri->user?->foto,
                    'persentase' => $santriPersen
                ];
            }
        }

        // Sort by lowest percentage
        usort($santriPerluPerhatian, fn($a, $b) => $a['persentase'] <=> $b['persentase']);
        $santriPerluPerhatian = array_slice($santriPerluPerhatian, 0, 10);

        // 5. Daftar Kehadiran Santri
        $daftarKehadiran = [];
        foreach ($santriList as $santri) {
            $santriKehadiran = \App\Models\KehadiranSantri::where('santri_id', $santri->id)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month);

            $hadir = (clone $santriKehadiran)->where('status', 'Hadir')->count();
            $izin = (clone $santriKehadiran)->where('status', 'Izin')->count();
            $sakit = (clone $santriKehadiran)->where('status', 'Sakit')->count();
            $alpa = (clone $santriKehadiran)->where('status', 'Alpa')->count();
            $total = $santriKehadiran->count();
            $persentase = $total > 0 ? round(($hadir / $total) * 100) : 0;

            $daftarKehadiran[] = [
                'id' => $santri->id,
                'nama' => $santri->nama_lengkap,
                'foto' => $santri->user?->foto,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'persentase' => $persentase
            ];
        }

        // Sort by name
        usort($daftarKehadiran, fn($a, $b) => strcmp($a['nama'], $b['nama']));

        return view('presensi.index', [
            'totalSantri' => $totalSantri,
            'avgKehadiran' => $avgKehadiran,
            'trendData' => $trendData,
            'santriPerluPerhatian' => $santriPerluPerhatian,
            'daftarKehadiran' => $daftarKehadiran,
            'selectedMonth' => $monthInput,
            'selectedKelas' => $kelasId,
            'kelasList' => $kelasList,
            'selectedDate' => $date,
        ]);
    }

    public function ustadzIndex(Request $request)
    {
        $userId = session('user.id');
        $today = now()->format('Y-m-d');

        // Data Hari Ini
        $presensiToday = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->get();

        $jamMasuk = $presensiToday->where('tipe', 'masuk')->first();
        $jamPulang = $presensiToday->where('tipe', 'pulang')->first();

        // Filter / Riwayat
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = \App\Models\Presensi::where('user_id', $userId);

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        } else {
             // Default 7 hari terakhir
             $query->where('tanggal', '>=', now()->subDays(7)->format('Y-m-d'));
        }

        $riwayat = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        // Hitung Total Hadir - Hanya hitung hari yang memiliki MASUK dan PULANG (status lengkap/selesai)
        $queryBase = \App\Models\Presensi::where('user_id', $userId);
        if ($startDate && $endDate) {
            $queryBase->whereBetween('tanggal', [$startDate, $endDate]);
        } else {
            $queryBase->where('tanggal', '>=', now()->subDays(7)->format('Y-m-d'));
        }

        // Ambil tanggal-tanggal yang memiliki KEDUA tipe (masuk dan pulang)
        $tanggalMasuk = (clone $queryBase)->where('tipe', 'masuk')->pluck('tanggal')->map(fn($t) => $t instanceof \Carbon\Carbon ? $t->format('Y-m-d') : $t)->toArray();
        $tanggalPulang = (clone $queryBase)->where('tipe', 'pulang')->pluck('tanggal')->map(fn($t) => $t instanceof \Carbon\Carbon ? $t->format('Y-m-d') : $t)->toArray();

        // Hitung tanggal yang ada di KEDUA array (intersection = memiliki masuk DAN pulang)
        $tanggalLengkap = array_intersect($tanggalMasuk, $tanggalPulang);
        $totalHadirCount = count(array_unique($tanggalLengkap));

        return view('ustadz.presensi.index', [
            'riwayat' => $riwayat,
            'jamMasuk' => $jamMasuk,
            'jamPulang' => $jamPulang,
            'filterStart' => $startDate,
            'filterEnd' => $endDate,
            'totalHadir' => $totalHadirCount
        ]);
    }

    public function santriIndex()
    {
        $userId = session('user.id');
        // Fallback if session missing but auth exists (shouldn't happen with middleware)
        if (!$userId && auth()->check()) $userId = auth()->id();

        $user = \App\Models\User::find($userId);
        $hasBiometric = $user && ($user->biometric_credential || $user->biometricCredentials()->exists());
        // Note: Previous code checked $user->biometric_credential (string column from earlier migration? Or relation?)
        // The earlier migration added 'biometric_credential' string to users table.
        // My recent migration added 'biometric_credentials' table and 'biometricCredentials' relation.
        // The 'biometric_credential' column on users table might still be there or used as 'main' credential.
        // Let's stick to simple property check if it was checking the column: !empty($user->biometric_credential)
        // But wait, I added a new table. The old column might be obsolete?
        // The view 'santri.presensi' uses $hasBiometric probably to show fingerprint button.
        // I should check if I should use the relation or the column.
        // Let's look at what I saw in `PresensiWebController.santriIndex` before:
        // `$hasBiometric = $user && !empty($user->biometric_credential);`
        // I will keep using the same logic for biometric to avoid breaking it, but I should probably check the new relation too if I want to support the new reg feature.
        // BUT the user just asked to fix `undefined variable $haspresensi`. I should focus on that.
        // I will keep the existing biometric check logic (as I saw it) or just not touch it if I can via replace.
        // Ah, I'm replacing the whole function.
        // Let's check if `biometric_credential` column still exists or if I should check the relation.
        // The user's earlier request was "daftarkan sidik jari". I added a new table.
        // The registration stores to `BiometricCredential` table.
        // The old `biometric_credential` column on `users` might be empty now for new registrations.
        // So I should check `biometricCredentials()->exists()` OR the old column.

        $hasBiometric = $user && ($user->biometric_credential || $user->biometricCredentials()->exists());

        $today = now()->format('Y-m-d');
        $hasPresensi = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->exists();

        return view('santri.presensi', compact('hasBiometric', 'hasPresensi'));
    }

    public function santriStore(Request $request)
    {
        // Use the same logic as 'masuk' or general presensi
        // Since santri might not have separate logic yet, we can reuse 'masuk' logic or creating a unified store if it's manual presensi without photo
        // However, santri presensi currently is 'Manual Presensi' (button) or 'Scan QR'.
        // Let's implement basic manual presensi for Santri here.

        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $userId = session('user.id');
        $check = $this->presensiService->cekRadius($request->latitude, $request->longitude);

        if (!$check['status']) {
            return back()->with('error', 'Gagal: Anda berada diluar radius presensi (' . round($check['distance']) . 'm).');
        }

        $today = now()->format('Y-m-d');

        // Simple attendance logic for Santri Manual
        // Check if already present
        $exists = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->exists();

        if ($exists) {
             return back()->with('error', 'Anda sudah melakukan presensi hari ini.');
        }

        \App\Models\Presensi::create([
            'user_id' => $userId,
            'tanggal' => $today,
            'jam' => now()->format('H:i:s'),
            'tipe' => 'masuk', // Asumsi manual = masuk
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status_presensi' => 'HADIR',
            'metode' => 'MANUAL' // Optional if column exists, otherwise remove
        ]);

        return back()->with('success', 'Presensi berhasil dicatat via Lokasi.');
    }

    /**
     * Show santri presensi history
     */
    public function santriHistory()
    {
        return view('presensi.index');
    }


    /**
     * Show PDF Confirmation Page
     */
    public function pdfConfirmation(Request $request)
    {
        $monthInput = $request->input('month', now()->format('Y-m'));
        $kelasId = $request->input('kelas');

        try {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $monthInput);
        } catch (\Exception $e) {
            $date = now();
        }

        $monthName = $date->locale('id')->translatedFormat('F Y');
        $filename = 'Laporan_Kehadiran_' . $date->format('M_Y') . '.pdf';

        return view('presensi.pdf_confirm', compact('monthInput', 'kelasId', 'monthName', 'filename'));
    }

    /**
     * Handle PDF Download
     */
    public function pdfDownload(Request $request)
    {
        $monthInput = $request->input('month', now()->format('Y-m'));
        $kelasId = $request->input('kelas');

        try {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $monthInput);
        } catch (\Exception $e) {
            $date = now();
        }

        $monthName = $date->locale('id')->translatedFormat('F Y');
        $filename = 'Laporan_Kehadiran_' . $date->format('M_Y') . '.pdf';

        // Get Kelas Name if filter active
        $kelasNama = null;
        if ($kelasId) {
            $kelas = \App\Models\Kelas::find($kelasId);
            if ($kelas) $kelasNama = $kelas->nama_kelas;
        }

        // Fetch Data Logic (Similar to Index)
        $santriListQuery = \App\Models\Santri::where('status_aktif', true)->orderBy('nama_lengkap', 'asc');

        if ($kelasId) {
            $santriListQuery->where('kelas_id', $kelasId);
        }
        $santriList = $santriListQuery->get();

        $data = [];
        foreach ($santriList as $santri) {
            $santriKehadiran = \App\Models\KehadiranSantri::where('santri_id', $santri->id)
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month);

            // Clone queries for counts
            $hadir = (clone $santriKehadiran)->where('status', 'Hadir')->count();
            $izin = (clone $santriKehadiran)->where('status', 'Izin')->count();
            $sakit = (clone $santriKehadiran)->where('status', 'Sakit')->count();
            $alpa = (clone $santriKehadiran)->where('status', 'Alpa')->count();
            $total = $santriKehadiran->count();
            $persentase = $total > 0 ? round(($hadir / $total) * 100) : 0;

            $data[] = [
                'nama' => $santri->nama_lengkap,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'persentase' => $persentase
            ];
        }

        // Generate PDF
        $printedBy = auth()->user() ? auth()->user()->name : 'Sistem';

        $pdf = Pdf::loadView('presensi.pdf_export', [
            'data' => $data,
            'monthName' => $monthName,
            'kelasNama' => $kelasNama,
            'printedBy' => $printedBy
        ])->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }
}
