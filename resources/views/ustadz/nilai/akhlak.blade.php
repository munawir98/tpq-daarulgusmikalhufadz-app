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
    <title>Nilai Akhlak</title>
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
                    <h1 class="text-white text-xl font-bold">Nilai Akhlak</h1>
                    <p class="text-white/70 text-xs">Penilaian perilaku & adab santri</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 -mt-4 pb-8">
            <!-- Success Message -->
            @if(session('success'))
            <div
                class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 rounded-xl border border-green-200 dark:border-green-800">
                <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Form Input -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg mb-6">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="material-symbols-rounded text-primary">add_circle</span>
                    Input Nilai Akhlak
                </h3>

                <form action="{{ route('ustadz.nilai.akhlak.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih
                            Santri</label>
                        <select name="santri_id" required
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary">
                            <option value="">-- Pilih Santri --</option>
                            @foreach($santriList as $santri)
                            <option value="{{ $santri->id }}">{{ $santri->user->name ?? $santri->nama ?? 'Unknown' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rating Stars for each category -->
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Disiplin -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <label
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-3">Disiplin</label>
                            <div class="flex gap-2" id="disiplinStars">
                                @for($i = 1; $i <= 5; $i++) <label class="cursor-pointer">
                                    <input type="radio" name="disiplin" value="{{ $i }}" class="hidden" required>
                                    <span
                                        class="material-symbols-rounded text-2xl text-gray-300 dark:text-gray-600 hover:text-amber-400 transition star-icon"
                                        data-value="{{ $i }}">star</span>
                                    </label>
                                    @endfor
                            </div>
                        </div>

                        <!-- Kerajinan -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <label
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-3">Kerajinan</label>
                            <div class="flex gap-2" id="kerajinanStars">
                                @for($i = 1; $i <= 5; $i++) <label class="cursor-pointer">
                                    <input type="radio" name="kerajinan" value="{{ $i }}" class="hidden" required>
                                    <span
                                        class="material-symbols-rounded text-2xl text-gray-300 dark:text-gray-600 hover:text-amber-400 transition star-icon"
                                        data-value="{{ $i }}">star</span>
                                    </label>
                                    @endfor
                            </div>
                        </div>

                        <!-- Kesopanan -->
                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                            <label
                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-3">Kesopanan</label>
                            <div class="flex gap-2" id="kesopananStars">
                                @for($i = 1; $i <= 5; $i++) <label class="cursor-pointer">
                                    <input type="radio" name="kesopanan" value="{{ $i }}" class="hidden" required>
                                    <span
                                        class="material-symbols-rounded text-2xl text-gray-300 dark:text-gray-600 hover:text-amber-400 transition star-icon"
                                        data-value="{{ $i }}">star</span>
                                    </label>
                                    @endfor
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan
                            (opsional)</label>
                        <textarea name="catatan" rows="2"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-700 text-sm focus:ring-primary focus:border-primary"
                            placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition flex items-center justify-center gap-2">
                        <span class="material-symbols-rounded">save</span>
                        Simpan Nilai
                    </button>
                </form>
            </div>

            <!-- Riwayat Nilai -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg">
                <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-4">Riwayat Nilai Akhlak</h3>

                <div class="flex flex-col gap-3">
                    @forelse($nilaiAkhlak as $nilai)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-semibold text-sm text-gray-900 dark:text-white">
                                    {{ $nilai->santri->user->name ?? $nilai->santri->nama ?? 'Unknown' }}
                                </p>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500">
                                    {{ $nilai->tanggal_penilaian ?
                                    \Carbon\Carbon::parse($nilai->tanggal_penilaian)->locale('id')->translatedFormat('d
                                    F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg">
                                <p class="text-[10px] text-gray-500 dark:text-gray-400">Disiplin</p>
                                <div class="flex justify-center gap-0.5 mt-1">
                                    @for($i = 1; $i <= 5; $i++) <span
                                        class="material-symbols-rounded text-xs {{ $i <= $nilai->disiplin ? 'text-amber-400' : 'text-gray-300' }}">
                                        star</span>
                                        @endfor
                                </div>
                            </div>
                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg">
                                <p class="text-[10px] text-gray-500 dark:text-gray-400">Kerajinan</p>
                                <div class="flex justify-center gap-0.5 mt-1">
                                    @for($i = 1; $i <= 5; $i++) <span
                                        class="material-symbols-rounded text-xs {{ $i <= $nilai->kerajinan ? 'text-amber-400' : 'text-gray-300' }}">
                                        star</span>
                                        @endfor
                                </div>
                            </div>
                            <div class="p-2 bg-white dark:bg-gray-800 rounded-lg">
                                <p class="text-[10px] text-gray-500 dark:text-gray-400">Kesopanan</p>
                                <div class="flex justify-center gap-0.5 mt-1">
                                    @for($i = 1; $i <= 5; $i++) <span
                                        class="material-symbols-rounded text-xs {{ $i <= $nilai->kesopanan ? 'text-amber-400' : 'text-gray-300' }}">
                                        star</span>
                                        @endfor
                                </div>
                            </div>
                        </div>
                        @if($nilai->catatan)
                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-3 italic">"{{ $nilai->catatan }}"</p>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <span
                            class="material-symbols-rounded text-gray-300 dark:text-gray-600 text-5xl mb-2">sentiment_satisfied</span>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada nilai akhlak</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        // Star rating interaction
        document.querySelectorAll('[id$="Stars"]').forEach(container => {
            const stars = container.querySelectorAll('.star-icon');
            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const value = parseInt(this.dataset.value);
                    const input = this.previousElementSibling;
                    input.checked = true;

                    // Update visual
                    stars.forEach((s, index) => {
                        if (index < value) {
                            s.classList.remove('text-gray-300', 'dark:text-gray-600');
                            s.classList.add('text-amber-400');
                        } else {
                            s.classList.remove('text-amber-400');
                            s.classList.add('text-gray-300', 'dark:text-gray-600');
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
