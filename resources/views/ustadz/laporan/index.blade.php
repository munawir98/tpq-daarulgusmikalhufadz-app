<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Pusat Data TPQ</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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
                        "display": ["Poppins", "sans-serif"]
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
            font-family: 'Poppins', sans-serif;
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
            class="flex items-center bg-primary dark:bg-slate-900 h-14 px-4 sticky top-0 z-50 border-b border-primary dark:border-slate-800 shadow-sm">
            <div class="w-full flex items-center justify-center relative">
                <h1 class="text-white dark:text-white text-base font-bold leading-tight tracking-tight text-center">
                    Pusat Data &amp; Statistik</h1>
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
            <!-- Card 1: Total Santri (Cyan/Blue) -->
            <!-- Card 1: Total Santri (Cyan/Blue) -->
            <a href="{{ route('ustadz.santri.index') }}"
                class="relative flex min-w-[120px] flex-1 flex-col gap-1 rounded-2xl p-3 bg-cyan-500 shadow-lg shadow-cyan-500/20 overflow-hidden group hover:shadow-md transition-all">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[16px]">groups</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-white text-[10px]">trending_up</span>
                            <p class="text-white text-[9px] font-bold">+{{ $persenSantri }}%</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-[9px] font-bold uppercase tracking-wider">Total
                        Santri</p>
                    <p class="text-white text-lg font-extrabold tracking-tight mt-0.5">{{
                        $totalSantri }}</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-2 -bottom-2 text-white/10 text-5xl pointer-events-none">groups</span>
            </a>

            <!-- Card 2: Total Ustadz (Emerald) -->
            <div
                class="relative flex min-w-[120px] flex-1 flex-col gap-1 rounded-2xl p-3 bg-emerald-500 shadow-lg shadow-emerald-500/20 overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[16px]">person_book</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-white text-[10px]">remove</span>
                            <p class="text-white text-[9px] font-bold">Stabil</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-[9px] font-bold uppercase tracking-wider">Total
                        Ustadz</p>
                    <p class="text-white text-lg font-extrabold tracking-tight mt-0.5">{{
                        $totalUstadz }}</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-2 -bottom-2 text-white/10 text-5xl pointer-events-none">person_book</span>
            </div>

            <!-- Card 3: Kehadiran (Amber/Orange) -->
            <!-- Card 3: Kehadiran (Amber/Orange) -->
            <a href="{{ route('presensi.index') }}"
                class="relative flex min-w-[120px] flex-1 flex-col gap-1 rounded-2xl p-3 bg-amber-500 shadow-lg shadow-amber-500/20 overflow-hidden group hover:shadow-md transition-all">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[16px]">event_available</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @if($trendKehadiran >= 0)
                            <span class="material-symbols-outlined text-white text-[10px]">trending_up</span>
                            <p class="text-white text-[9px] font-bold">+{{ $trendKehadiran }}%</p>
                            @else
                            <span class="material-symbols-outlined text-white text-[10px]">trending_down</span>
                            <p class="text-white text-[9px] font-bold">{{ $trendKehadiran }}%</p>
                            @endif
                        </div>
                    </div>
                    <p class="text-white/80 text-[9px] font-bold uppercase tracking-wider">Hadir
                        Hari Ini</p>
                    <p class="text-white text-lg font-extrabold tracking-tight mt-0.5">{{
                        $persenKehadiran }}%</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-2 -bottom-2 text-white/10 text-5xl pointer-events-none">event_available</span>
            </a>

            <!-- Card 4: Kas TPQ (Indigo) -->
            <!-- Card 4: Kas TPQ (Indigo) -->
            <a href="{{ route('ustadz.laporan.keuangan') }}"
                class="relative flex min-w-[120px] flex-1 flex-col gap-1 rounded-2xl p-3 bg-indigo-600 shadow-lg shadow-indigo-600/20 overflow-hidden group hover:shadow-md transition-all">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[16px]">account_balance_wallet</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @if($trendKas >= 0)
                            <span class="material-symbols-outlined text-white text-[10px]">trending_up</span>
                            <p class="text-white text-[9px] font-bold">+{{ $trendKas }}%</p>
                            @else
                            <span class="material-symbols-outlined text-white text-[10px]">trending_down</span>
                            <p class="text-white text-[9px] font-bold">{{ $trendKas }}%</p>
                            @endif
                        </div>
                    </div>
                    <p class="text-white/80 text-[9px] font-bold uppercase tracking-wider">Kas TPQ
                    </p>
                    <p class="text-white text-lg font-extrabold tracking-tight mt-0.5">{{
                        formatMoneyShort($totalKas) }}</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-2 -bottom-2 text-white/10 text-5xl pointer-events-none">account_balance_wallet</span>
            </a>
        </div>
        <div class="px-4 pt-2 pb-1 text-center">
            <h2 class="text-base font-bold text-slate-700 dark:text-white leading-tight">Laporan &amp; Sub-Menu</h2>
            <p class="text-slate-500 dark:text-slate-400 text-[10px]">Kelola data akademik dan finansial</p>
        </div>
        @push('styles')
        <style>
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-5px);
                }
            }

            .card-anim {
                opacity: 0;
                /* Hidden initially */
                animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            .icon-float:hover .material-symbols-outlined {
                animation: float 2s ease-in-out infinite;
            }
        </style>
        @endpush

        <div class="grid grid-cols-2 gap-2 p-3 pt-2">
            <!-- Kehadiran Santri (Primary/Blue) -->
            <a href="{{ route('presensi.index') }}"
                class="card-anim relative bg-white dark:bg-slate-800 flex flex-col gap-2 rounded-2xl p-3 overflow-hidden shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 group icon-float"
                style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between z-10 relative">
                    <div
                        class="p-1.5 bg-blue-50 dark:bg-blue-900/20 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <span
                            class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">analytics</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-slate-700 dark:text-slate-200 text-xs font-bold leading-tight">Kehadiran Santri</p>
                    <p class="text-slate-500 dark:text-slate-400 text-[9px] font-medium mt-0.5">Laporan Presensi</p>
                </div>
            </a>

            <!-- Setoran Hafalan (Emerald) -->
            <a href="{{ route('ustadz.hafalan.laporan') }}"
                class="card-anim relative bg-white dark:bg-slate-800 flex flex-col gap-2 rounded-2xl p-3 shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 overflow-hidden group icon-float"
                style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between z-10 relative">
                    <div
                        class="p-1.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <span
                            class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-xl">auto_stories</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-slate-700 dark:text-slate-200 text-xs font-bold leading-tight">Setoran Hafalan</p>
                    <div class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full mt-1.5">
                        <div class="bg-emerald-500 h-1.5 rounded-full w-3/4"></div>
                    </div>
                    <p class="text-[9px] text-slate-500 dark:text-slate-400 font-medium mt-0.5">Target: Juz 30 (75%)</p>
                </div>
            </a>

            <!-- Penilaian & Rapor (Amber/Orange) -->
            <!-- Penilaian & Rapor (Amber/Orange) -->
            <a href="{{ route('ustadz.nilai.index') }}"
                class="card-anim relative bg-white dark:bg-slate-800 flex flex-col gap-2 rounded-2xl p-3 shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 overflow-hidden group icon-float"
                style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between z-10 relative">
                    <div
                        class="p-1.5 bg-amber-50 dark:bg-amber-900/20 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-xl">grade</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-slate-700 dark:text-slate-200 text-xs font-bold leading-tight">Penilaian &amp; Rapor
                    </p>
                    <div class="flex gap-0.5 mt-1.5">
                        <span class="material-symbols-outlined text-amber-400 text-[12px] fill-amber-400">star</span>
                        <span class="material-symbols-outlined text-amber-400 text-[12px] fill-amber-400">star</span>
                        <span class="material-symbols-outlined text-amber-400 text-[12px] fill-amber-400">star</span>
                        <span class="material-symbols-outlined text-amber-400 text-[12px] fill-amber-400">star</span>
                        <span
                            class="material-symbols-outlined text-slate-200 dark:text-slate-600 text-[12px]">star</span>
                    </div>
                </div>
            </a>

            <!-- Laporan Keuangan (Topaz/Indigo) -->
            <!-- Laporan Keuangan (Topaz/Indigo) -->
            <a href="{{ route('ustadz.laporan.keuangan') }}"
                class="card-anim relative bg-white dark:bg-slate-800 flex flex-col gap-2 rounded-2xl p-3 shadow-sm border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all active:scale-95 overflow-hidden group icon-float"
                style="animation-delay: 0.4s;">
                <div class="flex items-center justify-between z-10 relative">
                    <div
                        class="p-1.5 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg group-hover:scale-110 transition-transform duration-300">
                        <span
                            class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-xl">payments</span>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-slate-700 dark:text-slate-200 text-xs font-bold leading-tight">Laporan Keuangan</p>
                    <p class="text-[9px] text-slate-500 dark:text-slate-400 font-medium mt-1.5">Update: Hari ini</p>
                </div>
            </a>

            <!-- Jurnal & Kegiatan (Rose) -->
            <!-- Jurnal & Kegiatan (Rose) -->
            <a href="{{ route('ustadz.laporan.kegiatan') }}"
                class="card-anim relative col-span-2 bg-rose-500 flex flex-col gap-2 rounded-2xl p-3 shadow-md hover:shadow-lg transition-all active:scale-95 overflow-hidden group icon-float mt-2"
                style="animation-delay: 0.5s;">
                <div class="flex items-center gap-3 z-10 relative">
                    <div
                        class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined text-white text-xl">event_note</span>
                    </div>
                    <div>
                        <p class="text-white text-xs font-bold leading-tight">Jurnal &amp; Kegiatan</p>
                        <p class="text-[10px] text-white/80">12 Agenda pekan ini</p>
                    </div>
                    <div class="ml-auto">
                        <span
                            class="material-symbols-outlined text-white/70 group-hover:translate-x-1 transition-transform">chevron_right</span>
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
