<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Jadwal Tahfidz - Tambah Jadwal Baru</title>
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
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen text-[#111816] dark:text-white pb-24 relative">
    <div class="sticky top-0 z-50 bg-primary px-4 py-6 flex items-center gap-4 shadow-md">
        <a href="{{ route('ustadz.dashboard') }}"
            class="flex items-center justify-center size-10 rounded-full bg-white/20 text-white hover:bg-white/30 transition-colors">
            <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <h1 class="text-white text-xl font-bold leading-tight tracking-tight">Jadwal Tahfidz</h1>
    </div>
    <main class="max-w-md mx-auto">
        <div class="bg-white dark:bg-[#1a2e29] pt-6 pb-4 shadow-sm">
            <div class="px-4 mb-4 flex justify-between items-center text-[#111816] dark:text-white">
                <h3 class="font-bold text-lg">Oktober 2023</h3>
                <span class="material-symbols-outlined text-primary">calendar_month</span>
            </div>
            <div class="flex gap-3 px-4 overflow-x-auto no-scrollbar pb-2">
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Sen</p>
                    <p class="text-xl font-bold">12</p>
                </div>
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Sel</p>
                    <p class="text-xl font-bold">13</p>
                </div>
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-primary text-white shadow-lg shadow-primary/20 ring-2 ring-primary ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Rab</p>
                    <p class="text-xl font-bold">14</p>
                </div>
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-primary text-white shadow-lg shadow-primary/20 ring-2 ring-primary ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Kam</p>
                    <p class="text-xl font-bold">15</p>
                </div>
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Jum</p>
                    <p class="text-xl font-bold">16</p>
                </div>
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-primary text-white shadow-lg shadow-primary/20 ring-2 ring-primary ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Sab</p>
                    <p class="text-xl font-bold">17</p>
                </div>
                <div
                    class="flex flex-col items-center justify-center min-w-[56px] h-20 rounded-xl bg-primary text-white shadow-lg shadow-primary/20 ring-2 ring-primary ring-offset-2 dark:ring-offset-[#1a2e29]">
                    <p class="text-xs font-medium opacity-90">Min</p>
                    <p class="text-xl font-bold">18</p>
                </div>
            </div>
        </div>
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
        <div class="p-4 space-y-4">
            <div
                class="flex flex-col items-stretch justify-start rounded-xl shadow-sm bg-white dark:bg-[#1a2e29] border-l-4 border-primary overflow-hidden">
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-[#0f8b6b] border border-primary/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary mr-1.5 animate-pulse"></span>
                            Sedang Berlangsung
                        </span>
                    </div>
                    <h4 class="text-[#111816] dark:text-white text-lg font-bold">Kelas Al-Fatihah</h4>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center text-[#61897f] text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">schedule</span>
                            16:00 - 17:30
                        </div>
                        <div class="flex items-center text-[#61897f] text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">person</span>
                            Ustadz Ahmad Fauzi
                        </div>
                        <div
                            class="flex items-start text-[#61897f] text-sm bg-primary/5 p-3 rounded-lg border border-primary/10 mt-2">
                            <span class="material-symbols-outlined text-lg mr-2 text-primary">menu_book</span>
                            <div>
                                <p class="font-semibold text-[#111816] dark:text-primary">Materi:</p>
                                <p>Setoran Surah An-Naba Ayat 1-20</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button
                            class="bg-primary text-white font-semibold py-2 px-6 rounded-lg text-sm shadow-md shadow-primary/30 active:scale-95 transition-transform">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-col items-stretch justify-start rounded-xl shadow-sm bg-white dark:bg-[#1a2e29] overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-800 text-gray-500">
                            Mendatang
                        </span>
                    </div>
                    <h4 class="text-[#111816] dark:text-white text-lg font-bold">Kelas Al-Ikhlas</h4>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center text-[#61897f] text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">schedule</span>
                            16:00 - 17:30
                        </div>
                        <div class="flex items-center text-[#61897f] text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">person</span>
                            Ustadzah Fatimah Azzahra
                        </div>
                        <div
                            class="flex items-start text-[#61897f] text-sm bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg mt-2">
                            <span class="material-symbols-outlined text-lg mr-2 text-gray-400">menu_book</span>
                            <div>
                                <p class="font-semibold text-[#111816] dark:text-gray-300">Materi:</p>
                                <p>Muraja'ah Surah Al-Mulk</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button
                            class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-semibold py-2 px-6 rounded-lg text-sm active:scale-95 transition-transform">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-8 text-center opacity-60">
            <div class="w-16 h-16 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-3xl text-primary">auto_stories</span>
            </div>
            <p class="text-xs text-[#61897f]">"Sebaik-baik kalian adalah orang yang belajar Al-Qur'an dan
                mengajarkannya."</p>
            <p class="text-[10px] mt-1 text-gray-400">(HR. Bukhari)</p>
        </div>
    </main>
    <div class="fixed bottom-8 right-6 z-[60]">
        <button
            class="flex items-center justify-center w-14 h-14 rounded-full bg-primary text-white shadow-lg shadow-primary/40 hover:scale-105 active:scale-95 transition-all focus:outline-none focus:ring-4 focus:ring-primary/30">
            <span class="material-symbols-outlined text-3xl">add</span>
        </button>
    </div>

</body>

</html>
