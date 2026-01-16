<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Kehadiran &amp; Aksi Ustadz</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0C5A9F",
                        secondary: "#EBF5FF",
                        "background-light": "#F8FAFC",
                        "background-dark": "#0F172A",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "12px",
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Poppins', sans-serif; }
        .ios-blur { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .chart-grid-line { stroke: #e2e8f0; stroke-width: 1; stroke-dasharray: 4; }
        .dark .chart-grid-line { stroke: #334155; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen pb-48">
    <header class="sticky top-0 z-50 bg-primary/95 dark:bg-slate-900/95 ios-blur shadow-lg shadow-blue-900/10">
        <div class="px-4 py-4 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-lg font-bold text-white leading-tight">Laporan &amp; Atensi</h1>
                <p class="text-[10px] font-bold text-blue-100 uppercase tracking-wider">TPQ Daarul Gusmik Al-Hufadz</p>
            </div>
        </div>
    </header>
    <main class="px-4 pt-6 space-y-6">
        <section
            class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 space-y-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-primary text-sm">filter_list</span>
                <span class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Filter
                    Laporan</span>
            </div>
            <form method="GET" action="{{ route('presensi.index') }}">
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase px-1">Periode</label>
                        <div class="relative">
                            <input type="month" name="month" value="{{ $selectedMonth }}"
                                class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm py-3 pl-3 pr-3 focus:ring-2 focus:ring-primary"
                                onchange="this.form.submit()">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase px-1">Kelas</label>
                        <div class="relative">
                            <select name="kelas"
                                class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm py-3 pl-3 pr-8 focus:ring-2 focus:ring-primary appearance-none"
                                onchange="this.form.submit()">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ $selectedKelas==$kelas->id ? 'selected' : '' }}>{{
                                    $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl">expand_more</span>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <section class="grid grid-cols-2 gap-4">
            <div class="bg-primary p-4 rounded-2xl text-white shadow-lg shadow-primary/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined opacity-80 text-xl">groups</span>
                    <span class="text-[10px] font-bold bg-white/20 px-2 py-0.5 rounded-full uppercase">Total</span>
                </div>
                <div class="text-2xl font-extrabold tracking-tight">{{ $totalSantri }}</div>
                <div class="text-xs opacity-80 font-medium">Santri Terdaftar</div>
            </div>
            <div class="bg-emerald-500 p-4 rounded-2xl text-white shadow-lg shadow-emerald-500/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined opacity-80 text-xl">monitoring</span>
                    <span class="text-[10px] font-bold bg-white/20 px-2 py-0.5 rounded-full uppercase">Avg</span>
                </div>
                <div class="text-2xl font-extrabold tracking-tight">{{ $avgKehadiran }}%</div>
                <div class="text-xs opacity-80 font-medium">Rata-rata Kehadiran</div>
            </div>
        </section>
        <section
            class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">show_chart</span>
                    <h2 class="font-bold text-slate-800 dark:text-slate-200">Tren Kehadiran Bulanan</h2>
                </div>
                <span
                    class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-1 rounded-lg uppercase tracking-wider">Last
                    6 Months</span>
            </div>
            <div class="relative h-48 w-full mt-4">
                @php
                // Calculate Y positions based on percentage (0% = 160, 100% = 0)
                $points = [];
                $xPositions = [0, 80, 160, 240, 320, 400];
                foreach ($trendData as $index => $trend) {
                $yPos = 160 - (($trend['percentage'] / 100) * 160);
                $points[] = ['x' => $xPositions[$index], 'y' => $yPos];
                }

                // Build path strings
                $fillPath = "M 0 160 L " . implode(' L ', array_map(fn($p) => "{$p['x']} {$p['y']}", $points)) . " L 400
                160 Z";
                $linePath = implode(' L ', array_map(fn($p) => "{$p['x']} {$p['y']}", $points));
                @endphp
                <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 400 160">
                    <line class="chart-grid-line" x1="0" x2="400" y1="0" y2="0"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="40" y2="40"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="80" y2="80"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="120" y2="120"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="160" y2="160"></line>
                    <path d="{{ $fillPath }}" fill="url(#gradient)" opacity="0.1"></path>
                    <path d="M {{ $linePath }}" fill="none" stroke="#0C5A9F" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="3"></path>
                    @foreach($points as $point)
                    <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" fill="#0C5A9F" r="4"></circle>
                    @endforeach
                    <defs>
                        <linearGradient id="gradient" x1="0%" x2="0%" y1="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#0C5A9F;stop-opacity:1"></stop>
                            <stop offset="100%" style="stop-color:#0C5A9F;stop-opacity:0"></stop>
                        </linearGradient>
                    </defs>
                </svg>
                <div
                    class="absolute -left-1 top-0 h-full flex flex-col justify-between text-[8px] font-bold text-slate-400 pointer-events-none py-0.5">
                    <span>100%</span>
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0%</span>
                </div>
            </div>
            <div class="flex justify-between mt-4 px-2">
                @foreach($trendData as $trend)
                <span class="text-[10px] font-bold text-slate-400">{{ $trend['month'] }}</span>
                @endforeach
            </div>
        </section>
        <section class="space-y-3">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-500 text-xl">priority_high</span>
                    <h2 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Santri Perlu Perhatian</h2>
                </div>
                <span
                    class="text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">&lt;
                    70% Kehadiran</span>
            </div>
            <div class="flex gap-3 overflow-x-auto pb-4 pt-1 hide-scrollbar -mx-4 px-4 snap-x">
                @forelse($santriPerluPerhatian as $santri)
                <div
                    class="flex-shrink-0 w-36 bg-white dark:bg-slate-800 p-3 rounded-2xl border border-rose-100 dark:border-rose-900/30 shadow-sm snap-start">
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-rose-500 font-bold overflow-hidden border-2 border-white dark:border-slate-700 shadow-sm">
                                @if($santri['foto'])
                                <img alt="{{ $santri['nama'] }}" class="w-full h-full object-cover"
                                    src="{{ asset('storage/' . $santri['foto']) }}" />
                                @else
                                <span class="text-lg">{{ strtoupper(substr($santri['nama'], 0, 1)) }}</span>
                                @endif
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[10px] text-white">warning</span>
                            </div>
                        </div>
                        <div class="space-y-0.5">
                            <h3 class="font-bold text-[11px] text-slate-800 dark:text-slate-200 line-clamp-1">{{
                                $santri['nama'] }}</h3>
                            <div class="text-lg font-black text-rose-600">{{ $santri['persentase'] }}%</div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex-1 text-center py-4 text-slate-400 text-sm">
                    <span class="material-symbols-outlined text-2xl mb-1">check_circle</span>
                    <p>Semua santri memiliki kehadiran baik!</p>
                </div>
                @endforelse
            </div>
        </section>
        <div class="space-y-4">
            <div class="flex items-center justify-between pt-2 px-1">
                <h2 class="font-bold text-slate-800 dark:text-slate-200">Daftar Kehadiran</h2>
                <span class="text-xs font-medium text-slate-500">{{ $selectedDate->translatedFormat('F Y') }}</span>
            </div>
            <div class="space-y-3 pb-32">
                @forelse($daftarKehadiran as $santri)
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between">
                    <div class="flex gap-4 items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary font-bold overflow-hidden">
                            @if($santri['foto'])
                            <img alt="{{ $santri['nama'] }}" class="w-full h-full object-cover"
                                src="{{ asset('storage/' . $santri['foto']) }}" />
                            @else
                            <span class="text-sm">{{ strtoupper(substr($santri['nama'], 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-sm">{{ $santri['nama'] }}</h3>
                            <div class="flex gap-2">
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 font-bold border border-emerald-100 dark:border-emerald-500/20">H:
                                    {{ $santri['hadir'] }}</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-500/10 text-amber-600 font-bold border border-amber-100 dark:border-amber-500/20">I:
                                    {{ $santri['izin'] + $santri['sakit'] }}</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-rose-50 dark:bg-rose-500/10 text-rose-600 font-bold border border-rose-100 dark:border-rose-500/20">A:
                                    {{ $santri['alpa'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div
                            class="text-xl font-extrabold {{ $santri['persentase'] >= 80 ? 'text-emerald-600' : ($santri['persentase'] >= 70 ? 'text-amber-500' : 'text-rose-500') }}">
                            {{ $santri['persentase'] }}%</div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-slate-400">
                    <span class="material-symbols-outlined text-4xl mb-2">groups</span>
                    <p>Belum ada data kehadiran</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>
    <div
        class="fixed bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-background-light dark:from-background-dark via-background-light/95 dark:via-background-dark/95 to-transparent pt-12">
        <div class="space-y-3">
            <!-- Two buttons side by side -->
            <div class="flex gap-2">
                <!-- Kirim Notifikasi Button -->
                <a href="{{ route('notifications.create') }}"
                    class="flex-1 bg-primary hover:bg-primary/90 text-white font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-primary/30 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">send_to_mobile</span>
                    <span class="text-xs">Kirim Notifikasi</span>
                </a>

                <!-- Lainnya Toggle Button -->
                <button id="actionToggle" onclick="toggleActions()"
                    class="bg-slate-600 hover:bg-slate-700 text-white font-bold py-3.5 px-4 rounded-xl flex items-center gap-2 shadow-lg transition-all active:scale-95">
                    <span class="material-symbols-outlined text-lg">more_horiz</span>
                    <span class="text-xs">Lainnya</span>
                    <span id="toggleIcon"
                        class="material-symbols-outlined text-sm transition-transform duration-300">expand_more</span>
                </button>
            </div>

            <!-- Hidden Actions Panel -->
            <div id="actionPanel" class="hidden">
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('ustadz.presensi.pdf', request()->query()) }}" id="exportPdfBtn"
                        class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold py-3 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm active:scale-95 transition-all">
                        <span class="material-symbols-outlined text-rose-500 text-lg">picture_as_pdf</span>
                        <span class="text-xs text-primary">Export PDF</span>
                    </a>
                    <button
                        class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold py-3 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm active:scale-95 transition-all">
                        <span class="material-symbols-outlined text-emerald-500 text-lg">description</span>
                        <span class="text-xs text-primary">Export Excel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleActions() {
            const panel = document.getElementById('actionPanel');
            const icon = document.getElementById('toggleIcon');

            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                panel.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>

    <script>
        // PDF Loading State Logic
        const exportPdfBtn = document.getElementById('exportPdfBtn');
        if (exportPdfBtn) {
            exportPdfBtn.addEventListener('click', function (e) {
                // Store original content
                const originalContent = this.innerHTML;

                // Change to loading state
                this.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-base font-bold whitespace-nowrap">memuat</span>
                `;

                // Disable button
                this.style.pointerEvents = 'none';
                this.classList.add('opacity-75');

                // Revert after 1 second (fallback)
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.pointerEvents = 'auto';
                    this.classList.remove('opacity-75');
                }, 5000); // Increased timeout to mimic redirect
            });
        }
    </script>
</body>

</html>
