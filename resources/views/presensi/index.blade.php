<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Kehadiran</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#25c0f4",
                        "deep-blue": "#1e3a8a",
                        "background-light": "#ffffff",
                        "background-dark": "#101e22",
                        "success": "#10B981",
                        "danger": "#EF4444",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
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
        body {
            font-family: 'Manrope', sans-serif;
            -webkit-tap-highlight-color: transparent;
            min-height: 100dvh;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0d181c] dark:text-gray-100 min-h-screen pb-32">
    <!-- Header -->
    <header class="p-6 pb-4">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('dashboard') }}"
                class="flex items-center text-gray-400 hover:text-primary transition-colors">
                <span class="material-symbols-outlined absolute left-4 text-xl">arrow_back_ios_new</span>
            </a>
            <div class="flex-1"></div>
            <span class="material-symbols-outlined text-deep-blue cursor-pointer">more_horiz</span>
        </div>
        <div class="space-y-1">
            <p class="text-deep-blue text-[11px] font-extrabold uppercase tracking-[0.2em] opacity-90">Laporan</p>
            <h1 class="text-deep-blue text-2xl font-extrabold leading-tight tracking-tight">Atensi &amp; Kehadiran
                Santri</h1>
        </div>
    </header>

    <!-- Filter Section -->
    <form method="GET" action="{{ route('presensi.index') }}" id="filterForm">
        <section class="px-6 py-2">
            <div class="flex gap-4">
                <div class="flex-1">
                    <label
                        class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-0.5 tracking-wider">Periode</label>
                    <div class="relative">
                        <select name="month" onchange="document.getElementById('filterForm').submit()"
                            class="w-full bg-white dark:bg-slate-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-semibold appearance-none focus:ring-primary focus:border-primary shadow-sm">
                            @for ($i = 0; $i < 6; $i++) @php $m=now()->subMonths($i);
                                @endphp
                                <option value="{{ $m->format('Y-m') }}" {{ $selectedMonth==$m->format('Y-m') ?
                                    'selected' : ''
                                    }}>
                                    {{ $m->locale('id')->translatedFormat('F Y') }}
                                </option>
                                @endfor
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xl">expand_more</span>
                    </div>
                </div>
                <div class="flex-1">
                    <label
                        class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-0.5 tracking-wider">Kelas</label>
                    <div class="relative">
                        <select name="kelas" onchange="document.getElementById('filterForm').submit()"
                            class="w-full bg-white dark:bg-slate-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-semibold appearance-none focus:ring-primary focus:border-primary shadow-sm">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $selectedKelas==$kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xl">expand_more</span>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <!-- Stats Cards -->
    <section class="px-6 py-4 flex gap-4">
        <div class="flex-1 bg-primary rounded-2xl p-5 shadow-lg shadow-primary/20 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-white/80 text-xs font-bold uppercase mb-1">Total Santri</p>
                <p class="text-white text-3xl font-extrabold tracking-tight">{{ $totalSantri }}</p>
            </div>
            <span
                class="material-symbols-outlined absolute -right-2 -bottom-2 text-white/20 text-6xl pointer-events-none">group</span>
        </div>
        <div class="flex-1 bg-success rounded-2xl p-5 shadow-lg shadow-success/20 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-white/80 text-xs font-bold uppercase mb-1">Rata-rata</p>
                <div class="flex items-baseline gap-1">
                    <p class="text-white text-3xl font-extrabold tracking-tight">{{ $avgKehadiran }}%</p>
                    <span class="text-white/90 text-xs font-bold">Bln Ini</span>
                </div>
            </div>
            <span
                class="material-symbols-outlined absolute -right-2 -bottom-2 text-white/20 text-6xl pointer-events-none">monitoring</span>
        </div>
    </section>

    <!-- Chart Section -->
    <section class="px-6 pt-4 pb-2">
        <div
            class="w-full bg-white dark:bg-slate-800/50 rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-100 uppercase tracking-wide">Tren Kehadiran (6
                    Bln)</h3>
                <span class="material-symbols-outlined text-gray-400 text-lg">info</span>
            </div>

            @php
            // Logic Chart SVG
            $points = "";
            $pointsCurve = "";
            $labels = [];
            $xStep = 20;

            $data = $trendData ?? [];
            $data = array_reverse($data); // Oldest first
            $data = array_slice($data, -6);

            foreach($data as $key => $item) {
            $x = $key * $xStep;
            // Y scaler: 100% -> 15 (top padding), 0% -> 100
            $pct = $item['percentage'];
            $y = 100 - ($pct * 0.85); // 100% = 15

            $points .= "L $x,$y ";
            $labels[] = ['x' => $x, 'y' => $y, 'val' => $pct . '%', 'month' => $item['month']];
            }

            if (count($labels) > 0) {
            $startParams = "M " . $labels[0]['x'] . "," . $labels[0]['y'];
            $pathLine = $startParams . " " . $points;
            $lastX = $labels[count($labels)-1]['x'];
            $pathArea = $pathLine . " L $lastX,100 L 0,100 Z";
            } else {
            $pathLine = "M 0,100 L 100,100";
            $pathArea = "M 0,100 L 100,100 Z";
            }
            @endphp

            <div class="relative w-full h-40">
                <div class="absolute inset-0 flex flex-col justify-between">
                    <div class="border-t border-gray-100 dark:border-gray-700/30 w-full h-0"></div>
                    <div class="border-t border-gray-100 dark:border-gray-700/30 w-full h-0"></div>
                    <div class="border-t border-gray-100 dark:border-gray-700/30 w-full h-0"></div>
                </div>
                <svg class="absolute inset-0 w-full h-full overflow-visible" preserveAspectRatio="none"
                    viewBox="0 0 100 100">
                    <defs>
                        <linearGradient id="chartFill" x1="0%" x2="0%" y1="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#25c0f4;stop-opacity:0.15"></stop>
                            <stop offset="100%" style="stop-color:#25c0f4;stop-opacity:0"></stop>
                        </linearGradient>
                    </defs>
                    <path d="{{ $pathArea }}" fill="url(#chartFill)"></path>
                    <path d="{{ $pathLine }}" fill="none" stroke="#25c0f4" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="3"></path>
                    @foreach($labels as $p)
                    <circle cx="{{ $p['x'] }}" cy="{{ $p['y'] }}" fill="#25c0f4" r="3" stroke="white"
                        stroke-width="1.5">
                        <title>{{ $p['month'] }}: {{ $p['val'] }}</title>
                    </circle>
                    @endforeach
                </svg>
                <!-- Axis Labels -->
                <div
                    class="absolute -bottom-6 w-full flex justify-between text-[8px] text-gray-400 font-bold uppercase tracking-wider">
                    @foreach($labels as $p)
                    <div style="width: 20px; text-align: center;">{{ $p['month'] }}</div>
                    @endforeach
                </div>
            </div>
            <div class="h-4"></div>
        </div>
    </section>

    <!-- Action Buttons (Separate Section) with Vibrant Colors -->
    <section class="px-6 py-4">
        <div
            class="flex justify-between items-center bg-white dark:bg-slate-800/50 rounded-2xl p-5 border border-gray-100 dark:border-gray-800 shadow-sm">

            <!-- Tombol Kirim Notif (Biru) -->
            <a href="{{ route('ustadz.broadcast.create') }}" class="flex flex-col items-center gap-2 flex-1 group">
                <div
                    class="w-12 h-12 bg-blue-500 dark:bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-md shadow-blue-200 dark:shadow-blue-900/20 group-active:scale-95 transition-transform">
                    <span class="material-symbols-outlined text-2xl">notifications</span>
                </div>
                <span class="text-[10px] font-extrabold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Kirim
                    Notif</span>
            </a>

            <!-- Tombol Export PDF (Merah) -->
            <a href="{{ route('ustadz.presensi.pdf', ['month' => $selectedMonth, 'kelas' => $selectedKelas]) }}"
                class="flex flex-col items-center gap-2 flex-1 group border-x border-gray-100 dark:border-gray-700">
                <div
                    class="w-12 h-12 bg-red-500 dark:bg-red-600 rounded-2xl flex items-center justify-center text-white shadow-md shadow-red-200 dark:shadow-red-900/20 group-active:scale-95 transition-transform">
                    <span class="material-symbols-outlined text-2xl">picture_as_pdf</span>
                </div>
                <span class="text-[10px] font-extrabold text-red-600 dark:text-red-400 uppercase tracking-wider">Export
                    PDF</span>
            </a>

            <!-- Tombol Export Excel (Hijau) -->
            <button class="flex flex-col items-center gap-2 flex-1 group"
                onclick="alert('Export Excel belum tersedia')">
                <div
                    class="w-12 h-12 bg-green-500 dark:bg-green-600 rounded-2xl flex items-center justify-center text-white shadow-md shadow-green-200 dark:shadow-green-900/20 group-active:scale-95 transition-transform">
                    <span class="material-symbols-outlined text-2xl">table_view</span>
                </div>
                <span
                    class="text-[10px] font-extrabold text-green-600 dark:text-green-400 uppercase tracking-wider">Export
                    Excel</span>
            </button>
        </div>
    </section>

    <!-- Santri Perlu Perhatian -->
    @if(count($santriPerluPerhatian) > 0)
    <section class="py-4">
        <h3 class="px-6 text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
            Santri Perlu Perhatian
            <span class="text-white text-xs font-bold bg-danger px-2 py-1 rounded-lg">&lt;70%</span>
        </h3>
        <div class="flex overflow-x-auto hide-scrollbar gap-4 px-6 pb-2">
            @foreach($santriPerluPerhatian as $s)
            <div class="flex-none w-24 flex flex-col items-center">
                <div class="relative mb-2">
                    @if($s['foto'])
                    <img alt="{{ $s['nama'] }}"
                        class="w-16 h-16 rounded-full border-[3px] border-danger p-0.5 object-cover bg-white"
                        src="{{ asset('storage/' . $s['foto']) }}" />
                    @else
                    <div
                        class="w-16 h-16 rounded-full border-[3px] border-danger p-0.5 bg-gray-100 flex items-center justify-center">
                        <span class="text-xl font-bold text-danger">{{ substr($s['nama'], 0, 1) }}</span>
                    </div>
                    @endif
                    <span
                        class="absolute -bottom-1 -right-1 bg-danger text-white text-[10px] font-bold px-2 py-1 rounded-full border-2 border-white shadow-sm">{{
                        $s['persentase'] }}%</span>
                </div>
                <p class="text-xs font-bold text-center truncate w-full text-gray-700 dark:text-gray-300">{{
                    Str::limit($s['nama'], 12) }}</p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Daftar Kehadiran -->
    <section class="px-6 py-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Daftar Kehadiran</h3>
            <button
                class="text-primary text-sm font-bold bg-primary/10 px-3 py-1 rounded-lg hover:bg-primary hover:text-white transition-colors">Lihat
                Semua</button>
        </div>
        <div class="space-y-3">
            @forelse($daftarKehadiran as $santri)
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3">
                    @if($santri['foto'])
                    <img src="{{ asset('storage/' . $santri['foto']) }}"
                        class="w-11 h-11 rounded-full object-cover border border-gray-200" />
                    @else
                    @php
                    $initials = collect(explode(' ', $santri['nama']))->map(function($segment) {
                    return strtoupper(substr($segment, 0, 1));
                    })->take(2)->join('');
                    @endphp
                    <div
                        class="w-11 h-11 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 font-bold border border-slate-200 dark:border-slate-600">
                        {{ $initials }}
                    </div>
                    @endif
                    <div>
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-100">{{ $santri['nama'] }}</p>
                        <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-tight mt-0.5">
                            <span class="text-success">{{ $santri['hadir'] }} Hadir</span> • {{ $santri['persentase']
                            }}%
                        </p>
                    </div>
                </div>
                <div class="flex gap-1.5">
                    <div class="flex flex-col items-center">
                        <span
                            class="w-7 h-7 flex items-center justify-center {{ $santri['hadir'] > 0 ? 'bg-success text-white shadow-sm shadow-success/30' : 'bg-gray-100 text-gray-300 dark:bg-gray-700 dark:text-gray-600' }} text-[10px] font-bold rounded-lg transition-colors">H</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span
                            class="w-7 h-7 flex items-center justify-center {{ $santri['izin'] > 0 ? 'bg-primary text-white shadow-sm shadow-primary/30' : 'bg-gray-100 text-gray-300 dark:bg-gray-700 dark:text-gray-600' }} text-[10px] font-bold rounded-lg transition-colors">I</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <span
                            class="w-7 h-7 flex items-center justify-center {{ $santri['alpa'] > 0 ? 'bg-danger text-white shadow-sm shadow-danger/30' : 'bg-gray-100 text-gray-300 dark:bg-gray-700 dark:text-gray-600' }} text-[10px] font-bold rounded-lg transition-colors">A</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <span class="material-symbols-outlined text-gray-300 text-6xl mb-2">event_busy</span>
                <p class="text-gray-400 text-sm font-medium">Belum ada data kehadiran bulan ini.</p>
            </div>
            @endforelse
        </div>
    </section>

</body>

</html>
