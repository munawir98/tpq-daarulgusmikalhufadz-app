<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tambah Jadwal Baru - TPQ Management</title>
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
    <style type="text/tailwindcss">body {
    font-family: "Plus Jakarta Sans", sans-serif
    }
.no-scrollbar::-webkit-scrollbar {
    display: none
    }
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none
    }
select {
    appearance: none;
    background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuDQX5gscGNwryI0HFCzozu7g-TRJXoqJTQzI0vgs7plLw9Dbyr8uG_TjcinxipZo3vKmz806w2l0n-WWs7_Xb3DbqC5_altdl6PLkqJ_HdIh4xaXem5WEfCVj5B1U_C73rKSIh55SP7p4QWxJnOqQ76gU6L-WAKUSj1PzVAbH8HfZOzo_HWh1Hq8JeYU4V4KY1YEW5wcVMhm7Eqsiu19367ujO3h6g3mqfEo6XhA_3PIzzNMMyRU1PQ7pX6md8XZwnbhd9IVsqcvfFa);
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.25rem
    }</style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen text-[#111816] dark:text-white pb-32">
    <div class="sticky top-0 z-50 bg-primary px-4 py-6 flex items-center gap-4 shadow-md">
        <a href="{{ route('ustadz.jadwal') }}"
            class="flex items-center justify-center size-10 rounded-full bg-white/20 text-white active:scale-90 transition-transform">
            <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <h1 class="text-white text-xl font-bold leading-tight tracking-tight">Tambah Jadwal Baru</h1>
    </div>
    <main class="max-w-md mx-auto px-4 py-6 space-y-6">
        <div class="bg-white dark:bg-[#1a2e29] rounded-2xl p-5 shadow-sm space-y-6">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Pilih Kelas</label>
                <div class="relative">
                    <select
                        class="w-full bg-background-light dark:bg-background-dark border-none rounded-xl py-4 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-gray-600 dark:text-gray-200">
                        <option disabled="" selected="" value="">Pilih Nama Kelas</option>
                        <option value="1">Kelas Al-Fatihah</option>
                        <option value="2">Kelas Al-Ikhlas</option>
                        <option value="3">Kelas An-Naba</option>
                    </select>
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Pilih Ustadz</label>
                <div class="relative">
                    <select
                        class="w-full bg-background-light dark:bg-background-dark border-none rounded-xl py-4 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-gray-600 dark:text-gray-200">
                        <option disabled="" selected="" value="">Pilih Pengajar</option>
                        <option value="1">Ustadz Ahmad Fauzi</option>
                        <option value="2">Ustadzah Fatimah Azzahra</option>
                        <option value="3">Ustadz Muhammad Ali</option>
                    </select>
                </div>
            </div>
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Pilih Hari</label>
                <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-background-dark hover:border-primary transition-colors"
                        type="button">
                        <span class="text-xs font-semibold text-gray-500">Sen</span>
                    </button>
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-background-dark hover:border-primary transition-colors"
                        type="button">
                        <span class="text-xs font-semibold text-gray-500">Sel</span>
                    </button>
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/20 ring-2 ring-primary ring-offset-2 dark:ring-offset-[#1a2e29]"
                        type="button">
                        <span class="text-xs font-bold">Rab</span>
                    </button>
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-background-dark hover:border-primary transition-colors"
                        type="button">
                        <span class="text-xs font-semibold text-gray-500">Kam</span>
                    </button>
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-background-dark hover:border-primary transition-colors"
                        type="button">
                        <span class="text-xs font-semibold text-gray-500">Jum</span>
                    </button>
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-background-dark hover:border-primary transition-colors"
                        type="button">
                        <span class="text-xs font-semibold text-gray-500">Sab</span>
                    </button>
                    <button
                        class="min-w-[50px] aspect-square flex flex-col items-center justify-center rounded-xl border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-background-dark hover:border-primary transition-colors"
                        type="button">
                        <span class="text-xs font-semibold text-gray-500">Min</span>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Jam Mulai</label>
                    <div class="relative">
                        <input
                            class="w-full bg-background-light dark:bg-background-dark border-none rounded-xl py-4 pl-4 pr-10 text-sm focus:ring-2 focus:ring-primary/50 text-gray-600 dark:text-gray-200"
                            placeholder="16:00" type="text" />
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary text-xl pointer-events-none">schedule</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Jam Selesai</label>
                    <div class="relative">
                        <input
                            class="w-full bg-background-light dark:bg-background-dark border-none rounded-xl py-4 pl-4 pr-10 text-sm focus:ring-2 focus:ring-primary/50 text-gray-600 dark:text-gray-200"
                            placeholder="17:30" type="text" />
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-primary text-xl pointer-events-none">schedule</span>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Materi Pembelajaran</label>
                <div class="relative">
                    <textarea
                        class="w-full bg-background-light dark:bg-background-dark border-none rounded-xl py-4 px-4 text-sm focus:ring-2 focus:ring-primary/50 text-gray-600 dark:text-gray-200 resize-none"
                        placeholder="Masukkan detail materi pembelajaran..." rows="3"></textarea>
                    <span
                        class="material-symbols-outlined absolute right-3 top-4 text-primary text-xl pointer-events-none">menu_book</span>
                </div>
            </div>
        </div>
        <div class="px-2">
            <div class="flex items-start gap-3 p-4 bg-primary/5 border border-primary/20 rounded-xl">
                <span class="material-symbols-outlined text-primary text-xl">info</span>
                <p class="text-xs text-[#61897f] leading-relaxed">
                    Pastikan jadwal yang Anda buat tidak bertabrakan dengan jadwal kelas lain yang menggunakan pengajar
                    yang sama.
                </p>
            </div>
        </div>
    </main>
    <div
        class="fixed bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-background-light via-background-light to-transparent dark:from-background-dark dark:via-background-dark">
        <div class="max-w-md mx-auto">
            <button
                class="w-full bg-primary text-white font-bold py-4 px-6 rounded-2xl shadow-xl shadow-primary/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Simpan Jadwal
            </button>
        </div>
    </div>

</body>

</html>
