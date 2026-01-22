<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HafalanWebController extends Controller
{
    protected function apiUrl($path = '')
    {
        return config('app.api_url', 'http://localhost:8000/api') . $path;
    }

    protected function getToken()
    {
        return session('api_token');
    }

    private function checkSchedule() {
        return true; // Bypass schedule check for development/testing

        $now = now();
        $dayOfWeek = $now->dayOfWeek; // 0=Sun, 6=Sat
        $currentTime = $now->format('H:i');

        // Jadwal: Rabu & Kamis (16:00 - 18:30)
        if ($dayOfWeek == 3 || $dayOfWeek == 4) {
            return ($currentTime >= '16:00' && $currentTime <= '18:30');
        }
        // Jadwal: Sabtu & Minggu (06:00 - 09:00)
        elseif ($dayOfWeek == 6 || $dayOfWeek == 0) {
            return ($currentTime >= '06:00' && $currentTime <= '09:00');
        }

        return false;
    }

    /**
     * Display hafalan list for ustadz
     */
    public function index(Request $request)
    {
        // Check Schedule Logic
        $isScheduleActive = $this->checkSchedule();
        $scheduleMessage = "";

        if (!$isScheduleActive) {
            $now = now();
            $dayOfWeek = $now->dayOfWeek; // 0=Sun, 1=Mon, ..., 6=Sat
            $currentTime = $now->format('H:i');

            if ($dayOfWeek == 1 || $dayOfWeek == 2) {
                // Mon/Tue -> Next: Wed 16:00
                $scheduleMessage = "Tunggu jadwal : Rabu 16:00";
            } elseif ($dayOfWeek == 3) {
                // Wed
                if ($currentTime > '18:30') {
                    $scheduleMessage = "Tunggu jadwal : Kamis 16:00";
                } else {
                    $scheduleMessage = "Tunggu jadwal : Rabu 16:00";
                }
            } elseif ($dayOfWeek == 4) {
                // Thu
                if ($currentTime > '18:30') {
                    $scheduleMessage = "Tunggu jadwal : Sabtu 06:00";
                } else {
                    $scheduleMessage = "Tunggu jadwal : Kamis 16:00";
                }
            } elseif ($dayOfWeek == 5) {
                // Fri -> Next: Sat 06:00
                $scheduleMessage = "Tunggu jadwal : Sabtu 06:00";
            } elseif ($dayOfWeek == 6) {
                // Sat
                if ($currentTime > '09:00') {
                    $scheduleMessage = "Tunggu jadwal : Minggu 06:00";
                } else {
                    $scheduleMessage = "Tunggu jadwal : Sabtu 06:00";
                }
            } elseif ($dayOfWeek == 0) {
                // Sun
                if ($currentTime > '09:00') {
                    $scheduleMessage = "Tunggu jadwal : Rabu 16:00";
                } else {
                    $scheduleMessage = "Tunggu jadwal : Minggu 06:00";
                }
            } else {
                $scheduleMessage = "Jadwal input belum dibuka.";
            }
        }

        // Get all santri list for SEARCH dropdown (FILTER BY CLASS ASSIGNMENT)
        $userSession = session('user'); // Use session instead of auth()->user()
        $querySantri = \App\Models\User::where('role', 'SANTRI');

        if ($userSession && isset($userSession['role']) && $userSession['role'] === 'USTADZ') {
            // Find Ustadz Profile
            $ustadz = \App\Models\Ustadz::where('user_id', $userSession['id'])->first();
            $nip = $userSession['nip'] ?? null; // Get NIP from session

            // Logic Adjustment to match inputForm behavior:
            // Only apply filters if NIP is set. If NIP is missing, default to showing ALL santri.
            // This handles cases where Ustadz data is incomplete (no NIP, no Class links) but they need to see list.
            if (!empty($nip)) {
                 $querySantri->where(function($q) use ($ustadz, $nip) {
                     // 1. NIP Based
                     $q->where('pembimbing_nip', $nip);

                     // 2. Class Based (Bonus: if profile exists, also show class students)
                     if ($ustadz) {
                         $q->orWhereHas('santri.kelas', function($subQ) use ($ustadz) {
                             $subQ->where('ustadz_id', $ustadz->id);
                         });
                     }
                 });
            }
            // If NIP is empty, we do NOTHING -> Returns All Santri.
        }

        $allSantri = $querySantri->select('id', 'name', 'pembimbing_nip')
            ->orderBy('name')
            ->get();


        $selectedSantriId = $request->santri_id;
        $selectedSantri = $selectedSantriId ? $allSantri->firstWhere('id', $selectedSantriId) : null;

        // 1. Get History
        $queryHistory = \App\Models\Hafalan::with(['santri', 'ustadz'])
            ->orderBy('created_at', 'desc');

        if ($selectedSantriId) {
            $queryHistory->where('santri_id', $selectedSantriId);
        }

        $riwayatSetoran = $queryHistory
            ->take(20)
            ->get();

        // 2. Statistics Calculation
        if ($selectedSantri) {
            // --- CONTEXT: SINGLE SANTRI ---
            $myHafalan = \App\Models\Hafalan::where('santri_id', $selectedSantriId)->get();

            // Total Ayat
            $totalAyat = $myHafalan->sum(function ($h) {
                return max(0, $h->ayat_akhir - $h->ayat_awal + 1);
            });

            // Target (Example: 1000 for all)
            $target = 1000;

            $stats = [
                'title' => 'Progress: ' . $selectedSantri->name,
                'percent' => min(100, round(($totalAyat / $target) * 100)),
                'achieved' => $totalAyat,
                'target' => $target,
                'remaining' => max(0, $target - $totalAyat),
                'label_achieved' => 'Sudah Hafal',
                'label_target' => 'Target Total',
            ];

            // Current Target / Last Activity
            $last = $myHafalan->sortByDesc('created_at')->first();
            if ($last) {
                // Determine Current Surah
                $currentSurah = $last->surah;

                // Calculate Duration for THIS Surah (First entry of this surah to Now/Last entry)
                $firstForSurah = $myHafalan->where('surah', $currentSurah)->sortBy('created_at')->first();
                $surahDuration = "-";

                if ($firstForSurah) {
                    $startSurah = \Carbon\Carbon::parse($firstForSurah->created_at);
                    // Calculates absolute difference (days, weeks, months) e.g. "2 weeks"
                    // If it's the same day, it might return "1 second" etc. so we can format it.
                    $diff = $startSurah->diffForHumans(null, [
                        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                        'parts' => 2,
                        'short' => true
                    ]);
                     // Localization fix
                    $surahDuration = str_replace(
                        ['y', 'mo', 'w', 'd', 'h', 'm', 's'],
                        [' Thn', ' Bln', ' Mgg', ' Hr', ' Jam', ' Menit', ' Detik'],
                        $diff
                    );
                }

                $nextStart = $last->ayat_akhir + 1;
                $nextEnd = $nextStart + 5;
                $currentTarget = "{$last->surah}: Ayat {$nextStart}-{$nextEnd}";
                $targetProgress = 0;
                $targetProgressText = "Durasi hafalan {$currentSurah}: {$surahDuration}";
            } else {
                $currentTarget = "Belum ada hafalan";
                $targetProgress = 0;
                $targetProgressText = "-";
            }

            // Global Duration (First ever to now)
            $firstHafalan = $myHafalan->sortBy('created_at')->first();
            if ($firstHafalan) {
                $since = \Carbon\Carbon::parse($firstHafalan->created_at);
                $duration = $since->diffForHumans(null, [
                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                    'parts' => 2,
                    'short' => true
                ]);
                $duration = str_replace(
                    ['y', 'mo', 'w', 'd', 'h', 'm', 's'],
                    [' Thn', ' Bln', ' Mgg', ' Hr', ' Jam', ' Menit', ' Detik'],
                    $duration
                );
            } else {
                $duration = "-";
            }
            $stats['duration'] = $duration;

            // Activity Status (2 Weeks Threshold)
            $statusLabel = "Menunggu Setoran";
            $statusColor = "gray";

            if ($last) {
                $lastDate = \Carbon\Carbon::parse($last->created_at);
                $daysSince = $lastDate->diffInDays(now());

                if ($daysSince <= 3) {
                    $statusLabel = "Sangat Aktif";
                    $statusColor = "green";
                } elseif ($daysSince <= 14) { // 2 Weeks
                    $statusLabel = "Aktif";
                    $statusColor = "blue";
                } else {
                    $statusLabel = "Perlu Perhatian"; // > 2 Weeks
                    $statusColor = "orange"; // or Red
                }
            }
            $stats['status_label'] = $statusLabel;
            $stats['status_color'] = $statusColor;

        } else {
            // --- CONTEXT: COLLECTIVE (DEFAULT) ---
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            // Fix for SQLite compatibility (Railway)
            $totalAyatBulanIni = \App\Models\Hafalan::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->selectRaw('SUM(CASE WHEN (ayat_akhir - ayat_awal + 1) > 0 THEN (ayat_akhir - ayat_awal + 1) ELSE 0 END) as total_ayat')
                ->value('total_ayat') ?? 0;

            // Deployment trigger check v2

            // Deployment trigger check v3
            $targetAyatMonth = 1000;

            $stats = [
                'title' => 'Target Bulan Ini',
                'percent' => min(100, round(($totalAyatBulanIni / $targetAyatMonth) * 100)),
                'achieved' => $totalAyatBulanIni,
                'target' => $targetAyatMonth,
                'remaining' => max(0, $targetAyatMonth - $totalAyatBulanIni),
                'label_achieved' => 'Capaian',
                'label_target' => 'Target',
                'duration' => now()->translatedFormat('F Y'), // "Januari 2026"
            ];

            // For collective, just show latest activity from anyone
            $lastHafalan = $riwayatSetoran->first();
            if ($lastHafalan) {
                $santriName = optional($lastHafalan->santri)->name ?? 'Santri (Terhapus)';
                $currentTarget = "{$lastHafalan->surah} ({$santriName})";
                $targetProgress = 0;
                $currentSurah = $lastHafalan->surah;

                // Calculate duration for this surah (collective or just relative to this santri's start of surah?)
                // Let's make it relative to the specific santri's start of this surah
                $firstForSurah = \App\Models\Hafalan::where('santri_id', $lastHafalan->santri_id)
                    ->where('surah', $currentSurah)
                    ->orderBy('created_at', 'asc')
                    ->first();

                $surahDuration = "-";
                if ($firstForSurah) {
                    $startSurah = \Carbon\Carbon::parse($firstForSurah->created_at);
                    $diff = $startSurah->diffForHumans(null, [
                        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                        'parts' => 2,
                        'short' => true
                    ]);
                    $surahDuration = str_replace(
                        ['y', 'mo', 'w', 'd', 'h', 'm', 's'],
                        [' Thn', ' Bln', ' Mgg', ' Hr', ' Jam', ' Menit', ' Detik'],
                        $diff
                    );
                }

                $targetProgressText = "Durasi {$currentSurah}: {$surahDuration}";
            } else {
                $currentTarget = "Belum ada aktivitas";
                $targetProgress = 0;
                $targetProgressText = "-";
            }
        }

        return view('ustadz.hafalan.index', [
            'riwayatSetoran' => $riwayatSetoran,
            'stats' => $stats,
            'currentTarget' => $currentTarget,
            'targetProgress' => $targetProgress,
            'targetProgressText' => $targetProgressText,
            'santriList' => $allSantri, // For dropdown
            'selectedSantriId' => $selectedSantriId,
            'isScheduleActive' => $isScheduleActive,
            'scheduleMessage' => $scheduleMessage,
        ]);
    }

    /**
     * Show input setoran form
     */
    public function inputForm(Request $request)
    {
        $user = session('user');
        $querySantri = \App\Models\User::where('role', 'SANTRI');

        if (isset($user['role']) && $user['role'] === 'USTADZ' && !empty($user['nip'])) {
            $querySantri->where('pembimbing_nip', $user['nip']);
        }

        $santris = $querySantri->select('id', 'name')->get();

        // Get all last hafalans in single query (optimized)
        $lastHafalans = \App\Models\Hafalan::whereIn('santri_id', $santris->pluck('id'))
            ->select('santri_id', 'surah', 'ayat_akhir')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('santri_id')
            ->map(fn($items) => $items->first());

        // Attach last hafalan to each santri
        $santris->each(function ($santri) use ($lastHafalans) {
            $santri->last_hafalan = $lastHafalans->get($santri->id);
        });

        // Check for specific santri selected via URL
        $selectedSantriId = $request->query('santri_id');

        return view('ustadz.hafalan.input', [
            'santris' => $santris,
            'selectedSantriId' => $selectedSantriId,
        ]);
    }

    /**
     * Show form for new setoran
     */
    public function create(Request $request)
    {
        $user = session('user');
        $querySantri = \App\Models\User::where('role', 'SANTRI');

        // Filter if Ustadz is bound to specific santri (if logic exists)
        if (isset($user['role']) && $user['role'] === 'USTADZ' && !empty($user['nip'])) {
            $querySantri->where('pembimbing_nip', $user['nip']);
        }

        $santriList = $querySantri->select('id', 'name')
            ->orderBy('name')
            ->get();

        $surahList = $this->getSurahList();

        // Check for specific santri selected via URL
        $selectedSantriId = $request->query('santri_id');

        return view('ustadz.hafalan.create', [
            'santriList' => $santriList,
            'surahList' => $surahList,
            'selectedSantriId' => $selectedSantriId,
        ]);
    }

    /**
     * Store new setoran
     */
    public function store(Request $request)
    {
        // Validate Schedule
        if (!$this->checkSchedule()) {
            return back()->with('error', 'Gagal menyimpan: Di luar jadwal KBM (Rabu-Kamis 16:00-18:30, Sabtu-Minggu 06:00-09:00)');
        }

        $request->validate([
            'santri_id' => 'required|exists:users,id',
            'surah' => 'required|string|max:255',
            'ayat_awal' => 'required|integer|min:1',
            'ayat_akhir' => 'required|integer|min:1|gte:ayat_awal',
            'nilai' => 'required|integer|min:1|max:5',
            'catatan' => 'nullable|string|max:500',
        ]);

        $surahList = $this->getSurahList();
        $surahData = $surahList->firstWhere('name', $request->surah);

        if (!$surahData) {
            return back()
                ->withInput()
                ->with('error', 'Surah tidak ditemukan dalam daftar.');
        }

        if ($request->ayat_awal < 1 || $request->ayat_akhir > $surahData['ayat']) {
            return back()
                ->withInput()
                ->with('error', "Ayat awal atau akhir tidak valid untuk surah {$request->surah} (total ayat {$surahData['ayat']}).");
        }

        // Convert star rating to grade
        $grades = [1 => 'Tidak Lancar', 2 => 'Kurang Lancar', 3 => 'Lancar', 4 => 'Sangat Lancar', 5 => 'Sempurna'];
        $grade = $grades[$request->nilai] ?? 'Lancar';

        try {
            $hafalan = \App\Models\Hafalan::create([
                'santri_id' => $request->santri_id,
                'ustadz_id' => session('user.id'),
                'surah' => $request->surah,
                'ayat_awal' => $request->ayat_awal,
                'ayat_akhir' => $request->ayat_akhir,
                'nilai' => $grade,
                'catatan' => $request->catatan,
                'tanggal' => now(),
            ]);

            // Send notification to santri
            $santri = \App\Models\User::find($request->santri_id);
            if ($santri) {
                \App\Models\Notification::createForUser(
                    $santri->id,
                    'Setoran Hafalan Baru',
                    "Setoran {$request->surah} ayat {$request->ayat_awal}-{$request->ayat_akhir} telah dicatat. Nilai: {$grade}",
                    'hafalan',
                    ['hafalan_id' => $hafalan->id]
                );
            }

            return redirect()->route('ustadz.hafalan.index')
                ->with('success', 'Setoran berhasil dicatat dan notifikasi dikirim ke santri!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Show hafalan detail
     */
    public function show($id)
    {
        $hafalan = \App\Models\Hafalan::with(['santri', 'ustadz'])->find($id);

        if (!$hafalan) {
            return redirect()->route('ustadz.hafalan.index')
                ->with('error', 'Data tidak ditemukan');
        }

        return view('ustadz.hafalan.show', [
            'hafalan' => $hafalan,
        ]);
    }

    /**
     * Get hafalan data for editing (AJAX)
     */
    public function edit($id)
    {
        $hafalan = \App\Models\Hafalan::with('santri')->find($id);

        if (!$hafalan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Convert grade back to numeric rating
        $gradeMap = ['Tidak Lancar' => 1, 'Kurang Lancar' => 2, 'Lancar' => 3, 'Sangat Lancar' => 4, 'Sempurna' => 5];
        $nilai = $gradeMap[$hafalan->nilai] ?? 3;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $hafalan->id,
                'surah' => $hafalan->surah,
                'ayat_awal' => $hafalan->ayat_awal,
                'ayat_akhir' => $hafalan->ayat_akhir,
                'nilai' => $nilai,
                'catatan' => $hafalan->catatan,
                'santri_name' => optional($hafalan->santri)->name ?? 'Santri (Terhapus)',
            ]
        ]);
    }

    /**
     * Update hafalan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ayat_awal' => 'required|integer|min:1',
            'ayat_akhir' => 'required|integer|min:1|gte:ayat_awal',
            'nilai' => 'required|integer|min:1|max:5',
            'catatan' => 'nullable|string|max:500',
        ]);

        $hafalan = \App\Models\Hafalan::find($id);

        if (!$hafalan) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        // Validate ayat_akhir does not exceed surah total ayat
        $surahList = $this->getSurahList();
        $searchName = strtolower(str_replace(["'", "'", "`", "-"], "", $hafalan->surah));
        $surahData = $surahList->first(function($surah) use ($searchName) {
            $listName = strtolower(str_replace(["'", "'", "`", "-"], "", $surah['name']));
            return $listName === $searchName || str_contains($listName, $searchName) || str_contains($searchName, $listName);
        });

        if ($surahData && $request->ayat_akhir > $surahData['ayat']) {
            return back()
                ->withInput()
                ->with('error', "Ayat akhir tidak boleh melebihi {$surahData['ayat']} (total ayat {$hafalan->surah})");
        }

        // Convert star rating to grade
        $grades = [1 => 'Tidak Lancar', 2 => 'Kurang Lancar', 3 => 'Lancar', 4 => 'Sangat Lancar', 5 => 'Sempurna'];
        $grade = $grades[$request->nilai] ?? 'Lancar';

        try {
            $hafalan->update([
                'ayat_awal' => $request->ayat_awal,
                'ayat_akhir' => $request->ayat_akhir,
                'nilai' => $grade,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('ustadz.hafalan.index')
                ->with('success', 'Setoran berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }


    /**
     * Get list of surah
     */
    protected function getSurahList()
    {
        return collect([
            // Juz 1-3
            ['number' => 1, 'name' => 'Al-Fatihah', 'ayat' => 7],
            ['number' => 2, 'name' => 'Al-Baqarah', 'ayat' => 286],
            ['number' => 3, 'name' => 'Ali Imran', 'ayat' => 200],
            ['number' => 4, 'name' => 'An-Nisa', 'ayat' => 176],
            ['number' => 5, 'name' => 'Al-Maidah', 'ayat' => 120],
            ['number' => 6, 'name' => 'Al-Anam', 'ayat' => 165],
            ['number' => 7, 'name' => 'Al-Araf', 'ayat' => 206],
            ['number' => 8, 'name' => 'Al-Anfal', 'ayat' => 75],
            ['number' => 9, 'name' => 'At-Taubah', 'ayat' => 129],
            ['number' => 10, 'name' => 'Yunus', 'ayat' => 109],
            ['number' => 11, 'name' => 'Hud', 'ayat' => 123],
            ['number' => 12, 'name' => 'Yusuf', 'ayat' => 111],
            ['number' => 13, 'name' => 'Ar-Rad', 'ayat' => 43],
            ['number' => 14, 'name' => 'Ibrahim', 'ayat' => 52],
            ['number' => 15, 'name' => 'Al-Hijr', 'ayat' => 99],
            ['number' => 16, 'name' => 'An-Nahl', 'ayat' => 128],
            ['number' => 17, 'name' => 'Al-Isra', 'ayat' => 111],
            ['number' => 18, 'name' => 'Al-Kahf', 'ayat' => 110],
            ['number' => 19, 'name' => 'Maryam', 'ayat' => 98],
            ['number' => 20, 'name' => 'Ta Ha', 'ayat' => 135],
            ['number' => 21, 'name' => 'Al-Anbiya', 'ayat' => 112],
            ['number' => 22, 'name' => 'Al-Hajj', 'ayat' => 78],
            ['number' => 23, 'name' => 'Al-Muminun', 'ayat' => 118],
            ['number' => 24, 'name' => 'An-Nur', 'ayat' => 64],
            ['number' => 25, 'name' => 'Al-Furqan', 'ayat' => 77],
            ['number' => 26, 'name' => 'Asy-Syuara', 'ayat' => 227],
            ['number' => 27, 'name' => 'An-Naml', 'ayat' => 93],
            ['number' => 28, 'name' => 'Al-Qasas', 'ayat' => 88],
            ['number' => 29, 'name' => 'Al-Ankabut', 'ayat' => 69],
            ['number' => 30, 'name' => 'Ar-Rum', 'ayat' => 60],
            ['number' => 31, 'name' => 'Luqman', 'ayat' => 34],
            ['number' => 32, 'name' => 'As-Sajdah', 'ayat' => 30],
            ['number' => 33, 'name' => 'Al-Ahzab', 'ayat' => 73],
            ['number' => 34, 'name' => 'Saba', 'ayat' => 54],
            ['number' => 35, 'name' => 'Fatir', 'ayat' => 45],
            ['number' => 36, 'name' => 'Yasin', 'ayat' => 83],
            ['number' => 37, 'name' => 'As-Saffat', 'ayat' => 182],
            ['number' => 38, 'name' => 'Sad', 'ayat' => 88],
            ['number' => 39, 'name' => 'Az-Zumar', 'ayat' => 75],
            ['number' => 40, 'name' => 'Ghafir', 'ayat' => 85],
            ['number' => 41, 'name' => 'Fussilat', 'ayat' => 54],
            ['number' => 42, 'name' => 'Asy-Syura', 'ayat' => 53],
            ['number' => 43, 'name' => 'Az-Zukhruf', 'ayat' => 89],
            ['number' => 44, 'name' => 'Ad-Dukhan', 'ayat' => 59],
            ['number' => 45, 'name' => 'Al-Jasiyah', 'ayat' => 37],
            ['number' => 46, 'name' => 'Al-Ahqaf', 'ayat' => 35],
            ['number' => 47, 'name' => 'Muhammad', 'ayat' => 38],
            ['number' => 48, 'name' => 'Al-Fath', 'ayat' => 29],
            ['number' => 49, 'name' => 'Al-Hujurat', 'ayat' => 18],
            ['number' => 50, 'name' => 'Qaf', 'ayat' => 45],
            ['number' => 51, 'name' => 'Az-Zariyat', 'ayat' => 60],
            ['number' => 52, 'name' => 'At-Tur', 'ayat' => 49],
            ['number' => 53, 'name' => 'An-Najm', 'ayat' => 62],
            ['number' => 54, 'name' => 'Al-Qamar', 'ayat' => 55],
            ['number' => 55, 'name' => 'Ar-Rahman', 'ayat' => 78],
            ['number' => 56, 'name' => 'Al-Waqiah', 'ayat' => 96],
            ['number' => 57, 'name' => 'Al-Hadid', 'ayat' => 29],
            ['number' => 58, 'name' => 'Al-Mujadilah', 'ayat' => 22],
            ['number' => 59, 'name' => 'Al-Hasyr', 'ayat' => 24],
            ['number' => 60, 'name' => 'Al-Mumtahanah', 'ayat' => 13],
            ['number' => 61, 'name' => 'As-Saff', 'ayat' => 14],
            ['number' => 62, 'name' => 'Al-Jumuah', 'ayat' => 11],
            ['number' => 63, 'name' => 'Al-Munafiqun', 'ayat' => 11],
            ['number' => 64, 'name' => 'At-Tagabun', 'ayat' => 18],
            ['number' => 65, 'name' => 'At-Talaq', 'ayat' => 12],
            ['number' => 66, 'name' => 'At-Tahrim', 'ayat' => 12],
            ['number' => 67, 'name' => 'Al-Mulk', 'ayat' => 30],
            ['number' => 68, 'name' => 'Al-Qalam', 'ayat' => 52],
            ['number' => 69, 'name' => 'Al-Haqqah', 'ayat' => 52],
            ['number' => 70, 'name' => 'Al-Maarij', 'ayat' => 44],
            ['number' => 71, 'name' => 'Nuh', 'ayat' => 28],
            ['number' => 72, 'name' => 'Al-Jinn', 'ayat' => 28],
            ['number' => 73, 'name' => 'Al-Muzzammil', 'ayat' => 20],
            ['number' => 74, 'name' => 'Al-Muddassir', 'ayat' => 56],
            ['number' => 75, 'name' => 'Al-Qiyamah', 'ayat' => 40],
            ['number' => 76, 'name' => 'Al-Insan', 'ayat' => 31],
            ['number' => 77, 'name' => 'Al-Mursalat', 'ayat' => 50],
            // Juz 30
            ['number' => 78, 'name' => 'An-Naba', 'ayat' => 40],
            ['number' => 79, 'name' => 'An-Naziat', 'ayat' => 46],
            ['number' => 80, 'name' => 'Abasa', 'ayat' => 42],
            ['number' => 81, 'name' => 'At-Takwir', 'ayat' => 29],
            ['number' => 82, 'name' => 'Al-Infitar', 'ayat' => 19],
            ['number' => 83, 'name' => 'Al-Mutaffifin', 'ayat' => 36],
            ['number' => 84, 'name' => 'Al-Insyiqaq', 'ayat' => 25],
            ['number' => 85, 'name' => 'Al-Buruj', 'ayat' => 22],
            ['number' => 86, 'name' => 'At-Tariq', 'ayat' => 17],
            ['number' => 87, 'name' => 'Al-Ala', 'ayat' => 19],
            ['number' => 88, 'name' => 'Al-Ghasyiyah', 'ayat' => 26],
            ['number' => 89, 'name' => 'Al-Fajr', 'ayat' => 30],
            ['number' => 90, 'name' => 'Al-Balad', 'ayat' => 20],
            ['number' => 91, 'name' => 'Asy-Syams', 'ayat' => 15],
            ['number' => 92, 'name' => 'Al-Lail', 'ayat' => 21],
            ['number' => 93, 'name' => 'Ad-Duha', 'ayat' => 11],
            ['number' => 94, 'name' => 'Asy-Syarh', 'ayat' => 8],
            ['number' => 95, 'name' => 'At-Tin', 'ayat' => 8],
            ['number' => 96, 'name' => 'Al-Alaq', 'ayat' => 19],
            ['number' => 97, 'name' => 'Al-Qadr', 'ayat' => 5],
            ['number' => 98, 'name' => 'Al-Bayyinah', 'ayat' => 8],
            ['number' => 99, 'name' => 'Az-Zalzalah', 'ayat' => 8],
            ['number' => 100, 'name' => 'Al-Adiyat', 'ayat' => 11],
            ['number' => 101, 'name' => 'Al-Qariah', 'ayat' => 11],
            ['number' => 102, 'name' => 'At-Takasur', 'ayat' => 8],
            ['number' => 103, 'name' => 'Al-Asr', 'ayat' => 3],
            ['number' => 104, 'name' => 'Al-Humazah', 'ayat' => 9],
            ['number' => 105, 'name' => 'Al-Fil', 'ayat' => 5],
            ['number' => 106, 'name' => 'Quraisy', 'ayat' => 4],
            ['number' => 107, 'name' => 'Al-Maun', 'ayat' => 7],
            ['number' => 108, 'name' => 'Al-Kautsar', 'ayat' => 3],
            ['number' => 109, 'name' => 'Al-Kafirun', 'ayat' => 6],
            ['number' => 110, 'name' => 'An-Nasr', 'ayat' => 3],
            ['number' => 111, 'name' => 'Al-Lahab', 'ayat' => 5],
            ['number' => 112, 'name' => 'Al-Ikhlas', 'ayat' => 4],
            ['number' => 113, 'name' => 'Al-Falaq', 'ayat' => 5],
            ['number' => 114, 'name' => 'An-Nas', 'ayat' => 6],
        ]);
    }

    /**
     * Get last hafalan for a santri (for auto-fill)
     */
    public function getLastHafalan($santriId)
    {
        $lastHafalan = \App\Models\Hafalan::where('santri_id', $santriId)
            ->orderBy('created_at', 'desc')
            ->first();

        try {
            if ($lastHafalan) {
                // Find total ayat for this surah
                $surahList = $this->getSurahList();
                // Ensure case-insensitive or trimmed comparison if needed, currently exact match
                $surahData = $surahList->firstWhere('name', $lastHafalan->surah);
                $totalAyat = $surahData ? $surahData['ayat'] : 1; // Avoid div by zero, default to 1 if unknown

                $percent = 0;
                if ($totalAyat > 0) {
                     $percent = round(($lastHafalan->ayat_akhir / $totalAyat) * 100);
                }

                return response()->json([
                    'success' => true,
                    'data' => [
                        'surah' => $lastHafalan->surah,
                        'ayat_mulai' => $lastHafalan->ayat_akhir + 1, // Continue from last ayat
                        'ayat_akhir' => $lastHafalan->ayat_akhir,
                        'total_ayat' => $totalAyat,
                        'progress_percent' => $percent,
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'No history found'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display Laporan Hafalan - Progress of all santri
     */
    public function laporan(Request $request)
    {
        // Get all santri (FILTER BY NIP USTADZ)
        $user = session('user');
        $querySantri = \App\Models\User::where('role', 'SANTRI');

        if (isset($user['role']) && $user['role'] === 'USTADZ' && !empty($user['nip'])) {
            $querySantri->where('pembimbing_nip', $user['nip']);
        }

        $santriList = $querySantri->select('id', 'name')
            ->orderBy('name')
            ->get();

        // Calculate stats for each santri
        $target = 1000; // Target ayat per santri
        $santriStats = [];

        foreach ($santriList as $santri) {
            $hafalan = \App\Models\Hafalan::where('santri_id', $santri->id)->get();

            // Last activity and last surah
            $lastHafalan = $hafalan->sortByDesc('created_at')->first();
            $lastActivity = $lastHafalan ? \Carbon\Carbon::parse($lastHafalan->created_at)->diffForHumans() : '-';
            $lastSurah = $lastHafalan ? $lastHafalan->surah : '-';

            // Total Ayat from LAST SURAH only (not all surahs)
            $hafalanLastSurah = $lastHafalan
                ? $hafalan->where('surah', $lastHafalan->surah)
                : collect([]);
            $totalAyat = $hafalanLastSurah->sum(function ($h) {
                return max(0, $h->ayat_akhir - $h->ayat_awal + 1);
            });

            // Get total ayat of the last surah
            $surahList = $this->getSurahList();
            $surahData = null;
            if ($lastHafalan) {
                // Normalize surah name for matching (remove apostrophes, extra spaces)
                $searchName = strtolower(str_replace(["'", "'", "`", "-"], "", $lastHafalan->surah));
                $surahData = $surahList->first(function($surah) use ($searchName) {
                    $listName = strtolower(str_replace(["'", "'", "`", "-"], "", $surah['name']));
                    return $listName === $searchName || str_contains($listName, $searchName) || str_contains($searchName, $listName);
                });
            }
            $totalAyatSurah = $surahData ? $surahData['ayat'] : 0;

            // Status
            $statusLabel = "Menunggu";
            $statusColor = "gray";
            if ($lastHafalan) {
                $daysSince = \Carbon\Carbon::parse($lastHafalan->created_at)->diffInDays(now());
                if ($daysSince <= 3) {
                    $statusLabel = "Sangat Aktif";
                    $statusColor = "green";
                } elseif ($daysSince <= 14) {
                    $statusLabel = "Aktif";
                    $statusColor = "blue";
                } else {
                    $statusLabel = "Perlu Perhatian";
                    $statusColor = "orange";
                }
            }

            // Calculate duration
            $firstHafalan = $hafalan->sortBy('tanggal')->first();
            $durasi = '-';
            $firstDate = null;
            if ($firstHafalan && $firstHafalan->tanggal) {
                $firstDate = \Carbon\Carbon::parse($firstHafalan->tanggal);
                $lastDate = $lastHafalan && $lastHafalan->tanggal
                    ? \Carbon\Carbon::parse($lastHafalan->tanggal)
                    : now();

                $diffDays = $firstDate->diffInDays($lastDate);
                $diffWeeks = $firstDate->diffInWeeks($lastDate);
                $diffMonths = $firstDate->diffInMonths($lastDate);
                $diffYears = $firstDate->diffInYears($lastDate);

                if ($diffYears >= 1) {
                    $remainingMonths = $diffMonths % 12;
                    $durasi = $diffYears . ' tahun' . ($remainingMonths > 0 ? ' ' . $remainingMonths . ' bulan' : '');
                } elseif ($diffMonths >= 1) {
                    $remainingWeeks = floor(($diffDays % 30) / 7);
                    $durasi = $diffMonths . ' bulan' . ($remainingWeeks > 0 ? ' ' . $remainingWeeks . ' minggu' : '');
                } elseif ($diffWeeks >= 1) {
                    $remainingDays = $diffDays % 7;
                    $durasi = $diffWeeks . ' minggu' . ($remainingDays > 0 ? ' ' . $remainingDays . ' hari' : '');
                } else {
                    $durasi = max(1, $diffDays) . ' hari';
                }
            }

            // Count pertemuan based on KehadiranSantri (attendance at scheduled sessions)
            $kehadiranCount = \App\Models\KehadiranSantri::where('santri_id', $santri->id)
                ->where('status', 'hadir')
                ->count();

            // Count unique surahs
            $totalSurah = $hafalan->pluck('surah')->unique()->count();

            // Calculate progress per surah
            $surahProgress = [];
            $uniqueSurahs = $hafalan->pluck('surah')->unique();
            foreach ($uniqueSurahs as $surahName) {
                // Get hafalan for this surah
                $hafalanThisSurah = $hafalan->where('surah', $surahName);
                $ayatHafal = $hafalanThisSurah->sum(function ($h) {
                    return max(0, $h->ayat_akhir - $h->ayat_awal + 1);
                });

                // Find total ayat for this surah
                $searchName = strtolower(str_replace(["'", "'", "`", "-"], "", $surahName));
                $surahInfo = $surahList->first(function($s) use ($searchName) {
                    $listName = strtolower(str_replace(["'", "'", "`", "-"], "", $s['name']));
                    return $listName === $searchName || str_contains($listName, $searchName) || str_contains($searchName, $listName);
                });
                $ayatTotal = $surahInfo ? $surahInfo['ayat'] : $ayatHafal;

                $percent = $ayatTotal > 0 ? round(($ayatHafal / $ayatTotal) * 100) : 0;

                $surahProgress[] = [
                    'name' => $surahName,
                    'hafal' => $ayatHafal,
                    'total' => $ayatTotal,
                    'percent' => min(100, $percent),
                ];
            }

            $santriStats[] = [
                'id' => $santri->id,
                'name' => $santri->name,
                'total_ayat' => $totalAyat,
                'total_surah' => $totalSurah,
                'total_ayat_surah' => $totalAyatSurah,
                'surah_progress' => $surahProgress,
                'percent' => min(100, round(($totalAyat / $target) * 100)),
                'target' => $target,
                'remaining' => max(0, $target - $totalAyat),
                'last_activity' => $lastActivity,
                'last_surah' => $lastSurah,
                'status_label' => $statusLabel,
                'status_color' => $statusColor,
                'total_setoran' => $hafalan->count(),
                'total_pertemuan' => $kehadiranCount > 0
                    ? $kehadiranCount
                    : $hafalan->pluck('created_at')->map(fn($d) => $d->format('Y-m-d'))->unique()->count(),
                'first_date' => $firstDate ? $firstDate->format('d M Y') : '-',
                'first_date_raw' => $firstDate ? $firstDate->format('Y-m-d') : null, // For live counter
                'durasi' => $durasi,
            ];
        }

        // Summary stats
        $totalSantri = count($santriList);
        $totalSetoran = array_sum(array_column($santriStats, 'total_setoran'));
        $totalAyatAll = array_sum(array_column($santriStats, 'total_ayat'));
        $avgPercent = $totalSantri > 0 ? round(array_sum(array_column($santriStats, 'percent')) / $totalSantri) : 0;

        $summary = [
            'total_santri' => $totalSantri,
            'total_setoran' => $totalSetoran,
            'total_ayat' => $totalAyatAll,
            'avg_percent' => $avgPercent,
        ];

        return view('ustadz.hafalan.laporan', compact('santriStats', 'summary'));
    }
}
