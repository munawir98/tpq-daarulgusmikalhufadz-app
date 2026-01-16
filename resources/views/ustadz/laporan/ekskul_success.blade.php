<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Kegiatan Ekskul Berhasil Disimpan</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
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
                        "success": "#22c55e",
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
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 48
        }
        body {
            font-family: "Poppins", sans-serif;
        }
        .success-bg-gradient {
            background: radial-gradient(circle at center, rgba(34, 197, 94, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
        }
        .dark .success-bg-gradient {
            background: radial-gradient(circle at center, rgba(34, 197, 94, 0.15) 0%, rgba(17, 25, 33, 0) 70%);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-white dark:bg-background-dark text-[#0e141b] dark:text-slate-100 min-h-screen flex flex-col items-center justify-center p-6">
    <main class="w-full max-w-md flex flex-col items-center text-center">
        <!-- Success Icon -->
        <div class="relative mb-8 flex items-center justify-center">
            <div class="success-bg-gradient absolute inset-0 scale-150 rounded-full"></div>
            <div
                class="relative size-24 bg-success/10 dark:bg-success/20 rounded-full flex items-center justify-center border-4 border-success/20 animate-pulse">
                <span class="material-symbols-outlined text-success text-6xl">check_circle</span>
            </div>
        </div>

        <!-- Success Message -->
        <div class="space-y-2 mb-8">
            <h1 class="text-[#0e141b] dark:text-white text-2xl font-extrabold tracking-tight">
                Kegiatan Ekskul Berhasil Disimpan!
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed px-4">
                Dokumentasi kegiatan ekstrakurikuler telah masuk ke sistem dan tercatat secara permanen.
            </p>
        </div>

        <!-- Summary Card -->
        <div
            class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 rounded-2xl p-5 mb-10 text-left shadow-sm">
            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400 dark:text-slate-500 mb-3">Ringkasan
                Laporan</p>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined !text-xl !fill-none">sports_martial_arts</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-none mb-1">Ekskul</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white">{{ $ekskul->nama }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined !text-xl !fill-none">person</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-none mb-1">Pelatih</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white">{{ $ekskul->pelatih ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined !text-xl !fill-none">groups</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-none mb-1">Jumlah Peserta</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white">{{ $ekskul->jumlah_peserta ?? 0 }}
                            Santri</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined !text-xl !fill-none">calendar_today</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-none mb-1">Tanggal</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white">
                            {{ \Carbon\Carbon::parse($ekskul->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="w-full space-y-3">
            <a href="{{ route('ustadz.laporan.kegiatan') }}"
                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                Selesai
            </a>
            <a href="{{ route('ustadz.laporan.ekskul.create') }}"
                class="w-full bg-transparent hover:bg-slate-50 dark:hover:bg-slate-800/50 text-primary font-semibold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-xl">add</span>
                Tambah Lagi
            </a>
        </div>
    </main>

    <footer class="mt-auto pt-10 pb-4 text-center">
        <p class="text-[10px] text-slate-400 dark:text-slate-600 font-medium tracking-wide">
            TPQ DAARUL GUSMIK AL-HUFADZ
        </p>
    </footer>
</body>

</html>
