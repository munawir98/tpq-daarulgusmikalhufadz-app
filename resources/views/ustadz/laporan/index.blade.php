<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Screen</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"
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
                        primary: "#3498db",
                        "ocean-dark": "#2980b9",
                        "ocean-light": "#5dade2",
                        "background-light": "#f0f4f8",
                        "background-dark": "#111827",
                        "card-light": "#ffffff",
                        "card-dark": "#1f2937",
                        "orange-accent": "#f39c12",
                        "green-accent": "#2ecc71",
                    },
                    fontFamily: {
                        sans: ["Poppins", "sans-serif"],
                        display: ["Poppins", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                        'xl': '1rem',
                        '2xl': '1.5rem',
                        '3xl': '2rem',
                    },
                    backgroundImage: {
                        'header-pattern': "repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.05) 10px, rgba(255,255,255,0.05) 20px)",
                    }
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark h-screen w-full flex flex-col font-sans text-gray-800 dark:text-gray-100 selection:bg-primary selection:text-white overflow-hidden">

    <!-- Fixed Header Gradient -->
    <div class="bg-gradient-to-br from-[#3b82f6] to-[#2563eb] dark:from-blue-900 dark:to-blue-950 relative shrink-0">
        <div class="absolute inset-0 bg-header-pattern pointer-events-none"></div>
        <div class="relative z-10 pt-12 pb-14 px-6">
            <div class="flex items-center gap-4 mb-2">
                <button
                    class="bg-white/20 hover:bg-white/30 p-2 rounded-full backdrop-blur-sm text-white transition-colors"
                    onclick="history.back()">
                    <span class="material-icons-round">arrow_back</span>
                </button>
                <div class="text-white">
                    <h1 class="text-xl font-bold leading-tight">Laporan</h1>
                    <p class="text-xs opacity-75 mt-0.5">Pusat Data &amp; Statistik TPQ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card Content (Flex Column) -->
    <div
        class="flex-1 bg-card-light dark:bg-card-dark rounded-t-[2.5rem] -mt-8 relative z-20 flex flex-col overflow-hidden shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">

        <!-- Fixed Filter Section -->
        <div class="px-6 pt-6 pb-2 shrink-0 bg-card-light dark:bg-card-dark rounded-t-[2.5rem] z-30">
            <!-- Search Input -->
            <div class="relative mb-4">
                <input id="searchInput"
                    class="w-full bg-gray-50 dark:bg-gray-800 border-none text-sm rounded-2xl py-3.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/50 shadow-sm placeholder-gray-400 text-gray-700 dark:text-gray-200 transition-shadow"
                    placeholder="Cari jenis laporan..." type="text" />
                <span class="material-icons-round absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <button id="toggleFilterBtn"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 bg-white dark:bg-gray-700 rounded-lg shadow-sm text-gray-500 hover:text-blue-500 transition-colors">
                    <span class="material-icons-round text-lg">tune</span>
                </button>
            </div>
            <!-- Filters -->
            <div class="hidden flex gap-2 overflow-x-auto scrollbar-hide pb-2" id="filterContainer">
                <button data-filter="all"
                    class="filter-btn active px-4 py-2 bg-blue-600 text-white rounded-full text-xs font-semibold shadow-md shadow-blue-500/30 whitespace-nowrap transition-all hover:bg-blue-700">Semua</button>
                <button data-filter="harian"
                    class="filter-btn px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-700 dark:hover:text-blue-400 transition-all">Harian</button>
                <button data-filter="bulanan"
                    class="filter-btn px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-700 dark:hover:text-blue-400 transition-all">Bulanan</button>
                <button data-filter="semester"
                    class="filter-btn px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-700 dark:hover:text-blue-400 transition-all">Semester</button>
            </div>
        </div>

        <!-- Scrollable Report List -->
        <div class="flex-1 overflow-y-auto px-6 pt-2 pb-24" id="reportList">
            <div class="space-y-4">
                <a class="report-item group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                    href="{{ route('ustadz.presensi') }}" data-category="harian bulanan"
                    data-title="Laporan Kehadiran Santri">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-icons-round text-2xl">fact_check</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Kehadiran Santri</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Rekap absensi harian &amp;
                                bulanan</p>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-teal-500 group-hover:bg-teal-50 dark:group-hover:bg-teal-900/20 transition-colors">
                            <span class="material-icons-round text-lg">chevron_right</span>
                        </div>
                    </div>
                </a>
                <a class="report-item group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                    href="{{ route('ustadz.hafalan.laporan') }}" data-category="harian bulanan"
                    data-title="Laporan Setoran Hafalan">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-icons-round text-2xl">menu_book</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Setoran Hafalan</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Progress tahfidz dan iqra</p>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-indigo-500 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/20 transition-colors">
                            <span class="material-icons-round text-lg">chevron_right</span>
                        </div>
                    </div>
                </a>
                <a class="report-item group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                    href="{{ route('ustadz.nilai.index') }}" data-category="semester" data-title="Laporan Nilai Santri">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-icons-round text-2xl">grade</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Nilai Santri</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Hasil ujian dan evaluasi</p>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-orange-500 group-hover:bg-orange-50 dark:group-hover:bg-orange-900/20 transition-colors">
                            <span class="material-icons-round text-lg">chevron_right</span>
                        </div>
                    </div>
                </a>
                <a class="report-item group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                    href="#" data-category="bulanan semester" data-title="Laporan Keuangan">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-icons-round text-2xl">account_balance_wallet</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Keuangan</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">SPP, Infaq dan tabungan</p>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-green-500 group-hover:bg-green-50 dark:group-hover:bg-green-900/20 transition-colors">
                            <span class="material-icons-round text-lg">chevron_right</span>
                        </div>
                    </div>
                </a>
                <a class="report-item group block bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all duration-200"
                    href="#" data-category="harian bulanan" data-title="Laporan Kegiatan">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <span class="material-icons-round text-2xl">event_note</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm">Laporan Kegiatan</h3>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Jurnal aktivitas &amp;
                                ekstrakurikuler</p>
                        </div>
                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 group-hover:text-purple-500 group-hover:bg-purple-50 dark:group-hover:bg-purple-900/20 transition-colors">
                            <span class="material-icons-round text-lg">chevron_right</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Logic Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const reportItems = document.querySelectorAll('.report-item');
            const toggleFilterBtn = document.getElementById('toggleFilterBtn');
            const filterContainer = document.getElementById('filterContainer');

            // Toggle Filter Container
            toggleFilterBtn.addEventListener('click', function () {
                filterContainer.classList.toggle('hidden');

                // Visual feedback for active state
                if (!filterContainer.classList.contains('hidden')) {
                    this.classList.add('text-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                    this.classList.remove('text-gray-500', 'bg-white', 'dark:bg-gray-700');
                } else {
                    this.classList.remove('text-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                    this.classList.add('text-gray-500', 'bg-white', 'dark:bg-gray-700');
                }
            });

            let currentFilter = 'all';
            let currentSearch = '';

            // Filter Buttons Logic
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Update Active State
                    filterBtns.forEach(b => {
                        // Reset to inactive styles with hover
                        b.className = 'filter-btn px-4 py-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 rounded-full text-xs font-medium whitespace-nowrap hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-gray-700 dark:hover:text-blue-400 transition-all';
                    });

                    // Set active styles
                    this.className = 'filter-btn active px-4 py-2 bg-blue-600 text-white rounded-full text-xs font-semibold shadow-md shadow-blue-500/30 whitespace-nowrap transition-all hover:bg-blue-700';

                    // Scroll into view
                    this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

                    currentFilter = this.getAttribute('data-filter');
                    filterReports();
                });
            });

            // Search Logic
            searchInput.addEventListener('input', function (e) {
                currentSearch = e.target.value.toLowerCase();
                filterReports();
            });

            function filterReports() {
                reportItems.forEach(item => {
                    const title = item.getAttribute('data-title').toLowerCase();
                    const categories = item.getAttribute('data-category');

                    const matchesSearch = title.includes(currentSearch);
                    const matchesFilter = currentFilter === 'all' || categories.includes(currentFilter);

                    if (matchesSearch && matchesFilter) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
