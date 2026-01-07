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
    <title>Detail Santri</title>
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
                <h2 class="text-lg font-bold flex-1 text-center pr-12">Detail Santri</h2>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="p-4">
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-5 border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center text-3xl font-bold text-primary">
                        A</div>
                    <div>
                        <h3 class="text-xl font-bold">Ahmad Rizki</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">NIS: 20240001</p>
                        <span
                            class="inline-block mt-2 px-3 py-1 bg-primary/10 rounded-full text-xs font-bold text-primary">Kelas
                            Iqra 1</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="px-4 grid grid-cols-3 gap-3">
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold text-primary">95%</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Kehadiran</p>
            </div>
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold">12</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Setoran</p>
            </div>
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 text-center border border-gray-100 dark:border-gray-700">
                <p class="text-2xl font-bold text-primary">A</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Nilai</p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="p-4 space-y-4">
            <h4 class="text-sm font-bold">Informasi</h4>
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl border border-gray-100 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700">
                <div class="flex justify-between p-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Tanggal Lahir</span>
                    <span class="text-sm font-medium">15 Maret 2015</span>
                </div>
                <div class="flex justify-between p-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</span>
                    <span class="text-sm font-medium">Laki-laki</span>
                </div>
                <div class="flex justify-between p-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Wali</span>
                    <span class="text-sm font-medium">Bapak Hasan</span>
                </div>
                <div class="flex justify-between p-4">
                    <span class="text-sm text-gray-500 dark:text-gray-400">No. HP Wali</span>
                    <span class="text-sm font-medium text-primary">081234567890</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="p-4 space-y-3">
            <h4 class="text-sm font-bold">Hafalan Terakhir</h4>
            <div
                class="bg-surface-light dark:bg-surface-dark rounded-2xl p-4 border border-gray-100 dark:border-gray-700 flex gap-3">
                <div class="size-10 rounded-xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">menu_book</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Al-Fatihah: Ayat 1-7</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">2 hari lalu • Sempurna</p>
                </div>
            </div>
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
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">groups</span>
                    <span class="text-[10px]">Santri</span>
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
