<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Konfirmasi Ekspor Laporan</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#25c0f4",
                        "background-light": "#f5f8f8",
                        "background-dark": "#101e22",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
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
        body {
            font-family: 'Manrope', sans-serif;
            min-height: max(884px, 100dvh);
        }

        .glass-blur {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen flex items-center justify-center font-display">
    <!-- Background Mockup (Laporan Kehadiran Screen) -->
    <div class="fixed inset-0 z-0 flex flex-col p-4 opacity-40 blur-sm pointer-events-none">
        <header class="flex items-center justify-between mb-6">
            <span class="material-symbols-outlined text-[#0d181c] dark:text-white">arrow_back_ios</span>
            <h1 class="text-lg font-bold text-[#0d181c] dark:text-white">Laporan Kehadiran</h1>
            <span class="material-symbols-outlined text-[#0d181c] dark:text-white">more_vert</span>
        </header>
        <div class="space-y-4">
            <div
                class="bg-white dark:bg-[#1a2b30] p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="h-4 w-32 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                <div class="h-3 w-48 bg-gray-100 dark:bg-gray-800 rounded"></div>
            </div>
            <div
                class="bg-white dark:bg-[#1a2b30] p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="h-4 w-24 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                <div class="h-3 w-56 bg-gray-100 dark:bg-gray-800 rounded"></div>
            </div>
            <div
                class="bg-white dark:bg-[#1a2b30] p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="h-4 w-40 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>
                <div class="h-3 w-32 bg-gray-100 dark:bg-gray-800 rounded"></div>
            </div>
        </div>
    </div>

    <!-- Modal Backdrop Overlay -->
    <div class="fixed inset-0 z-10 bg-[#141414]/40 glass-blur flex flex-col justify-end transition-opacity">
        <!-- Bottom Sheet Modal Content -->
        <div
            class="relative bg-white dark:bg-background-dark rounded-t-3xl shadow-2xl animate-in slide-in-from-bottom duration-300">
            <!-- BottomSheetHandle -->
            <button class="flex h-6 w-full items-center justify-center pt-2 cursor-pointer" onclick="history.back()">
                <div class="h-1 w-10 rounded-full bg-[#cee2e8] dark:bg-gray-700"></div>
            </button>

            <!-- Modal Header Icon -->
            <div class="flex justify-center mt-6">
                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-4xl">picture_as_pdf</span>
                </div>
            </div>

            <!-- HeadlineText -->
            <h3
                class="text-[#0d181c] dark:text-white tracking-tight text-2xl font-bold leading-tight px-6 text-center pb-2 pt-4">
                Konfirmasi Ekspor
            </h3>

            <!-- BodyText -->
            <p
                class="text-[#49879c] dark:text-gray-400 text-base font-normal leading-relaxed pb-6 pt-1 px-8 text-center">
                Apakah Anda yakin ingin mengunduh laporan periode <span
                    class="font-semibold text-[#0d181c] dark:text-white">{{ $monthName }}</span> dalam format <span
                    class="font-semibold text-[#0d181c] dark:text-white">PDF</span>?
            </p>

            <!-- ListItem (File Metadata Box) -->
            <div class="px-6 pb-6">
                <div
                    class="flex items-center gap-4 bg-[#f8fbfc] dark:bg-[#1a2b30] border border-[#e7f0f4] dark:border-gray-800 px-4 min-h-[72px] py-2 rounded-xl">
                    <div
                        class="text-primary flex items-center justify-center rounded-lg bg-primary/10 shrink-0 size-12">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[#0d181c] dark:text-white text-base font-medium leading-normal line-clamp-1">
                            {{ $filename }}
                        </p>
                        <p class="text-[#49879c] dark:text-gray-400 text-sm font-normal leading-normal line-clamp-2">
                            Ukuran: ~KB
                        </p>
                    </div>
                </div>
            </div>

            <!-- ButtonGroup -->
            <div class="flex justify-center pb-10">
                <div class="flex flex-1 gap-3 max-w-[480px] flex-col items-stretch px-6 py-3">
                    <a href="{{ route('ustadz.presensi.download', ['month' => $monthInput, 'kelas' => $kelasId]) }}"
                        target="_blank"
                        class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-5 bg-primary text-white text-base font-bold leading-normal tracking-[0.015em] w-full shadow-lg shadow-primary/25 active:scale-[0.98] transition-transform">
                        <span class="truncate">Unduh Sekarang</span>
                    </a>
                    <button onclick="history.back()"
                        class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-transparent text-[#49879c] dark:text-gray-400 text-base font-semibold leading-normal tracking-[0.015em] w-full active:bg-gray-50 dark:active:bg-gray-800 transition-colors">
                        <span class="truncate">Batal</span>
                    </button>
                </div>
            </div>

            <!-- Safe Area Bottom (iOS) -->
            <div class="h-5 bg-transparent"></div>
        </div>
    </div>
</body>

</html>
