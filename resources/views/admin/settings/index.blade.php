<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pengaturan Admin - TPQ Digital</title>
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
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
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

        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl pb-24">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-center px-5 py-4 relative">
                <a href="/admin/dashboard"
                    class="absolute left-5 p-2 -ml-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-xl font-bold">Pengaturan</h2>
            </div>
        </header>

        <main class="flex flex-col gap-6 px-5 pt-6">

            <!-- Profile Card -->
            <div
                class="flex flex-col items-center bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="relative">
                    <div
                        class="size-24 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden border-4 border-white dark:border-gray-600 shadow-lg mb-3">
                        @if(session('user.foto'))
                        <img alt="Profile picture" class="w-full h-full object-cover"
                            src="{{ asset('storage/' . session('user.foto')) }}" />
                        @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-3xl font-bold">
                            {{ substr(session('user.name', 'A'), 0, 1) }}
                        </div>
                        @endif
                    </div>
                </div>
                <h2 class="text-xl font-bold text-[#111813] dark:text-white text-center">{{ session('user.name',
                    'Admin') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ session('user.email', '-') }}</p>
                <span
                    class="mt-2 px-3 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase">
                    {{ session('user.role', 'ADMIN') }}
                </span>
            </div>

            <!-- Akun Section -->
            <div class="flex flex-col gap-2">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">Akun
                </h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <a href="/admin/settings/profile"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">person</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Edit Profil</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                    <a href="/admin/settings/password"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div
                            class="p-2 rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">lock</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Ubah Kata Sandi</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                </div>
            </div>

            <!-- Manajemen TPQ Section -->
            <div class="flex flex-col gap-2">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">
                    Manajemen TPQ</h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <a href="/admin/santri"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-2 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">groups</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Kelola Santri</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                    <a href="/admin/ustadz"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-2 rounded-xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">school</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Kelola Ustadz</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                    <a href="/admin/kelas"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div
                            class="p-2 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">class</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Kelola Kelas</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                </div>
            </div>

            <!-- Preferensi Aplikasi Section -->
            <div class="flex flex-col gap-2">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">
                    Preferensi Aplikasi</h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex items-center gap-3 p-4 w-full border-b border-gray-100 dark:border-gray-700">
                        <div
                            class="p-2 rounded-xl bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">language</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Bahasa</p>
                        </div>
                        <span class="text-xs font-medium text-gray-400 mr-1">Indonesia</span>
                        <span class="material-symbols-outlined text-gray-400"
                            style="font-size: 20px;">chevron_right</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 w-full">
                        <div
                            class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">dark_mode</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Mode Gelap</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input id="darkModeToggle" class="sr-only peer" type="checkbox" />
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Lainnya Section -->
            <div class="flex flex-col gap-2">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">Lainnya
                </h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <a href="/help"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-2 rounded-xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">help</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Bantuan & Dukungan</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                    <a href="/about"
                        class="flex items-center gap-3 p-4 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div
                            class="p-2 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 20px;">info</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-sm text-[#111813] dark:text-white">Tentang Aplikasi</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 20px;">chevron_right</span>
                    </a>
                </div>
            </div>

            <!-- Logout Button -->
            <a href="/logout"
                class="w-full flex items-center justify-center gap-2 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-bold text-sm border border-red-100 dark:border-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors mb-2">
                <span class="material-symbols-outlined" style="font-size: 20px;">logout</span>
                Keluar
            </a>

            <p class="text-center text-xs text-gray-400 pb-8">Versi Aplikasi {{ config('app.version', '1.0.0') }}</p>
        </main>

        <!-- Bottom Navigation -->
        <nav
            class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 pb-5 pt-3 px-6 z-50">
            <div class="flex justify-between items-center">
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/admin/dashboard">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="text-[10px] font-medium">Dashboard</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/admin/santri">
                    <span class="material-symbols-outlined">people</span>
                    <span class="text-[10px] font-medium">Users</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/admin/kelas">
                    <span class="material-symbols-outlined">class</span>
                    <span class="text-[10px] font-medium">Classes</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-primary" href="/admin/settings">
                    <span class="material-symbols-outlined filled">settings</span>
                    <span class="text-[10px] font-medium">Settings</span>
                </a>
            </div>
        </nav>
    </div>

    <script>
        // Dark Mode Toggle
        const darkToggle = document.getElementById('darkModeToggle');

        // Check saved preference
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
            darkToggle.checked = true;
        }

        darkToggle.addEventListener('change', function () {
            if (this.checked) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>

</html>
