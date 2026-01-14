<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Rincian Keuangan</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
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
        body {
    font-family: "Poppins", sans-serif;
    -webkit-tap-highlight-color: transparent;
    min-height: max(884px, 100dvh)
    }
.form-select-custom {
    background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuDTeTWcBltFphsW3UWBg1-Mai21IXipLIgj83lpY7blE2tgKibXhwBk9eTeeizBJE1tvuL5jHeJq7GCFfwXwkNwppH__u5n1x1xjQgKr1zTOUBXffdQ9WwwkHquDhmbOdc-nccbXZ-Dmlxf9RTi8YtCgP7UCgw3VfdLfgarVCnXcrn4uDs5AaH1N-BWV3M_m7_pPd6MdMJHmqPZIe-UlYWghrke45u76C62rTNzJxUrQcRYZpW7h0O5tx38jW7KKp63sA2W1ZkM_bBf);
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none
    }
</style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-100 min-h-screen flex flex-col">
    <header
        class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center px-4 h-14 relative justify-center">
            <h2 class="text-lg font-bold leading-tight tracking-tight text-center">Rincian Keuangan</h2>
            <button class="text-primary absolute right-4">
                <span class="material-symbols-outlined text-[22px]">info</span>
            </button>
        </div>
    </header>
    <main class="flex-1 pb-24">
        <section class="px-4 pt-4">
            <div class="w-full">
                <label class="block text-sm font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1">Periode
                    Laporan</label>
                <form id="periodForm" method="GET">
                    <select name="period" onchange="document.getElementById('periodForm').submit()"
                        class="form-select-custom w-full h-12 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-base font-medium focus:ring-2 focus:ring-primary focus:border-primary transition-all">
                        @foreach($periods as $p)
                        <option value="{{ $p['value'] }}" {{ $selectedPeriod==$p['value'] ? 'selected' : '' }}>
                            {{ $p['label'] }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </section>
        <section class="p-4 grid grid-cols-2 gap-4">
            <div
                class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tight">Infaq
                        Kelas</p>
                </div>
                <p class="text-xl font-extrabold leading-tight">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</p>
            </div>
            <div class="flex flex-col gap-2 rounded-xl p-5 bg-primary shadow-lg shadow-primary/20">
                <div class="flex items-center gap-2 text-white/80">
                    <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                    <p class="text-xs font-bold uppercase tracking-tight">Total Bisyaroh</p>
                </div>
                <p class="text-white text-xl font-extrabold leading-tight">Rp {{ number_format($totalBisyaroh, 0, ',',
                    '.') }}</p>
            </div>
        </section>
        <section class="mt-2">
            <h3 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest px-5 mb-3">
                Rincian Bisyaroh</h3>
            <div
                class="mx-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
                <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="size-10 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Bisyaroh Pokok</p>
                            <p class="text-xs text-slate-500">Gaji bulanan tetap</p>
                        </div>
                    </div>
                    <p class="font-bold">Rp {{ number_format($bisyarohPokok, 0, ',', '.') }}</p>
                </div>

                <!-- Calendar Section -->
                <div class="p-4 bg-slate-50/50 dark:bg-slate-800/20">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold uppercase text-slate-500">Data Kehadiran</h4>
                        <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{
                            $presensiCount }} Hari Hadir</span>
                    </div>

                    @php
                    $daysInMonth = \Carbon\Carbon::createFromDate($year, $month)->daysInMonth;
                    $attendanceMap = [];
                    foreach($presensiDetails as $detail) {
                    // Extract day from date
                    $d = \Carbon\Carbon::parse($detail->tanggal)->day;
                    $attendanceMap[$d] = true;
                    }
                    @endphp

                    <div class="grid grid-cols-7 gap-2 text-center">
                        <span class="text-[10px] font-bold text-slate-400">Sn</span>
                        <span class="text-[10px] font-bold text-slate-400">Sl</span>
                        <span class="text-[10px] font-bold text-slate-400">Rb</span>
                        <span class="text-[10px] font-bold text-slate-400">Km</span>
                        <span class="text-[10px] font-bold text-slate-400">Jm</span>
                        <span class="text-[10px] font-bold text-slate-400">Sb</span>
                        <span class="text-[10px] font-bold text-slate-400">Mg</span>

                        {{-- Empty slots for start of month --}}
                        {{-- Fixed calendar comment issue --}}
                        @php
                        $firstDayOfWeek = \Carbon\Carbon::createFromDate($year, $month, 1)->dayOfWeekIso; // 1 (Mon) - 7
                        (Sun)
                        @endphp
                        @for($i = 1; $i < $firstDayOfWeek; $i++) <span></span>
                            @endfor

                            {{-- Days --}}
                            @for($day = 1; $day <= $daysInMonth; $day++) @php $isPresent=isset($attendanceMap[$day]);
                                @endphp <div
                                class="aspect-square flex flex-col items-center justify-center rounded-lg text-xs font-medium {{ $isPresent ? 'bg-green-500 text-white shadow-sm' : 'text-slate-500 bg-white border border-slate-100' }}">
                                {{ $day }}
                    </div>
                    @endfor
                </div>
            </div>
            </div>
        </section>
        <section class="mt-6 px-4">
            <div class="flex items-center justify-between mb-3 px-1">
                <h3 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest">Infaq Santri
                    di Kelas Saya</h3>
                <span class="text-[10px] font-bold text-primary px-2 py-0.5 bg-primary/10 rounded-full">{{ $santriCount
                    }} Santri</span>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <div class="overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th class="p-4 text-[10px] font-bold text-slate-400 uppercase">Nama Santri</th>
                                <th class="p-4 text-[10px] font-bold text-slate-400 uppercase text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @forelse($infaqList as $infaq)
                            <tr>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-sm">{{ $infaq->nama_santri }}</span>
                                        <span class="text-[10px] text-slate-400 italic">{{
                                            \Carbon\Carbon::parse($infaq->tanggal)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-right font-medium text-sm">Rp {{ number_format($infaq->jumlah, 0,
                                    ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="p-4 text-center text-sm text-gray-500">Belum ada data infaq di
                                    periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <button
                    class="w-full py-4 text-sm font-bold text-primary border-t border-slate-50 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    Lihat Semua Rincian Infaq ({{ $santriCount }})
                </button>
            </div>
        </section>
    </main>
    <div
        class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg border-t border-slate-200 dark:border-slate-800">
        <button
            class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-primary/20 active:scale-[0.98] transition-all">
            <span class="material-symbols-outlined">picture_as_pdf</span>
            Unduh Slip Gaji (PDF)
        </button>
    </div>

</body>

</html>
