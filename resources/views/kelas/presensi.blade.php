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
    <title>Rekap Presensi</title>
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
            <div class="flex items-center justify-center relative">
                <h2 class="text-lg font-bold flex-1 text-center">Rekap Presensi</h2>
                <div class="absolute right-0">
                    <button class="flex size-12 items-center justify-center text-primary">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="p-4 flex gap-2 overflow-x-auto no-scrollbar">
            <button class="shrink-0 px-4 py-2 rounded-full bg-primary text-[#102216] text-sm font-bold">Minggu
                Ini</button>
            <button
                class="shrink-0 px-4 py-2 rounded-full bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-sm">Bulan
                Ini</button>
            <button
                class="shrink-0 px-4 py-2 rounded-full bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-sm">Semester</button>
        </div>

        <!-- Summary -->
        <div class="px-4">
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 mb-3">Ringkasan</h3>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div>
                        <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center mx-auto mb-1">
                            <span class="font-bold text-primary">45</span>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Hadir</p>
                    </div>
                    <div>
                        <div class="size-10 rounded-xl bg-yellow-500/10 flex items-center justify-center mx-auto mb-1">
                            <span class="font-bold text-yellow-500">3</span>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Izin</p>
                    </div>
                    <div>
                        <div class="size-10 rounded-xl bg-blue-500/10 flex items-center justify-center mx-auto mb-1">
                            <span class="font-bold text-blue-500">2</span>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Sakit</p>
                    </div>
                    <div>
                        <div class="size-10 rounded-xl bg-red-500/10 flex items-center justify-center mx-auto mb-1">
                            <span class="font-bold text-red-500">1</span>
                        </div>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">Alpha</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="p-4">
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-bold">Detail</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @for($i = 1; $i <= 5; $i++) <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                {{ chr(64 + $i) }}</div>
                            <span class="text-sm font-medium">Santri {{ $i }}</span>
                        </div>
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-primary/10 text-primary">{{ rand(90,
                            100) }}%</span>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Kirim Notifikasi ke Orang Tua -->
    <div class="p-4">
        <a href="{{ route('ustadz.broadcast.create') }}"
            class="w-full flex items-center justify-center gap-3 bg-primary text-[#102216] font-bold py-4 rounded-2xl shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-95">
            <span class="material-symbols-outlined">notifications_active</span>
            Kirim Notifikasi ke Orang Tua
        </a>
    </div>

    <!-- Bottom Nav -->
    <nav
        class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-surface-light dark:bg-surface-dark border-t border-gray-100 dark:border-gray-800 pb-5 pt-3 px-6 z-50">
        <div class="flex justify-between items-center">
            <a class="flex flex-col items-center gap-1 text-gray-400" href="{{ route('dashboard') }}"><span
                    class="material-symbols-outlined">home</span><span class="text-[10px]">Beranda</span></a>
            <a class="flex flex-col items-center gap-1 text-primary" href="{{ route('kelas.index') }}"><span
                    class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span><span
                    class="text-[10px]">Kelas</span></a>
            <a class="flex flex-col items-center gap-1 text-gray-400" href="{{ route('chat.index') }}"><span
                    class="material-symbols-outlined">chat</span><span class="text-[10px]">Chat</span></a>
            <a class="flex flex-col items-center gap-1 text-gray-400" href="{{ route('profile.index') }}"><span
                    class="material-symbols-outlined">settings</span><span class="text-[10px]">Profil</span></a>
        </div>
    </nav>
    </div>
</body>

</html>
