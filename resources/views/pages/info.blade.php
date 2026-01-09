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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Info</title>

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

        <!-- Header Background - Blue Theme (Matches Dashboard) -->
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

            <!-- Top Header Content -->
            <div class="px-6 pt-8 pb-4 text-white flex flex-col pt-[calc(2rem+env(safe-area-inset-top))] shrink-0">
                <div class="flex items-center gap-4 mb-6">
                    <!-- Back Button -->
                    <a href="{{ route('dashboard') }}"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md flex items-center justify-center text-white transition active:scale-95">
                        <span class="material-icons-round">arrow_back</span>
                    </a>
                    <h1 class="text-xl font-bold text-white tracking-wide">Pusat Informasi</h1>
                </div>

                <!-- Search Bar -->
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-blue-200 pointer-events-none">
                        <span class="material-icons-round">search</span>
                    </span>
                    <input
                        class="w-full bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl py-3 pl-12 pr-12 text-white placeholder-blue-200 focus:outline-none focus:bg-white/20 focus:border-white/40 transition shadow-lg shadow-blue-900/10 text-sm"
                        placeholder="Cari pengumuman, tips..." type="text" />
                    <button
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-white/10 rounded-lg text-white hover:bg-white/20 transition">
                        <span class="material-icons-round text-lg">tune</span>
                    </button>
                </div>
            </div>

            <!-- Content Card -->
            <div
                class="flex-1 bg-white dark:bg-[#1f2937] rounded-t-[30px] -mt-6 relative z-20 overflow-hidden flex flex-col shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">

                <!-- Filter Tabs -->
                <div class="pt-6 px-6 pb-2 shrink-0">
                    <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-4 mask-fade-right">
                        <button
                            class="px-5 py-2.5 rounded-full bg-blue-600 text-white text-sm font-semibold shadow-lg shadow-blue-500/30 whitespace-nowrap active:scale-95 transition-transform flex items-center gap-2">
                            Semua
                        </button>
                        <button
                            class="px-5 py-2.5 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700 transition active:scale-95 flex items-center gap-2">
                            <span class="material-icons-round text-red-500 text-lg">campaign</span>
                            Pengumuman
                        </button>
                        <button
                            class="px-5 py-2.5 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700 transition active:scale-95 flex items-center gap-2">
                            <span class="material-icons-round text-gray-600 dark:text-gray-400 text-lg">school</span>
                            Akademik
                        </button>
                        <button
                            class="px-5 py-2.5 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700 transition active:scale-95 flex items-center gap-2">
                            <span class="material-icons-round text-orange-400 text-lg">lightbulb</span>
                            Tips
                        </button>
                        <button
                            class="px-5 py-2.5 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm font-medium whitespace-nowrap hover:bg-gray-50 dark:hover:bg-gray-700 transition active:scale-95 flex items-center gap-2">
                            <span class="material-icons-round text-purple-500 text-lg">event</span>
                            Kegiatan
                        </button>
                    </div>
                </div>

                <!-- Scrollable List -->
                <div class="overflow-y-auto flex-1 px-6 pb-6 space-y-4">

                    <!-- Item 1: Rapat (PENTING) -->
                    <a class="block bg-white dark:bg-gray-800 border border-red-100 dark:border-red-900/30 rounded-2xl p-4 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-200"
                        href="#">
                        <div
                            class="absolute -top-2 -right-2 w-16 h-16 bg-red-500/5 rounded-full blur-xl group-hover:bg-red-500/10 transition">
                        </div>
                        <div class="flex items-start gap-4 relative z-10">
                            <div
                                class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-500 flex items-center justify-center shrink-0">
                                <span class="material-icons-round text-2xl">campaign</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span
                                        class="text-[10px] font-bold text-red-600 bg-red-50 dark:bg-red-900/30 px-2.5 py-0.5 rounded-md border border-red-100 dark:border-red-900/50">PENTING</span>
                                    <span class="text-[10px] text-gray-400 font-medium">08 Jan 2026</span>
                                </div>
                                <h3
                                    class="text-sm font-bold text-gray-800 dark:text-white mb-1.5 leading-snug group-hover:text-red-600 transition-colors">
                                    Rapat Evaluasi Ustadz Bulanan</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">Mohon
                                    kehadirannya pada rapat evaluasi bulanan yang akan dilaksanakan di Aula Utama.</p>
                            </div>
                        </div>
                    </a>

                    <!-- Item 2: Pembaruan Aplikasi (SISTEM) -->
                    <a class="block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group"
                        href="#">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-500 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                <span class="material-icons-round text-2xl">system_update</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span
                                        class="text-[10px] font-bold text-blue-500 bg-blue-50 dark:bg-blue-900/30 px-2.5 py-0.5 rounded-md">SISTEM</span>
                                    <span class="text-[10px] text-gray-400 font-medium">07 Jan 2026</span>
                                </div>
                                <h3
                                    class="text-sm font-bold text-gray-800 dark:text-white mb-1.5 leading-snug group-hover:text-blue-600 transition-colors">
                                    Pembaruan Aplikasi v2.4</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">Fitur
                                    baru
                                    presensi kini mendukung deteksi lokasi yang lebih akurat. Silakan update sekarang.
                                </p>
                            </div>
                        </div>
                    </a>

                    <!-- Item 3: Prestasi (GAMBAR) -->
                    <a class="block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-3 shadow-sm hover:shadow-md transition-all duration-200 group"
                        href="#">
                        <div class="flex gap-4">
                            <div
                                class="w-24 h-24 rounded-xl bg-gray-100 dark:bg-gray-700 shrink-0 overflow-hidden relative shadow-inner">
                                <div
                                    class="absolute inset-0 bg-gradient-to-tr from-green-400 to-teal-500 flex items-center justify-center text-white group-hover:scale-110 transition-transform duration-500">
                                    <span class="material-icons-round text-3xl drop-shadow-md">emoji_events</span>
                                </div>
                            </div>
                            <div class="flex-1 py-1">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span
                                        class="text-[10px] font-bold text-green-600 bg-green-50 dark:bg-green-900/30 px-2.5 py-0.5 rounded-md">PRESTASI</span>
                                    <span class="text-[10px] text-gray-400 font-medium">05 Jan 2026</span>
                                </div>
                                <h3
                                    class="text-sm font-bold text-gray-800 dark:text-white mb-1.5 leading-snug group-hover:text-green-600 transition-colors">
                                    Juara Umum Lomba Tahfidz</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">Selamat
                                    kepada
                                    ananda Rizky yang telah meraih juara umum tingkat kota pada perlombaan kemarin.</p>
                            </div>
                        </div>
                    </a>

                    <!-- Item 4: Tips -->
                    <a class="block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group"
                        href="#">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-500 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                <span class="material-icons-round text-2xl">lightbulb</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span
                                        class="text-[10px] font-bold text-orange-500 bg-orange-50 dark:bg-orange-900/30 px-2.5 py-0.5 rounded-md">TIPS</span>
                                    <span class="text-[10px] text-gray-400 font-medium">02 Jan 2026</span>
                                </div>
                                <h3
                                    class="text-sm font-bold text-gray-800 dark:text-white mb-1.5 leading-snug group-hover:text-orange-500 transition-colors">
                                    Cara Efektif Murojaah</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">Simak 5
                                    metode
                                    murojaah yang tidak membosankan untuk santri TPQ agar hafalan tetap terjaga.</p>
                            </div>
                        </div>
                    </a>

                    <!-- Item 5: Kegiatan -->
                    <a class="block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200 group"
                        href="#">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-500 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                <span class="material-icons-round text-2xl">event_available</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span
                                        class="text-[10px] font-bold text-purple-500 bg-purple-50 dark:bg-purple-900/30 px-2.5 py-0.5 rounded-md">KEGIATAN</span>
                                    <span class="text-[10px] text-gray-400 font-medium">28 Des 2025</span>
                                </div>
                                <h3
                                    class="text-sm font-bold text-gray-800 dark:text-white mb-1.5 leading-snug group-hover:text-purple-500 transition-colors">
                                    Persiapan Munaqosah</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">Jadwal
                                    persiapan munaqosah santri kelas akhir dimulai minggu depan. Harap persiapkan diri.
                                </p>
                            </div>
                        </div>
                    </a>

                    <!-- End Text -->
                    <div class="pt-4 pb-10 text-center">
                        <p class="text-xs text-gray-300 dark:text-gray-600 font-medium tracking-wide">TIDAK ADA
                            INFORMASI
                            LAINNYA</p>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- Close Scrollable Content -->
    </div> <!-- Close Main Container -->

</body>

</html>
