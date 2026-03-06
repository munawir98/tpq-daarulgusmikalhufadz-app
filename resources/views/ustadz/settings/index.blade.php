<!DOCTYPE html>
<script>
    // Dark mode init
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pengaturan Ustadz - TPQ Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
                        "primary": "#4A90B8",
                        "primary-dark": "#2E6B8A",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-white dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-center px-5 py-4 relative">
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
                            class="w-full h-full flex items-center justify-center bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-3xl font-bold">
                            {{ substr(session('user.name', 'U'), 0, 1) }}
                        </div>
                        @endif
                    </div>
                </div>
                <h2 class="text-xl font-bold text-[#111813] dark:text-white text-center">{{ session('user.name',
                    'Ustadz') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ session('user.email', '-') }}</p>
                <span
                    class="mt-2 px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-xs font-bold uppercase">
                    {{ session('user.role', 'USTADZ') }}
                </span>
            </div>

            <!-- Akun Section -->
            <div class="flex flex-col gap-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1 mb-1">Akun</h3>

                <a href="/ustadz/settings/profile"
                    class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition active:scale-[0.98]">
                    <div class="p-2.5 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">Edit Profil</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Ubah nama, email, foto</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </a>

                <a href="/ustadz/settings/password"
                    class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition active:scale-[0.98]">
                    <div
                        class="p-2.5 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400">
                        <span class="material-symbols-outlined">lock</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">Ubah Kata Sandi</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Perbarui password akun</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </a>
            </div>

            <!-- Preferensi Aplikasi -->
            <div class="flex flex-col gap-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1 mb-1">Preferensi Aplikasi</h3>

                <div
                    class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div
                        class="p-2.5 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                        <span class="material-symbols-outlined">dark_mode</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">Mode Gelap</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tampilan tema gelap</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
            </div>

            <!-- Lainnya -->
            <div class="flex flex-col gap-2">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest px-1 mb-1">Lainnya</h3>

                <a href="/help"
                    class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition active:scale-[0.98]">
                    <div class="p-2.5 rounded-xl bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400">
                        <span class="material-symbols-outlined">help</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">Bantuan</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">FAQ & dukungan</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </a>

                <a href="/about"
                    class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition active:scale-[0.98]">
                    <div class="p-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">Tentang Aplikasi</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Versi & info pengembang</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </a>
            </div>

            <!-- Logout Button -->
            <a href="/logout"
                class="flex items-center justify-center gap-2 p-4 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-2xl font-bold hover:bg-red-100 dark:hover:bg-red-900/30 transition active:scale-[0.98] mb-6">
                <span class="material-symbols-outlined">logout</span>
                Keluar
            </a>

        </main>


    </div>

    <script>
        // Dark Mode Toggle
        const toggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        // Set initial state
        toggle.checked = html.classList.contains('dark');

        toggle.addEventListener('change', () => {
            if (toggle.checked) {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });
    </script>
</body>

</html>
