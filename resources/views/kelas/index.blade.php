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
    <title>Daftar Kelas</title>
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
                <a href="{{ url()->previous() }}"
                    class="flex size-12 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-white/10 transition-colors">
                    <span class="material-symbols-outlined">arrow_back_ios_new</span>
                </a>
                <h2 class="text-lg font-bold flex-1 text-center pr-12">Daftar Kelas</h2>
            </div>
        </div>

        <!-- Search -->
        <div class="p-4">
            <div
                class="flex items-center bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-700 px-4 h-12 gap-3">
                <span class="material-symbols-outlined text-gray-400">search</span>
                <input
                    class="flex-1 bg-transparent border-none focus:ring-0 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500"
                    placeholder="Cari kelas..." />
            </div>
        </div>

        <!-- Stats -->
        <div class="px-4 grid grid-cols-3 gap-3 mb-4">
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold text-primary">5</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Kelas</p>
            </div>
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold">48</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Santri</p>
            </div>
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold">4</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ustadz</p>
            </div>
        </div>

        <!-- Class List -->
        <div class="px-4 space-y-3">
            @for($i = 1; $i <= 5; $i++) <a href="{{ route('kelas.show', $i) }}"
                class="flex items-center gap-4 p-4 bg-surface-light dark:bg-surface-dark rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary/50 transition-colors">
                <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">school</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Kelas {{ $i }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ rand(5, 15) }} Santri</p>
                </div>
                <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </a>
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
                <a class="flex flex-col items-center gap-1 text-primary" href="#">
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
