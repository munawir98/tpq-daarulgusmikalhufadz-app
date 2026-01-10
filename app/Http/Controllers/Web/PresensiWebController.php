<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
     * Main Index (Rekap/History)
     * Used by Ustadz & maybe shared
     */
    public function index(Request $request)
    {
        $userId = session('user.id');

        // Handle Month Filter (format: YYYY-MM)
        $monthInput = $request->input('month', now()->format('Y-m'));
        $date = \Carbon\Carbon::createFromFormat('Y-m', $monthInput);

        // 1. Data Hari Ini (Only relevant if selected month is current month, otherwise maybe hide or show average)
        // For simplicity, we keep showing today's data or maybe null if looking at past months.
        // Let's keep it simple: "Hari Ini" block always shows REAL TODAY regardless of filter,
        // because it's a "dashboard" status widget.
        $today = now()->format('Y-m-d');
        $jamMasuk = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->where('tipe', 'masuk')
            ->first();
        $jamPulang = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', $today)
            ->where('tipe', 'pulang')
            ->first();

        // 2. Statistik Bulanan (Based on Selected Month)
        $totalHadir = \App\Models\Presensi::where('user_id', $userId)
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->where('status_presensi', 'HADIR')
            ->selectRaw('count(distinct tanggal) as total')
            ->value('total');

        $totalIzin = \App\Models\Presensi::where('user_id', $userId)
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->where('status_presensi', 'IZIN')
            ->count();

        $totalAlfa = \App\Models\Presensi::where('user_id', $userId)
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->where('status_presensi', 'ALFA')
            ->count();

        // Simple heuristic for working days
        $totalHariKerja = 22; // Placeholder/Standard

        // 3. Riwayat (Filtered by Month)
        $riwayatRaw = \App\Models\Presensi::where('user_id', $userId)
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'asc')
            ->get();

        $riwayatMingguIni = $riwayatRaw->groupBy('tanggal'); // Variable name kept for compatibility but holds Month data now

        return view('presensi.index', [
            'jamMasuk' => $jamMasuk,
            'jamPulang' => $jamPulang,
            'totalHadir' => $totalHadir ?? 0,
            'totalIzin' => $totalIzin ?? 0,
            'totalAlfa' => $totalAlfa ?? 0,
            'totalHariKerja' => $totalHariKerja,
            'riwayat' => $riwayatMingguIni, // Renaming recommended but sticking to view expectations or creating alias
            'riwayatMingguIni' => $riwayatMingguIni,
            'selectedDate' => $date, // Pass Carbon object for view title
        ]);
    }

    public function ustadzIndex(Request $request)
    {
        $userId = session('user.id');

        // Ambil data riwayat presensi 7 hari terakhir untuk ditampilkan di halaman presensi
        $riwayat = \App\Models\Presensi::where('user_id', $userId)
            ->where('tanggal', '>=', now()->subDays(7)->format('Y-m-d'))
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->get();

        return view('ustadz.presensi.index', [
            'riwayat' => $riwayat
        ]);
    }

    public function santriIndex()
    {
        return view('santri.presensi');
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
}
