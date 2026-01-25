<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Jadwal Tahfidz</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ecb6",
                        "accent-gold": "#d4a017",
                        "background-light": "#f6f8f8",
                        "background-dark": "#10221d",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen text-[#111816] dark:text-white pb-24 relative">

    <main class="max-w-md mx-auto pt-4 relative">
        <!-- Box Header -->
        <header
            class="flex items-center justify-between bg-white dark:bg-[#1a2e29] h-16 px-4 shadow-sm mx-4 rounded-2xl mb-6 border border-gray-100 dark:border-gray-800 relative z-30">
            <a href="{{ route('ustadz.dashboard') }}"
                class="flex items-center justify-center size-10 rounded-full bg-gray-50 dark:bg-white/10 text-gray-600 dark:text-white hover:bg-gray-100 transition-colors">
                <span class="material-symbols-outlined">chevron_left</span>
            </a>
            <h1 class="text-[#111816] dark:text-white text-lg font-bold leading-tight flex-1 text-center pr-10">Jadwal
                Tahfidz</h1>
        </header>

        <!-- Calendar Strip (Static & Distinct Colors) -->
        <div class="bg-white dark:bg-[#1a2e29] pt-6 pb-4 shadow-sm">
            <div class="px-4 mb-4 flex justify-between items-center text-[#111816] dark:text-white">
                <h3 class="font-bold text-lg">Oktober 2023</h3>
                <span class="material-symbols-outlined text-primary">calendar_month</span>
            </div>
            <div class="flex gap-3 px-4 overflow-x-auto no-scrollbar pb-2">
                <!-- Senin (Inactive) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Sen</p>
                    <p class="text-xl font-bold">12</p>
                </div>
                <!-- Selasa (Inactive) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Sel</p>
                    <p class="text-xl font-bold">13</p>
                </div>
                <!-- Rabu (Active - Blue) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/20 ring-2 ring-blue-500 ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Rab</p>
                    <p class="text-xl font-bold">14</p>
                </div>
                <!-- Kamis (Active - Purple) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-gradient-to-br from-purple-500 to-fuchsia-500 text-white shadow-lg shadow-purple-500/20 ring-2 ring-purple-500 ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Kam</p>
                    <p class="text-xl font-bold">15</p>
                </div>
                <!-- Jumat (Inactive) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Jum</p>
                    <p class="text-xl font-bold">16</p>
                </div>
                <!-- Sabtu (Active - Orange) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-orange-500/20 ring-2 ring-orange-500 ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Sab</p>
                    <p class="text-xl font-bold">17</p>
                </div>
                <!-- Minggu (Active - Teal) -->
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-gradient-to-br from-teal-400 to-emerald-500 text-white shadow-lg shadow-teal-500/20 ring-2 ring-teal-500 ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Min</p>
                    <p class="text-xl font-bold">18</p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="px-4 py-4">
            <div class="bg-gradient-to-br from-[#0f8b6b] to-primary rounded-2xl p-4 text-white shadow-lg">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-xl">info</span>
                    <h4 class="font-bold">Info Jadwal Khusus</h4>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                        <p class="text-[10px] uppercase tracking-wider opacity-80 font-bold mb-1">Rabu &amp; Kamis</p>
                        <p class="text-sm font-semibold">16:00 - 17:30</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                        <p class="text-[10px] uppercase tracking-wider opacity-80 font-bold mb-1">Sabtu &amp; Ahad</p>
                        <p class="text-sm font-semibold">06:00 - 08:00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 pt-2 pb-2">
            <h3 class="text-[#111816] dark:text-gray-200 text-lg font-bold leading-tight">Rabu, 14 Oktober</h3>
        </div>

        <!-- Cards Container -->
        <div class="p-4 space-y-4">
            <!-- Card 1: Sedang Berlangsung (Colorful Gradient) -->
            <div
                class="flex flex-col items-stretch justify-start rounded-xl shadow-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-white overflow-hidden relative transform transition-all active:scale-[0.98]">
                <!-- Decoration -->
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-6xl">school</span>
                </div>

                <div class="p-4 relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/20 backdrop-blur-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-white mr-1.5 animate-pulse"></span>
                            Sedang Berlangsung
                        </span>
                    </div>
                    <h4 class="text-white text-lg font-bold">Kelas Al-Fatihah</h4>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center text-blue-100 text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">schedule</span>
                            16:00 - 17:30
                        </div>
                        <div class="flex items-center text-blue-100 text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">person</span>
                            Ustadz Ahmad Fauzi
                        </div>
                        <div
                            class="flex items-start text-blue-50 text-sm bg-white/10 p-3 rounded-lg border border-white/10 mt-2 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-lg mr-2 text-white">menu_book</span>
                            <div>
                                <p class="font-semibold text-white">Materi:</p>
                                <p class="opacity-90">Setoran Surah An-Naba Ayat 1-20</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button
                            class="bg-white text-blue-600 font-bold py-2 px-6 rounded-lg text-sm shadow-md active:scale-95 transition-transform hover:bg-blue-50">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2: Mendatang (Colorful Gradient) -->
            <div
                class="flex flex-col items-stretch justify-start rounded-xl shadow-lg bg-gradient-to-br from-purple-500 to-pink-500 text-white overflow-hidden relative transform transition-all active:scale-[0.98]">
                <!-- Decoration -->
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-6xl">event_upcoming</span>
                </div>

                <div class="p-4 relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/20 backdrop-blur-sm">
                            Mendatang
                        </span>
                    </div>
                    <h4 class="text-white text-lg font-bold">Kelas Al-Ikhlas</h4>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center text-purple-100 text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">schedule</span>
                            16:00 - 17:30
                        </div>
                        <div class="flex items-center text-purple-100 text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">person</span>
                            Ustadzah Fatimah Azzahra
                        </div>
                        <div
                            class="flex items-start text-purple-50 text-sm bg-white/10 p-3 rounded-lg border border-white/10 mt-2 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-lg mr-2 text-white">menu_book</span>
                            <div>
                                <p class="font-semibold text-white">Materi:</p>
                                <p class="opacity-90">Muraja'ah Surah Al-Mulk</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button
                            class="bg-white text-purple-600 font-bold py-2 px-6 rounded-lg text-sm shadow-md active:scale-95 transition-transform hover:bg-purple-50">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quote -->
        <div class="px-4 py-8 text-center opacity-60">
            <div class="w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl text-primary">auto_stories</span>
            </div>
            <p class="text-xs text-[#61897f]">"Sebaik-baik kalian adalah orang yang belajar Al-Qur'an dan
                mengajarkannya."</p>
            <p class="text-[10px] mt-1 text-gray-400">(HR. Bukhari)</p>
        </div>
    </main>

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-6 z-[60]">
        <button
            class="flex items-center justify-center w-14 h-14 rounded-full bg-primary text-white shadow-lg shadow-primary/40 hover:scale-105 active:scale-95 transition-all focus:outline-none focus:ring-4 focus:ring-primary/30">
            <span class="material-symbols-outlined text-3xl">add</span>
        </button>
    </div>

</body>

</html>
