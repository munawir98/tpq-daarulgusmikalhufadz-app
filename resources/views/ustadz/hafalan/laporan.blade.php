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
    <title>Laporan Hafalan</title>
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
                        <h1 class="text-white text-xl font-bold">Laporan Hafalan</h1>
                        <p class="text-white/70 text-xs">Progress hafalan semua santri</p>
                    </div>
                    <div class="w-10"></div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="px-6 -mt-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                            <span class="text-2xl font-bold text-primary">{{ $summary['total_santri'] }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Santri</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 dark:bg-green-900/30 rounded-xl">
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{
                                $summary['total_setoran'] }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Setoran</p>
                        </div>
                        <div class="text-center p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl">
                            <span class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{
                                number_format($summary['total_ayat']) }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total Ayat</p>
                        </div>
                        <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/30 rounded-xl">
                            <span class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{
                                $summary['avg_percent'] }}%</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Rata-rata</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Santri List -->
            <div class="pt-2">
                <div
                    class="bg-white dark:bg-gray-800 rounded-t-[30px] p-6 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] border-t border-gray-100 dark:border-gray-700 min-h-[60vh]">
                    <!-- Header & Search Row -->
                    <div class="flex items-center justify-between gap-4 mb-3">
                        <h3 class="font-bold text-sm text-gray-900 dark:text-white whitespace-nowrap ml-2">Progres
                            Santri
                        </h3>

                        <!-- Search Bar -->
                        <div class="relative flex-1 mr-2">
                            <span
                                class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                            <input type="text" id="searchInput" placeholder="Cari santri"
                                class="w-full pl-10 pr-10 py-2 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-xs focus:ring-primary focus:border-primary transition-all"
                                onkeyup="filterSantri()">
                            <button id="clearSearchBtn" onclick="clearSearch()"
                                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-rounded text-lg">close</span>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="mb-8">
                        <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                            <button onclick="setFilter('all')" id="filterAll"
                                class="filter-btn active shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-white transition-all">
                                Semua
                            </button>
                            <button onclick="setFilter('green')" id="filterGreen"
                                class="filter-btn shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-green-100 hover:text-green-600 transition-all">
                                Sangat Aktif
                            </button>
                            <button onclick="setFilter('blue')" id="filterBlue"
                                class="filter-btn shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-blue-100 hover:text-blue-600 transition-all">
                                Baik
                            </button>
                            <button onclick="setFilter('orange')" id="filterOrange"
                                class="filter-btn shrink-0 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-orange-100 hover:text-orange-600 transition-all">
                                Perlu Bimbingan
                            </button>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3" id="santriList">
                        @foreach($santriStats as $santri)
                        <div class="santri-card bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700"
                            data-name="{{ strtolower($santri['name']) }}" data-status="{{ $santri['status_color'] }}">
                            <!-- Header Row -->
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold flex-shrink-0">
                                    {{ substr($santri['name'], 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white truncate">{{
                                        $santri['name'] }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Terakhir: {{
                                        $santri['last_surah']
                                        }}</p>
                                </div>
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold flex-shrink-0
                                @if($santri['status_color'] === 'green') bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400
                                @elseif($santri['status_color'] === 'blue') bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($santri['status_color'] === 'orange') bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400
                                @else bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400
                                @endif">
                                    {{ $santri['status_label'] }}
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-2">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-500 dark:text-gray-400">Progress</span>
                                    <span class="font-bold text-primary">{{ $santri['percent'] }}%</span>
                                </div>
                                <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-primary to-[#3D7A9E] rounded-full transition-all duration-500"
                                        style="width: {{ $santri['percent'] }}%"></div>
                                </div>
                            </div>

                            <!-- Stats Row -->
                            <div class="grid grid-cols-4 gap-2 text-center text-xs">
                                @if(isset($santri['surah_progress']) && count($santri['surah_progress']) > 1)
                                <!-- Case: Multiple Surahs (Show List) -->
                                <div
                                    class="col-span-2 p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg flex flex-col justify-center text-left">
                                    <div class="max-h-[60px] overflow-y-auto no-scrollbar space-y-1">
                                        @foreach($santri['surah_progress'] as $prog)
                                        <div
                                            class="flex justify-between items-center text-[10px] leading-tight border-b border-gray-200 dark:border-gray-600 last:border-0 pb-0.5 last:pb-0">
                                            <span class="font-medium truncate max-w-[60px]"
                                                title="{{ $prog['name'] }}">{{
                                                $prog['name'] }}</span>
                                            <span class="text-gray-500 whitespace-nowrap">{{ $prog['hafal'] }}/{{
                                                $prog['total'] }} ({{ $prog['percent'] }}%)</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <!-- Case: Single Surah (Standard) -->
                                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $santri['total_ayat_surah']
                                        }}</span>
                                    <p class="text-gray-500 dark:text-gray-400">Total</p>
                                </div>
                                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $santri['total_ayat']
                                        }}</span>
                                    <p class="text-gray-500 dark:text-gray-400">Hafal</p>
                                </div>
                                @endif
                                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg flex flex-col justify-center">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $santri['total_setoran']
                                        }}</span>
                                    <p class="text-gray-500 dark:text-gray-400">Setoran</p>
                                </div>
                                <div class="p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg flex flex-col justify-center">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $santri['total_pertemuan']
                                        }}</span>
                                    <p class="text-gray-500 dark:text-gray-400">Masuk</p>
                                </div>
                            </div>

                            <!-- Duration Info -->
                            <div class="mt-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="flex items-center justify-between" style="font-size: 10px;">
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-rounded text-blue-500"
                                            style="font-size: 12px;">calendar_today</span>
                                        <span class="text-gray-600 dark:text-gray-300">Mulai: <strong>{{
                                                $santri['first_date'] }}</strong></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-rounded text-blue-500 animate-pulse"
                                            style="font-size: 12px;">timer</span>
                                        <span class="text-gray-600 dark:text-gray-300">Durasi:
                                            <strong class="durasi-counter"
                                                data-first-date="{{ $santri['first_date_raw'] }}">{{ $santri['durasi']
                                                }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Last Activity -->
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <span class="material-symbols-rounded" style="font-size: 14px;">schedule</span>
                                {{ $santri['last_activity'] }}
                            </div>
                        </div>
                        @endforeach

                        @if(count($santriStats) === 0)
                        <div
                            class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-8 text-center border border-gray-100 dark:border-gray-700">
                            <span class="material-symbols-rounded text-gray-300 dark:text-gray-600 mb-3"
                                style="font-size: 48px;">group</span>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada data santri</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let currentFilter = 'all';

        function filterSantri() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.santri-card');

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const status = card.dataset.status || '';

                const matchesSearch = name.includes(searchValue);
                const matchesFilter = currentFilter === 'all' || status === currentFilter;

                if (matchesSearch && matchesFilter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });

            // Toggle Clear Button
            const clearBtn = document.getElementById('clearSearchBtn');
            if (clearBtn) {
                if (searchValue.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            updateEmptyState();
        }

        function clearSearch() {
            const input = document.getElementById('searchInput');
            if (input) {
                input.value = '';
                filterSantri();
                input.focus();
            }
        }

        function setFilter(filter) {
            currentFilter = filter;

            // Update button styles
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-300');
            });

            const activeBtn = document.getElementById('filter' + filter.charAt(0).toUpperCase() + filter.slice(1));
            if (activeBtn) {
                activeBtn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-600', 'dark:text-gray-300');
                activeBtn.classList.add('bg-primary', 'text-white');

                // Scroll into view
                activeBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            filterSantri();
        }

        function updateEmptyState() {
            const cards = document.querySelectorAll('.santri-card');
            let visibleCount = 0;
            cards.forEach(card => {
                if (card.style.display !== 'none') visibleCount++;
            });

            // Show/hide empty state message
            const emptyDiv = document.querySelector('#santriList > div:last-child');
            if (emptyDiv && emptyDiv.classList.contains('bg-gray-50')) {
                emptyDiv.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        // Live Duration Counter
        function updateDurasiCounters() {
            document.querySelectorAll('.durasi-counter').forEach(counter => {
                const firstDate = counter.dataset.firstDate;
                if (!firstDate) return;

                const start = new Date(firstDate);
                const now = new Date();
                const diffMs = now - start;

                // Calculate differences
                const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                const diffWeeks = Math.floor(diffDays / 7);
                const diffMonths = Math.floor(diffDays / 30);
                const diffYears = Math.floor(diffDays / 365);

                let durasi = '';
                if (diffYears >= 1) {
                    const remainingMonths = diffMonths % 12;
                    durasi = diffYears + ' tahun' + (remainingMonths > 0 ? ' ' + remainingMonths + ' bulan' : '');
                } else if (diffMonths >= 1) {
                    const remainingWeeks = Math.floor((diffDays % 30) / 7);
                    durasi = diffMonths + ' bulan' + (remainingWeeks > 0 ? ' ' + remainingWeeks + ' minggu' : '');
                } else if (diffWeeks >= 1) {
                    const remainingDays = diffDays % 7;
                    durasi = diffWeeks + ' minggu' + (remainingDays > 0 ? ' ' + remainingDays + ' hari' : '');
                } else {
                    // Show days, hours, minutes for recent entries
                    const hours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diffMs % (1000 * 60)) / 1000);

                    if (diffDays > 0) {
                        durasi = diffDays + ' hari ' + hours + ' jam';
                    } else if (hours > 0) {
                        durasi = hours + ' jam ' + minutes + ' menit';
                    } else {
                        durasi = minutes + ' menit ' + seconds + ' detik';
                    }
                }

                counter.textContent = durasi;
            });
        }

        // Update every second
        setInterval(updateDurasiCounters, 1000);
        // Initial update
        updateDurasiCounters();
    </script>

</body>

</html>
