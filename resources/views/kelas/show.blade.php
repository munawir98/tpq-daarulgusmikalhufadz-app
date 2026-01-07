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
    <title>Detail Kelas</title>
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
                        "primary": "#13ec5b",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1c2e22",
                    },
                    fontFamily: { "display": ["Manrope", "sans-serif"] },
                },
            },
        }
    </script>
</head>

<body class="bg-background-light dark:bg-background-dark font-display min-h-screen text-[#111813] dark:text-white">
    <div
        class="relative flex min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark shadow-2xl pb-24">

        <!-- Header -->
        <div
            class="sticky top-0 z-50 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm p-4 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between">
                <a href="{{ route('kelas.index') }}"
                    class="flex size-12 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                    <span class="material-symbols-outlined">arrow_back_ios_new</span>
                </a>
                <h2 class="text-lg font-bold flex-1 text-center pr-12">Detail Kelas</h2>
            </div>
        </div>

        <!-- Class Info Card -->
        <div class="p-4">
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-5 border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-4 mb-4">
                    <div class="size-16 rounded-2xl bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-3xl">school</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Kelas Iqra 1</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ustadz Ahmad</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div
                        class="bg-gray-50 dark:bg-background-dark rounded-xl p-3 text-center border border-gray-100 dark:border-gray-800">
                        <p class="text-xl font-bold text-primary">12</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Santri</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-background-dark rounded-xl p-3 text-center border border-gray-100 dark:border-gray-800">
                        <p class="text-xl font-bold">95%</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Hadir</p>
                    </div>
                    <div
                        class="bg-gray-50 dark:bg-background-dark rounded-xl p-3 text-center border border-gray-100 dark:border-gray-800">
                        <p class="text-xl font-bold text-primary">A</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Nilai</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-4 grid grid-cols-2 gap-3 mb-4">
            <a href="{{ route('kelas.presensi', 1) }}"
                class="flex items-center justify-center gap-2 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary/50 transition-colors">
                <span class="material-symbols-outlined text-primary">fact_check</span>
                <span class="text-sm font-bold">Rekap</span>
            </a>
            <button
                class="flex items-center justify-center gap-2 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary/50 transition-colors">
                <span class="material-symbols-outlined text-orange-500">download</span>
                <span class="text-sm font-bold">Export</span>
            </button>
        </div>

        <!-- Santri List -->
        <div class="px-4 space-y-3">
            <h4 class="text-sm font-bold">Daftar Santri</h4>
            @for($i = 1; $i <= 5; $i++) <div
                class="flex items-center gap-3 p-3 bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-700">
                <div
                    class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                    {{ chr(64 + $i) }}</div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Santri {{ $i }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">NIS: 2024000{{ $i }}</p>
                </div>
                <span class="px-2 py-1 text-[10px] font-bold rounded-full bg-primary/10 text-primary">Aktif</span>
        </div>
        @endfor
    </div>

    <!-- Bottom Nav -->
    <nav
        class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-surface-light dark:bg-surface-dark border-t border-gray-100 dark:border-gray-800 pb-5 pt-3 px-6 z-50">
        <div class="flex justify-between items-center">
            <a class="flex flex-col items-center gap-1 text-gray-400" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">home</span>
                <span class="text-[10px]">Beranda</span>
            </a>
            <a class="flex flex-col items-center gap-1 text-primary" href="{{ route('kelas.index') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span>
                <span class="text-[10px]">Kelas</span>
            </a>
            <a class="flex flex-col items-center gap-1 text-gray-400" href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined">chat</span>
                <span class="text-[10px]">Chat</span>
            </a>
            <a class="flex flex-col items-center gap-1 text-gray-400" href="{{ route('profile.index') }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-[10px]">Profil</span>
            </a>
        </div>
    </nav>
    </div>
</body>

</html>
