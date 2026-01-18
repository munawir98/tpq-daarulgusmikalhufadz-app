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
            <a href="{{ route('ustadz.santri.index') }}"
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-4 bg-cyan-500 shadow-lg shadow-cyan-500/20 overflow-hidden group hover:shadow-md transition-all">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[26px]">groups</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-white text-[14px]">trending_up</span>
                            <p class="text-white text-[11px] font-bold">+{{ $persenSantri }}%</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-sm font-bold uppercase tracking-wider">Total
                        Santri</p>
                    <p class="text-white text-2xl font-extrabold tracking-tight mt-0.5">{{
                        $totalSantri }}</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10 text-7xl pointer-events-none">groups</span>
            </a>

            <!-- Card 2: Total Ustadz (Emerald) -->
            <div
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-4 bg-emerald-500 shadow-lg shadow-emerald-500/20 overflow-hidden group">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[26px]">person_book</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-white text-[14px]">remove</span>
                            <p class="text-white text-[11px] font-bold">Stabil</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-sm font-bold uppercase tracking-wider">Total
                        Ustadz</p>
                    <p class="text-white text-2xl font-extrabold tracking-tight mt-0.5">{{
                        $totalUstadz }}</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10 text-7xl pointer-events-none">person_book</span>
            </div>

            <!-- Card 3: Kehadiran (Amber/Orange) -->
            <a href="{{ route('presensi.index') }}"
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-4 bg-amber-500 shadow-lg shadow-amber-500/20 overflow-hidden group hover:shadow-md transition-all">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[26px]">event_available</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @if($trendKehadiran >= 0)
                            <span class="material-symbols-outlined text-white text-[14px]">trending_up</span>
                            <p class="text-white text-[11px] font-bold">+{{ $trendKehadiran }}%</p>
                            @else
                            <span class="material-symbols-outlined text-white text-[14px]">trending_down</span>
                            <p class="text-white text-[11px] font-bold">{{ $trendKehadiran }}%</p>
                            @endif
                        </div>
                    </div>
                    <p class="text-white/80 text-sm font-bold uppercase tracking-wider">Hadir
                        Hari Ini</p>
                    <p class="text-white text-2xl font-extrabold tracking-tight mt-0.5">{{
                        $persenKehadiran }}%</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10 text-7xl pointer-events-none">event_available</span>
            </a>

            <!-- Card 4: Kas TPQ (Indigo) -->
            <a href="{{ route('ustadz.laporan.keuangan') }}"
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-4 bg-indigo-600 shadow-lg shadow-indigo-600/20 overflow-hidden group hover:shadow-md transition-all">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="p-1.5 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[26px]">account_balance_wallet</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @if($trendKas >= 0)
                            <span class="material-symbols-outlined text-white text-[14px]">trending_up</span>
                            <p class="text-white text-[11px] font-bold">+{{ $trendKas }}%</p>
                            @else
                            <span class="material-symbols-outlined text-white text-[14px]">trending_down</span>
                            <p class="text-white text-[11px] font-bold">{{ $trendKas }}%</p>
                            @endif
                        </div>
                    </div>
                    <p class="text-white/80 text-sm font-bold uppercase tracking-wider">Kas TPQ
                    </p>
                    <p class="text-white text-2xl font-extrabold tracking-tight mt-0.5">{{
                        formatMoneyShort($totalKas) }}</p>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10 text-7xl pointer-events-none">account_balance_wallet</span>
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



        <div class="px-4 pb-20 pt-4">
            <div class="grid grid-cols-2 gap-3">
                <!-- Kehadiran Santri -->
                <a href="{{ route('ustadz.santri.index') }}"
                    class="relative flex flex-col items-center justify-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-300 group overflow-hidden">
                    <div
                        class="p-2 bg-blue-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-blue-600 text-2xl">how_to_reg</span>
                    </div>
                    <h4 class="mt-3 text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                        Kehadiran Santri</h4>
                    <p class="text-xs text-gray-400 text-center mt-0.5 leading-tight">Rekap harian &
                        bulanan</p>
                </a>

                <!-- Setoran Hafalan -->
                <a href="{{ route('ustadz.hafalan.index') }}"
                    class="relative flex flex-col items-center justify-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition-all duration-300 group overflow-hidden">
                    <div
                        class="p-2 bg-purple-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-purple-600 text-2xl">menu_book</span>
                    </div>
                    <h4 class="mt-3 text-sm font-bold text-gray-800 group-hover:text-purple-600 transition-colors">
                        Setoran Hafalan</h4>
                    <p class="text-xs text-gray-400 text-center mt-0.5 leading-tight">Progres hafalan
                        santri</p>
                </a>

                <!-- Penilaian & Rapor -->
                <a href="{{ route('ustadz.nilai.index') }}"
                    class="relative flex flex-col items-center justify-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-amber-200 transition-all duration-300 group overflow-hidden">
                    <div
                        class="p-2 bg-amber-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-amber-600 text-2xl">stars</span>
                    </div>
                    <h4 class="mt-3 text-sm font-bold text-gray-800 group-hover:text-amber-600 transition-colors">
                        Penilaian & Rapor</h4>
                    <p class="text-xs text-gray-400 text-center mt-0.5 leading-tight">Input nilai &
                        cetak rapor</p>
                </a>

                <!-- Laporan Keuangan -->
                <a href="{{ route('ustadz.laporan.keuangan') }}"
                    class="relative flex flex-col items-center justify-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition-all duration-300 group overflow-hidden">
                    <div
                        class="p-2 bg-emerald-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl">account_balance_wallet</span>
                    </div>
                    <h4 class="mt-3 text-sm font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">
                        Laporan Keuangan</h4>
                    <p class="text-xs text-gray-400 text-center mt-0.5 leading-tight">Arus kas &
                        pemasukan</p>
                </a>

                <!-- Jurnal & Kegiatan -->
                <a href="{{ route('ustadz.laporan.kegiatan') }}"
                    class="col-span-2 relative flex flex-row items-center justify-between p-4 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-pink-200 transition-all duration-300 group overflow-hidden">
                    <div class="flex items-center gap-3">
                        <div
                            class="p-2 bg-pink-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                            <span class="material-symbols-outlined text-pink-600 text-2xl">edit_note</span>
                        </div>
                        <div class="text-left">
                            <h4 class="text-sm font-bold text-gray-800 group-hover:text-pink-600 transition-colors">
                                Jurnal & Kegiatan</h4>
                            <p class="text-xs text-gray-400 mt-0.5 leading-tight">Catatan harian &
                                ekstrakurikuler</p>
                        </div>
                    </div>
                    <div
                        class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-pink-600 transition-colors duration-300">
                        <span
                            class="material-symbols-outlined text-gray-400 text-sm group-hover:text-white transition-colors">arrow_forward_ios</span>
                    </div>
                </a>
            </div>
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
                    <button class="text-xs font-bold px-3 py-1 bg-white text-primary rounded-full">Lihat
                        Detail</button>
                </div>
            </div>
        </div>
        <div class="h-8"></div>
    </div>

</body>

</html>
