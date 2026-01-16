<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Nilai Berhasil Disimpan</title>
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
    <style type="text/tailwindcss">
        :root {
            --primary-color: #197fe6;
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        }
        .celebration-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(25, 127, 230, 0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="bg-white dark:bg-background-dark text-[#0e141b] dark:text-slate-200 min-h-screen">
    <div
        class="relative flex h-screen w-full flex-col group/design-root overflow-hidden max-w-[480px] mx-auto celebration-bg">
        <!-- Close Button -->
        <div class="p-4 flex justify-end">
            <a href="{{ route('ustadz.nilai.index') }}"
                class="text-slate-400 dark:text-slate-500 active:opacity-60 transition-opacity">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col items-center justify-center px-8 pb-12">
            <!-- Success Icon -->
            <div class="relative mb-8">
                <div
                    class="size-28 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                    <div
                        class="size-20 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <span class="material-symbols-outlined text-white text-5xl font-bold">check</span>
                    </div>
                </div>
                <div
                    class="absolute -top-2 -right-2 size-10 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-amber-500 fill-1 text-2xl">star</span>
                </div>
            </div>

            <!-- Success Message -->
            <div class="text-center space-y-3 mb-10">
                <h1 class="text-2xl font-bold text-[#0e141b] dark:text-white leading-tight">Nilai Berhasil Disimpan!
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-[260px] mx-auto">
                    Data penilaian santri telah diperbarui di sistem raport.
                </p>
            </div>

            <!-- Summary Card -->
            <div
                class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-2xl p-5 mb-12 shadow-sm">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        @php
                        $initials = strtoupper(substr($nilai->santri->nama_lengkap ?? 'S', 0, 2));
                        @endphp
                        <div
                            class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                            {{ $initials }}</div>
                        <div>
                            <p
                                class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">
                                Santri</p>
                            <p class="text-sm font-bold text-[#0e141b] dark:text-white">
                                {{ $nilai->santri->nama_lengkap ?? 'Santri' }}</p>
                        </div>
                    </div>
                    <div class="h-px bg-slate-200/60 dark:bg-slate-700/60"></div>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                        $rataRata = (($nilai->tilawah ?? 0) + ($nilai->hafalan ?? 0) + ($nilai->adab ?? 0) +
                        ($nilai->tajwid ?? 0)) / 4;
                        $predikat = $rataRata >= 90 ? 'A+' : ($rataRata >= 80 ? 'A' : ($rataRata >= 70 ? 'B' : 'C'));
                        $predikatColor = $rataRata >= 90 ? 'text-emerald-600 dark:text-emerald-400' : ($rataRata >= 80 ?
                        'text-primary' : ($rataRata >= 70 ? 'text-amber-500' : 'text-red-500'));
                        @endphp
                        <div>
                            <p
                                class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">
                                Rata-rata</p>
                            <p class="text-lg font-bold text-primary">{{ number_format($rataRata, 1) }}</p>
                        </div>
                        <div class="text-right">
                            <p
                                class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">
                                Predikat</p>
                            <p class="text-lg font-bold {{ $predikatColor }}">{{ $predikat }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="w-full space-y-3">
                <a href="{{ route('ustadz.nilai.index') }}"
                    class="w-full bg-primary text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 active:scale-[0.98] transition-all shadow-lg shadow-primary/25">
                    Selesai
                </a>
                <a href="{{ route('ustadz.nilai.input') }}"
                    class="w-full bg-transparent text-primary font-semibold py-4 rounded-xl flex items-center justify-center gap-2 active:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined text-xl">add</span>
                    Input Nilai Lainnya
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="py-6 text-center">
            <p class="text-[10px] text-slate-400 dark:text-slate-600 font-medium tracking-widest uppercase">
                TPQ Daarul Gusmik Al-Hufadz
            </p>
        </div>
    </div>
</body>

</html>
