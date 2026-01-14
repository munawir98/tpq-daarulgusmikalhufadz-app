<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Riwayat Notifikasi Ustadz</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                    },
                    fontFamily: {
                        "display": ["Poppins", "sans-serif"]
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
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-100">
    <div
        class="relative flex min-h-screen w-full flex-col overflow-x-hidden max-w-[430px] mx-auto bg-white dark:bg-background-dark shadow-xl">
        <!-- Header -->
        <header
            class="sticky top-0 z-50 flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md p-4 border-b border-slate-100 dark:border-slate-800">
            <button onclick="history.back()"
                class="text-primary flex size-9 items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined text-[20px]">arrow_back_ios</span>
            </button>
            <h1
                class="text-[#0e141b] dark:text-white text-base font-semibold leading-tight tracking-tight flex-1 text-center pr-10">
                Riwayat Notifikasi</h1>
        </header>

        <!-- Search Bar -->
        <div class="px-4 py-3">
            <label class="flex flex-col min-w-40 h-10 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm">
                    <div class="text-[#4e7397] flex border-none bg-[#e7edf3] dark:bg-slate-800 items-center justify-center pl-4 rounded-l-xl"
                        data-icon="search">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                    <input
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-xl text-[#0e141b] dark:text-white focus:outline-0 focus:ring-0 border-none bg-[#e7edf3] dark:bg-slate-800 placeholder:text-[#4e7397] px-4 pl-2 text-sm font-normal leading-normal"
                        placeholder="Cari nama santri..." value="" />
                </div>
            </label>
        </div>

        <!-- Filter Chips -->
        <div class="flex gap-2 px-4 pb-4 overflow-x-auto no-scrollbar">
            <div
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary px-4 shadow-md shadow-primary/20">
                <p class="text-white text-xs font-medium leading-normal">Semua</p>
            </div>
            <div
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-[#e7edf3] dark:bg-slate-800 px-4">
                <p class="text-[#0e141b] dark:text-slate-300 text-xs font-medium leading-normal">Terkirim</p>
            </div>
            <div
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-[#e7edf3] dark:bg-slate-800 px-4">
                <p class="text-[#0e141b] dark:text-slate-300 text-xs font-medium leading-normal">Dibaca</p>
            </div>
            <div
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-[#e7edf3] dark:bg-slate-800 px-4">
                <p class="text-[#0e141b] dark:text-slate-300 text-xs font-medium leading-normal">Gagal</p>
            </div>
        </div>

        <!-- History List -->
        <main class="flex flex-col gap-1 px-2">
            <!-- Item 1: Read (Success) -->
            <div onclick="window.location.href='{{ route('notifications.show', 1) }}'"
                class="flex gap-3 bg-white dark:bg-background-dark px-4 py-3 rounded-xl active:bg-slate-50 dark:active:bg-slate-800/50 transition-colors cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/30">
                <div class="relative">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-[48px] w-[48px] border-2 border-slate-100 dark:border-slate-800 shadow-sm"
                        data-alt="Portrait of student Ahmad Fauzi"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDLkjk7-MOdAh_2pjJc7-Hxo8lsEtwxJrZufJHcMaMQFH9aGWXi6WYXSIwVv9U3XRKM03TWRNAIjXae3zSUiIPNl8KwwosuiRkWQBCiId3ISgeTdQGtpfKiJDh9FZsD6Qb8AngAClaX-Ro8m1t3CVBth6ufSNxinm_s2TNAJAUG0X5h1QSBYNx1tA_Hdchc6OE-Ekvivcrew4H8huad2gM0Z8L1ry3SgR810r8BX7JhIJD5fYYN0PJeUaVANqZEWNPY7j4R1d9ttZCm");'>
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-white dark:bg-slate-800 rounded-full p-0.5">
                        <span class="material-symbols-outlined text-[#25D366] text-[16px] leading-none">chat</span>
                    </div>
                </div>
                <div class="flex flex-1 flex-col justify-center">
                    <div class="flex justify-between items-start">
                        <p class="text-[#0e141b] dark:text-white text-sm font-semibold leading-none">Ahmad Fauzi</p>
                        <span class="text-[#4e7397] text-[10px] font-normal">08:30</span>
                    </div>
                    <p class="text-primary text-xs font-medium mt-1">Peringatan Absensi</p>
                    <p class="text-[#4e7397] dark:text-slate-400 text-[10px] mt-0.5">10 Feb 2024</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="bg-primary/10 dark:bg-primary/20 text-primary px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">done_all</span>
                        Dibaca
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="mx-4 h-[1px] bg-slate-100 dark:bg-slate-800"></div>

            <!-- Item 2: Sent (WhatsApp) -->
            <div onclick="window.location.href='{{ route('notifications.show', 1) }}'"
                class="flex gap-3 bg-white dark:bg-background-dark px-4 py-3 rounded-xl active:bg-slate-50 dark:active:bg-slate-800/50 transition-colors cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/30">
                <div class="relative">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-[48px] w-[48px] border-2 border-slate-100 dark:border-slate-800"
                        data-alt="Portrait of student Siti Aminah"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCEvuoo8Afk9XjvnuazrX2sqM8LeEHx1ClAhSvNGT24zUXZPtZm_8J1I2P93ech9zC4sj0YaNb-sCZzsgID2em0hIzjqyVKB5nasgWVXjWUO8XwqnDKG91qFX8-Q6CUwrlS1BHqtk1bkoP8MNWZCFimHke1QPN94Luxfh-5ggJFZHxbWz7FUz5igzRjtWHTXMz3AL_1MTF11Vi5XLiwGs6EQvTK4Cf6-yUa6UBa6Mg6MVPofVW6Tqt1vxXnXep-9dSDdru_Ti1eoVp6");'>
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-white dark:bg-slate-800 rounded-full p-0.5">
                        <span class="material-symbols-outlined text-[#25D366] text-[16px] leading-none">chat</span>
                    </div>
                </div>
                <div class="flex flex-1 flex-col justify-center">
                    <div class="flex justify-between items-start">
                        <p class="text-[#0e141b] dark:text-white text-sm font-semibold leading-none">Siti Aminah</p>
                        <span class="text-[#4e7397] text-[10px] font-normal">09:15</span>
                    </div>
                    <p class="text-primary text-xs font-medium mt-1">Info Pembayaran SPP</p>
                    <p class="text-[#4e7397] dark:text-slate-400 text-[10px] mt-0.5">10 Feb 2024</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">check</span>
                        Terkirim
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="mx-4 h-[1px] bg-slate-100 dark:bg-slate-800"></div>

            <!-- Item 3: Failed (App Notification) -->
            <div onclick="window.location.href='{{ route('notifications.show', 1) }}'"
                class="flex gap-3 bg-white dark:bg-background-dark px-4 py-3 rounded-xl active:bg-slate-50 dark:active:bg-slate-800/50 transition-colors cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/30">
                <div class="relative">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-[48px] w-[48px] border-2 border-slate-100 dark:border-slate-800"
                        data-alt="Portrait of student Yusuf Hamdan"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBWhCxARIvcUdlTEVX1IAZI2lTbqw9TIZZiwJkOV9Flq_7JZNo4nVM6BJ5me-W37XnF1WxKYcgY1u-5mQdotChU0rEgbWp42yFj0Mc7Ic3hUa-I2vg5LtS05f57iksaBS-rDuuemOJttPJfjFhla29ROalnCJwQy9AxxQs-06DKJgSpVxBg_8eOAxbI6TH9IrOS6uy0Ze4Xf4XegO1In9MEXKFtzqGtiI9yMPp0C9CYHUnTTdVHPPuzEpnF0KgMk6wJt42V1h0vyztc");'>
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-white dark:bg-slate-800 rounded-full p-0.5">
                        <span
                            class="material-symbols-outlined text-primary text-[16px] leading-none">notifications_active</span>
                    </div>
                </div>
                <div class="flex flex-1 flex-col justify-center">
                    <div class="flex justify-between items-start">
                        <p class="text-[#0e141b] dark:text-white text-sm font-semibold leading-none">Yusuf Hamdan</p>
                        <span class="text-[#4e7397] text-[10px] font-normal">Yesterday</span>
                    </div>
                    <p class="text-primary text-xs font-medium mt-1">Update Akademik</p>
                    <p class="text-[#4e7397] dark:text-slate-400 text-[10px] mt-0.5">09 Feb 2024</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">error_outline</span>
                        Gagal
                    </div>
                </div>
            </div>

            <!-- Item 4: Read (App Notification) -->
            <div onclick="window.location.href='{{ route('notifications.show', 1) }}'"
                class="flex gap-3 bg-white dark:bg-background-dark px-4 py-3 rounded-xl active:bg-slate-50 dark:active:bg-slate-800/50 transition-colors cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/30">
                <div class="relative">
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-[48px] w-[48px] border-2 border-slate-100 dark:border-slate-800"
                        data-alt="Portrait of student Rania Zahra"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC7faSP7wR3ngS3cix3QRimY3qvQtyRxQRSSSU_Kxb8e2zXIx4_XJjsfcjUYlF8hmMSxznK8-2ltstvSCKrqqJAYzTgYDmLjcubKZ0OgBxElPZCXHORnISjjImydrUGekuzkkrzH-q9hbgcEk9tf8w4LyMrB_pNEhrU-JfGSIeVHSBvBGqOf0m5-F36vdT340agCvJCV-ZmCL-YYMSmRDqGItvskbyxEmqlxQ8ETzREdSCxD04yEFNgTr5Nh4fDaOxo2D0kq-utOIyv");'>
                    </div>
                    <div class="absolute -bottom-1 -right-1 bg-white dark:bg-slate-800 rounded-full p-0.5">
                        <span
                            class="material-symbols-outlined text-primary text-[16px] leading-none">notifications_active</span>
                    </div>
                </div>
                <div class="flex flex-1 flex-col justify-center">
                    <div class="flex justify-between items-start">
                        <p class="text-[#0e141b] dark:text-white text-sm font-semibold leading-none">Rania Zahra</p>
                        <span class="text-[#4e7397] text-[10px] font-normal">14:20</span>
                    </div>
                    <p class="text-primary text-xs font-medium mt-1">Jadwal Ujian Baru</p>
                    <p class="text-[#4e7397] dark:text-slate-400 text-[10px] mt-0.5">08 Feb 2024</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="bg-primary/10 dark:bg-primary/20 text-primary px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">done_all</span>
                        Dibaca
                    </div>
                </div>
            </div>
        </main>
        <!-- Empty State (Hidden by default, shown if list is empty) -->
        <div class="hidden flex-1 flex-col items-center justify-center p-12 text-center">
            <div class="w-48 h-48 mb-6 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center">
                <span
                    class="material-symbols-outlined text-slate-300 dark:text-slate-600 text-8xl">notifications_off</span>
            </div>
            <h3 class="text-lg font-bold text-[#0e141b] dark:text-white">Tidak ada riwayat</h3>
            <p class="text-[#4e7397] dark:text-slate-400 mt-2">Data notifikasi yang Anda cari tidak ditemukan di server.
            </p>
        </div>
        <!-- FAB for New Notification -->
        <button
            class="fixed bottom-8 right-8 flex size-12 items-center justify-center rounded-full bg-primary text-white shadow-xl hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined">add_comment</span>
        </button>
        <!-- Safe Area Spacer -->
        <div class="h-20 w-full"></div>
    </div>
</body>

</html>
