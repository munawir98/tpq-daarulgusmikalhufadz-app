<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Nilai Santri</title>
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overscroll-behavior-y: none;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-200 min-h-screen">
    <div
        class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden max-w-[480px] mx-auto bg-background-light dark:bg-background-dark shadow-xl pb-24 rounded-none sm:rounded-2xl">
        
        <!-- Premium Header Background -->
        <div class="absolute top-0 left-0 w-full h-[180px] bg-blue-800 islamic-pattern highlight-overlay z-0 rounded-b-[40px] overflow-hidden">
        </div>

        <!-- Top Header -->
        <div class="relative z-10 px-6 pt-8 pb-4 flex items-center justify-between text-white">
            <a href="{{ route('ustadz.dashboard') }}" class="flex items-center gap-2 active:opacity-60 transition-opacity">
                <span class="material-symbols-outlined">arrow_back_ios</span>
            </a>
            <h1 class="text-lg font-bold tracking-tight">Laporan Nilai</h1>
            <div class="w-10"></div>
        </div>

        <!-- Scrollable Content in White Container -->
        <div id="whiteContainer" class="relative z-20 w-full bg-white dark:bg-surface-dark rounded-t-[30px] shadow-soft pt-6 flex-grow min-h-0 transition-all duration-300">
            <div class="p-4 space-y-5">
            <!-- TextField Filters -->
            <form method="GET" action="{{ route('ustadz.nilai.index') }}" class="flex flex-wrap items-end gap-3">
                <label class="flex flex-col min-w-[140px] flex-1">
                    <p class="text-[#0e141b] dark:text-slate-300 text-sm font-medium leading-normal pb-2">Tahun Ajaran
                    </p>
                    <div class="relative">
                        <select name="tahun_ajaran" onchange="this.form.submit()"
                            class="form-select flex w-full min-w-0 flex-1 appearance-none rounded-lg text-[#0e141b] dark:text-white focus:outline-0 focus:ring-0 border border-[#d0dbe7] dark:border-slate-700 bg-slate-50 dark:bg-slate-800 h-12 p-[12px] pr-10 text-sm font-normal bg-none">
                            @foreach($tahunAjaranList ?? [] as $ta)
                            <option value="{{ $ta }}" {{ ($selectedTahunAjaran ?? '' )==$ta ? 'selected' : '' }}>{{ $ta
                                }}</option>
                            @endforeach
                            @if(empty($tahunAjaranList))
                            <option>2024/2025 Ganjil</option>
                            <option>2024/2025 Genap</option>
                            @endif
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-3 text-[#4e7397] pointer-events-none">expand_more</span>
                    </div>
                </label>
                <label class="flex flex-col min-w-[140px] flex-1">
                    <p class="text-[#0e141b] dark:text-slate-300 text-sm font-medium leading-normal pb-2">Kelas</p>
                    <div class="relative">
                        <select name="kelas_id" onchange="this.form.submit()"
                            class="form-select flex w-full min-w-0 flex-1 appearance-none rounded-lg text-[#0e141b] dark:text-white focus:outline-0 focus:ring-0 border border-[#d0dbe7] dark:border-slate-700 bg-slate-50 dark:bg-slate-800 h-12 p-[12px] pr-10 text-sm font-normal bg-none">
                            @if($kelasList->isNotEmpty())
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ ($selectedKelas ?? '' )==$kelas->id ? 'selected' : ''
                                }}>{{ $kelas->nama }}</option>
                            @endforeach
                            @else
                            <option disabled selected>Kelas belum dibuat</option>
                            @endif
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-3 text-[#4e7397] pointer-events-none">expand_more</span>
                    </div>
                </label>
            </form>

            <!-- Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div
                    class="flex flex-col gap-2 rounded-xl p-4 border border-[#d0dbe7] dark:border-slate-700 bg-white dark:bg-slate-800/50 shadow-sm">
                    <p class="text-[#4e7397] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Rata-rata
                        Kelas</p>
                    <p class="text-primary tracking-light text-2xl font-bold leading-tight">{{
                        number_format($rataRataKelas ?? 0, 1) }}</p>
                </div>
                <div
                    class="flex flex-col gap-2 rounded-xl p-4 border border-[#d0dbe7] dark:border-slate-700 bg-white dark:bg-slate-800/50 shadow-sm">
                    <p class="text-[#4e7397] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Santri
                        Tertinggi</p>
                    <p
                        class="text-emerald-600 dark:text-emerald-400 tracking-tight text-lg font-bold leading-tight truncate">
                        {{ $santriTertinggi ?? '-' }}</p>
                </div>
            </div>

            <!-- SectionHeader -->
            <div class="flex items-center justify-between pt-2">
                <h3 class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Daftar
                    Nilai Santri</h3>
                <span class="text-primary text-sm font-medium">{{ count($santriList ?? []) }} Santri</span>
            </div>

            <!-- Student List Items -->
            <div class="space-y-4 pb-32">
                @forelse($santriList ?? [] as $santri)
                @php
                $nilai = $santri->nilai ?? null;
                $tilawah = $nilai->tilawah ?? 0;
                $hafalan = $nilai->hafalan ?? 0;
                $adab = $nilai->adab ?? 0;
                $tajwid = $nilai->tajwid ?? 0;
                $rataRata = ($tilawah + $hafalan + $adab + $tajwid) / 4;

                if ($rataRata >= 90) {
                $grade = 'A+';
                $gradeColor = 'bg-emerald-500';
                $barColor = 'bg-emerald-500';
                $textColor = 'text-emerald-500';
                } elseif ($rataRata >= 80) {
                $grade = 'A';
                $gradeColor = 'bg-primary';
                $barColor = 'bg-primary';
                $textColor = 'text-primary';
                } elseif ($rataRata >= 70) {
                $grade = 'B';
                $gradeColor = 'bg-amber-500';
                $barColor = 'bg-amber-500';
                $textColor = 'text-amber-500';
                } else {
                $grade = 'C';
                $gradeColor = 'bg-red-500';
                $barColor = 'bg-red-500';
                $textColor = 'text-red-500';
                }
                @endphp
                <div
                    class="flex flex-col gap-3 bg-white dark:bg-slate-800/40 p-4 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <div class="flex gap-4 justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div
                                class="bg-primary/10 rounded-full h-12 w-12 border-2 border-primary/20 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-2xl">person</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-[#0e141b] dark:text-white text-base font-semibold leading-tight">{{
                                    $santri->nama_lengkap }}</p>
                                <p class="text-[#4e7397] dark:text-slate-400 text-xs font-normal">NIS: {{ $santri->nis
                                    ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="{{ $gradeColor }} text-white text-lg font-bold px-3 py-1 rounded-lg">{{ $grade
                                }}</span>
                            <span class="text-[10px] text-slate-400 mt-1 uppercase">Nilai Akhir</span>
                        </div>
                    </div>
                    <!-- Assessment Details (Progress Bars) -->
                    <div class="grid grid-cols-2 gap-x-6 gap-y-3 pt-2 border-t border-slate-50 dark:border-slate-800">
                        <div class="space-y-1">
                            <div class="flex justify-between text-[11px] font-medium uppercase text-slate-500">
                                <span>Tilawah</span>
                                <span class="{{ $textColor }}">{{ $tilawah }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                <div class="{{ $barColor }} h-full" style="width: {{ $tilawah }}%"></div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[11px] font-medium uppercase text-slate-500">
                                <span>Hafalan</span>
                                <span class="{{ $textColor }}">{{ $hafalan }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                <div class="{{ $barColor }} h-full" style="width: {{ $hafalan }}%"></div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[11px] font-medium uppercase text-slate-500">
                                <span>Adab</span>
                                <span class="{{ $textColor }}">{{ $adab }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                <div class="{{ $barColor }} h-full" style="width: {{ $adab }}%"></div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[11px] font-medium uppercase text-slate-500">
                                <span>Tajwid</span>
                                <span class="{{ $textColor }}">{{ $tajwid }}</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                                <div class="{{ $barColor }} h-full" style="width: {{ $tajwid }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">school</span>
                    <p class="text-slate-500 text-sm">
                        @if(request('kelas_id'))
                        Tidak ada data santri di kelas ini
                        @else
                        Belum ada data nilai santri
                        @endif
                    </p>
                    <p class="text-slate-400 text-xs mt-1">
                        @if(request('kelas_id'))
                        Silakan pilih kelas lain
                        @else
                        Silakan input nilai terlebih dahulu
                        @endif
                    </p>
                </div>
                @endforelse
            </div>
        </div>

        </div> <!-- End White Container -->

        <!-- Floating Action Area (Bottom Navigation) -->
        <div
            class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white/90 dark:bg-surface-dark/90 backdrop-blur-md border-t border-slate-100 dark:border-slate-800 p-4 pb-8 flex items-center gap-3 z-30">
            <a href="{{ route('ustadz.nilai.input') }}"
                class="flex-1 bg-primary text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 active:scale-95 transition-transform shadow-lg shadow-primary/25">
                <span class="material-symbols-outlined">add_circle</span>
                Input Nilai Baru
            </a>
            <button onclick="window.print()"
                class="w-14 h-14 border-2 border-primary text-primary rounded-xl flex items-center justify-center active:bg-primary/5 active:scale-95 transition-all">
                <span class="material-symbols-outlined">picture_as_pdf</span>
            </button>
        </div>
    </div>
</body>

</html>
