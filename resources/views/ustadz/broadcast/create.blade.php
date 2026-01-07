<!DOCTYPE html>
<script>
    // Dark mode init - run before anything else to prevent flash
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Broadcast</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Configuration -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a2e22",
                        "text-main-light": "#111813",
                        "text-main-dark": "#f0fdf4",
                        "text-sub-light": "#61896f",
                        "text-sub-dark": "#a3c2ad",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.5rem", "lg": "0.75rem", "xl": "1rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .toggle-checkbox:checked {
            right: 0;
            border-color: #13ec5b;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #13ec5b;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex justify-center min-h-screen">
    <!-- Mobile Container -->
    <div
        class="relative flex h-full min-h-screen w-full max-w-[480px] flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden shadow-2xl">

        <!-- Top App Bar -->
        <div
            class="sticky top-0 z-20 flex items-center bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm p-4 justify-between border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <a href="{{ route('ustadz.dashboard') }}"
                    class="flex items-center justify-center size-10 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-300"
                        style="font-size: 20px;">arrow_back</span>
                </a>
                <h2 class="text-xl font-bold text-text-main-light dark:text-text-main-dark">Broadcast</h2>
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-1 pb-24 px-4 overflow-y-auto">
            <form action="{{ route('ustadz.broadcast.store') }}" method="POST" class="flex flex-col gap-5 mt-4">
                @csrf

                {{-- Success Message --}}
                @if(session('success'))
                <div id="successAlert"
                    class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-600 dark:text-green-400 text-sm text-center transition-opacity duration-500">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('successAlert');
                        if (alert) {
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
                @endif

                {{-- Error Message --}}
                @if($errors->any())
                <div
                    class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-600 dark:text-red-400 text-sm">
                    {{ $errors->first() }}
                </div>
                @endif

                {{-- Penerima --}}
                <div
                    class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <label
                        class="text-sm font-bold text-text-main-light dark:text-text-main-dark mb-2 block">Penerima</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400" style="font-size: 20px;">groups</span>
                        </div>
                        <select name="target"
                            class="w-full pl-10 pr-10 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all appearance-none text-text-main-light dark:text-white cursor-pointer"
                            required>
                            <option value="all_santri">Semua Santri</option>
                            <option value="all_ustadz">Semua Ustadz</option>
                            <option value="all_users">Semua Pengguna</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="material-symbols-outlined text-gray-400">expand_more</span>
                        </div>
                    </div>
                </div>

                {{-- Judul --}}
                <div
                    class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <label class="text-sm font-bold text-text-main-light dark:text-text-main-dark mb-2 block">Judul
                        Pengumuman</label>
                    <input name="title" type="text"
                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all placeholder:text-gray-400 text-text-main-light dark:text-white"
                        placeholder="Contoh: Libur Hari Raya Idul Fitri" required value="{{ old('title') }}" />
                </div>

                {{-- Isi Pengumuman --}}
                <div
                    class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <label class="text-sm font-bold text-text-main-light dark:text-text-main-dark mb-2 block">Isi
                        Pengumuman</label>
                    <textarea name="content"
                        class="w-full p-4 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm text-text-main-light dark:text-white placeholder:text-gray-400 min-h-[160px] resize-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                        placeholder="Tulis detail pengumuman di sini..." required>{{ old('content') }}</textarea>
                </div>

                {{-- Jadwalkan Posting --}}
                <div
                    class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center size-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                <span class="material-symbols-outlined">schedule_send</span>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="font-bold text-sm text-text-main-light dark:text-text-main-dark">Jadwalkan</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Kirim di waktu tertentu</span>
                            </div>
                        </div>
                        <div class="relative inline-block w-12 align-middle select-none">
                            <input type="checkbox" name="is_scheduled" id="toggle-schedule"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer border-gray-300 dark:border-gray-600 transition-all duration-300 ease-in-out" />
                            <label
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-200 dark:bg-gray-700 cursor-pointer transition-colors duration-300"
                                for="toggle-schedule"></label>
                        </div>
                    </div>
                    <div id="schedule-picker"
                        class="hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 grid grid-cols-2 gap-3">
                        <input type="date" name="schedule_date"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-sm bg-gray-50" />
                        <input type="time" name="schedule_time"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 text-sm bg-gray-50" />
                    </div>
                </div>

                {{-- Info --}}
                <div
                    class="flex gap-3 p-4 bg-yellow-50 dark:bg-yellow-900/10 rounded-xl border border-yellow-100 dark:border-yellow-900/20">
                    <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-500 shrink-0"
                        style="font-size: 20px;">info</span>
                    <p class="text-xs text-yellow-800 dark:text-yellow-400 leading-relaxed">
                        Pengumuman akan dikirimkan melalui notifikasi ke semua penerima yang dipilih.
                    </p>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full py-4 rounded-xl bg-primary text-[#102216] font-bold text-sm shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined" style="font-size: 20px;">send</span>
                    Kirim Pengumuman
                </button>
            </form>
        </div>

    </div>

    <script>
        // Toggle schedule picker
        const toggle = document.getElementById('toggle-schedule');
        const picker = document.getElementById('schedule-picker');
        if (toggle && picker) {
            toggle.addEventListener('change', function () {
                if (this.checked) {
                    picker.classList.remove('hidden');
                } else {
                    picker.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>
