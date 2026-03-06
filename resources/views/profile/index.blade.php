<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pengaturan - TPQ Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
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
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            min-height: 100vh;
            overflow-y: auto;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark shadow-2xl">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-center px-4 py-2.5 relative">
                <h2 class="text-lg font-bold">Pengaturan</h2>
            </div>
        </header>

        <main class="flex flex-col gap-4 px-4 pt-2.5">

            <!-- Profile Card -->
            <div
                class="flex flex-col items-center bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <form id="photoForm" action="/profile/upload-photo" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="relative cursor-pointer" onclick="document.getElementById('photoInputMain').click()">
                        <div
                            class="size-20 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden border-3 border-white dark:border-gray-600 shadow-md mb-2">
                            @if(session('user.foto'))
                            <img id="photoPreviewMain" alt="Profile picture" class="w-full h-full object-cover"
                                src="{{ asset('storage/' . session('user.foto')) }}" />
                            @else
                            <img id="photoPreviewMain" alt="Profile picture" class="w-full h-full object-cover hidden"
                                src="" />
                            <div id="photoPlaceholderMain"
                                class="w-full h-full flex items-center justify-center bg-primary/20 text-primary text-2xl font-bold">
                                {{ substr(session('user.name', 'S'), 0, 1) }}</div>
                            @endif
                            <div
                                class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-full">
                                <span class="material-symbols-outlined text-white">camera_alt</span>
                            </div>
                        </div>
                        <button type="button"
                            class="absolute bottom-2 right-0 w-6 h-6 flex items-center justify-center rounded-full bg-primary text-[#102216] border-2 border-white dark:border-gray-800 shadow-md hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-size: 12px;">edit</span>
                        </button>
                    </div>
                    <input type="file" id="photoInputMain" name="foto" accept="image/*" capture="environment"
                        class="hidden" onchange="previewAndSubmitPhoto(this)" />
                </form>
                <h2 class="text-base font-bold text-[#111813] dark:text-white text-center">{{ session('user.name',
                    'Santri') }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">NIS: {{ session('user.nis', '-') }}</p>
            </div>

            <!-- Akun Section -->
            <div class="flex flex-col gap-1.5">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">Akun
                </h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <a href="/profile/edit"
                        class="flex items-center gap-2.5 p-3 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-1.5 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">person</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Edit Profil</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 18px;">chevron_right</span>
                    </a>
                    <a href="/profile/password"
                        class="flex items-center gap-2.5 p-3 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div
                            class="p-1.5 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">lock</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Ubah Kata Sandi</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 18px;">chevron_right</span>
                    </a>
                </div>
            </div>

            <!-- Preferensi Aplikasi Section -->
            <div class="flex flex-col gap-1.5">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">
                    Preferensi Aplikasi</h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <a href="/profile/notifications"
                        class="flex items-center gap-2.5 p-3 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-1.5 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">notifications</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Notifikasi</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 18px;">chevron_right</span>
                    </a>
                    <div class="flex items-center gap-2.5 p-3 w-full border-b border-gray-100 dark:border-gray-700">
                        <div
                            class="p-1.5 rounded-lg bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">language</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Bahasa</p>
                        </div>
                        <span class="text-xs font-medium text-gray-400 mr-1">Indonesia</span>
                        <span class="material-symbols-outlined text-gray-400"
                            style="font-size: 18px;">chevron_right</span>
                    </div>
                    <div class="flex items-center gap-2.5 p-3 w-full">
                        <div
                            class="p-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">dark_mode</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Mode Gelap</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input id="darkModeToggle" class="sr-only peer" type="checkbox" />
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Lainnya Section -->
            <div class="flex flex-col gap-1.5">
                <h3 class="text-[10px] font-bold text-gray-500 dark:text-gray-400 px-1 uppercase tracking-wider">Lainnya
                </h3>
                <div
                    class="flex flex-col bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                    <a href="/help"
                        class="flex items-center gap-2.5 p-3 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-b border-gray-100 dark:border-gray-700 group">
                        <div
                            class="p-1.5 rounded-lg bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">help</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Bantuan & Dukungan</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 18px;">chevron_right</span>
                    </a>
                    <a href="/about"
                        class="flex items-center gap-2.5 p-3 w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div
                            class="p-1.5 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 shrink-0">
                            <span class="material-symbols-outlined" style="font-size: 18px;">info</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-[13px] text-[#111813] dark:text-white">Tentang Aplikasi</p>
                        </div>
                        <span
                            class="material-symbols-outlined text-gray-400 group-hover:translate-x-1 transition-transform"
                            style="font-size: 18px;">chevron_right</span>
                    </a>
                </div>
            </div>

            <!-- Logout Button -->
            <a href="/logout"
                class="w-full flex items-center justify-center gap-2 p-3 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-bold text-[13px] border border-red-100 dark:border-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors mb-1">
                <span class="material-symbols-outlined" style="font-size: 18px;">logout</span>
                Keluar
            </a>

            <p class="text-center text-[10px] text-gray-400 pb-4">Versi Aplikasi {{ config('app.version', '1.0.0') }}
            </p>
        </main>


    </div>

    <script>
        // Dark Mode Toggle
        const darkToggle = document.getElementById('darkModeToggle');

        // Check saved preference
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
            darkToggle.checked = true;
        }

        darkToggle.addEventListener('change', function () {
            if (this.checked) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        });

        // Photo upload preview and submit
        function previewAndSubmitPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('photoPreviewMain');
                    const placeholder = document.getElementById('photoPlaceholderMain');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);

                // Submit form after short delay for preview
                setTimeout(() => {
                    document.getElementById('photoForm').submit();
                }, 500);
            }
        }
    </script>
</body>

</html>
