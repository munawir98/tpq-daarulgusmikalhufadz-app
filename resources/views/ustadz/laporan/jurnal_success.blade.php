<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Jurnal Berhasil Disimpan</title>
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
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
        }
        body {
            font-family: "Poppins", sans-serif;
        }
        .confetti-pattern {
            background-image: radial-gradient(#197fe622 1px, transparent 1px), radial-gradient(#22c55e22 1px, transparent 1px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-white dark:bg-background-dark text-[#0e141b] dark:text-slate-100 min-h-screen flex flex-col items-center justify-center confetti-pattern">
    <main class="w-full max-w-md px-6 flex flex-col items-center text-center">
        <!-- Success Icon -->
        <div class="mb-8 relative">
            <div class="size-24 bg-success/10 rounded-full flex items-center justify-center relative z-10">
                <div
                    class="size-16 bg-success rounded-full flex items-center justify-center shadow-lg shadow-success/30">
                    <span class="material-symbols-outlined text-white text-4xl font-bold">check</span>
                </div>
            </div>
            <div class="absolute inset-0 bg-success/5 rounded-full scale-150 -z-0"></div>
        </div>

        <!-- Success Message -->
        <div class="space-y-2 mb-10">
            <h1 class="text-[#0e141b] dark:text-white text-2xl font-extrabold tracking-tight">Jurnal Berhasil
                Disimpan!</h1>
            <p class="text-[#4e7397] dark:text-slate-400 text-sm px-4">
                Data kegiatan Anda telah tercatat ke dalam sistem TPQ.
            </p>
        </div>

        <!-- Summary Card -->
        <div
            class="w-full bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-5 shadow-sm mb-12 text-left">
            <div class="flex flex-col gap-4">
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-xl">calendar_today</span>
                    </div>
                    <div>
                        <p class="text-xs text-[#4e7397] font-medium uppercase tracking-wider">Tanggal</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white">
                            {{ \Carbon\Carbon::parse($jurnal->tanggal)->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-xl">school</span>
                    </div>
                    <div>
                        <p class="text-xs text-[#4e7397] font-medium uppercase tracking-wider">Kelas</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white">
                            {{ $jurnal->kelas->nama ?? 'Kelas Umum' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="p-2 bg-slate-50 dark:bg-slate-800 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-xl">description</span>
                    </div>
                    <div>
                        <p class="text-xs text-[#4e7397] font-medium uppercase tracking-wider">Kegiatan</p>
                        <p class="text-sm font-bold text-[#0e141b] dark:text-white leading-snug">{{ $jurnal->judul }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="w-full space-y-3 pb-8">
            <a href="{{ route('ustadz.laporan.kegiatan') }}"
                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center">
                Selesai
            </a>
            <a href="{{ route('ustadz.laporan.jurnal.create') }}"
                class="w-full bg-transparent text-primary hover:bg-primary/5 font-semibold py-4 rounded-xl transition-all border border-transparent flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-xl">add</span>
                Tambah Lagi
            </a>
        </div>
    </main>

    <div
        class="fixed bottom-1 w-32 h-1.5 bg-slate-300 dark:bg-slate-700 rounded-full left-1/2 -translate-x-1/2 opacity-30">
    </div>
</body>

</html>
