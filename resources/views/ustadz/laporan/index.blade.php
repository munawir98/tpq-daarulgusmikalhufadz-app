<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Pusat Data TPQ</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Lexend', sans-serif;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-100 min-h-screen">
    <div
        class="relative flex min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden">
        <header
            class="flex items-center bg-white dark:bg-slate-900 p-4 pb-3 justify-between sticky top-0 z-50 border-b border-slate-200 dark:border-slate-800">
            <div class="flex size-12 shrink-0 items-center">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary"
                    data-alt="TPQ Daarul Gusmik Al-Hufadz official logo"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDLiUnszySqLqDtMxZbO3260Gh_fnaUn8e_IyoKnxM1wBbldnUVfayRq7VuHekfzv1MKhs_RwubG6kLRLTKoBNTVDPkCmwCvgQUAJ5jI5aLibJmtn7r4YBHAIQzVmkGMM2gmMIvLDj6z2tqIMNSRFBKQyL0t1XDBpM0OT_naryDdfJumlFTvbEENEoSRZ67k8ex1uoY5gCDomdH9RHXQsYOsXPPsvKC2tVSPV9HTBqzGNk3zBk8JsRk581XTVmMX-NG6T-WhSOaRxMZ");'>
                </div>
            </div>
            <div class="flex flex-col items-center flex-1 text-center">
                <h1 class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight tracking-tight">Pusat Data
                    &amp;
                    Statistik TPQ</h1>
            </div>
            <div class="flex w-12 items-center justify-end">
                <a href="{{ route('ustadz.notifications.index') }}"
                    class="flex cursor-pointer items-center justify-center rounded-full h-10 w-10 bg-slate-100 dark:bg-slate-800 text-[#0e141b] dark:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-[24px]">notifications</span>
                </a>
            </div>
        </header>
        @php
        function formatMoneyShort($amount) {
        if ($amount >= 1000000000) return 'Rp ' . round($amount / 1000000000, 1) . 'M';
        if ($amount >= 1000000) return 'Rp ' . round($amount / 1000000, 1) . 'Jt';
        if ($amount >= 1000) return 'Rp ' . round($amount / 1000, 1) . 'Rb';
        return 'Rp ' . number_format($amount, 0, ',', '.');
        }
        @endphp
        <div class="flex flex-wrap gap-3 p-4">
            <a href="{{ route('ustadz.santri.index') }}"
                class="flex min-w-[150px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all active:scale-95 cursor-pointer">
                <div class="flex items-center justify-between">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Santri</p>
                    <span class="material-symbols-outlined text-primary text-xl">groups</span>
                </div>
                <p class="text-[#0e141b] dark:text-white tracking-tight text-2xl font-bold">{{ $totalSantri }}</p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[#078838] text-sm">trending_up</span>
                    <p class="text-[#078838] text-xs font-semibold">+{{ $persenSantri }}% bln ini</p>
                </div>
            </a>
            <div
                class="flex min-w-[150px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Ustadz</p>
                    <span class="material-symbols-outlined text-primary text-xl">person_book</span>
                </div>
                <p class="text-[#0e141b] dark:text-white tracking-tight text-2xl font-bold">{{ $totalUstadz }}</p>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-slate-400 text-sm">remove</span>
                    <p class="text-slate-500 text-xs font-semibold">Stabil</p>
                </div>
            </div>
            <a href="{{ route('presensi.index') }}"
                class="flex min-w-[150px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all active:scale-95 cursor-pointer">
                <div class="flex items-center justify-between">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Kehadiran Hari Ini</p>
                    <span class="material-symbols-outlined text-primary text-xl">event_available</span>
                </div>
                <p class="text-[#0e141b] dark:text-white tracking-tight text-2xl font-bold">{{ $persenKehadiran }}%</p>
                <div class="flex items-center gap-1">
                    @if($trendKehadiran >= 0)
                    <span class="material-symbols-outlined text-[#078838] text-sm">trending_up</span>
                    <p class="text-[#078838] text-xs font-semibold">+{{ $trendKehadiran }}% vs kemarin</p>
                    @else
                    <span class="material-symbols-outlined text-[#e73908] text-sm">trending_down</span>
                    <p class="text-[#e73908] text-xs font-semibold">{{ $trendKehadiran }}% vs kemarin</p>
                    @endif
                </div>
            </a>
            <a href="{{ route('ustadz.laporan.keuangan') }}"
                class="flex min-w-[150px] flex-1 flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all active:scale-95 cursor-pointer">
                <div class="flex items-center justify-between">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Kas TPQ</p>
                    <span class="material-symbols-outlined text-primary text-xl">account_balance_wallet</span>
                </div>
                <p class="text-[#0e141b] dark:text-white tracking-tight text-xl font-bold">{{
                    formatMoneyShort($totalKas) }}</p>
                <div class="flex items-center gap-1">
                    @if($trendKas >= 0)
                    <span class="material-symbols-outlined text-[#078838] text-sm">trending_up</span>
                    <p class="text-[#078838] text-xs font-semibold">+{{ $trendKas }}% bln ini</p>
                    @else
                    <span class="material-symbols-outlined text-[#e73908] text-sm">trending_down</span>
                    <p class="text-[#e73908] text-xs font-semibold">{{ $trendKas }}% bln ini</p>
                    @endif
                </div>
            </a>
        </div>
        <div class="px-4 pt-4 pb-2">
            <h2 class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Laporan
                &amp; Sub-Menu</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Kelola data akademik dan finansial</p>
        </div>
        <div class="grid grid-cols-2 gap-3 p-4 pt-2">
            <!-- Kehadiran Santri -->
            <a href="{{ route('presensi.index') }}"
                class="relative bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 flex flex-col gap-3 rounded-xl p-4 overflow-hidden shadow-sm hover:shadow-md transition-all active:scale-95">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                    </div>
                </div>
                <p class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight">Kehadiran Santri</p>
                <div class="flex items-end gap-1 h-8">
                    <div class="w-2 bg-primary/20 h-4 rounded-t-sm"></div>
                    <div class="w-2 bg-primary/40 h-6 rounded-t-sm"></div>
                    <div class="w-2 bg-primary h-8 rounded-t-sm"></div>
                    <div class="w-2 bg-primary/60 h-5 rounded-t-sm"></div>
                    <div class="w-2 bg-primary/30 h-3 rounded-t-sm"></div>
                </div>
            </a>

            <!-- Setoran Hafalan -->
            <a href="{{ route('ustadz.hafalan.laporan') }}"
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 flex flex-col gap-3 rounded-xl p-4 shadow-sm hover:shadow-md transition-all active:scale-95">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg">
                        <span class="material-symbols-outlined text-emerald-600">auto_stories</span>
                    </div>
                </div>
                <p class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight">Setoran Hafalan</p>
                <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full mt-2">
                    <div class="bg-emerald-500 h-1.5 rounded-full w-3/4"></div>
                </div>
                <p class="text-[10px] text-slate-400 font-medium">Target: Juz 30 (75%)</p>
            </a>

            <!-- Penilaian & Rapor -->
            <a href="{{ route('ustadz.nilai.index') }}"
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 flex flex-col gap-3 rounded-xl p-4 shadow-sm hover:shadow-md transition-all active:scale-95">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-amber-50 dark:bg-amber-900/30 rounded-lg">
                        <span class="material-symbols-outlined text-amber-500">grade</span>
                    </div>
                </div>
                <p class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight">Penilaian &amp; Rapor</p>
                <div class="flex gap-0.5 mt-2">
                    <span class="material-symbols-outlined text-amber-400 text-[14px] fill-amber-400">star</span>
                    <span class="material-symbols-outlined text-amber-400 text-[14px] fill-amber-400">star</span>
                    <span class="material-symbols-outlined text-amber-400 text-[14px] fill-amber-400">star</span>
                    <span class="material-symbols-outlined text-amber-400 text-[14px] fill-amber-400">star</span>
                    <span class="material-symbols-outlined text-slate-300 text-[14px]">star</span>
                </div>
            </a>

            <!-- Laporan Keuangan -->
            <a href="{{ route('ustadz.laporan.keuangan') }}"
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 flex flex-col gap-3 rounded-xl p-4 shadow-sm hover:shadow-md transition-all active:scale-95">
                <div class="flex items-center justify-between">
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                        <span class="material-symbols-outlined text-indigo-600">payments</span>
                    </div>
                </div>
                <p class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight">Laporan Keuangan</p>
                <p class="text-[10px] text-slate-400 font-medium mt-2">Update: Hari ini</p>
            </a>

            <!-- Jurnal & Kegiatan -->
            <a href="{{ route('ustadz.laporan.kegiatan') }}"
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 flex flex-col gap-3 rounded-xl p-4 shadow-sm col-span-2 hover:shadow-md transition-all active:scale-95">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-rose-50 dark:bg-rose-900/30 rounded-lg">
                        <span class="material-symbols-outlined text-rose-500">event_note</span>
                    </div>
                    <div>
                        <p class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight">Jurnal &amp; Kegiatan
                        </p>
                        <p class="text-xs text-slate-400">12 Agenda pekan ini</p>
                    </div>
                    <div class="ml-auto">
                        <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    </div>
                </div>
            </a>
        </div>
        <div class="px-4 pb-3 pt-4">
            <h2 class="text-[#0e141b] dark:text-white text-[20px] font-bold leading-tight tracking-[-0.015em]">Quick
                Insights</h2>
        </div>
        <div class="px-4 pb-12">
            <div
                class="bg-gradient-to-br from-primary to-blue-700 rounded-xl p-4 text-white shadow-lg shadow-primary/20">
                <div class="flex items-start justify-between">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-yellow-300">emoji_events</span>
                            <p class="text-sm font-medium opacity-90">Capaian Pekan Ini</p>
                        </div>
                        <h3 class="text-lg font-bold mt-2 leading-tight">Kelas Tahfidz B</h3>
                        <p class="text-xs opacity-80 mt-1">Kehadiran Tertinggi (98.4%) dengan rata-rata setoran 3
                            halaman/santri.</p>
                    </div>
                    <div class="bg-white/20 p-2 rounded-lg">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/20 flex justify-between items-center">
                    <span class="text-[10px] font-medium tracking-wider uppercase">Highlight Admin</span>
                    <button class="text-xs font-bold px-3 py-1 bg-white text-primary rounded-full">Lihat Detail</button>
                </div>
            </div>
        </div>
        <div class="h-8"></div>
    </div>

</body>

</html>
