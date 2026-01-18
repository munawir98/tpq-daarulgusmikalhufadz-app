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
        <div class="flex flex-wrap gap-3 p-3">
            <!-- Card 1: Total Santri (Cyan/Blue) -->
            <a href="{{ route('ustadz.santri.index') }}"
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-3 bg-cyan-500 shadow-lg shadow-cyan-500/20 overflow-hidden group hover:shadow-md transition-all hover:-translate-y-1 active:scale-95 duration-300 ease-out">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[22px]">groups</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-white text-[12px]">trending_up</span>
                            <p class="text-white text-[10px] font-bold">+{{ $persenSantri }}%</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-white/90 text-xs font-bold">Total Santri</p>
                        <p class="text-white text-lg font-extrabold tracking-tight">{{ $totalSantri }}</p>
                    </div>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-3 -bottom-3 text-white/10 text-6xl pointer-events-none transition-transform duration-500 group-hover:rotate-12">groups</span>
            </a>

            <!-- Card 2: Total Ustadz (Emerald) -->
            <div
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-3 bg-emerald-500 shadow-lg shadow-emerald-500/20 overflow-hidden group hover:-translate-y-1 transition-all duration-300 ease-out">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[22px]">person_book</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-white text-[12px]">remove</span>
                            <p class="text-white text-[10px] font-bold">Stabil</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-white/90 text-xs font-bold">Total Ustadz</p>
                        <p class="text-white text-lg font-extrabold tracking-tight">{{ $totalUstadz }}</p>
                    </div>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-3 -bottom-3 text-white/10 text-6xl pointer-events-none transition-transform duration-500 group-hover:rotate-12">person_book</span>
            </div>

            <!-- Card 3: Kehadiran (Amber/Orange) -->
            <a href="{{ route('presensi.index') }}"
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-3 bg-amber-500 shadow-lg shadow-amber-500/20 overflow-hidden group hover:shadow-md transition-all hover:-translate-y-1 active:scale-95 duration-300 ease-out">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[22px]">event_available</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @if($trendKehadiran >= 0)
                            <span class="material-symbols-outlined text-white text-[12px]">trending_up</span>
                            <p class="text-white text-[10px] font-bold">+{{ $trendKehadiran }}%</p>
                            @else
                            <span class="material-symbols-outlined text-white text-[12px]">trending_down</span>
                            <p class="text-white text-[10px] font-bold">{{ $trendKehadiran }}%</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-white/90 text-xs font-bold">Hadir Hari Ini</p>
                        <p class="text-white text-lg font-extrabold tracking-tight">{{ $persenKehadiran }}%</p>
                    </div>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-3 -bottom-3 text-white/10 text-6xl pointer-events-none transition-transform duration-500 group-hover:rotate-12">event_available</span>
            </a>

            <!-- Card 4: Kas TPQ (Indigo) -->
            <a href="{{ route('ustadz.laporan.keuangan') }}"
                class="relative flex w-[48%] flex-grow flex-col gap-1 rounded-2xl p-3 bg-indigo-600 shadow-lg shadow-indigo-600/20 overflow-hidden group hover:shadow-md transition-all hover:-translate-y-1 active:scale-95 duration-300 ease-out">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-2">
                        <div class="p-1 bg-white/20 rounded-lg backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-[22px]">account_balance_wallet</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            @if($trendKas >= 0)
                            <span class="material-symbols-outlined text-white text-[12px]">trending_up</span>
                            <p class="text-white text-[10px] font-bold">+{{ $trendKas }}%</p>
                            @else
                            <span class="material-symbols-outlined text-white text-[12px]">trending_down</span>
                            <p class="text-white text-[10px] font-bold">{{ $trendKas }}%</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-white/90 text-xs font-bold">Kas TPQ</p>
                        <p class="text-white text-xl font-extrabold tracking-tight">{{ formatMoneyShort($totalKas) }}
                        </p>
                    </div>
                </div>
                <span
                    class="material-symbols-outlined absolute -right-3 -bottom-3 text-white/10 text-6xl pointer-events-none transition-transform duration-500 group-hover:rotate-12">account_balance_wallet</span>
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



        <div class="px-4 pb-20 pt-2">
            <div class="grid grid-cols-2 gap-3">
                <!-- Kehadiran Santri -->
                <a href="{{ route('ustadz.santri.index') }}"
                    class="relative flex flex-col items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-300 group overflow-hidden hover:-translate-y-1 active:scale-95 ease-out">
                    <div
                        class="p-1.5 bg-blue-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-blue-600 text-xl">how_to_reg</span>
                    </div>
                    <h4 class="mt-2 text-xs font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                        Kehadiran Santri</h4>
                    <p class="text-[10px] text-gray-400 text-center mt-0.5 leading-tight">Rekap harian &
                        bulanan</p>
                </a>

                <!-- Setoran Hafalan -->
                <a href="{{ route('ustadz.hafalan.index') }}"
                    class="relative flex flex-col items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition-all duration-300 group overflow-hidden hover:-translate-y-1 active:scale-95 ease-out">
                    <div
                        class="p-1.5 bg-purple-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-purple-600 text-xl">menu_book</span>
                    </div>
                    <h4 class="mt-2 text-xs font-bold text-gray-800 group-hover:text-purple-600 transition-colors">
                        Setoran Hafalan</h4>
                    <p class="text-[10px] text-gray-400 text-center mt-0.5 leading-tight">Progres hafalan
                        santri</p>
                </a>

                <!-- Penilaian & Rapor -->
                <a href="{{ route('ustadz.nilai.index') }}"
                    class="relative flex flex-col items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-amber-200 transition-all duration-300 group overflow-hidden hover:-translate-y-1 active:scale-95 ease-out">
                    <div
                        class="p-1.5 bg-amber-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-amber-600 text-xl">stars</span>
                    </div>
                    <h4 class="mt-2 text-xs font-bold text-gray-800 group-hover:text-amber-600 transition-colors">
                        Penilaian & Rapor</h4>
                    <p class="text-[10px] text-gray-400 text-center mt-0.5 leading-tight">Input nilai &
                        cetak rapor</p>
                </a>

                <!-- Laporan Keuangan -->
                <a href="{{ route('ustadz.laporan.keuangan') }}"
                    class="relative flex flex-col items-center justify-center p-3 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition-all duration-300 group overflow-hidden hover:-translate-y-1 active:scale-95 ease-out">
                    <div
                        class="p-1.5 bg-emerald-50 relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                        <span class="material-symbols-outlined text-emerald-600 text-xl">account_balance_wallet</span>
                    </div>
                    <h4 class="mt-2 text-xs font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">
                        Laporan Keuangan</h4>
                    <p class="text-[10px] text-gray-400 text-center mt-0.5 leading-tight">Arus kas &
                        pemasukan</p>
                </a>

                <!-- Jurnal & Kegiatan -->
                <!-- Jurnal & Kegiatan -->
                <a href="{{ route('ustadz.laporan.kegiatan') }}"
                    class="col-span-2 relative flex flex-row items-center justify-between p-3 bg-red-600 rounded-2xl shadow-lg shadow-red-600/20 hover:shadow-xl hover:shadow-red-600/30 transition-all duration-300 group overflow-hidden border border-red-500 hover:-translate-y-1 active:scale-95 ease-out">
                    <div class="flex items-center gap-2 relative z-10">
                        <div
                            class="p-1.5 bg-white/20 backdrop-blur-sm relative group-hover:scale-110 transition-transform duration-300 rounded-xl">
                            <span class="material-symbols-outlined text-white text-xl">edit_note</span>
                        </div>
                        <div class="text-left">
                            <h4 class="text-xs font-bold text-white group-hover:text-white transition-colors">
                                Jurnal & Kegiatan</h4>
                            <p class="text-[10px] text-white/90 mt-0.5 leading-tight">Catatan harian &
                                ekstrakurikuler</p>
                        </div>
                    </div>
                    <div
                        class="w-6 h-6 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:bg-white transition-colors duration-300 relative z-10">
                        <span
                            class="material-symbols-outlined text-white text-[10px] group-hover:text-red-600 transition-colors">arrow_forward_ios</span>
                    </div>
                    <!-- Decoration Icon -->
                    <span
                        class="material-symbols-outlined absolute -right-2 -bottom-4 text-white/10 text-6xl pointer-events-none z-0">edit_note</span>
                </a>
            </div>
        </div>

        <div class="h-8"></div>
    </div>

</body>

</html>
