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
    <title>Laporan Kehadiran Santri</title>
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
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-white dark:bg-background-dark h-screen w-full overflow-hidden flex flex-col font-display text-slate-800 dark:text-slate-100 selection:bg-teal-500 selection:text-white">
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
                        <h1 class="text-xl font-bold leading-tight">Kehadiran Santri</h1>
                        <p class="text-xs opacity-75 mt-0.5">Rekapitulasi Presensi</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button id="headerShareBtn"
                        class="bg-white/20 p-2 rounded-xl backdrop-blur-sm text-white hover:bg-white/30 transition-colors">
                        <span class="material-icons-round text-xl">share</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div
        class="flex-1 bg-white dark:bg-background-dark rounded-t-[2.5rem] -mt-8 relative z-20 overflow-y-auto pb-36 shadow-[0_-4px_20px_rgba(0,0,0,0.1)]">
        <div class="p-6">
            <div class="mb-6">
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-teal-50 dark:bg-teal-900/30 rounded-lg text-teal-600">
                            <span class="material-icons-round">calendar_month</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wider leading-none">
                                Periode</p>
                            <p class="text-sm font-semibold dark:text-white">{{
                                $selectedDate->locale('id')->isoFormat('MMMM Y') }}</p>
                        </div>
                    </div>
                    <button onclick="openDatePicker()"
                        class="text-teal-600 font-semibold text-xs py-2 px-4 bg-teal-50 dark:bg-teal-900/40 rounded-full hover:bg-teal-100 transition-colors">
                        Pilih
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-6">
                <a href="/ustadz/santri"
                    class="block bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800 hover:shadow-md transition-all active:scale-[0.98]">
                    <p class="text-[10px] text-slate-500 font-medium uppercase mb-1">Total Santri</p>
                    <div class="flex items-end gap-2">
                        <span class="text-2xl font-bold text-slate-800 dark:text-white">42</span>
                        <span class="text-[10px] text-slate-400 mb-1">Anak</span>
                    </div>
                </a>
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
                    <p class="text-[10px] text-teal-600 font-medium uppercase mb-1">Hadir</p>
                    <div class="flex items-end gap-2">
                        <span class="text-2xl font-bold text-teal-600">94%</span>
                        <span class="text-[10px] text-teal-400 mb-1">Avg</span>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
                    <p class="text-[10px] text-amber-500 font-medium uppercase mb-1">Izin/Sakit</p>
                    <div class="flex items-end gap-2">
                        <span class="text-2xl font-bold text-amber-500">12</span>
                        <span class="text-[10px] text-amber-400 mb-1">Sesi</span>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800">
                    <p class="text-[10px] text-rose-500 font-medium uppercase mb-1">Alfa</p>
                    <div class="flex items-end gap-2">
                        <span class="text-2xl font-bold text-rose-500">3</span>
                        <span class="text-[10px] text-rose-400 mb-1">Sesi</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mb-4 px-2">
                <h2 class="text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-tight">Rincian Per
                    Santri</h2>
                <div class="flex gap-2">
                    <button class="p-1.5 text-slate-400 hover:text-teal-600 transition-colors">
                        <span class="material-icons-round text-xl">search</span>
                    </button>
                    <button class="p-1.5 text-slate-400 hover:text-teal-600 transition-colors">
                        <span class="material-icons-round text-xl">sort</span>
                    </button>
                </div>
            </div>
            <div class="space-y-3">
                <button
                    class="w-full group bg-white dark:bg-card-dark border border-slate-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <img alt="Ahmad" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBO8picldVhg5DxyIWGP2bd1CURGqoTZxQye-GI3VdxzhEsa73sUsOhb7R-UFW6kpLXhAvbMCvqUJou90pBcHptAkbbN1gkBJcnxiJlMn5WeERIKCK-ax2Pe4WO6gRWCGYKj5GW1YOM9JY3BMt4OTrAyKuuYTJmOTA3HRsvAKartV6js7xL0g3t7KyVTSQAmWogSIX-THTdsGiWo03KfdUoiUjSvjE2QdqgwgZ6XpBt5Wz5qRxQdS_nfMN1nsmfO8bOX8zCvo07Ijur" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-teal-500 border-2 border-white dark:border-slate-800 rounded-full flex items-center justify-center">
                                <span class="material-icons-round text-[10px] text-white">check</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-800 dark:text-white text-sm">Ahmad Syafi'i</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-500 w-[90%]"></div>
                                </div>
                                <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">20/22</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-teal-600">90%</p>
                            <p class="text-[10px] text-slate-400">Aktif</p>
                        </div>
                    </div>
                </button>
                <button
                    class="w-full group bg-white dark:bg-card-dark border border-slate-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <img alt="Fatimah" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCXbtwie968vXM74qXQZ53WBXH8ydrtMfq-yoInyEnrvEXqcZGdTNArX1asr8HfyW_nch1O3B5fJuYvgF2_1mX_0BEZ89brgFGNehsuTw45T38Law1EA2MEfr9A70bXcaGkT873QOOhxKmc0mJQlahgcpvKP5LtvSMYh4pAfT6pthLoyxBqh7kRpYdpJp07QBVfQt2pWYaOLi6AX3DXZocXUoPeoIcrqTn2pqf4_NawEA6eMJKM1Lc3Hedo0m7kSTW7xuti58HyhRzT" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-teal-500 border-2 border-white dark:border-slate-800 rounded-full flex items-center justify-center">
                                <span class="material-icons-round text-[10px] text-white">check</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-800 dark:text-white text-sm">Fatimah Az-Zahra</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-500 w-[100%]"></div>
                                </div>
                                <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">22/22</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-teal-600">100%</p>
                            <p class="text-[10px] text-slate-400">Rajin</p>
                        </div>
                    </div>
                </button>
                <button
                    class="w-full group bg-white dark:bg-card-dark border border-slate-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <img alt="Zaid" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfIaFGef7kJbbHeCJ7uIqe8USsDGpfavgHU1Ain5qOydInqyoDQAd8XkyBrhGBq8rBGZZoCwPiN_2pD-jVYTMwASJEf7hTurUSlfFk-Af9FtgkYckQ4DCY2-48VwN2NJsDxGv4F-FQ5KSaX29ZYpjZgNo3Lkkx8IwRBXgHHkTZcXcMocipuOz8bto0-Volvug9iJVs9aHDOsk4qckfOcpqI0iuGeFIXnIGlosMga3WKg-MevaOSGzaUKGLyq-OxAVg-Q3tPNNDTjVG" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-amber-500 border-2 border-white dark:border-slate-800 rounded-full flex items-center justify-center">
                                <span class="material-icons-round text-[10px] text-white">priority_high</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-800 dark:text-white text-sm">Zaid Al-Khoir</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-500 w-[72%]"></div>
                                </div>
                                <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">16/22</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-amber-500">72%</p>
                            <p class="text-[10px] text-slate-400">Kurang</p>
                        </div>
                    </div>
                </button>
                <button
                    class="w-full group bg-white dark:bg-card-dark border border-slate-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm hover:shadow-md transition-all text-left">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                                <img alt="Maryam" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3jcZyJpLhSgiomvlPkt8vtxM7wYFTXNl1RguTDktUnmZg-r5ZH0fWOhw6JvGlyRqavFT4NM0E_aj5FSGRCDM761XjvcvjAoUDY9Gqt9iKagr2kXYgBcigAVlDmg6cBvbCXnhTrXRJqiJRWujqMdQykDYRi-059OMZdnM4LzmR1EhSQuwyzxY5S5EZJqCsB6EKzcV_1XRSXxrgxVT--cjW20e2aiWIyrVb2ZK6S9upc7ddyIXC3-fry0jUcthe2CKbXrbWwOH3yeU2" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-teal-500 border-2 border-white dark:border-slate-800 rounded-full flex items-center justify-center">
                                <span class="material-icons-round text-[10px] text-white">check</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-800 dark:text-white text-sm">Maryam Nurul Huda</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-500 w-[86%]"></div>
                                </div>
                                <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">19/22</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-teal-600">86%</p>
                            <p class="text-[10px] text-slate-400">Aktif</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
    <!-- Dynamic Period Script -->
    <form id="periodForm" action="{{ route('ustadz.presensi') }}" method="GET" class="hidden">
        <input type="month" name="month" id="monthInput" onchange="this.form.submit()">
    </form>

    <div
        class="fixed bottom-0 left-0 w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 px-6 pt-3 pb-6 z-50 shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="flex gap-3 max-w-[280px] mx-auto">
            <a href="{{ route('ustadz.presensi.pdf') }}"
                class="flex-1 flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white py-3 px-4 rounded-xl font-semibold shadow-lg shadow-teal-500/20 transition-all active:scale-[0.98]">
                <span class="material-icons-round text-xl leading-none">picture_as_pdf</span>
                <span class="text-[13px]">Cetak PDF</span>
            </a>
            <button
                class="flex-1 flex items-center justify-center gap-2 bg-white dark:bg-slate-800 border-2 border-teal-600 text-teal-600 dark:text-teal-400 py-3 px-4 rounded-xl font-semibold transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-xl leading-none font-bold">description</span>
                <span class="text-[13px]">Export Excel</span>
            </button>
        </div>
    </div>

    <script>
        // Period Picker Logic
        function openDatePicker() {
            document.getElementById('monthInput').showPicker();
        }

        // Share Logic
        document.getElementById('headerShareBtn').addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Laporan Kehadiran Santri',
                        text: 'Laporan kehadiran santri periode {{ $selectedDate->translatedFormat("F Y") }}',
                        url: window.location.href,
                    });
                } catch (err) {
                    console.log('Share dismissed');
                }
            } else {
                // Fallback
                alert('Fitur share tidak didukung browser ini. Silakan screenshot atau copy URL.');
            }
        });
    </script>

</body>

</html>
