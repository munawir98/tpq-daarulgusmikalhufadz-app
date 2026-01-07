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
    <title>Admin Dashboard Screen</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b",
                        "primary-dark": "#0ea841",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1c3024",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "full": "9999px" },
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

<body
    class="bg-background-light dark:bg-background-dark text-[#111813] dark:text-gray-100 font-display min-h-screen antialiased overflow-x-hidden selection:bg-primary selection:text-black">

    <!-- Main Container with max-width -->
    <div
        class="relative flex min-h-screen w-full max-w-md mx-auto flex-col shadow-xl bg-background-light dark:bg-background-dark">

        <div
            class="sticky top-0 z-50 bg-background-light/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex flex-col">
                    <h2 class="text-xl font-extrabold leading-tight text-gray-900 dark:text-white">Dashboard</h2>
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">TPQ Daarul Gusmik Al-Hufadz</p>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-600 dark:text-gray-300 relative group">
                        <span class="material-symbols-outlined text-[24px]">notifications</span>
                        <span
                            class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-surface-dark animate-pulse"></span>
                    </button>
                    <button
                        class="w-10 h-10 rounded-full ring-2 ring-gray-100 dark:ring-gray-700 overflow-hidden bg-gray-200">
                        @if(session('user.foto'))
                        <img src="{{ asset('storage/' . session('user.foto')) }}" class="w-full h-full object-cover"
                            alt="Profile">
                        @else
                        <div
                            class="w-full h-full flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-bold">
                            {{ substr(session('user.name', 'A'), 0, 1) }}
                        </div>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        <main class="flex-1 flex flex-col gap-6 pb-28 pt-4">
            <!-- Greeting Card -->
            <div class="px-4">
                <div
                    class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Selamat Datang,</p>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ session('user.name', 'Admin') }}
                        </h3>
                    </div>
                    <div
                        class="bg-primary/10 dark:bg-primary/20 text-primary-dark dark:text-primary px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        System Active
                    </div>
                </div>
            </div>

            <!-- Overview Section -->
            <div class="px-4">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3 px-1">
                    Overview
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div
                        class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col relative overflow-hidden group">
                        <div
                            class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-full transition-transform group-hover:scale-110">
                        </div>
                        <div
                            class="bg-blue-100 dark:bg-blue-900/30 w-10 h-10 rounded-lg flex items-center justify-center mb-3 relative z-10">
                            <span
                                class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-[24px]">groups</span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white relative z-10">312</p>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 relative z-10">Total Santri</p>
                    </div>
                    <div
                        class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col relative overflow-hidden group">
                        <div
                            class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 dark:bg-green-900/10 rounded-full transition-transform group-hover:scale-110">
                        </div>
                        <div
                            class="bg-green-100 dark:bg-green-900/30 w-10 h-10 rounded-lg flex items-center justify-center mb-3 relative z-10">
                            <span
                                class="material-symbols-outlined text-green-600 dark:text-green-400 text-[24px]">school</span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white relative z-10">24</p>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 relative z-10">Total Ustadz</p>
                    </div>
                    <div
                        class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col relative overflow-hidden group">
                        <div
                            class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 dark:bg-orange-900/10 rounded-full transition-transform group-hover:scale-110">
                        </div>
                        <div
                            class="bg-orange-100 dark:bg-orange-900/30 w-10 h-10 rounded-lg flex items-center justify-center mb-3 relative z-10">
                            <span
                                class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-[24px]">class</span>
                        </div>
                        <p class="text-3xl font-extrabold text-gray-900 dark:text-white relative z-10">12</p>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 relative z-10">Active Classes
                        </p>
                    </div>
                    <div
                        class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-red-100 dark:border-red-900/30 flex flex-col relative overflow-hidden group">
                        <div
                            class="absolute -right-4 -top-4 w-24 h-24 bg-red-50 dark:bg-red-900/10 rounded-full transition-transform group-hover:scale-110">
                        </div>
                        <div
                            class="bg-red-100 dark:bg-red-900/30 w-10 h-10 rounded-lg flex items-center justify-center mb-3 relative z-10">
                            <span
                                class="material-symbols-outlined text-red-600 dark:text-red-400 text-[24px]">assignment_late</span>
                        </div>
                        <div class="flex items-baseline gap-1 relative z-10">
                            <p class="text-3xl font-extrabold text-gray-900 dark:text-white">8</p>
                            <span class="w-2 h-2 bg-red-500 rounded-full mb-2"></span>
                        </div>
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 relative z-10">Pending Setoran
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-4">
                <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3 px-1">
                    Management
                </h3>
                <div class="flex flex-col gap-3">
                    <button
                        class="w-full bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4 text-left hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors active:scale-[0.99] group">
                        <div
                            class="bg-indigo-50 dark:bg-indigo-900/20 w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30">
                            <span
                                class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[24px]">manage_accounts</span>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                                Manage Users</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Santri, Ustadz, and Staff
                                accounts
                            </p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 dark:text-gray-600 group-hover:text-primary transition-colors">chevron_right</span>
                    </button>
                    <button
                        class="w-full bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4 text-left hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors active:scale-[0.99] group">
                        <div
                            class="bg-teal-50 dark:bg-teal-900/20 w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors group-hover:bg-teal-100 dark:group-hover:bg-teal-900/30">
                            <span
                                class="material-symbols-outlined text-teal-600 dark:text-teal-400 text-[24px]">edit_calendar</span>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                                Manage Classes</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Schedules, Assignments &amp;
                                Rooms
                            </p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 dark:text-gray-600 group-hover:text-primary transition-colors">chevron_right</span>
                    </button>
                    <button
                        class="w-full bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4 text-left hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors active:scale-[0.99] group">
                        <div
                            class="bg-amber-50 dark:bg-amber-900/20 w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors group-hover:bg-amber-100 dark:group-hover:bg-amber-900/30">
                            <span
                                class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-[24px]">campaign</span>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                                Announcements</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Broadcast updates to TPQ members
                            </p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 dark:text-gray-600 group-hover:text-primary transition-colors">chevron_right</span>
                    </button>
                    <button
                        class="w-full bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex items-center gap-4 text-left hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors active:scale-[0.99] group">
                        <div
                            class="bg-purple-50 dark:bg-purple-900/20 w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors group-hover:bg-purple-100 dark:group-hover:bg-purple-900/30">
                            <span
                                class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-[24px]">bar_chart</span>
                        </div>
                        <div class="flex-1">
                            <p
                                class="text-base font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                                System Reports</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Attendance, Progress, and Stats
                            </p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-300 dark:text-gray-600 group-hover:text-primary transition-colors">chevron_right</span>
                    </button>
                </div>
            </div>
            <div class="px-4 mt-2">
                <div
                    class="p-4 rounded-xl bg-gradient-to-r from-gray-900 to-gray-800 dark:from-gray-800 dark:to-gray-700 text-white flex items-center justify-between shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="bg-white/10 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-[20px]">system_update</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold">System Status</p>
                            <p class="text-[10px] text-gray-300">All services operational</p>
                        </div>
                    </div>
                    <div class="text-[10px] font-mono bg-black/20 px-2 py-1 rounded">v2.1.0</div>
                </div>
            </div>
        </main>
        <div
            class="sticky bottom-0 bg-surface-light dark:bg-surface-dark border-t border-gray-200 dark:border-gray-800 pb-safe pt-2 px-2 z-50">
            <div class="flex justify-around items-center h-16 pb-2">
                <button class="flex flex-col items-center justify-center w-full gap-1 text-primary">
                    <span class="material-symbols-outlined text-[26px] fill-1">dashboard</span>
                    <span class="text-[10px] font-bold">Dashboard</span>
                </button>
                <a href="/admin/santri"
                    class="flex flex-col items-center justify-center w-full gap-1 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <span class="material-symbols-outlined text-[26px]">people</span>
                    <span class="text-[10px] font-medium">Users</span>
                </a>
                <a href="/admin/kelas"
                    class="flex flex-col items-center justify-center w-full gap-1 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <span class="material-symbols-outlined text-[26px]">class</span>
                    <span class="text-[10px] font-medium">Classes</span>
                </a>
                <a href="/admin/settings"
                    class="flex flex-col items-center justify-center w-full gap-1 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <span class="material-symbols-outlined text-[26px]">settings</span>
                    <span class="text-[10px] font-medium">Settings</span>
                </a>
            </div>
        </div>
    </div> <!-- End of max-width container -->

</body>

</html>
