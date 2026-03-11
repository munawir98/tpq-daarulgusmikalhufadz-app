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
                        primary: "#4A90B8",
                        "primary-dark": "#2E6B8A",
                        "header-blue": "#3D7A9E",
                        "header-dark": "#2A5A78",
                        "background-light": "#F2F4F8",
                        "background-dark": "#111921",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748",
                        "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -10px rgba(74, 144, 184, 0.15)',
                        'card': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                        'nav': '0 -10px 40px rgba(0,0,0,0.05)',
                    }
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #4A90B8;
        }
        body {
            font-family: 'Poppins', sans-serif;
            overscroll-behavior-y: none;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        }

        @keyframes moveTexture {
            from {
                background-position: 0 0;
            }

            to {
                background-position: -40px 0;
            }
        }

        .highlight-overlay {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(255, 255, 255, 0.02) 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.02) 75%,
                    rgba(255, 255, 255, 0.08) 100%);
        }

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
        
        .celebration-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(74, 144, 184, 0.05) 1px, transparent 0);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="bg-white dark:bg-background-dark text-[#0e141b] dark:text-slate-200 min-h-screen">
    <div
        class="relative flex h-screen w-full flex-col group/design-root overflow-hidden max-w-[480px] mx-auto bg-background-light dark:bg-background-dark shadow-xl sm:rounded-2xl">
        
        <!-- Premium Header Background -->
        <div class="absolute top-0 left-0 w-full h-[180px] bg-blue-800 islamic-pattern highlight-overlay z-0 rounded-b-[40px] overflow-hidden">
        </div>

        <!-- Close Button -->
        <div class="relative z-20 p-4 flex justify-end">
            <a href="{{ route('ustadz.nilai.index') }}"
                class="text-white/80 active:opacity-60 transition-opacity">
                <span class="material-symbols-outlined">close</span>
            </a>
        </div>

        <!-- Scrollable Content in White Container -->
        <div id="whiteContainer" class="relative z-10 flex-1 flex flex-col items-center justify-center px-8 pb-12 bg-white dark:bg-surface-dark rounded-t-[30px] shadow-soft mt-12 transition-all duration-300">
            <div class="celebration-bg absolute inset-0 rounded-t-[30px] pointer-events-none opacity-40"></div>
            
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
