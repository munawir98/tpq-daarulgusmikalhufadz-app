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
    <title>Nilai Hafalan</title>
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
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
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
                    <h1 class="text-white text-xl font-bold">Nilai Hafalan</h1>
                    <p class="text-white/70 text-xs">Rekap rating setoran santri</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 -mt-4 pb-8">
            <!-- Summary Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg mb-6">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4">Rekap Nilai Hafalan</h3>

                <div class="flex flex-col gap-3">
                    @forelse($santriList as $santri)
                    <a href="{{ route('ustadz.nilai.hafalan', ['santri_id' => $santri['id']]) }}"
                        class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition {{ $selectedSantri && $selectedSantri->id == $santri['id'] ? 'ring-2 ring-primary' : '' }}">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                            {{ substr($santri['name'], 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">{{ $santri['name']
                                }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $santri['total_setoran'] }} setoran •
                                {{ $santri['total_ayat'] }} ayat</p>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-rounded text-amber-400 text-lg">star</span>
                            <span class="font-bold text-sm text-gray-900 dark:text-white">{{ $santri['avg_rating']
                                }}</span>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-8">
                        <span
                            class="material-symbols-rounded text-gray-300 dark:text-gray-600 text-5xl mb-2">school</span>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada data santri</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Detail Santri -->
            @if($selectedSantri)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <div
                        class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                        {{ substr($selectedSantri->user->name ?? 'S', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $selectedSantri->user->name ?? 'Unknown'
                            }}</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Detail setoran hafalan</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    @forelse($hafalanDetail as $hafalan)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $hafalan->surah }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ayat {{ $hafalan->ayat_awal }} - {{
                                    $hafalan->ayat_akhir }}</p>
                            </div>
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++) <span
                                    class="material-symbols-rounded text-sm {{ $i <= $hafalan->nilai ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }}">
                                    star</span>
                                    @endfor
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500">
                            {{ $hafalan->tanggal ?
                            \Carbon\Carbon::parse($hafalan->tanggal)->locale('id')->translatedFormat('d F Y') : '-' }}
                        </p>
                        @if($hafalan->catatan)
                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-2 italic">"{{ $hafalan->catatan }}"</p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada setoran</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
</body>

</html>
