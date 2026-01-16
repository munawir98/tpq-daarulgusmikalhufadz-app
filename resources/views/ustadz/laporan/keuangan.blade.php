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
            <h2 class="text-base font-bold leading-tight tracking-tight text-center">Rincian Keuangan</h2>
            <button class="text-primary absolute right-4">
                <span class="material-symbols-outlined text-[22px]">info</span>
            </button>
        </div>
    </header>
    <main class="flex-1 pb-24">
        <section class="px-4 pt-4">
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 ml-1">Periode
                    Laporan</label>
                <form id="periodForm" method="GET">
                    <select name="period" onchange="document.getElementById('periodForm').submit()"
                        class="form-select-custom w-full h-11 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary transition-all">
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
            <button onclick="toggleInfaqModal()"
                class="flex flex-col gap-2 rounded-xl p-5 bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 text-left hover:border-primary/50 transition-colors group relative overflow-hidden">
                <div
                    class="absolute -right-6 -top-6 size-20 bg-primary/5 rounded-full group-hover:scale-110 transition-transform">
                </div>
                <div class="flex items-center gap-2 text-primary relative z-10">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-tight">Infaq
                        Kelas</p>
                    <span
                        class="material-symbols-outlined text-sm ml-auto text-slate-400 group-hover:text-primary transition-colors">open_in_new</span>
                </div>
                <p class="text-lg font-extrabold leading-tight relative z-10">Rp {{ number_format($totalInfaq, 0, ',',
                    '.') }}</p>
            </button>
            <div class="flex flex-col gap-2 rounded-xl p-5 bg-primary shadow-lg shadow-primary/20">
                <div class="flex items-center gap-2 text-white/80">
                    <span class="material-symbols-outlined text-xl">account_balance_wallet</span>
                    <p class="text-xs font-bold uppercase tracking-tight">Total Bisyaroh</p>
                </div>
                <p class="text-white text-lg font-extrabold leading-tight">Rp {{ number_format($totalBisyaroh, 0, ',',
                    '.') }}</p>
            </div>
        </section>
        <section class="mt-2">
            <h3 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest px-5 mb-3">
                Rincian Bisyaroh</h3>
            <div
                class="mx-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm">
                <!-- Gaji per Pertemuan -->
                <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="size-10 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <p class="font-bold text-xs">Gaji per Pertemuan</p>
                            <p class="text-[10px] text-slate-500">Bisyaroh per hari hadir</p>
                        </div>
                    </div>
                    <p class="font-bold text-sm">Rp {{ number_format($gajiPerPertemuan, 0, ',', '.') }}</p>
                </div>

                <!-- Jumlah Kehadiran -->
                <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="size-10 bg-green-50 dark:bg-green-900/30 rounded-full flex items-center justify-center text-green-600">
                            <span class="material-symbols-outlined">event_available</span>
                        </div>
                        <div>
                            <p class="font-bold text-xs">Jumlah Kehadiran</p>
                            <p class="text-[10px] text-slate-500">Periode {{ $fullPeriodName }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-sm text-green-600">{{ $presensiCount }} Hari</p>
                </div>

                <!-- Total Bisyaroh -->
                <div class="flex items-center justify-between p-4 bg-primary/5 dark:bg-primary/10">
                    <div class="flex items-center gap-3">
                        <div class="size-10 bg-primary/20 rounded-full flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">account_balance_wallet</span>
                        </div>
                        <div>
                            <p class="font-bold text-xs text-primary">Total Bisyaroh</p>
                            <p class="text-[10px] text-slate-500">Rp {{ number_format($gajiPerPertemuan, 0, ',', '.') }}
                                × {{ $presensiCount }} hari</p>
                        </div>
                    </div>
                    <p class="font-extrabold text-base text-primary">Rp {{ number_format($totalBisyaroh, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Calendar Section - Data Kehadiran (Collapsible) -->
                <div class="border-t border-slate-100 dark:border-slate-800">
                    <!-- Toggle Header -->
                    <button onclick="toggleKehadiran()"
                        class="w-full p-4 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between hover:bg-slate-100 dark:hover:bg-slate-800/40 transition-colors">
                        <div class="flex items-center gap-2">
                            <h4 class="text-xs font-bold uppercase text-slate-500">Tanggal Kehadiran</h4>
                            <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{
                                $presensiCount }} Hari Hadir</span>
                        </div>
                        <span id="toggleIcon"
                            class="material-symbols-outlined text-slate-400 transition-transform duration-300">expand_more</span>
                    </button>

                    <!-- Collapsible Content -->
                    <div id="kehadiranContent" class="hidden p-4 pt-0 bg-slate-50/50 dark:bg-slate-800/20">
                        @php
                        $daysInMonth = \Carbon\Carbon::createFromDate($year, $month, 1)->daysInMonth;
                        $attendanceMap = [];
                        foreach($presensiDetails as $detail) {
                        $d = \Carbon\Carbon::parse($detail->tanggal)->day;
                        if (!isset($attendanceMap[$d])) $attendanceMap[$d] = [];
                        $attendanceMap[$d][] = [
                        'jam' => $detail->jam,
                        'status' => $detail->status_presensi
                        ];
                        }
                        @endphp

                        <div class="rounded-lg">
                            <div class="grid grid-cols-7 gap-1.5 text-center">
                                <span class="text-[10px] font-bold text-slate-400">Sn</span>
                                <span class="text-[10px] font-bold text-slate-400">Sl</span>
                                <span class="text-[10px] font-bold text-slate-400">Rb</span>
                                <span class="text-[10px] font-bold text-slate-400">Km</span>
                                <span class="text-[10px] font-bold text-slate-400">Jm</span>
                                <span class="text-[10px] font-bold text-slate-400">Sb</span>
                                <span class="text-[10px] font-bold text-slate-400">Mg</span>

                                {{-- Empty slots for start of month --}}
                                @php
                                $firstDayOfWeek = \Carbon\Carbon::createFromDate($year, $month, 1)->dayOfWeekIso;
                                @endphp
                                @for($i = 1; $i < $firstDayOfWeek; $i++) <span></span> @endfor

                                    {{-- Days --}}
                                    @for($day = 1; $day <= $daysInMonth; $day++) @php
                                        $hasData=isset($attendanceMap[$day]); $events=$hasData ? $attendanceMap[$day] :
                                        []; $dataAttr=$hasData ? htmlspecialchars(json_encode($events),
                                        ENT_QUOTES, 'UTF-8' ) : '' ; @endphp <button
                                        onclick="showAttendanceDetail('{{ $day }} {{ $fullPeriodName }}', this.getAttribute('data-events'))"
                                        data-events="{{ $dataAttr }}"
                                        class="aspect-square flex flex-col items-center justify-center rounded-lg text-[10px] font-medium transition-all {{ $hasData ? 'bg-green-500 text-white shadow-sm hover:bg-green-600 active:scale-95' : 'text-slate-400 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700' }}">
                                        {{ $day }}
                                        </button>
                                        @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Spacer untuk bottom padding -->
        <div class="h-8"></div>
    </main>


    <!-- Infaq Modal -->
    <div id="infaqModal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 pointer-events-none"
            id="infaqModalBackdrop"></div>

        <!-- Panel -->
        <div class="fixed inset-x-0 bottom-0 z-10 w-full overflow-hidden bg-white dark:bg-slate-900 rounded-t-3xl shadow-2xl transform transition-all translate-y-full"
            id="infaqModalPanel">
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-bold">Rincian Infaq Kelas</h3>
                    <p class="text-xs text-slate-500">Total: Rp {{ number_format($totalInfaq, 0, ',', '.') }} • {{
                        $santriCount }} Santri</p>
                </div>
                <button onclick="toggleInfaqModal()"
                    class="p-2 bg-slate-50 dark:bg-slate-800 rounded-full text-slate-500 hover:text-slate-700">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="max-h-[60vh] overflow-y-auto p-0">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 sticky top-0 z-10">
                        <tr>
                            <th
                                class="p-4 text-[10px] font-bold text-slate-400 uppercase border-b border-slate-100 dark:border-slate-800">
                                Nama Santri</th>
                            <th
                                class="p-4 text-[10px] font-bold text-slate-400 uppercase text-right border-b border-slate-100 dark:border-slate-800">
                                Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse($infaqList as $infaq)
                        <tr>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-xs">{{ $infaq->nama_santri }}</span>
                                    <span class="text-[10px] text-slate-400 italic">{{
                                        \Carbon\Carbon::parse($infaq->tanggal)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-right font-medium text-xs">Rp {{ number_format($infaq->jumlah, 0, ',',
                                '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="p-4 text-center text-xs text-gray-500 py-10">Belum ada data infaq di
                                periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 safe-area-bottom">
                <button onclick="toggleInfaqModal()"
                    class="w-full py-3 bg-primary text-white font-bold rounded-xl active:scale-[0.98] transition-transform">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function toggleInfaqModal() {
            const modal = document.getElementById('infaqModal');
            const backdrop = document.getElementById('infaqModalBackdrop');
            const panel = document.getElementById('infaqModalPanel');

            if (modal.classList.contains('hidden')) {
                // Open
                modal.classList.remove('hidden');
                // Force reflow
                void modal.offsetWidth;

                // Animate in
                backdrop.classList.remove('opacity-0');
                backdrop.classList.remove('pointer-events-none');
                panel.classList.remove('translate-y-full');
            } else {
                // Close animation
                backdrop.classList.add('opacity-0');
                backdrop.classList.add('pointer-events-none');
                panel.classList.add('translate-y-full');

                // Wait for transition
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        function toggleKehadiran() {
            const content = document.getElementById('kehadiranContent');
            const icon = document.getElementById('toggleIcon');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        function showAttendanceDetail(dateStr, eventsJson) {
            if (!eventsJson) return;

            try {
                const events = JSON.parse(eventsJson);
                let message = "Detail Kehadiran " + dateStr + ":\n";
                events.forEach(e => {
                    message += "- " + e.status + " pada jam " + e.jam + "\n";
                });
                alert(message);
            } catch (e) {
                console.error("Error parsing events", e);
            }
        }
    </script>
</body>


</html>
