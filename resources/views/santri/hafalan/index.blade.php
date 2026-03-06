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
    <title>Riwayat Hafalan</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a2e22",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .filter-scroll {
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            overscroll-behavior-x: contain;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display min-h-screen relative flex flex-col text-[#111813] dark:text-gray-100">

    <!-- Top App Bar -->
    <div
        class="sticky top-0 z-50 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm p-4 pb-2 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between max-w-md mx-auto">
            <h2
                class="text-[#111813] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">
                Riwayat Hafalan
            </h2>
            <div class="flex w-10 items-center justify-end">
                <a href="{{ route('profile.index') }}"
                    class="flex size-9 items-center justify-center overflow-hidden rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark">
                    @if(session('user.foto'))
                    <img alt="Foto Profil" class="w-full h-full object-cover"
                        src="{{ Str::startsWith(session('user.foto'), 'data:') ? session('user.foto') : asset('storage/' . session('user.foto')) }}" />
                    @else
                    <div
                        class="w-full h-full flex items-center justify-center bg-primary/20 text-primary font-bold text-xs">
                        {{ substr(session('user.name', 'S'), 0, 1) }}
                    </div>
                    @endif
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 flex flex-col">
        <!-- Search Bar -->
        <div class="max-w-md mx-auto w-full px-4 py-3">
            <div class="flex w-full items-stretch rounded-xl h-12 shadow-sm">
                <div
                    class="text-[#61896f] dark:text-[#8baea0] flex bg-surface-light dark:bg-surface-dark items-center justify-center pl-4 rounded-l-xl">
                    <span class="material-symbols-outlined" style="font-size: 22px;">search</span>
                </div>
                <input id="searchInput" oninput="filterHafalan()"
                    class="flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl rounded-l-none text-[#111813] dark:text-white focus:outline-0 focus:ring-0 border-none bg-surface-light dark:bg-surface-dark placeholder:text-[#61896f] dark:placeholder:text-[#607d6e] px-4 pl-2 text-base font-normal"
                    placeholder="Cari surah atau ayat..." />
            </div>
        </div>

        <!-- Filter Chips - 4 Options Grid -->
        <div class="max-w-md mx-auto w-full px-4 py-2">
            <div class="grid grid-cols-4 gap-2">
                <button onclick="setFilter('all')" id="filterAll"
                    class="filter-btn flex h-8 items-center justify-center rounded-full bg-primary text-[#111813] text-xs font-bold">
                    Semua
                </button>
                <button onclick="setFilter('sempurna')" id="filterSempurna"
                    class="filter-btn flex h-8 items-center justify-center rounded-full bg-surface-light dark:bg-surface-dark border border-gray-100 dark:border-gray-700 text-xs font-medium text-[#111813] dark:text-gray-300">
                    Sempurna
                </button>
                <button onclick="setFilter('lancar')" id="filterLancar"
                    class="filter-btn flex h-8 items-center justify-center rounded-full bg-surface-light dark:bg-surface-dark border border-gray-100 dark:border-gray-700 text-xs font-medium text-[#111813] dark:text-gray-300">
                    Lancar
                </button>
                <button onclick="setFilter('kurang')" id="filterKurang"
                    class="filter-btn flex h-8 items-center justify-center rounded-full bg-surface-light dark:bg-surface-dark border border-gray-100 dark:border-gray-700 text-xs font-medium text-[#111813] dark:text-gray-300">
                    Lainnya
                </button>
            </div>
        </div>

        <!-- History List -->
        <div class="max-w-md mx-auto w-full">
            <div class="flex flex-col gap-3 p-4 pb-8" id="hafalanList">
                @if(isset($hafalans) && $hafalans->count() > 0)
                @foreach($hafalans as $hafalan)
                <div class="hafalan-card flex flex-col gap-3 bg-surface-light dark:bg-surface-dark p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800"
                    data-surah="{{ strtolower($hafalan->surah) }}" data-nilai="{{ strtolower($hafalan->nilai) }}">
                    <div class="flex items-center gap-3">
                        <div class="relative shrink-0 size-11 rounded-full overflow-hidden
                        @if($hafalan->nilai == 'Sempurna') bg-green-100 dark:bg-green-900/30
                        @elseif($hafalan->nilai == 'Sangat Lancar') bg-blue-100 dark:bg-blue-900/30
                        @elseif($hafalan->nilai == 'Lancar') bg-yellow-100 dark:bg-yellow-900/30
                        @elseif($hafalan->nilai == 'Kurang Lancar') bg-orange-100 dark:bg-orange-900/30
                        @else bg-red-100 dark:bg-red-900/30
                        @endif flex items-center justify-center">
                            <span class="material-symbols-outlined
                            @if($hafalan->nilai == 'Sempurna') text-green-600 dark:text-green-400
                            @elseif($hafalan->nilai == 'Sangat Lancar') text-blue-600 dark:text-blue-400
                            @elseif($hafalan->nilai == 'Lancar') text-yellow-600 dark:text-yellow-400
                            @elseif($hafalan->nilai == 'Kurang Lancar') text-orange-600 dark:text-orange-400
                            @else text-red-600 dark:text-red-400
                            @endif" style="font-size: 22px;">menu_book</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[#111813] dark:text-white text-sm font-bold leading-normal truncate">
                                {{ $hafalan->surah }}: Ayat {{ $hafalan->ayat_awal }}-{{ $hafalan->ayat_akhir }}
                            </p>
                            <p class="text-[#61896f] dark:text-gray-400 text-xs font-medium">
                                {{ $hafalan->created_at->locale('id')->translatedFormat('D, d M Y • H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Rating Stars -->
                    <div class="flex items-center gap-2">
                        <div class="flex gap-0.5">
                            @php
                            $stars = match($hafalan->nilai) {
                            'Sempurna' => 5,
                            'Sangat Lancar' => 4,
                            'Lancar' => 3,
                            'Kurang Lancar' => 2,
                            default => 1
                            };
                            @endphp
                            @for($i = 1; $i <= 5; $i++) <span
                                class="material-symbols-outlined {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                style="font-variation-settings: 'FILL' {{ $i <= $stars ? 1 : 0 }}; font-size: 18px;">
                                star</span>
                                @endfor
                        </div>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full
                        @if($hafalan->nilai == 'Sempurna') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300
                        @elseif($hafalan->nilai == 'Sangat Lancar') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300
                        @elseif($hafalan->nilai == 'Lancar') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300
                        @elseif($hafalan->nilai == 'Kurang Lancar') bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300
                        @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300
                        @endif">{{ $hafalan->nilai }}</span>
                    </div>

                    <!-- Ustadz Note -->
                    @if($hafalan->catatan)
                    <div class="bg-background-light dark:bg-background-dark p-3 rounded-lg">
                        <p class="text-[#111813] dark:text-gray-200 text-sm leading-relaxed">
                            <span
                                class="font-bold text-[10px] text-[#61896f] dark:text-gray-500 uppercase tracking-wide block mb-1">
                                Catatan {{ $hafalan->ustadz->name ?? 'Ustadz' }}
                            </span>
                            "{{ $hafalan->catatan }}"
                        </p>
                    </div>
                    @endif
                </div>
                @endforeach
                @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 mb-3"
                        style="font-size: 64px;">menu_book</span>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada riwayat hafalan</p>
                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Mulai setoran hafalan pertamamu!</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        let currentFilter = 'all';

        // Normalize text for flexible search (removes -, ', spaces AND collapses double letters)
        function normalizeText(text) {
            return text.toLowerCase()
                .replace(/[-'`\s]/g, '')
                .replace(/(.)\1+/g, '$1');
        }

        function setFilter(filter) {
            currentFilter = filter;

            // Update button styles
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-[#111813]', 'font-bold');
                btn.classList.add('bg-surface-light', 'dark:bg-surface-dark', 'border', 'border-gray-100', 'dark:border-gray-700', 'font-medium', 'text-[#111813]', 'dark:text-gray-300');
            });

            // Map filter to button ID
            const filterIdMap = {
                'all': 'filterAll',
                'sempurna': 'filterSempurna',
                'lancar': 'filterLancar',
                'kurang': 'filterKurang'
            };

            const activeBtn = document.getElementById(filterIdMap[filter] || 'filterAll');
            if (activeBtn) {
                activeBtn.classList.remove('bg-surface-light', 'dark:bg-surface-dark', 'border', 'border-gray-100', 'dark:border-gray-700', 'font-medium');
                activeBtn.classList.add('bg-primary', 'text-[#111813]', 'font-bold');
            }

            filterHafalan();
        }

        function filterHafalan() {
            const searchQuery = normalizeText(document.getElementById('searchInput').value);
            const cards = document.querySelectorAll('.hafalan-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const surah = normalizeText(card.dataset.surah);
                const nilai = card.dataset.nilai.toLowerCase();

                let matchFilter = false;
                if (currentFilter === 'all') {
                    matchFilter = true;
                } else if (currentFilter === 'kurang') {
                    // Lainnya = Sangat Lancar, Kurang Lancar, Tidak Lancar
                    matchFilter = nilai.includes('sangat') || nilai.includes('kurang') || nilai.includes('tidak');
                } else {
                    matchFilter = nilai.includes(currentFilter);
                }
                let matchSearch = surah.includes(searchQuery);

                if (matchFilter && matchSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide empty state
            let emptyState = document.getElementById('emptySearchState');
            if (!emptyState) {
                emptyState = document.createElement('div');
                emptyState.id = 'emptySearchState';
                emptyState.className = 'flex flex-col items-center justify-center py-8 text-center';
                emptyState.innerHTML = '<span class="material-symbols-outlined text-gray-300 dark:text-gray-600 mb-2" style="font-size: 48px;">search_off</span><p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ditemukan</p>';
                document.getElementById('hafalanList').appendChild(emptyState);
            }
            emptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
        }
    </script>
</body>

</html>
