<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Laporan Kehadiran &amp; Aksi Ustadz</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
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
                        primary: "#0C5A9F",
                        secondary: "#EBF5FF",
                        "background-light": "#F8FAFC",
                        "background-dark": "#0F172A",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "12px",
                    },
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        body { font-family: 'Poppins', sans-serif; }
        .ios-blur { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .chart-grid-line { stroke: #e2e8f0; stroke-width: 1; stroke-dasharray: 4; }
        .dark .chart-grid-line { stroke: #334155; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen pb-48">
    <header class="sticky top-0 z-50 bg-primary/95 dark:bg-slate-900/95 ios-blur shadow-lg shadow-blue-900/10">
        <div class="px-4 py-4 flex items-center gap-4">
            <button onclick="history.back()"
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-white/10 transition-colors text-white">
                <span class="material-symbols-outlined">arrow_back_ios</span>
            </button>
            <div>
                <h1 class="text-lg font-bold text-white leading-tight">Laporan &amp; Atensi</h1>
                <p class="text-[10px] font-bold text-blue-100 uppercase tracking-wider">TPQ Daarul Gusmik Al-Hufadz</p>
            </div>
        </div>
    </header>
    <main class="px-4 pt-6 space-y-6">
        <section
            class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 space-y-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-primary text-sm">filter_list</span>
                <span class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Filter
                    Laporan</span>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase px-1">Periode</label>
                    <div class="relative">
                        <select
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm py-3 pl-3 pr-8 focus:ring-2 focus:ring-primary appearance-none">
                            <option>Januari 2026</option>
                            <option>Februari 2026</option>
                            <option>Maret 2026</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl">expand_more</span>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase px-1">Kelas</label>
                    <div class="relative">
                        <select
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-xl text-sm py-3 pl-3 pr-8 focus:ring-2 focus:ring-primary appearance-none">
                            <option>Semua Kelas</option>
                            <option>Iqra 1</option>
                            <option>Iqra 2</option>
                            <option>Al-Qur'an</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xl">expand_more</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="grid grid-cols-2 gap-4">
            <div class="bg-primary p-4 rounded-2xl text-white shadow-lg shadow-primary/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined opacity-80 text-xl">groups</span>
                    <span class="text-[10px] font-bold bg-white/20 px-2 py-0.5 rounded-full uppercase">Total</span>
                </div>
                <div class="text-2xl font-extrabold tracking-tight">54</div>
                <div class="text-xs opacity-80 font-medium">Santri Terdaftar</div>
            </div>
            <div class="bg-emerald-500 p-4 rounded-2xl text-white shadow-lg shadow-emerald-500/20">
                <div class="flex items-center justify-between mb-2">
                    <span class="material-symbols-outlined opacity-80 text-xl">monitoring</span>
                    <span class="text-[10px] font-bold bg-white/20 px-2 py-0.5 rounded-full uppercase">Avg</span>
                </div>
                <div class="text-2xl font-extrabold tracking-tight">88%</div>
                <div class="text-xs opacity-80 font-medium">Rata-rata Kehadiran</div>
            </div>
        </section>
        <section
            class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl">show_chart</span>
                    <h2 class="font-bold text-slate-800 dark:text-slate-200">Tren Kehadiran Bulanan</h2>
                </div>
                <span
                    class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-1 rounded-lg uppercase tracking-wider">Last
                    6 Months</span>
            </div>
            <div class="relative h-48 w-full mt-4">
                <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 400 160">
                    <line class="chart-grid-line" x1="0" x2="400" y1="0" y2="0"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="40" y2="40"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="80" y2="80"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="120" y2="120"></line>
                    <line class="chart-grid-line" x1="0" x2="400" y1="160" y2="160"></line>
                    <path d="M 0 160 L 0 64 L 80 48 L 160 80 L 240 32 L 320 48 L 400 32 L 400 160 Z"
                        fill="url(#gradient)" opacity="0.1"></path>
                    <path d="M 0 64 L 80 48 L 160 80 L 240 32 L 320 48 L 400 32" fill="none" stroke="#0C5A9F"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                    <circle cx="0" cy="64" fill="#0C5A9F" r="4"></circle>
                    <circle cx="80" cy="48" fill="#0C5A9F" r="4"></circle>
                    <circle cx="160" cy="80" fill="#0C5A9F" r="4"></circle>
                    <circle cx="240" cy="32" fill="#0C5A9F" r="4"></circle>
                    <circle cx="320" cy="48" fill="#0C5A9F" r="4"></circle>
                    <circle cx="400" cy="32" fill="#0C5A9F" r="4"></circle>
                    <defs>
                        <linearGradient id="gradient" x1="0%" x2="0%" y1="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#0C5A9F;stop-opacity:1"></stop>
                            <stop offset="100%" style="stop-color:#0C5A9F;stop-opacity:0"></stop>
                        </linearGradient>
                    </defs>
                </svg>
                <div
                    class="absolute -left-1 top-0 h-full flex flex-col justify-between text-[8px] font-bold text-slate-400 pointer-events-none py-0.5">
                    <span>100%</span>
                    <span>75%</span>
                    <span>50%</span>
                    <span>25%</span>
                    <span>0%</span>
                </div>
            </div>
            <div class="flex justify-between mt-4 px-2">
                <span class="text-[10px] font-bold text-slate-400">Agt</span>
                <span class="text-[10px] font-bold text-slate-400">Sep</span>
                <span class="text-[10px] font-bold text-slate-400">Okt</span>
                <span class="text-[10px] font-bold text-slate-400">Nov</span>
                <span class="text-[10px] font-bold text-slate-400">Des</span>
                <span class="text-[10px] font-bold text-slate-400">Jan</span>
            </div>
        </section>
        <section class="space-y-3">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-rose-500 text-xl">priority_high</span>
                    <h2 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Santri Perlu Perhatian</h2>
                </div>
                <span
                    class="text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-500/10 px-2 py-1 rounded-lg uppercase tracking-wider">&lt;
                    70% Kehadiran</span>
            </div>
            <div class="flex gap-3 overflow-x-auto pb-4 pt-1 hide-scrollbar -mx-4 px-4 snap-x">
                <div
                    class="flex-shrink-0 w-36 bg-white dark:bg-slate-800 p-3 rounded-2xl border border-rose-100 dark:border-rose-900/30 shadow-sm snap-start">
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-rose-500 font-bold overflow-hidden border-2 border-white dark:border-slate-700 shadow-sm">
                                <img alt="Ahmad" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDM81C1pYx76oABjrsPBtuk2dkVg8YspJ_3kTUDLp3zNMYolo4SmlorNrTCgJIq7a0nSyN57TtYydNjRO7S7NGY2M74ge-xhVP2NwqjiBI__U6FxqLF8SeeeXfayGqxbHxJWaYKKSzJ-iBiJF4_aSY5zAjALxi1gWCRSz0ud4IfAvElY8SqTqcx9M_yvzGoG9pU9vcwKCbpJPkN25X5-idFeNaUZi1fhKTEr9LMhaJ9SSPAIiS2q8vTUL94hnkv6XdCUUKRFs53sCI1" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[10px] text-white">warning</span>
                            </div>
                        </div>
                        <div class="space-y-0.5">
                            <h3 class="font-bold text-[11px] text-slate-800 dark:text-slate-200 line-clamp-1">Ahmad
                                Dhani</h3>
                            <div class="text-lg font-black text-rose-600">58%</div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex-shrink-0 w-36 bg-white dark:bg-slate-800 p-3 rounded-2xl border border-rose-100 dark:border-rose-900/30 shadow-sm snap-start">
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-rose-500 font-bold overflow-hidden border-2 border-white dark:border-slate-700 shadow-sm">
                                <img alt="Budi" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDdgSOuyMBMowqqrFI1oaRZp-tuSjl1qdQ533Jp5kXjzBcqgImaCMonXcQJGW5pKGQ9tnH4b_d04dIN53AHdkcXJQEeQl380bsA8CIDC_gMd8H8rTi-USDpZUzpgEnzIKgb22gDK4gyioStxOV3WXFNC1h1wjc28gMIA6DSU174BzTBDYXPvAZ5k9TEl0-LUB5kR_cCe3qSKHuaS32H4Yl5OJo32QUkkDKqrmjvwEPvSeWMNs70VZzh_PeQoJyIj9RbdrpHvbPNROCU" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[10px] text-white">warning</span>
                            </div>
                        </div>
                        <div class="space-y-0.5">
                            <h3 class="font-bold text-[11px] text-slate-800 dark:text-slate-200 line-clamp-1">Zaki
                                Musyafa</h3>
                            <div class="text-lg font-black text-rose-600">62%</div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex-shrink-0 w-36 bg-white dark:bg-slate-800 p-3 rounded-2xl border border-rose-100 dark:border-rose-900/30 shadow-sm snap-start">
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-rose-500 font-bold overflow-hidden border-2 border-white dark:border-slate-700 shadow-sm">
                                <img alt="Siti" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA29r_Kw1sjiSumqEBuCn7MDW24R8WLjmtfhQ8kBV_z0wtazoc-Zr0H4uMNvbxNncGbl80_IMjm_nPNUt4zJqdxe4bwaT995ngrwR1gWnCerol9tYR0gem2tSNwaOhrCAIW9WUylc-c9H0C6jBqYXVSRr3oHFMSqyU4hXRLKojwqyQcxDjJluIr_8rpNVXsjffXdnAFGh31wWNpxTsYViE4OqjJIUBpZnY0WfmAvgJxuYvxswox9WwLWHSmJsvsFp_uqryJVTsj1nzH" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[10px] text-white">warning</span>
                            </div>
                        </div>
                        <div class="space-y-0.5">
                            <h3 class="font-bold text-[11px] text-slate-800 dark:text-slate-200 line-clamp-1">Siti
                                Aminah</h3>
                            <div class="text-lg font-black text-rose-600">45%</div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex-shrink-0 w-36 bg-white dark:bg-slate-800 p-3 rounded-2xl border border-rose-100 dark:border-rose-900/30 shadow-sm snap-start">
                    <div class="flex flex-col items-center text-center space-y-2">
                        <div class="relative">
                            <div
                                class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-rose-500 font-bold overflow-hidden border-2 border-white dark:border-slate-700 shadow-sm">
                                <img alt="Umar" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBVD9xDmS3gOy7en7yO_fbjqBPrw7wNMbvbyYDXDn1_9kPSiOaOTnp8amrGDLyUfGs64S4DRyUqhD7kPVnfOGdD8s39-gQFAUxzm-oAUbDCzJuLYqdDY8quMoxXJGYPXOYcI_d6e8dpMBex22UarYsoomqk8UKXqZgvTyOIZ7jX_STf9lyrs5zqF2w_iVWt70cCpyNOIEzMB4B9GGugNQkoWUo_t1_aGluJ7cXbKcMUcijb4T4WzO3wj2LVwz9ir1u3wvGA6w4zrYoD" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-5 h-5 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[10px] text-white">warning</span>
                            </div>
                        </div>
                        <div class="space-y-0.5">
                            <h3 class="font-bold text-[11px] text-slate-800 dark:text-slate-200 line-clamp-1">Umar
                                Syarif</h3>
                            <div class="text-lg font-black text-rose-600">68%</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="space-y-4">
            <div class="flex items-center justify-between pt-2 px-1">
                <h2 class="font-bold text-slate-800 dark:text-slate-200">Daftar Kehadiran</h2>
                <span class="text-xs font-medium text-slate-500">Januari 2026</span>
            </div>
            <div class="space-y-3 pb-32">
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between">
                    <div class="flex gap-4 items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary font-bold overflow-hidden">
                            <img alt="Avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDyFGyF8aLKn3UddjYSrqm5w3GE-YTnGX0TaqVuBY4VddAPFMW8aNqDMa6Y9M1eDK0Z5lcCwZxp2K8CoERnq-sBB1MZFsBiBUSYTOz1kUD4sCyaAMSwp3F9KYBNhfJeHEMiLf8XfoJX1UpZF_fe7D3AHPfePPWMul3vMxuWoCCCDIjVE0uJ5eDlri4HqK1HyIVatheiql6NECXFI_wK57DE52_DI7Ok8QAvAGsGN6LamK9fxT7ZSVyh1jWnxKRX2qMnAhAP8jEfTpCu" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-sm">Ahmad Syafi'i</h3>
                            <div class="flex gap-2">
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 font-bold border border-emerald-100 dark:border-emerald-500/20">H:
                                    20</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-500/10 text-amber-600 font-bold border border-amber-100 dark:border-amber-500/20">I:
                                    2</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-rose-50 dark:bg-rose-500/10 text-rose-600 font-bold border border-rose-100 dark:border-rose-500/20">A:
                                    0</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-extrabold text-emerald-600">90%</div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between">
                    <div class="flex gap-4 items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary font-bold overflow-hidden">
                            <img alt="Avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlttyb7F5FrUH5lMX9Etv41UyD7GhX8wmvNwlL6vK-AI8dsxcWIkODhYEaWOXFy_d3P-wG0RoyRH8Vrot7jiZLgbYMH7fAd231O6548dWXa7OfC6kjWnsQT9AfzHqEUxjngGkEboefGTI28WiIkXcTrhZjFYV-6k0mLixVM6RGqTXImY1ULN03pT_DKSxlWbCc7re-wtjMK7n-GWkGEJ51GCCw3N4MIFKlPKuh7Iuxa9jt9o-g8X0XUEZHEpeI99qBP3d4XLdwsNKL" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-sm">Fatimah Az-Zahra</h3>
                            <div class="flex gap-2">
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 font-bold border border-emerald-100 dark:border-emerald-500/20">H:
                                    22</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-500/10 text-amber-600 font-bold border border-amber-100 dark:border-amber-500/20">I:
                                    0</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-rose-50 dark:bg-rose-500/10 text-rose-600 font-bold border border-rose-100 dark:border-rose-500/20">A:
                                    0</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-extrabold text-emerald-600">100%</div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between">
                    <div class="flex gap-4 items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary font-bold overflow-hidden">
                            <img alt="Avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOexBbhHgA5pS_tDG4sWqhwUNLTXrqrU0u-C5wsG8sAtUyCpBQAbhoyBe9r0XFAKleGA0AbbsOGx_hWY7JDQiY_p3yBRBn1cJKYygiRjQwLxNEhAMs7vDoy6NTvC957xlbfigKb5DTtE0XPEPMrBgmdbns_ZPT-HlF-Q4S1_ihj7ngciZQBL653N204VsKBgQllGL7fo4V6F4CJ1Lb07OkEJM0ZNKxnhcxcknMqbZiLYombw5vg6ArcWqTcCMtTBe9numBrmltr9r5" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-sm">Zaid Al-Khoir</h3>
                            <div class="flex gap-2">
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 font-bold border border-emerald-100 dark:border-emerald-500/20">H:
                                    16</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-500/10 text-amber-600 font-bold border border-amber-100 dark:border-amber-500/20">I:
                                    4</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-rose-50 dark:bg-rose-500/10 text-rose-600 font-bold border border-rose-100 dark:border-rose-500/20">A:
                                    2</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-extrabold text-amber-500">72%</div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-between">
                    <div class="flex gap-4 items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-primary font-bold overflow-hidden">
                            <img alt="Avatar" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPGoexQ4QrUH9N3fPK8n_PinuEbSeWlKST_sUlGugxIlh5sbMS4ZyUluwA1LUBMX352h2DCVFzPQFA6LU6sqe_2kzX4s0MI2AQAYvIh3U-ojSa0da9iahzhPgd57uk-JZB6Tk2SD-O-WKlrixTTNx5fepk5WgGUuB9nTxwEbjyOpFrGTDAzHT8-SIC3rfgZlflLz1bGIwu49pKpfj0tguriA5MxV33h_yw8Pl7rKgp3FPoUrZ6QJ5to9J9m83f788xHNWieR4j0slX" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-bold text-sm">Maryam Nurul Huda</h3>
                            <div class="flex gap-2">
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 font-bold border border-emerald-100 dark:border-emerald-500/20">H:
                                    19</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-500/10 text-amber-600 font-bold border border-amber-100 dark:border-amber-500/20">I:
                                    2</span>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded bg-rose-50 dark:bg-rose-500/10 text-rose-600 font-bold border border-rose-100 dark:border-rose-500/20">A:
                                    1</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-extrabold text-emerald-600">86%</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div
        class="fixed bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-background-light dark:from-background-dark via-background-light/95 dark:via-background-dark/95 to-transparent pt-12">
        <div class="space-y-3">
            <a href="{{ route('notifications.create') }}"
                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-2xl flex items-center justify-center gap-2 shadow-xl shadow-primary/30 transition-all active:scale-95">
                <span class="material-symbols-outlined text-xl">send_to_mobile</span>
                Kirim Notifikasi ke Orang Tua
            </a>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('ustadz.presensi.pdf', request()->query()) }}" id="exportPdfBtn"
                    class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-rose-500 text-xl">picture_as_pdf</span>
                    <span class="text-sm text-primary">Export PDF</span>
                </a>
                <button
                    class="flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-emerald-500 text-xl">description</span>
                    <span class="text-sm text-primary">Export Excel</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // PDF Loading State Logic
        const exportPdfBtn = document.getElementById('exportPdfBtn');
        if (exportPdfBtn) {
            exportPdfBtn.addEventListener('click', function (e) {
                // Store original content
                const originalContent = this.innerHTML;

                // Change to loading state
                this.innerHTML = `
                    <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-base font-bold whitespace-nowrap">memuat</span>
                `;

                // Disable button
                this.style.pointerEvents = 'none';
                this.classList.add('opacity-75');

                // Revert after 1 second (fallback)
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.pointerEvents = 'auto';
                    this.classList.remove('opacity-75');
                }, 5000); // Increased timeout to mimic redirect
            });
        }
    </script>
</body>

</html>
