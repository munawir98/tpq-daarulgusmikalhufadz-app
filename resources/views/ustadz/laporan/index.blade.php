<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - TPQ Daarul Gusmik Alhufadz</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Smooth Marker Transitions */
        .leaflet-marker-icon,
        .leaflet-marker-shadow,
        path.leaflet-interactive {
            transition: transform 1s cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        /* Gradient Texture Overlay - like reference image */
        @keyframes moveTexture {
            from {
                background-position: 0 0;
            }

            to {
                background-position: -40px 0;
            }
        }

        /* Separate static highlight */
        .highlight-overlay {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(255, 255, 255, 0.02) 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.02) 75%,
                    rgba(255, 255, 255, 0.08) 100%);
        }

        /* Unified seamless stripe pattern */
        .islamic-pattern {
            background-image:
                linear-gradient(45deg,
                    rgba(255, 255, 255, 0.05) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.05) 50%,
                    rgba(255, 255, 255, 0.05) 75%,
                    transparent 75%,
                    transparent);
            background-size: 40px 40px;
            animation: moveTexture 3s linear infinite;
        }

        .islamic-pattern.pattern-dark {
            background-image:
                linear-gradient(45deg,
                    rgba(30, 64, 175, 0.08) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(30, 64, 175, 0.08) 50%,
                    rgba(30, 64, 175, 0.08) 75%,
                    transparent 75%,
                    transparent);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-display min-h-screen p-0 block">

    <div
        class="relative w-full h-[100dvh] bg-background-light dark:bg-background-dark rounded-none overflow-hidden shadow-none flex flex-col">

        <!-- Header Background - Blue Theme -->
        <div
            class="absolute top-0 left-0 w-full h-[260px] bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] z-0 rounded-b-[40px] overflow-hidden">
            <div class="absolute top-[-50px] right-[-50px] w-64 h-64 bg-[#5BA3CC] rounded-full blur-3xl opacity-60">
            </div>
            <div class="absolute bottom-[-20px] left-[-20px] w-48 h-48 bg-[#2A5A78] rounded-full blur-2xl opacity-50">
            </div>
            <div class="absolute top-[100px] left-[50%] w-32 h-32 bg-[#6BB8DE] rounded-full blur-2xl opacity-30">
            </div>
            <div class="absolute inset-0 highlight-overlay"></div>
            <div class="absolute inset-0 islamic-pattern"></div>
        </div>

        <!-- Scrollable Content -->
        <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar flex flex-col">

            <!-- Top Header -->
            <div class="px-6 pt-8 pb-10 text-white flex flex-col pt-[calc(2rem+env(safe-area-inset-top))] shrink-0">
                <div class="flex items-center gap-4 mb-2">
                    <a href="{{ route('ustadz.dashboard') }}"
                        class="bg-white/20 hover:bg-white/30 p-2 rounded-full backdrop-blur-sm text-white transition-colors">
                        <span class="material-icons-round">arrow_back</span>
                    </a>
                    <div class="text-white">
                        <h1 class="text-xl font-bold leading-tight">Laporan</h1>
                        <p class="text-xs opacity-75 mt-0.5">Pusat Data &amp; Statistik TPQ</p>
                    </div>
                </div>
            </div>

            <!-- Content Card -->
            <div
                class="flex-1 bg-white dark:bg-[#1f2937] rounded-t-[30px] -mt-8 relative z-20 overflow-y-auto pb-10 shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">
                <div class="p-6">
                    <!-- Search & Filter -->
                    <div class="mb-6">
                        <div class="relative mb-4">
                            <input
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none text-sm rounded-2xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/50 shadow-sm placeholder-gray-400 text-gray-700 dark:text-gray-200 transition-shadow"
                                placeholder="Cari jenis laporan..." type="text" />
                            <span
                                class="material-icons-round absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                            <button
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 bg-white dark:bg-gray-700 rounded-lg shadow-sm text-gray-500 hover:text-blue-500 transition-colors">
                                <span class="material-icons-round text-lg">tune</span>
                            </button>
                        </div>
                        <!-- Tabs -->
                        <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-2">
                            <button
                                class="px-4 py-2 bg-blue-600 text-white rounded-full text-xs font-semibold shadow-md shadow-blue-500/30 whitespace-nowrap">Semua</button>
                            <button
                                class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700">Harian</button>
                            <button
                                class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700">Bulanan</button>
                            <button
                                class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700">Semester</button>
                        </div>
                    </div>

                    <!-- Menu List -->
                    <div class="space-y-4">

                        <!-- 1. Laporan Kehadiran Santri -->
                        <a class="group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                            href="{{ route('ustadz.presensi') }}">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <span class="material-icons-round text-2xl">fact_check</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Kehadiran Santri
                                    </h3>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Rekap absensi harian
                                        &amp;
                                        bulanan</p>
                                </div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-teal-500 group-hover:bg-teal-50 dark:group-hover:bg-teal-900/20 transition-colors">
                                    <span class="material-icons-round text-lg">chevron_right</span>
                                </div>
                            </div>
                        </a>

                        <!-- 2. Laporan Setoran Hafalan -->
                        <a class="group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                            href="{{ route('ustadz.hafalan.laporan') }}">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <span class="material-icons-round text-2xl">menu_book</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Setoran Hafalan
                                    </h3>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Progress tahfidz dan
                                        iqra</p>
                                </div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-indigo-500 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/20 transition-colors">
                                    <span class="material-icons-round text-lg">chevron_right</span>
                                </div>
                            </div>
                        </a>

                        <!-- 3. Laporan Nilai Santri -->
                        <a class="group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                            href="{{ route('ustadz.nilai.index') }}">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <span class="material-icons-round text-2xl">grade</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Nilai Santri
                                    </h3>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Hasil ujian dan
                                        evaluasi</p>
                                </div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-orange-500 group-hover:bg-orange-50 dark:group-hover:bg-orange-900/20 transition-colors">
                                    <span class="material-icons-round text-lg">chevron_right</span>
                                </div>
                            </div>
                        </a>

                        <!-- 4. Laporan Keuangan (Placeholder) -->
                        <a class="group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                            href="#">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <span class="material-icons-round text-2xl">account_balance_wallet</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Keuangan</h3>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">SPP, Infaq dan
                                        tabungan</p>
                                </div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-green-500 group-hover:bg-green-50 dark:group-hover:bg-green-900/20 transition-colors">
                                    <span class="material-icons-round text-lg">chevron_right</span>
                                </div>
                            </div>
                        </a>

                        <!-- 5. Laporan Kegiatan (Placeholder) -->
                        <a class="group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                            href="#">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <span class="material-icons-round text-2xl">event_note</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Kegiatan</h3>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Jurnal aktivitas
                                        &amp;
                                        ekstrakurikuler</p>
                                </div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-purple-500 group-hover:bg-purple-50 dark:group-hover:bg-purple-900/20 transition-colors">
                                    <span class="material-icons-round text-lg">chevron_right</span>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>



        </div>
    </div> <!-- Close Scrollable Content -->
    </div> <!-- Close Main Container -->

</body>

</html>
