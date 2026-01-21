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
        body {
            font-family: 'Poppins', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-200 min-h-screen">
    <div
        class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden max-w-[480px] mx-auto bg-white dark:bg-background-dark shadow-xl">
        <!-- TopAppBar -->
        <!-- Gradient Header -->
        <header
            class="flex items-center justify-between bg-gradient-to-r from-[#1A2980] to-[#26D0CE] h-16 px-4 shadow-lg shadow-blue-900/20 mx-6 rounded-2xl mt-6 mb-4 relative z-20">
            <a href="{{ route('ustadz.laporan.index') }}"
                class="flex items-center justify-center w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white transition-colors">
                <span class="material-symbols-outlined text-[20px]">arrow_back_ios_new</span>
            </a>
            <div class="flex items-center gap-2">
                <div class="bg-white/20 p-1.5 rounded-lg">
                    <span class="material-symbols-outlined text-white text-[20px]">grade</span>
                </div>
                <h1 class="text-white text-base font-bold leading-tight tracking-wide">Laporan Nilai</h1>
            </div>
            <div class="w-10"></div> <!-- Spacer for centering -->
        </header>

        <div class="p-4 space-y-4">
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
                            @foreach($kelasList ?? [] as $kelas)
                            <option value="{{ $kelas->id }}" {{ ($selectedKelas ?? '' )==$kelas->id ? 'selected' : ''
                                }}>{{ $kelas->nama }}</option>
                            @endforeach
                            @if(empty($kelasList))
                            <option>Semua Kelas</option>
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
                    <p class="text-slate-500 text-sm">Belum ada data nilai santri</p>
                    <p class="text-slate-400 text-xs mt-1">Silakan input nilai terlebih dahulu</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Floating Action Area (Bottom Navigation) -->
        <div
            class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white dark:bg-background-dark border-t border-slate-100 dark:border-slate-800 p-4 pb-8 flex items-center gap-3 z-20">
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
