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

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-down {
            animation: slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
    <div
        class="fixed inset-0 z-10 bg-[#141414]/40 glass-blur flex flex-col justify-start pt-6 md:pt-10 transition-opacity p-4">
        <!-- Modal Content -->
        <div
            class="relative w-full max-w-sm mx-auto bg-white dark:bg-background-dark rounded-3xl shadow-2xl animate-slide-down">

            <!-- Handle for Mobile (Visual only) -->
            <div class="md:hidden flex justify-center pt-3 pb-1">
                <div class="h-1 w-10 rounded-full bg-slate-200 dark:bg-slate-700"></div>
            </div>

            <!-- Modal Header Icon -->
            <div class="flex justify-center mt-6">
                <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-3xl">picture_as_pdf</span>
                </div>
            </div>

            <!-- HeadlineText -->
            <h3
                class="text-[#0d181c] dark:text-white tracking-tight text-xl font-bold leading-tight px-6 text-center pb-2 pt-4">
                Konfirmasi Ekspor
            </h3>

            <!-- BodyText -->
            <p
                class="text-slate-500 dark:text-slate-400 text-sm font-medium leading-relaxed pb-6 pt-1 px-8 text-center">
                Download laporan periode <span class="font-bold text-slate-700 dark:text-white">{{ $monthName }}</span>?
            </p>

            <!-- ListItem (File Metadata Box) -->
            <div class="px-6 pb-6">
                <div
                    class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 px-4 py-3 rounded-2xl">
                    <div
                        class="text-primary flex items-center justify-center rounded-xl bg-white dark:bg-slate-700 shrink-0 size-10 shadow-sm border border-slate-100 dark:border-slate-600">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <p class="text-slate-700 dark:text-white text-sm font-bold leading-tight truncate">
                            {{ $filename }}
                        </p>
                        <p class="text-slate-400 dark:text-slate-500 text-xs font-medium mt-0.5">
                            Format PDF • A4
                        </p>
                    </div>
                </div>
            </div>

            <!-- ButtonGroup -->
            <div class="flex gap-3 px-6 pb-6">
                <button onclick="history.back()"
                    class="flex-1 cursor-pointer items-center justify-center rounded-xl h-12 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-bold active:scale-95 transition-all">
                    Batal
                </button>
                <a href="{{ route('ustadz.presensi.download', ['month' => $monthInput, 'kelas' => $kelasId]) }}"
                    target="_blank" onclick="simulateDownload(this)"
                    class="flex-[2] cursor-pointer flex items-center justify-center gap-2 rounded-xl h-12 bg-primary text-white text-sm font-bold shadow-lg shadow-primary/25 active:scale-95 transition-all outline-none md:hover:bg-sky-500">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Download</span>
                </a>
            </div>
        </div>
    </div>
    <script>
        function simulateDownload(btn) {
            btn.style.pointerEvents = 'none';
            btn.classList.add('opacity-75');
            let progress = 0;

            // Initial state
            btn.innerHTML = `<span class='material-symbols-outlined animate-spin text-[20px]'>progress_activity</span><span>Memproses ${progress}%</span>`;

            // Progress Interval
            const interval = setInterval(() => {
                progress += Math.floor(Math.random() * 5) + 2; // Random increment 2-6%
                if (progress > 95) progress = 95; // Hold at 95%
                btn.innerHTML = `<span class='material-symbols-outlined animate-spin text-[20px]'>progress_activity</span><span>Memproses ${progress}%</span>`;
            }, 100);

            // Finish after 3s (simulated PDF gen time)
            setTimeout(() => {
                clearInterval(interval);
                btn.innerHTML = `<span class='material-symbols-outlined text-[20px]'>check</span><span>100% Selesai</span>`;
                btn.classList.remove('opacity-75');
            }, 3000);

            // Reset after 5s
            setTimeout(() => {
                btn.innerHTML = `<span class='material-symbols-outlined text-[18px]'>download</span><span>Download</span>`;
                btn.style.pointerEvents = 'auto';
            }, 5000);
        }
    </script>
</body>

</html>
