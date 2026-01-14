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
    <title>Menu Nilai</title>
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
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748",
                        "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
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
    <div class="relative max-w-[434px] mx-auto min-h-screen bg-surface-light dark:bg-surface-dark shadow-2xl">

        <!-- Header -->
        <div class="bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] pt-12 pb-8 px-6">
            <div class="flex items-center justify-center mb-4">
                <div class="text-center">
                    <h1 class="text-white text-xl font-bold">Menu Nilai</h1>
                    <p class="text-white/70 text-xs">Penilaian santri</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 -mt-4 pb-8">
            <!-- Grid Menu -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Nilai Hafalan -->
                <a href="{{ route('ustadz.nilai.hafalan') }}"
                    class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded text-amber-500 text-3xl">star</span>
                    </div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-1">Nilai Hafalan</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Rekap rating setoran</p>
                </a>

                <!-- Nilai Tajwid -->
                <a href="{{ route('ustadz.nilai.tajwid') }}"
                    class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded text-blue-500 text-3xl">menu_book</span>
                    </div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-1">Nilai Tajwid</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Kualitas bacaan</p>
                </a>

                <!-- Nilai Akhlak -->
                <a href="{{ route('ustadz.nilai.akhlak') }}"
                    class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded text-green-500 text-3xl">sentiment_satisfied</span>
                    </div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-1">Nilai Akhlak</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Perilaku & adab</p>
                </a>

                <!-- Rapor -->
                <a href="{{ route('ustadz.nilai.rapor') }}"
                    class="bg-white dark:bg-gray-800 rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-rounded text-purple-500 text-3xl">description</span>
                    </div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white mb-1">Rapor</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Rekap semua nilai</p>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
