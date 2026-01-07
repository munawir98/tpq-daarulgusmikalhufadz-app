<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Profil - TPQ Digital</title>
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

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between px-5 py-4 relative">
                <a href="/profile"
                    class="p-2 -ml-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-gray-600 dark:text-gray-300">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h2 class="text-xl font-bold absolute left-1/2 -translate-x-1/2">Edit Profil</h2>
                <div class="w-10"></div>
            </div>
        </header>

        <main class="flex flex-col gap-6 px-5 pt-6 flex-1 pb-32">

            <!-- Photo Section -->
            <div class="flex flex-col items-center">
                <div class="relative group cursor-pointer" onclick="document.getElementById('photoInput').click()">
                    <div
                        class="size-28 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden border-4 border-white dark:border-gray-600 shadow-xl">
                        @if(session('user.foto'))
                        <img id="photoPreview" alt="Profile picture" class="w-full h-full object-cover"
                            src="{{ asset('storage/' . session('user.foto')) }}" />
                        @else
                        <img id="photoPreview" alt="Profile picture" class="w-full h-full object-cover hidden" src="" />
                        <div id="photoPlaceholder"
                            class="w-full h-full flex items-center justify-center bg-primary/20 text-primary text-4xl font-bold">
                            {{ substr(session('user.name', 'S'), 0, 1) }}</div>
                        @endif
                        <div
                            class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-full">
                            <span class="material-symbols-outlined text-white">camera_alt</span>
                        </div>
                    </div>
                    <button type="button"
                        class="absolute bottom-1 right-1 p-2 rounded-full bg-primary text-[#102216] border-4 border-white dark:border-background-dark shadow-lg hover:scale-105 transition-transform">
                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                    </button>
                </div>
                <p class="mt-3 text-sm font-medium text-gray-400 dark:text-gray-500">Ketuk untuk ubah foto</p>
                <!-- Hidden file input -->
                <input type="file" id="photoInput" form="profileForm" name="foto" accept="image/*" capture="environment"
                    class="hidden" onchange="previewPhoto(this)" />
            </div>

            <!-- Form -->
            <form id="profileForm" action="/profile/update" method="POST" enctype="multipart/form-data"
                class="flex flex-col gap-5 mt-2">
                @csrf

                <!-- Nama Lengkap -->
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">Nama
                        Lengkap</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                            style="font-size: 20px;">person</span>
                        <input name="name"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3.5 pl-11 pr-4 text-sm font-medium text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white placeholder-gray-400 shadow-sm"
                            placeholder="Masukkan nama lengkap" type="text" value="{{ session('user.name', '') }}" />
                    </div>
                </div>

                <!-- Tingkatan -->
                <div class="flex flex-col gap-2">
                    <label
                        class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">Tingkatan</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                            style="font-size: 20px;">school</span>
                        <select name="tingkatan"
                            class="w-full appearance-none rounded-2xl border border-gray-200 bg-white py-3.5 pl-11 pr-10 text-sm font-medium text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm">
                            <option value="">Pilih Tingkatan</option>
                            <option value="ULA">ULA</option>
                            <option value="WUSTHA">WUSTHA</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                            style="font-size: 24px;">arrow_drop_down</span>
                    </div>
                </div>

                <!-- Halaqoh -->
                <div class="flex flex-col gap-2">
                    <label
                        class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">Halaqoh</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                            style="font-size: 20px;">groups</span>
                        <select name="halaqoh"
                            class="w-full appearance-none rounded-2xl border border-gray-200 bg-white py-3.5 pl-11 pr-10 text-sm font-medium text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm">
                            <option value="">Pilih Halaqoh</option>
                            <option value="A">Halaqoh A</option>
                            <option value="B">Halaqoh B</option>
                            <option value="C">Halaqoh C</option>
                            <option value="D">Halaqoh D</option>
                            <option value="E">Halaqoh E</option>
                            <option value="F">Halaqoh F</option>
                            <option value="G">Halaqoh G</option>
                            <option value="H">Halaqoh H</option>
                            <option value="I">Halaqoh I</option>
                            <option value="J">Halaqoh J</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                            style="font-size: 24px;">arrow_drop_down</span>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label
                        class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                            style="font-size: 20px;">mail</span>
                        <input name="email"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3.5 pl-11 pr-4 text-sm font-medium text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white placeholder-gray-400 shadow-sm"
                            placeholder="Masukkan alamat email" type="email" value="{{ session('user.email', '') }}" />
                    </div>
                </div>

                <!-- Nomor WhatsApp -->
                <div class="flex flex-col gap-2">
                    <label
                        class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">Nomor
                        WhatsApp</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"
                            style="font-size: 20px;">call</span>
                        <input name="no_hp"
                            class="w-full rounded-2xl border border-gray-200 bg-white py-3.5 pl-11 pr-4 text-sm font-medium text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white placeholder-gray-400 shadow-sm"
                            placeholder="Contoh: 0812..." type="tel" value="" />
                    </div>
                </div>

            </form>
        </main>

        <!-- Save Button -->
        <div
            class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto px-5 pt-4 pb-8 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md z-20 border-t border-gray-100 dark:border-gray-800/50">
            <button type="submit" onclick="document.querySelector('form').submit()"
                class="w-full flex items-center justify-center gap-2 p-4 rounded-2xl bg-primary text-[#102216] font-bold text-base shadow-lg shadow-primary/20 hover:shadow-primary/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                <span class="material-symbols-outlined" style="font-size: 20px;">check</span>
                Simpan Perubahan
            </button>
        </div>
    </div>

    <script>
        // Dark mode check
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        // Preview photo before upload
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('photoPreview');
                    const placeholder = document.getElementById('photoPlaceholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
