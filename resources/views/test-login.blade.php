<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santri Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
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
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col items-center justify-center p-6 bg-background-light dark:bg-background-dark">
        <div class="flex flex-col items-center mb-10 w-full">
            <div
                class="size-20 bg-primary/10 dark:bg-primary/20 rounded-3xl flex items-center justify-center text-primary mb-6 ring-1 ring-primary/20">
                <span class="material-symbols-outlined" style="font-size: 40px;">mosque</span>
            </div>
            <h1 class="text-3xl font-bold text-[#111813] dark:text-white mb-2">Santri Login</h1>
            <p class="text-gray-500 dark:text-gray-400 text-center text-sm leading-relaxed">Masuk untuk mengakses
                dashboard,<br />hafalan, dan pengumuman TPQ.</p>
        </div>
        <form action="#" class="w-full flex flex-col gap-5" onsubmit="event.preventDefault();">
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1"
                    for="nis">Nomor Induk Santri</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span
                            class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                            style="font-size: 22px;">badge</span>
                    </div>
                    <input
                        class="block w-full pl-12 pr-4 py-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-[#111813] dark:text-white shadow-sm placeholder-gray-300 focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        id="nis" placeholder="Contoh: 12345678" type="text" />
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1"
                    for="password">Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span
                            class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                            style="font-size: 22px;">lock</span>
                    </div>
                    <input
                        class="block w-full pl-12 pr-12 py-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-[#111813] dark:text-white shadow-sm placeholder-gray-300 focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        id="password" placeholder="••••••••" type="password" />
                    <button
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                        type="button">
                        <span class="material-symbols-outlined" style="font-size: 22px;">visibility_off</span>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between mt-1">
                <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                    <div class="relative flex items-center justify-center">
                        <input
                            class="peer appearance-none size-5 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 checked:bg-primary checked:border-primary transition-all cursor-pointer"
                            type="checkbox" />
                        <span
                            class="material-symbols-outlined absolute text-[#102216] opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none font-bold"
                            style="font-size: 14px;">check</span>
                    </div>
                    <span
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-[#111813] dark:group-hover:text-white transition-colors">Ingat
                        Saya</span>
                </label>
                <a class="text-sm font-bold text-primary hover:underline underline-offset-4 decoration-2" href="#">Lupa
                    Sandi?</a>
            </div>
            <div class="flex flex-col gap-4 mt-4">
                <button
                    class="w-full bg-primary hover:bg-[#10d953] text-[#102216] font-bold py-4 rounded-2xl shadow-lg shadow-primary/25 hover:shadow-primary/40 active:scale-95 transition-all flex items-center justify-center gap-2"
                    type="submit">
                    <span>Masuk Aplikasi</span>
                    <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                </button>
            </div>
        </form>
        <p class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
            Belum terdaftar sebagai Santri?<br />
            <a class="font-bold text-[#111813] dark:text-white hover:text-primary transition-colors" href="#">Hubungi
                Admin TPQ</a>
        </p>
    </div>

</body>

</html>
<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Santri Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
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
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col items-center justify-center p-6 bg-background-light dark:bg-background-dark">
        <div class="flex flex-col items-center mb-10 w-full">
            <div
                class="size-20 bg-primary/10 dark:bg-primary/20 rounded-3xl flex items-center justify-center text-primary mb-6 ring-1 ring-primary/20">
                <span class="material-symbols-outlined" style="font-size: 40px;">mosque</span>
            </div>
            <h1 class="text-3xl font-bold text-[#111813] dark:text-white mb-2">Santri Login</h1>
            <p class="text-gray-500 dark:text-gray-400 text-center text-sm leading-relaxed">Masuk untuk mengakses
                dashboard,<br />hafalan, dan pengumuman TPQ.</p>
        </div>
        <form action="#" class="w-full flex flex-col gap-5" onsubmit="event.preventDefault();">
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1"
                    for="nis">Nomor Induk Santri</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span
                            class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                            style="font-size: 22px;">badge</span>
                    </div>
                    <input
                        class="block w-full pl-12 pr-4 py-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-[#111813] dark:text-white shadow-sm placeholder-gray-300 focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        id="nis" placeholder="Contoh: 12345678" type="text" />
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1"
                    for="password">Kata Sandi</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span
                            class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                            style="font-size: 22px;">lock</span>
                    </div>
                    <input
                        class="block w-full pl-12 pr-12 py-4 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-[#111813] dark:text-white shadow-sm placeholder-gray-300 focus:outline-none focus:border-primary/50 focus:ring-4 focus:ring-primary/10 transition-all"
                        id="password" placeholder="••••••••" type="password" />
                    <button
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                        type="button">
                        <span class="material-symbols-outlined" style="font-size: 22px;">visibility_off</span>
                    </button>
                </div>
            </div>
            <div class="flex items-center justify-between mt-1">
                <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                    <div class="relative flex items-center justify-center">
                        <input
                            class="peer appearance-none size-5 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 checked:bg-primary checked:border-primary transition-all cursor-pointer"
                            type="checkbox" />
                        <span
                            class="material-symbols-outlined absolute text-[#102216] opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none font-bold"
                            style="font-size: 14px;">check</span>
                    </div>
                    <span
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 group-hover:text-[#111813] dark:group-hover:text-white transition-colors">Ingat
                        Saya</span>
                </label>
                <a class="text-sm font-bold text-primary hover:underline underline-offset-4 decoration-2" href="#">Lupa
                    Sandi?</a>
            </div>
            <div class="flex flex-col gap-4 mt-4">
                <button
                    class="w-full bg-primary hover:bg-[#10d953] text-[#102216] font-bold py-4 rounded-2xl shadow-lg shadow-primary/25 hover:shadow-primary/40 active:scale-95 transition-all flex items-center justify-center gap-2"
                    type="submit">
                    <span>Masuk Aplikasi</span>
                    <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                </button>
            </div>
        </form>
        <p class="mt-12 text-center text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
            Belum terdaftar sebagai Santri?<br />
            <a class="font-bold text-[#111813] dark:text-white hover:text-primary transition-colors" href="#">Hubungi
                Admin TPQ</a>
        </p>
    </div>

</body>

</html>
