<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Menu - TPQ Daarul Gusmi Al-Huffadz</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        'primary': '#4A90B8',
                        'primary-dark': '#3A7CA5',
                        'background-light': '#f5f7fa',
                        'background-dark': '#0f172a',
                        'surface-dark': '#1e293b',
                        'text-main-light': '#1a1a2e',
                        'text-sub-light': '#6b7280'
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        .islamic-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.15'%3E%3Cpath d='M30 0l30 15v30L30 60 0 45V15L30 0zm0 10l-20 10v20l20 10 20-10V20L30 10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass-nav {
            background: rgba(30, 41, 59, 0.95);
        }

        .shadow-nav {
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.08);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark">

    <div
        class="min-h-screen bg-background-light dark:bg-background-dark flex flex-col relative max-w-[430px] mx-auto transition-all duration-300 overflow-hidden">

        <!-- Gradient Header -->
        <div class="bg-gradient-to-br from-[#4A90B8] via-[#3A7CA5] to-[#2E6B8A] relative">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0 islamic-pattern"></div>
            </div>

            <div class="relative z-10 px-6 pt-12 pb-8">
                <!-- Top Bar -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('ustadz.dashboard') }}"
                        class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center hover:bg-white/30 transition-colors">
                        <span class="material-symbols-rounded text-white text-xl">arrow_back</span>
                    </a>
                    <h1 class="text-xl font-bold text-white">Semua Menu</h1>
                    <div class="w-10"></div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="flex-1 bg-white dark:bg-surface-dark rounded-t-[32px] -mt-6 pt-6 pb-28 overflow-y-auto">

            <!-- Akses Cepat -->
            <div class="px-6 mb-8">
                <h3 class="text-sm font-bold text-text-main-light dark:text-white mb-4 px-1">Akses Cepat</h3>
                <div class="flex gap-4 overflow-x-auto no-scrollbar pb-2">
                    <a href="{{ route('presensi.index') }}"
                        class="shrink-0 w-[70px] flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-[18px] bg-blue-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-primary transition-colors duration-300 shadow-sm">
                            <span
                                class="material-symbols-rounded text-primary text-[28px] group-hover:text-white transition-colors">fact_check</span>
                        </div>
                        <span
                            class="text-[11px] font-medium text-text-main-light dark:text-gray-300 text-center">Presensi</span>
                    </a>
                    <a href="{{ route('ustadz.hafalan.index') }}"
                        class="shrink-0 w-[70px] flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-[18px] bg-teal-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-teal-500 transition-colors duration-300 shadow-sm">
                            <span
                                class="material-symbols-rounded text-teal-500 text-[28px] group-hover:text-white transition-colors">menu_book</span>
                        </div>
                        <span
                            class="text-[11px] font-medium text-text-main-light dark:text-gray-300 text-center">Setoran</span>
                    </a>
                    <a href="{{ route('ustadz.nilai.index') }}"
                        class="shrink-0 w-[70px] flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-[18px] bg-orange-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-orange-500 transition-colors duration-300 shadow-sm">
                            <span
                                class="material-symbols-rounded text-orange-500 text-[28px] group-hover:text-white transition-colors">edit_note</span>
                        </div>
                        <span
                            class="text-[11px] font-medium text-text-main-light dark:text-gray-300 text-center">Nilai</span>
                    </a>
                    <a href="{{ route('ustadz.laporan') }}"
                        class="shrink-0 w-[70px] flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-[18px] bg-purple-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-purple-500 transition-colors duration-300 shadow-sm">
                            <span
                                class="material-symbols-rounded text-purple-500 text-[28px] group-hover:text-white transition-colors">history_edu</span>
                        </div>
                        <span
                            class="text-[11px] font-medium text-text-main-light dark:text-gray-300 text-center">Laporan</span>
                    </a>
                </div>
            </div>

            <!-- Menu Utama -->
            <div class="px-6 mb-8">
                <h3 class="text-sm font-bold text-text-main-light dark:text-white mb-6 px-1">Menu Utama</h3>
                <div class="grid grid-cols-4 gap-x-0 gap-y-5 justify-items-center max-w-[340px] mx-auto">
                    <a href="{{ route('help') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">calendar_month</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Jadwal</span>
                    </a>
                    <a href="{{ route('santri.index') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">groups</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Santri</span>
                    </a>
                    <a href="{{ route('ustadz.hafalan.index') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">book_2</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Materi</span>
                    </a>
                    <a href="{{ route('ustadz.broadcast.create') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">campaign</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Info</span>
                    </a>
                    <a href="{{ route('help') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">payments</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Insentif</span>
                    </a>
                    <a href="{{ route('help') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">emoji_events</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Prestasi</span>
                    </a>
                    <a href="{{ route('help') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">volunteer_activism</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Infaq</span>
                    </a>
                    <a href="{{ route('kelas.index') }}" class="flex flex-col items-center gap-2 group">
                        <div
                            class="w-14 h-14 rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-800 shadow-sm flex items-center justify-center group-hover:shadow-md group-hover:-translate-y-1 transition-all">
                            <span class="material-symbols-rounded text-primary text-[28px]">school</span>
                        </div>
                        <span class="text-[11px] font-medium text-text-sub-light dark:text-gray-400">Kelas</span>
                    </a>
                </div>
            </div>

            <!-- Pengaturan -->
            <div class="px-6 mb-8">
                <h3 class="text-sm font-bold text-text-main-light dark:text-white mb-4 px-1">Pengaturan</h3>
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                            <span class="material-symbols-rounded text-primary text-xl">person</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-text-main-light dark:text-white">Profil Saya</p>
                            <p class="text-xs text-text-sub-light dark:text-gray-400">Lihat dan edit profil</p>
                        </div>
                        <span class="material-symbols-rounded text-gray-400 text-xl">chevron_right</span>
                    </a>
                    <div class="border-t border-gray-100 dark:border-gray-700"></div>
                    <a href="{{ route('ustadz.settings') }}"
                        class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <span
                                class="material-symbols-rounded text-gray-600 dark:text-gray-300 text-xl">settings</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-text-main-light dark:text-white">Pengaturan</p>
                            <p class="text-xs text-text-sub-light dark:text-gray-400">Notifikasi, tampilan, dll</p>
                        </div>
                        <span class="material-symbols-rounded text-gray-400 text-xl">chevron_right</span>
                    </a>
                    <div class="border-t border-gray-100 dark:border-gray-700"></div>
                    <a href="{{ route('help') }}"
                        class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center">
                            <span class="material-symbols-rounded text-green-600 text-xl">help</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-text-main-light dark:text-white">Bantuan</p>
                            <p class="text-xs text-text-sub-light dark:text-gray-400">FAQ dan panduan</p>
                        </div>
                        <span class="material-symbols-rounded text-gray-400 text-xl">chevron_right</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Bottom Navigation -->
        <div
            class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[430px] glass-nav h-[90px] shadow-nav flex justify-between items-end pb-6 px-2 z-30">
            <a href="{{ route('ustadz.dashboard') }}" class="flex-1 flex flex-col items-center gap-1 group">
                <span
                    class="material-symbols-rounded text-gray-400 dark:text-gray-500 text-[26px] group-hover:text-primary group-hover:scale-110 transition-all">home</span>
                <span
                    class="text-[10px] font-medium text-gray-400 dark:text-gray-500 group-hover:text-primary transition-colors">Beranda</span>
            </a>
            <a href="{{ route('ustadz.menu') }}" class="flex-1 flex flex-col items-center gap-1">
                <span class="material-symbols-rounded text-primary text-[26px]">menu</span>
                <span class="text-[10px] font-bold text-primary">Menu</span>
            </a>
            <div class="relative w-16 flex justify-center">
                <a href="{{ route('ustadz.hafalan.create') }}"
                    class="absolute -top-12 w-16 h-16 bg-primary rounded-full shadow-[0_8px_20px_rgba(74,144,184,0.4)] flex items-center justify-center transform transition-transform active:scale-95 border-[6px] border-background-light dark:border-background-dark group">
                    <span
                        class="material-symbols-rounded text-white text-[32px] group-hover:rotate-90 transition-transform duration-500">qr_code_scanner</span>
                </a>
            </div>
            <a href="#" class="flex-1 flex flex-col items-center gap-1 group">
                <span
                    class="material-symbols-rounded text-gray-400 dark:text-gray-500 text-[26px] group-hover:text-primary group-hover:scale-110 transition-all">calendar_today</span>
                <span
                    class="text-[10px] font-medium text-gray-400 dark:text-gray-500 group-hover:text-primary transition-colors">Jadwal</span>
            </a>
            <a href="{{ route('profile.index') }}" class="flex-1 flex flex-col items-center gap-1 group">
                <span
                    class="material-symbols-rounded text-gray-400 dark:text-gray-500 text-[26px] group-hover:text-primary group-hover:scale-110 transition-all">person</span>
                <span
                    class="text-[10px] font-medium text-gray-400 dark:text-gray-500 group-hover:text-primary transition-colors">Akun</span>
            </a>
        </div>

    </div>

</body>

</html>
