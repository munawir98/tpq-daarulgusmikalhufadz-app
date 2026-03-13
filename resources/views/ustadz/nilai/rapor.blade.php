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
    <title>Rapor Santri</title>
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
                        "header-dark": "#2A5A78",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748",
                        "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: { display: ["Poppins", "sans-serif"] },
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
    <div
        class="relative max-w-[434px] mx-auto min-h-screen bg-surface-light dark:bg-surface-dark shadow-2xl overflow-y-auto no-scrollbar pb-8">

        <!-- Header -->
        <div class="bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] pt-12 pb-8 px-6">
            <div class="flex items-center justify-center mb-4">
                <div class="text-center">
                    <h1 class="text-white text-xl font-bold">Rapor Santri</h1>
                    <p class="text-white/70 text-xs">Rekap semua nilai per santri</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 -mt-4 pb-8">
            <!-- Pilih Santri -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg mb-6">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">person_search</span>
                    Pilih Santri
                </h3>

                <form method="GET" action="{{ route('ustadz.nilai.rapor') }}">
                    <div class="flex gap-2">
                        <select name="santri_id"
                            class="flex-1 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary">
                            <option value="">-- Pilih Santri --</option>
                            @foreach($santriList as $santri)
                            <option value="{{ $santri->id }}" {{ $selectedSantri && $selectedSantri->id == $santri->id ?
                                'selected' : '' }}>
                                {{ $santri->user->name ?? $santri->nama ?? 'Unknown' }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-4 py-2 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition">
                            <span class="material-symbols-rounded">search</span>
                        </button>
                    </div>
                </form>
            </div>

            @if($selectedSantri && $raporData)
            <!-- Santri Info -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg mb-6">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($selectedSantri->user->name ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $selectedSantri->user->name ??
                            'Unknown' }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Rapor Penilaian</p>
                    </div>
                </div>

                <!-- Total Average -->
                <div class="p-4 bg-gradient-to-br from-primary/10 to-primary/5 rounded-xl text-center mb-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Nilai Rata-rata</p>
                    <p class="text-4xl font-bold text-primary">{{ $raporData['total_avg'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        @if($raporData['total_avg'] >= 80)
                        <span class="text-green-600">Sangat Baik 🌟</span>
                        @elseif($raporData['total_avg'] >= 60)
                        <span class="text-blue-600">Baik 👍</span>
                        @elseif($raporData['total_avg'] >= 40)
                        <span class="text-amber-600">Cukup 📚</span>
                        @else
                        <span class="text-red-600">Perlu Bimbingan 💪</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Detail Nilai -->
            <div class="space-y-4">
                <!-- Nilai Hafalan -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <span class="material-symbols-rounded text-amber-500">star</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nilai Hafalan</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{
                                $raporData['hafalan']['total_setoran'] }} setoran</p>
                        </div>
                        <div class="ml-auto flex items-center gap-1">
                            <span class="material-symbols-rounded text-amber-400">star</span>
                            <span class="font-bold text-lg text-gray-900 dark:text-white">{{
                                $raporData['hafalan']['avg_rating'] }}</span>
                            <span class="text-xs text-gray-500">/5</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-center">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{
                                $raporData['hafalan']['total_ayat'] }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Total Ayat</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{
                                $raporData['hafalan']['total_setoran'] }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Total Setoran</p>
                        </div>
                    </div>
                </div>

                <!-- Nilai Tajwid -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <span class="material-symbols-rounded text-blue-500">menu_book</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nilai Tajwid</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $raporData['tajwid']['count'] }}
                                penilaian</p>
                        </div>
                        <div
                            class="ml-auto px-4 py-2 rounded-xl {{ $raporData['tajwid']['avg'] >= 80 ? 'bg-green-100 text-green-600' : ($raporData['tajwid']['avg'] >= 60 ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600') }}">
                            <span class="font-bold text-lg">{{ $raporData['tajwid']['avg'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Nilai Akhlak -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <span class="material-symbols-rounded text-green-500">sentiment_satisfied</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white">Nilai Akhlak</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $raporData['akhlak']['count'] }}
                                penilaian</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex justify-center gap-0.5 mb-1">
                                @for($i = 1; $i <= 5; $i++) <span
                                    class="material-symbols-rounded text-xs {{ $i <= $raporData['akhlak']['disiplin'] ? 'text-amber-400' : 'text-gray-300' }}">
                                    star</span>
                                    @endfor
                            </div>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Disiplin</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex justify-center gap-0.5 mb-1">
                                @for($i = 1; $i <= 5; $i++) <span
                                    class="material-symbols-rounded text-xs {{ $i <= $raporData['akhlak']['kerajinan'] ? 'text-amber-400' : 'text-gray-300' }}">
                                    star</span>
                                    @endfor
                            </div>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Kerajinan</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex justify-center gap-0.5 mb-1">
                                @for($i = 1; $i <= 5; $i++) <span
                                    class="material-symbols-rounded text-xs {{ $i <= $raporData['akhlak']['kesopanan'] ? 'text-amber-400' : 'text-gray-300' }}">
                                    star</span>
                                    @endfor
                            </div>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">Kesopanan</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg text-center">
                <span class="material-symbols-rounded text-gray-300 dark:text-gray-600 text-6xl mb-4">description</span>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Pilih santri untuk melihat rapor</p>
            </div>
            @endif
        </div>
    </div>
</body>

</html>
