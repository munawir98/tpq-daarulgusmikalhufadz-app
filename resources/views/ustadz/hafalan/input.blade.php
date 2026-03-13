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
    <title>Input Setoran Hafalan</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
                        "header-dark": "#2A5A78",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748",
                        "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased text-[#111813] dark:text-white flex justify-center items-start min-h-screen p-0 sm:py-4">
    <div
        class="relative flex h-[100dvh] sm:h-auto sm:min-h-[850px] sm:rounded-[40px] w-full flex-col overflow-x-hidden max-w-[480px] mx-auto bg-background-light dark:bg-background-dark shadow-xl">

        <!-- Header -->
        <div
            class="sticky top-0 z-20 flex items-center bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm p-4 pb-2 justify-center border-b border-gray-100 dark:border-gray-800">
            <h2 class="text-[#111813] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] text-center">
                Input Setoran</h2>
        </div>

        <!-- Form -->
        <form action="{{ route('ustadz.hafalan.store') }}" method="POST"
            class="flex-1 flex flex-col px-4 py-6 gap-6 pb-32">
            @csrf

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="p-4 bg-primary/10 border border-primary/30 rounded-2xl text-primary text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div
                class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-red-600 dark:text-red-400 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Santri Selection with Search -->
            <div class="flex flex-col gap-2">
                <label class="text-[#111813] dark:text-gray-200 text-base font-bold leading-normal">Nama Santri</label>
                <input type="hidden" name="santri_id" id="santriIdInput" required>
                <div class="relative">
                    <input type="text" id="santriSearch" placeholder="Cari nama santri..."
                        class="peer flex w-full h-14 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white placeholder:text-[#61896f] p-[15px] pr-12 text-base font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none"
                        onfocus="showSantriDropdown()" oninput="filterSantri(this.value)" autocomplete="off">
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-[#61896f] pointer-events-none">
                        <span class="material-symbols-outlined" style="font-size: 24px;">search</span>
                    </div>
                    <!-- Dropdown -->
                    <div id="santriDropdown"
                        class="hidden absolute left-0 right-0 top-full mt-1 bg-surface-light dark:bg-surface-dark rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 max-h-48 overflow-y-auto z-40">
                        @isset($santris)
                        @foreach($santris as $santri)
                        <button type="button" onclick="selectSantri({{ $santri->id }}, '{{ $santri->name }}')"
                            class="santri-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-primary/10 transition-colors"
                            data-name="{{ strtolower($santri->name) }}">
                            <div
                                class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">
                                {{ substr($santri->name, 0, 1) }}
                            </div>
                            <span class="text-[#111813] dark:text-white text-sm font-medium flex-1">{{ $santri->name
                                }}</span>
                            @if($santri->last_hafalan)
                            <span class="text-xs text-gray-500">{{ $santri->last_hafalan->surah }} • {{
                                $santri->last_hafalan->ayat_akhir }}</span>
                            @endif
                        </button>
                        @endforeach
                        @endisset
                        <div id="santriEmpty" class="hidden px-4 py-4 text-center text-gray-400 text-sm">Tidak ditemukan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auto-fill Info Banner -->
            <div id="autoFillInfo" class="hidden p-3 bg-primary/10 rounded-xl flex items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-size: 18px;">info</span>
                <span id="autoFillText" class="text-sm text-primary font-medium"></span>
            </div>

            <!-- Materi Hafalan -->
            <div class="flex flex-col gap-4">
                <label class="text-[#111813] dark:text-gray-200 text-base font-bold leading-normal">Materi
                    Hafalan</label>
                <input type="hidden" name="surah" id="surahInput" required>
                <div class="relative">
                    <select id="surahSelect" onchange="selectSurah(this.value)"
                        class="appearance-none flex w-full h-14 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] pr-12 text-base font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none">
                        <option value="">Pilih Surah</option>
                        @php
                        $surahs = [
                        ['no' => 1, 'name' => 'Al-Fatihah', 'ayat' => 7],
                        ['no' => 78, 'name' => 'An-Naba', 'ayat' => 40],
                        ['no' => 79, 'name' => "An-Nazi'at", 'ayat' => 46],
                        ['no' => 80, 'name' => 'Abasa', 'ayat' => 42],
                        ['no' => 81, 'name' => 'At-Takwir', 'ayat' => 29],
                        ['no' => 82, 'name' => 'Al-Infitar', 'ayat' => 19],
                        ['no' => 83, 'name' => 'Al-Mutaffifin', 'ayat' => 36],
                        ['no' => 84, 'name' => 'Al-Insyiqaq', 'ayat' => 25],
                        ['no' => 85, 'name' => 'Al-Buruj', 'ayat' => 22],
                        ['no' => 86, 'name' => 'At-Tariq', 'ayat' => 17],
                        ['no' => 87, 'name' => "Al-A'la", 'ayat' => 19],
                        ['no' => 88, 'name' => 'Al-Ghasyiyah', 'ayat' => 26],
                        ['no' => 89, 'name' => 'Al-Fajr', 'ayat' => 30],
                        ['no' => 90, 'name' => 'Al-Balad', 'ayat' => 20],
                        ['no' => 91, 'name' => 'Asy-Syams', 'ayat' => 15],
                        ['no' => 92, 'name' => 'Al-Lail', 'ayat' => 21],
                        ['no' => 93, 'name' => 'Ad-Dhuha', 'ayat' => 11],
                        ['no' => 94, 'name' => 'Asy-Syarh', 'ayat' => 8],
                        ['no' => 95, 'name' => 'At-Tin', 'ayat' => 8],
                        ['no' => 96, 'name' => 'Al-Alaq', 'ayat' => 19],
                        ['no' => 97, 'name' => 'Al-Qadr', 'ayat' => 5],
                        ['no' => 98, 'name' => 'Al-Bayyinah', 'ayat' => 8],
                        ['no' => 99, 'name' => 'Az-Zalzalah', 'ayat' => 8],
                        ['no' => 100, 'name' => 'Al-Adiyat', 'ayat' => 11],
                        ['no' => 101, 'name' => "Al-Qari'ah", 'ayat' => 11],
                        ['no' => 102, 'name' => 'At-Takasur', 'ayat' => 8],
                        ['no' => 103, 'name' => 'Al-Asr', 'ayat' => 3],
                        ['no' => 104, 'name' => 'Al-Humazah', 'ayat' => 9],
                        ['no' => 105, 'name' => 'Al-Fil', 'ayat' => 5],
                        ['no' => 106, 'name' => 'Quraisy', 'ayat' => 4],
                        ['no' => 107, 'name' => "Al-Ma'un", 'ayat' => 7],
                        ['no' => 108, 'name' => 'Al-Kausar', 'ayat' => 3],
                        ['no' => 109, 'name' => 'Al-Kafirun', 'ayat' => 6],
                        ['no' => 110, 'name' => 'An-Nasr', 'ayat' => 3],
                        ['no' => 111, 'name' => 'Al-Lahab', 'ayat' => 5],
                        ['no' => 112, 'name' => 'Al-Ikhlas', 'ayat' => 4],
                        ['no' => 113, 'name' => 'Al-Falaq', 'ayat' => 5],
                        ['no' => 114, 'name' => 'An-Nas', 'ayat' => 6],
                        ];
                        @endphp
                        @foreach($surahs as $surah)
                        <option value="{{ $surah['name'] }}">{{ $surah['no'] }}. {{ $surah['name'] }} ({{ $surah['ayat']
                            }} ayat)</option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-[#61896f] pointer-events-none">
                        <span class="material-symbols-outlined" style="font-size: 24px;">keyboard_arrow_down</span>
                    </div>
                </div>

                <!-- Ayat Range -->
                <div class="flex gap-4">
                    <div class="flex flex-col flex-1 gap-1">
                        <label class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ayat Mulai</label>
                        <input name="ayat_mulai" type="number" min="1" required placeholder="1"
                            class="flex w-full h-12 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] text-base font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                    <div class="flex flex-col flex-1 gap-1">
                        <label class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ayat Selesai</label>
                        <input name="ayat_selesai" type="number" min="1" required placeholder="10"
                            class="flex w-full h-12 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] text-base font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Quality Evaluation -->
            <div
                class="flex flex-col gap-3 bg-surface-light dark:bg-surface-dark p-5 rounded-2xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700">
                <div class="flex items-center justify-between">
                    <label class="text-[#111813] dark:text-gray-200 text-base font-bold">Kualitas Bacaan</label>
                    <span id="ratingLabel"
                        class="inline-flex items-center rounded-full bg-yellow-50 dark:bg-yellow-900/30 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:text-yellow-300">Belum
                        Dinilai</span>
                </div>
                <input type="hidden" name="nilai" id="nilaiInput" value="0">
                <div class="flex items-center gap-3 pt-1">
                    @for($i = 1; $i <= 5; $i++) <button type="button" onclick="setRating({{ $i }})"
                        class="star-btn text-gray-300 dark:text-gray-600 hover:text-yellow-400 hover:scale-110 transition-all">
                        <span class="material-symbols-outlined" style="font-size: 32px;">star</span>
                        </button>
                        @endfor
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ketuk bintang untuk menilai</p>
            </div>

            <!-- Notes -->
            <div class="flex flex-col gap-2">
                <label class="text-[#111813] dark:text-gray-200 text-base font-bold">Catatan</label>
                <textarea name="catatan" placeholder="Tulis catatan untuk santri (opsional)..."
                    class="flex w-full min-h-[120px] rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] text-base shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none resize-none"></textarea>
            </div>

            <!-- Submit Button -->
            <div
                class="fixed bottom-0 left-0 right-0 p-4 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-t border-gray-100 dark:border-gray-800 z-30 max-w-md mx-auto">
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 h-14 bg-primary hover:bg-green-400 active:scale-[0.98] rounded-full transition-all shadow-lg shadow-primary/20">
                    <span class="text-black text-base font-bold tracking-wide">Simpan Setoran</span>
                    <span class="material-symbols-outlined text-black" style="font-size: 20px;">check_circle</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        // Check for auto-selected santri from Controller
        @if (isset($selectedSantriId) && $selectedSantriId)
            document.addEventListener('DOMContentLoaded', function () {
                const targetId = {{ $selectedSantriId }
            };
        // Iterate over buttons to find the name (inefficient but safe given structure)
        const buttons = document.querySelectorAll('.santri-item');
        for (let btn of buttons) {
            // Parse the onclick attribute or distinct ID approach
            // Easier: just look at onclick string or data attribute if I added one.
            // I'll add data-id to the button first for easier selection.
            if (btn.getAttribute('onclick').includes('selectSantri(' + targetId + ',')) {
                btn.click();
                break;
            }
        }
        });
        @endif

        // Star Rating
        function setRating(rating) {
            document.getElementById('nilaiInput').value = rating;
            const stars = document.querySelectorAll('.star-btn');
            const labels = ['Belum Dinilai', 'Tidak Lancar', 'Kurang Lancar', 'Lancar', 'Sangat Lancar', 'Sempurna'];
            stars.forEach((star, index) => {
                const icon = star.querySelector('.material-symbols-outlined');
                if (index < rating) {
                    star.classList.remove('text-gray-300', 'dark:text-gray-600');
                    star.classList.add('text-yellow-400');
                    icon.style.fontVariationSettings = "'FILL' 1";
                } else {
                    star.classList.add('text-gray-300', 'dark:text-gray-600');
                    star.classList.remove('text-yellow-400');
                    icon.style.fontVariationSettings = "'FILL' 0";
                }
            });
            document.getElementById('ratingLabel').textContent = labels[rating];
        }

        // Santri Dropdown
        function showSantriDropdown() {
            document.getElementById('santriDropdown').classList.remove('hidden');
        }

        function selectSantri(id, name) {
            document.getElementById('santriIdInput').value = id;
            document.getElementById('santriSearch').value = name;
            document.getElementById('santriDropdown').classList.add('hidden');

            // Fetch last hafalan
            fetch('/ustadz/hafalan/last/' + id)
                .then(r => r.json())
                .then(result => {
                    const info = document.getElementById('autoFillInfo');
                    const text = document.getElementById('autoFillText');
                    if (result.success && result.data) {
                        info.classList.remove('hidden');
                        text.textContent = 'Lanjutan dari: ' + result.data.surah + ' ayat ' + result.data.ayat_akhir;
                        document.querySelector('input[name="ayat_mulai"]').value = result.data.ayat_mulai;
                    } else {
                        info.classList.add('hidden');
                    }
                });
        }

        function filterSantri(query) {
            const items = document.querySelectorAll('.santri-item');
            const q = query.toLowerCase();
            let visible = 0;
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(q)) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });
            document.getElementById('santriEmpty').classList.toggle('hidden', visible > 0);
        }

        // Surah Select
        function selectSurah(name) {
            document.getElementById('surahInput').value = name;
        }

        // Form Validation
        document.querySelector('form').addEventListener('submit', function (e) {
            const ayatMulai = parseInt(document.querySelector('input[name="ayat_mulai"]').value) || 0;
            const ayatSelesai = parseInt(document.querySelector('input[name="ayat_selesai"]').value) || 0;

            if (ayatSelesai < ayatMulai) {
                e.preventDefault();
                alert('Ayat Selesai harus >= Ayat Mulai!');
                return;
            }
            if (!document.getElementById('santriIdInput').value) {
                e.preventDefault();
                alert('Pilih santri terlebih dahulu!');
                return;
            }
            if (!document.getElementById('surahInput').value) {
                e.preventDefault();
                alert('Pilih surah terlebih dahulu!');
                return;
            }
            if (document.getElementById('nilaiInput').value < 1) {
                e.preventDefault();
                alert('Beri nilai kualitas bacaan!');
                return;
            }
        });

        // Close dropdown on outside click
        document.addEventListener('click', function (e) {
            const search = document.getElementById('santriSearch');
            const dropdown = document.getElementById('santriDropdown');
            if (!search.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
