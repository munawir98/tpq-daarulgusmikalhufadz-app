<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Notifikasi - TPQ Digital</title>
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
            <div class="flex items-center justify-between px-5 py-4 relative">
                <a href="/santri/dashboard"
                    class="flex items-center justify-center p-2 -ml-2 rounded-full text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-lg font-bold">Notifikasi</h2>
                <form action="/notifications/mark-all-read" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-xs font-bold text-primary hover:text-green-600 transition-colors px-2 py-1">
                        Baca Semua
                    </button>
                </form>
            </div>
        </header>

        <main class="flex flex-col gap-6 px-5 pt-6">

            <!-- Hari Ini -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Hari Ini</h3>

                <!-- Unread Notification -->
                <div
                    class="group relative flex flex-col gap-3 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md active:scale-[0.99] cursor-pointer">
                    <div
                        class="absolute top-4 right-4 size-2.5 rounded-full bg-red-500 ring-4 ring-white dark:ring-gray-800">
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full bg-green-50 dark:bg-green-900/20 text-primary">
                            <span class="material-symbols-outlined text-[20px]">payments</span>
                        </div>
                        <div class="flex-1 pr-4">
                            <h4 class="text-sm font-bold text-[#111813] dark:text-white mb-1">Pembayaran Diterima</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">
                                Alhamdulillah, pembayaran SPP bulan Juni untuk Ananda telah kami terima.</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">10:30 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Unread Notification -->
                <div
                    class="group relative flex flex-col gap-3 bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md active:scale-[0.99] cursor-pointer">
                    <div
                        class="absolute top-4 right-4 size-2.5 rounded-full bg-red-500 ring-4 ring-white dark:ring-gray-800">
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                            <span class="material-symbols-outlined text-[20px]">menu_book</span>
                        </div>
                        <div class="flex-1 pr-4">
                            <h4 class="text-sm font-bold text-[#111813] dark:text-white mb-1">Hafalan Baru</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">Target
                                hafalan baru Surat Al-Mutaffifin ayat 1-10 telah ditambahkan oleh Ustadz.</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">08:15 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kemarin -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Kemarin</h3>

                <!-- Read Notification -->
                <div
                    class="group relative flex flex-col gap-3 bg-white/60 dark:bg-gray-800/60 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-800 active:scale-[0.99] cursor-pointer">
                    <div class="flex items-start gap-4 opacity-80 group-hover:opacity-100 transition-opacity">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full bg-orange-50 dark:bg-orange-900/20 text-orange-600">
                            <span class="material-symbols-outlined text-[20px]">campaign</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-[#111813] dark:text-white mb-1">Pengumuman Libur</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">Kegiatan
                                belajar mengajar diliburkan pada hari Jumat karena Rapat Guru.</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">Kemarin, 14:00</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Minggu Lalu -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Minggu Lalu</h3>

                <div
                    class="group relative flex flex-col gap-3 bg-white/60 dark:bg-gray-800/60 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-800 active:scale-[0.99] cursor-pointer">
                    <div class="flex items-start gap-4 opacity-80 group-hover:opacity-100 transition-opacity">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full bg-purple-50 dark:bg-purple-900/20 text-purple-600">
                            <span class="material-symbols-outlined text-[20px]">info</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-[#111813] dark:text-white mb-1">Update Aplikasi</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">Versi
                                terbaru aplikasi TPQ kini tersedia (v1.0.3). Nikmati fitur baru!</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">15 Des</p>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative flex flex-col gap-3 bg-white/60 dark:bg-gray-800/60 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-800 active:scale-[0.99] cursor-pointer">
                    <div class="flex items-start gap-4 opacity-80 group-hover:opacity-100 transition-opacity">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full bg-teal-50 dark:bg-teal-900/20 text-teal-600">
                            <span class="material-symbols-outlined text-[20px]">waving_hand</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-[#111813] dark:text-white mb-1">Selamat Datang!</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">Selamat
                                datang di aplikasi resmi TPQ Daarul Gusmik Al-Hufadz.</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">12 Des</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-8"></div>
        </main>

        <!-- Bottom Navigation -->
        <nav
            class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 pb-5 pt-3 px-6 z-50">
            <div class="flex justify-between items-center">
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/santri/dashboard">
                    <span class="material-symbols-outlined">home</span>
                    <span class="text-[10px] font-medium">Beranda</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-primary" href="/notifications">
                    <span class="material-symbols-outlined filled">notifications</span>
                    <span class="text-[10px] font-medium">Notifikasi</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/chat">
                    <span class="material-symbols-outlined">chat</span>
                    <span class="text-[10px] font-medium">Chat</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/profile">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="text-[10px] font-medium">Pengaturan</span>
                </a>
            </div>
        </nav>
    </div>

    <script>
        // Dark mode check
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>

</html>
