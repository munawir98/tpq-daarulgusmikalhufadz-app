<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Data Seluruh Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0d9488",
                        "ocean-dark": "#0f766e",
                        "ocean-light": "#2dd4bf",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                        "card-light": "#ffffff",
                        "card-dark": "#1e293b",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                        'xl': '1rem',
                        '2xl': '1.5rem',
                        '3xl': '2rem',
                    },
                    backgroundImage: {
                        'header-pattern': "repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.05) 10px, rgba(255,255,255,0.05) 20px)",
                    }
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #0d9488;
        }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark h-screen w-full overflow-hidden flex flex-col font-display text-slate-800 dark:text-slate-100 selection:bg-teal-500 selection:text-white">
    <div class="bg-gradient-to-br from-teal-600 to-teal-800 dark:from-teal-900 dark:to-slate-950 relative shrink-0">
        <div class="absolute inset-0 bg-header-pattern pointer-events-none"></div>
        <div class="relative z-10 pt-12 pb-14 px-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <button
                        class="bg-white/20 hover:bg-white/30 p-2 rounded-full backdrop-blur-sm text-white transition-colors"
                        onclick="history.back()">
                        <span class="material-icons-round">arrow_back</span>
                    </button>
                    <div class="text-white">
                        <h1 class="text-xl font-bold leading-tight">Data Seluruh Santri</h1>
                        <p class="text-xs opacity-75 mt-0.5">Manajemen Database Santri</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="flex-1 bg-background-light dark:bg-background-dark rounded-t-[2.5rem] -mt-8 relative z-20 overflow-y-auto pb-32 shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">
        <div class="p-6">
            <div class="mb-6">
                <div
                    class="bg-white dark:bg-card-dark p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-teal-50 dark:bg-teal-900/30 rounded-xl flex items-center justify-center text-teal-600">
                        <span class="material-icons-round text-2xl">groups</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-none mb-1">
                            Total Santri</p>
                        <p class="text-lg font-bold dark:text-white text-teal-600">42 <span
                                class="text-slate-400 font-medium">Anak</span></p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mb-6">
                <div class="flex-1 relative">
                    <span
                        class="material-icons-round absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input
                        class="w-full pl-12 pr-4 py-3 bg-white dark:bg-card-dark border-none rounded-2xl text-sm shadow-sm focus:ring-2 focus:ring-teal-500 dark:placeholder-slate-500"
                        placeholder="Cari Nama atau NIS..." type="text" />
                </div>
                <button class="bg-white dark:bg-card-dark p-3 rounded-2xl shadow-sm text-slate-500">
                    <span class="material-icons-round">tune</span>
                </button>
            </div>
            <div class="space-y-3">
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-50 dark:border-slate-800 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-50 dark:border-slate-700">
                        <img alt="Santri" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBO8picldVhg5DxyIWGP2bd1CURGqoTZxQye-GI3VdxzhEsa73sUsOhb7R-UFW6kpLXhAvbMCvqUJou90pBcHptAkbbN1gkBJcnxiJlMn5WeERIKCK-ax2Pe4WO6gRWCGYKj5GW1YOM9JY3BMt4OTrAyKuuYTJmOTA3HRsvAKartV6js7xL0g3t7KyVTSQAmWogSIX-THTdsGiWo03KfdUoiUjSvjE2QdqgwgZ6XpBt5Wz5qRxQdS_nfMN1nsmfO8bOX8zCvo07Ijur" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-white leading-tight">Ahmad Syafi'i</h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">NIS: 2324001</p>
                        <div
                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[9px] font-bold uppercase tracking-wider">
                            Kelas Al-Fatihah
                        </div>
                    </div>
                    <button class="text-slate-300 group-hover:text-teal-500 transition-colors">
                        <span class="material-icons-round">chevron_right</span>
                    </button>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-50 dark:border-slate-800 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-50 dark:border-slate-700">
                        <img alt="Santri" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCXbtwie968vXM74qXQZ53WBXH8ydrtMfq-yoInyEnrvEXqcZGdTNArX1asr8HfyW_nch1O3B5fJuYvgF2_1mX_0BEZ89brgFGNehsuTw45T38Law1EA2MEfr9A70bXcaGkT873QOOhxKmc0mJQlahgcpvKP5LtvSMYh4pAfT6pthLoyxBqh7kRpYdpJp07QBVfQt2pWYaOLi6AX3DXZocXUoPeoIcrqTn2pqf4_NawEA6eMJKM1Lc3Hedo0m7kSTW7xuti58HyhRzT" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-white leading-tight">Fatimah Az-Zahra</h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">NIS: 2324002</p>
                        <div
                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[9px] font-bold uppercase tracking-wider">
                            Kelas Al-Ikhlas
                        </div>
                    </div>
                    <button class="text-slate-300 group-hover:text-teal-500 transition-colors">
                        <span class="material-icons-round">chevron_right</span>
                    </button>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-50 dark:border-slate-800 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-50 dark:border-slate-700">
                        <img alt="Santri" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfIaFGef7kJbbHeCJ7uIqe8USsDGpfavgHU1Ain5qOydInqyoDQAd8XkyBrhGBq8rBGZZoCwPiN_2pD-jVYTMwASJEf7hTurUSlfFk-Af9FtgkYckQ4DCY2-48VwN2NJsDxGv4F-FQ5KSaX29ZYpjZgNo3Lkkx8IwRBXgHHkTZcXcMocipuOz8bto0-Volvug9iJVs9aHDOsk4qckfOcpqI0iuGeFIXnIGlosMga3WKg-MevaOSGzaUKGLyq-OxAVg-Q3tPNNDTjVG" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-white leading-tight">Zaid Al-Khoir</h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">NIS: 2324003</p>
                        <div
                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[9px] font-bold uppercase tracking-wider">
                            Kelas Al-Fatihah
                        </div>
                    </div>
                    <button class="text-slate-300 group-hover:text-teal-500 transition-colors">
                        <span class="material-icons-round">chevron_right</span>
                    </button>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-50 dark:border-slate-800 flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-50 dark:border-slate-700">
                        <img alt="Santri" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3jcZyJpLhSgiomvlPkt8vtxM7wYFTXNl1RguTDktUnmZg-r5ZH0fWOhw6JvGlyRqavFT4NM0E_aj5FSGRCDM761XjvcvjAoUDY9Gqt9iKagr2kXYgBcigAVlDmg6cBvbCXnhTrXRJqiJRWujqMdQykDYRi-059OMZdnM4LzmR1EhSQuwyzxY5S5EZJqCsB6EKzcV_1XRSXxrgxVT--cjW20e2aiWIyrVb2ZK6S9upc7ddyIXC3-fry0jUcthe2CKbXrbWwOH3yeU2" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-white leading-tight">Maryam Nurul Huda</h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">NIS: 2324004</p>
                        <div
                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[9px] font-bold uppercase tracking-wider">
                            Kelas An-Nas
                        </div>
                    </div>
                    <button class="text-slate-300 group-hover:text-teal-500 transition-colors">
                        <span class="material-icons-round">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div
        class="fixed bottom-0 left-0 w-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-t border-slate-100 dark:border-slate-800 px-6 pt-4 pb-10 z-50">
        <button
            class="w-full flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white py-4 px-6 rounded-2xl font-bold shadow-lg shadow-teal-500/30 transition-all active:scale-[0.98]">
            <span class="material-icons-round">person_add</span>
            <span>Tambah Santri Baru</span>
        </button>
    </div>

</body>

</html>
