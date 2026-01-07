<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Presensi</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#4A90B8",
                        "primary-dark": "#2E6B8A",
                        "header-blue": "#3D7A9E",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748",
                        "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="font-display bg-background-light dark:bg-background-dark min-h-screen">

    <!-- Main Container -->
    <div
        class="relative max-w-[434px] mx-auto h-screen overflow-hidden bg-surface-light dark:bg-surface-dark shadow-2xl">

        <!-- Scrollable Content -->
        <div class="h-full overflow-y-auto no-scrollbar pb-8">

            <!-- Header -->
            <div class="bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] pt-12 pb-8 px-6">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('ustadz.dashboard') }}"
                        class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white hover:bg-white/20 transition">
                        <span class="material-symbols-rounded">arrow_back</span>
                    </a>
                    <div class="text-center flex-1">
                        <h1 class="text-white text-xl font-bold">Laporan Presensi</h1>
                        <p class="text-white/70 text-xs">Riwayat kehadiran Anda</p>
                    </div>
                    <div class="w-10"></div>
                </div>
            </div>

            <!-- Status Hari Ini Card -->
            <div class="px-4 -mt-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Status Hari Ini</p>
                            <p class="text-xs font-bold text-gray-900 dark:text-white mt-1">
                                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d M Y') }}
                            </p>
                        </div>
                        @if($jamMasuk && $jamPulang)
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span class="text-xs font-bold text-green-600 dark:text-green-400">Lengkap ✓</span>
                        </div>
                        @elseif($jamMasuk)
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400">Masuk ✓</span>
                        </div>
                        @else
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400">Belum Presensi</span>
                        </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-3 text-center">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase mb-1 font-medium">Jam Masuk
                            </p>
                            <p class="text-xl font-bold text-primary">
                                {{ $jamMasuk ? \Carbon\Carbon::parse($jamMasuk->jam)->format('H:i') : '-- : --' }}
                            </p>
                        </div>
                        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-xl p-3 text-center">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase mb-1 font-medium">Jam
                                Keluar</p>
                            <p class="text-xl font-bold text-orange-500">
                                {{ $jamPulang ? \Carbon\Carbon::parse($jamPulang->jam)->format('H:i') : '-- : --' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Bulanan -->
            <div class="px-4 mb-6">
                <h3 class="font-bold text-xs text-gray-900 dark:text-white mb-4">
                    Statistik Bulan {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('F Y') }}
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-between h-full relative overflow-hidden group">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <p
                                    class="text-[10px] text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">
                                    Hari Hadir</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white leading-none">{{ $totalHadir
                                    }}</p>
                            </div>
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-green-600 shadow-md shadow-green-500/20 flex items-center justify-center shrink-0">
                                <span class="material-symbols-rounded text-white text-base">check_circle</span>
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-4 -right-4 w-20 h-20 bg-green-50 dark:bg-green-900/10 rounded-full blur-2xl z-0 pointer-events-none">
                        </div>
                    </div>

                    <div onclick="openCalendarModal()"
                        class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition flex flex-col justify-between h-full relative overflow-hidden group">
                        <div class="flex justify-between items-start z-10">
                            <div>
                                <p
                                    class="text-[10px] text-gray-500 dark:text-gray-400 font-medium uppercase tracking-wider mb-1">
                                    Total Record</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-white leading-none">{{
                                    $totalHariKerja }}</p>
                            </div>
                            <div
                                class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 shadow-md shadow-blue-500/20 flex items-center justify-center shrink-0">
                                <span class="material-symbols-rounded text-white text-base">calendar_month</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Riwayat Minggu Ini -->
            <!-- Riwayat -->
            <div class="px-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-xs text-gray-900 dark:text-white">
                        Riwayat {{ $range }} Hari Terakhir
                    </h3>
                    <button onclick="openRangeModal()"
                        class="w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <span class="material-symbols-rounded text-gray-500 dark:text-gray-400 text-sm">edit</span>
                    </button>
                </div>

                <div class="flex flex-col gap-3">
                    @forelse($riwayatMingguIni as $tanggal => $records)
                    @php
                    $masuk = $records->where('tipe', 'masuk')->first();
                    $pulang = $records->where('tipe', 'pulang')->first();
                    $isComplete = $masuk && $pulang;
                    $carbonTanggal = \Carbon\Carbon::parse($tanggal);
                    @endphp
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-xl {{ $isComplete ? 'bg-gradient-to-br from-primary to-primary-dark text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }} flex flex-col items-center justify-center">
                                    <span class="text-xs font-bold leading-none">{{ $carbonTanggal->format('d')
                                        }}</span>
                                    <span class="text-[6px] uppercase">{{
                                        $carbonTanggal->locale('id')->translatedFormat('D') }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-[10px] text-gray-900 dark:text-white">
                                        {{ $carbonTanggal->locale('id')->translatedFormat('l') }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400">
                                        {{ $carbonTanggal->locale('id')->translatedFormat('F Y') }}
                                    </p>
                                </div>
                            </div>
                            @if($isComplete)
                            <span
                                class="px-2 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">
                                Lengkap
                            </span>
                            @elseif($masuk)
                            <span
                                class="px-2 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                Masuk
                            </span>
                            @else
                            <span
                                class="px-2 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400">
                                Pulang Only
                            </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-2 flex items-center gap-2">
                                <span class="material-symbols-rounded text-green-500 text-sm">login</span>
                                <div>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Masuk</p>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">
                                        {{ $masuk ? \Carbon\Carbon::parse($masuk->jam)->format('H:i') : '--:--' }}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-2 flex items-center gap-2">
                                <span class="material-symbols-rounded text-orange-500 text-sm">logout</span>
                                <div>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400">Pulang</p>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white">
                                        {{ $pulang ? \Carbon\Carbon::parse($pulang->jam)->format('H:i') : '--:--' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($masuk && $masuk->foto)
                        <div class="mt-3 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-rounded text-sm">photo_camera</span>
                            <span>Foto tersimpan</span>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div
                        class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl py-12 px-6 text-center border border-gray-100 dark:border-gray-700">
                        <span
                            class="material-symbols-rounded text-gray-300 dark:text-gray-600 mb-2 text-3xl">fact_check</span>
                        <p class="text-gray-500 dark:text-gray-400 text-xs text-center">Belum ada riwayat</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Spacer for bottom -->
            <div class="h-8"></div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div id="calendarModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeCalendarModal()"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white dark:bg-gray-800 rounded-t-[30px] p-6 animate-slide-up">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full mx-auto mb-6"></div>

            <div class="flex items-center justify-between mb-6">
                <button onclick="changeMonth(-1)"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <span class="material-symbols-rounded text-gray-600 dark:text-gray-300">chevron_left</span>
                </button>
                <h3 id="calendarMonth" class="text-lg font-bold text-gray-900 dark:text-white capitalize"></h3>
                <button onclick="changeMonth(1)"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <span class="material-symbols-rounded text-gray-600 dark:text-gray-300">chevron_right</span>
                </button>
            </div>

            <!-- Days Header -->
            <div class="grid grid-cols-7 gap-1 mb-2 text-center">
                <div class="text-[10px] font-bold text-gray-400 uppercase">Min</div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Sen</div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Sel</div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Rab</div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Kam</div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Jum</div>
                <div class="text-[10px] font-bold text-gray-400 uppercase">Sab</div>
            </div>

            <!-- Calendar Grid -->
            <div id="calendarGrid" class="grid grid-cols-7 gap-1">
                <!-- Days will be injected here -->
            </div>

            <div class="mt-6 flex gap-4 text-[10px] justify-center">
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-gray-500 dark:text-gray-400">Hadir Lengkap</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <span class="text-gray-500 dark:text-gray-400">Masuk Saja</span>
                </div>
                <!-- <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                    <span class="text-gray-500 dark:text-gray-400">Pulang Saja</span>
                </div> -->
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideUp 0.3s ease-out forwards;
        }
    </style>

    <!-- Range Selection Modal -->
    <div id="rangeModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeRangeModal()"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white dark:bg-gray-800 rounded-t-[30px] p-6 animate-slide-up">
            <div class="w-12 h-1 bg-gray-300 dark:bg-gray-600 rounded-full mx-auto mb-6"></div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 text-center">Pilih Rentang Waktu</h3>

            <div class="grid grid-cols-3 gap-3">
                <button onclick="selectRange(3)"
                    class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">3 Hari</span>
                </button>
                <button onclick="selectRange(7)"
                    class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">7 Hari</span>
                </button>
                <button onclick="selectRange(14)"
                    class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">2 Minggu</span>
                </button>
                <button onclick="selectRange(30)"
                    class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">1 Bulan</span>
                </button>
                <button onclick="selectRange(90)"
                    class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">3 Bulan</span>
                </button>
                <button onclick="selectRange(180)"
                    class="p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">6 Bulan</span>
                </button>
                <button onclick="selectRange(365)"
                    class="col-span-3 p-2 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary dark:hover:text-primary transition border border-transparent hover:border-primary/30">
                    <span class="text-xs font-bold">1 Tahun</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Data Presensi dari Backend
        const presensiData = @json($presensiData);
        // Format: { "2024-01-01": [...records], ... }

        let currentYear = new Date().getFullYear();
        let currentMonth = new Date().getMonth();

        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // --- Range Modal Logic ---
        function openRangeModal() {
            document.getElementById('rangeModal').classList.remove('hidden');
        }

        function closeRangeModal() {
            document.getElementById('rangeModal').classList.add('hidden');
        }

        function selectRange(days) {
            const url = new URL(window.location.href);
            url.searchParams.set('range', days);
            window.location.href = url.toString();
        }

        // --- Calendar Modal Logic ---
        function openCalendarModal() {
            document.getElementById('calendarModal').classList.remove('hidden');
            renderCalendar(currentYear, currentMonth);
        }

        function closeCalendarModal() {
            document.getElementById('calendarModal').classList.add('hidden');
        }

        function changeMonth(step) {
            currentMonth += step;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            } else if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentYear, currentMonth);
        }

        function renderCalendar(year, month) {
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const grid = document.getElementById('calendarGrid');
            const montHeader = document.getElementById('calendarMonth');

            montHeader.textContent = `${monthNames[month]} ${year}`;
            grid.innerHTML = '';

            // Empty slots for days before start
            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                grid.appendChild(empty);
            }

            // Days
            for (let day = 1; day <= daysInMonth; day++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const el = document.createElement('div');

                // Base styles
                el.className = 'aspect-square rounded-full flex items-center justify-center text-xs font-medium text-gray-700 dark:text-gray-300 relative';
                el.textContent = day;

                // Check attendance
                if (presensiData[dateStr]) {
                    const records = presensiData[dateStr];
                    const hasMasuk = records.some(r => r.tipe === 'masuk');
                    const hasPulang = records.some(r => r.tipe === 'pulang');

                    if (hasMasuk && hasPulang) {
                        el.classList.add('bg-green-100', 'text-green-600', 'font-bold', 'dark:bg-green-900/40', 'dark:text-green-400');
                    } else if (hasMasuk) {
                        el.classList.add('bg-blue-100', 'text-blue-600', 'font-bold', 'dark:bg-blue-900/40', 'dark:text-blue-400');
                    } else if (hasPulang) {
                        el.classList.add('bg-orange-100', 'text-orange-600', 'font-bold', 'dark:bg-orange-900/40', 'dark:text-orange-400');
                    }
                }

                // Highlight Today
                const today = new Date();
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    el.classList.add('border-2', 'border-primary');
                }

                grid.appendChild(el);
            }
        }
    </script>
</body>

</html>
