<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santri Dashboard</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#10B981",
                        "primary-dark": "#047857",
                        "background-light": "#F3F4F6",
                        "background-dark": "#111827",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            min-height: 100vh;
            /* overflow: hidden; Removed for desktop scroll */
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark shadow-2xl pb-24">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between px-5 py-4">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Assalamu'alaikum,</span>
                    <h2 class="text-xl font-bold leading-tight tracking-tight text-[#111813] dark:text-white">{{
                        session('user.name', 'Santri') }}</h2>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('notifications.index') }}"
                        class="relative flex items-center justify-center size-10 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-300"
                            style="font-size: 22px;">notifications</span>
                        @php
                        $unreadCount = \App\Models\User::find(session('user.id'))->unreadNotifications()->count();
                        @endphp
                        @if($unreadCount > 0)
                        <span
                            class="absolute top-2 right-2.5 size-2 bg-red-500 rounded-full border border-white dark:border-gray-800"></span>
                        @endif
                    </a>
                    <a href="{{ route('profile.index') }}"
                        class="size-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden border border-gray-100 dark:border-gray-600">
                        @if(session('user.foto'))
                        <img alt="Foto Profil" class="w-full h-full object-cover"
                            src="{{ Str::startsWith(session('user.foto'), 'data:') ? session('user.foto') : asset('storage/' . session('user.foto')) }}" />
                        @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-primary/20 text-primary font-bold">
                            {{ substr(session('user.name', 'S'), 0, 1) }}</div>
                        @endif
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 w-full px-5 py-6 flex flex-col gap-6 pb-24">

            <!-- Statistik Card -->
            <div class="grid grid-cols-2 gap-3">
                <div
                    class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-4 text-white shadow-lg shadow-primary/20 relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-0 p-3 opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <span class="material-symbols-outlined text-6xl">fact_check</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-medium text-white/80 mb-1">Total Hadir</p>
                        <h3 class="text-3xl font-bold mb-1">24</h3>
                        <p class="text-[10px] bg-white/20 inline-block px-1.5 py-0.5 rounded text-white/90">Bulan Ini
                        </p>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-0 p-3 opacity-5 dark:opacity-10 group-hover:scale-110 transition-transform duration-500">
                        <span class="material-symbols-outlined text-green-500 text-6xl">book</span>
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Hafalan</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white mb-1">Juz 30</h3>
                        <p class="text-[10px] text-green-600 font-medium">Dalam Progress</p>
                    </div>
                </div>
            </div>

            <!-- Menu Cepat -->
            <div>
                <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-3">Menu Cepat</h3>
                <div class="grid grid-cols-4 gap-4">
                    <a href="{{ route('santri.jadwal') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="size-12 rounded-2xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center shadow-sm group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30 transition-colors">
                            <span class="material-symbols-outlined">calendar_month</span>
                        </div>
                        <span class="text-[10px] font-medium text-gray-600 dark:text-gray-400 text-center">Jadwal</span>
                    </a>

                    <a href="{{ route('santri.hafalan.index') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="size-12 rounded-2xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 flex items-center justify-center shadow-sm group-hover:bg-orange-100 dark:group-hover:bg-orange-900/30 transition-colors">
                            <span class="material-symbols-outlined">history</span>
                        </div>
                        <span
                            class="text-[10px] font-medium text-gray-600 dark:text-gray-400 text-center">Riwayat</span>
                    </a>

                    <a href="#" class="flex flex-col items-center gap-2 group">
                        <div
                            class="size-12 rounded-2xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 flex items-center justify-center shadow-sm group-hover:bg-purple-100 dark:group-hover:bg-purple-900/30 transition-colors">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <span class="text-[10px] font-medium text-gray-600 dark:text-gray-400 text-center">SPP</span>
                    </a>

                    <a href="#" class="flex flex-col items-center gap-2 group">
                        <div
                            class="size-12 rounded-2xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center shadow-sm group-hover:bg-teal-100 dark:group-hover:bg-teal-900/30 transition-colors">
                            <span class="material-symbols-outlined">campaign</span>
                        </div>
                        <span
                            class="text-[10px] font-medium text-gray-600 dark:text-gray-400 text-center">Pengumuman</span>
                    </a>
                </div>
            </div>

            <!-- Jadwal Hari Ini -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-white">Jadwal Hari Ini</h3>
                    <a href="{{ route('santri.jadwal') }}"
                        class="text-xs font-semibold text-primary hover:text-primary-dark">Lihat Semua</a>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm flex items-start gap-4">
                    <div
                        class="flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-xl p-2 w-14 h-14 shrink-0">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400">{{
                            \Carbon\Carbon::now()->format('M') }}</span>
                        <span class="text-xl font-bold text-primary">{{ \Carbon\Carbon::now()->format('d') }}</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 dark:text-white mb-1">Tahsin & Tahfidz</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            16:00 - 17:30 WIB
                        </p>
                        <div class="flex items-center gap-2">
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">Kelas
                                A</span>
                            <span
                                class="px-2 py-0.5 rounded text-[10px] font-medium bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400">Masuk</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quote Card -->
            <div
                class="bg-gradient-to-r from-orange-400 to-amber-500 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                <div class="absolute -left-6 -top-6 w-24 h-24 bg-white/20 rounded-full blur-xl"></div>
                <div class="relative z-10 text-center">
                    <span class="material-symbols-outlined text-4xl mb-2 opacity-80">format_quote</span>
                    <p class="text-sm font-medium italic mb-2">"Sebaik-baik kalian adalah yang mempelajari Al-Qur'an dan
                        mengajarkannya."</p>
                    <p class="text-xs opacity-90 font-bold">- HR. Bukhari</p>
                </div>
            </div>

        </main>

        <!-- Bottom Navigation -->
        @include('layouts.partials.bottom-nav')
    </div>
</body>

</html>
