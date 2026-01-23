<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manajemen Daftar Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2563eb", // SOLID BLUE (Blue 600)
                        "primary-dark": "#1d4ed8", // Blue 700
                        "background-light": "#f6f8f8",
                        "background-dark": "#0f172a", // Slate 900
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
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
    <style type="text/tailwindcss">
        body {
            font-family: "Plus Jakarta Sans", sans-serif;
            min-height: max(884px, 100dvh);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1;
        }
        /* Dropdown logic */
        .dropdown-menu {
            display: none;
        }
        .group-menu:focus-within .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }
        /* Pagination Styling */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            padding-top: 1rem;
        }
    </style>
    <script>
        // Dark mode check
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen">
    <div
        class="relative flex h-full min-h-screen w-full flex-col max-w-[480px] mx-auto bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl">

        <!-- Hero Section (Header + Stats) -->
        <div
            class="relative bg-gradient-to-br from-[#1A2980] via-[#26D0CE] to-[#26D0CE] pb-12 pt-8 px-6 rounded-b-[40px] shadow-lg overflow-hidden">
            <!-- Decorative Elements -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full blur-2xl -ml-10 -mb-10 pointer-events-none">
            </div>
            <span
                class="material-symbols-outlined absolute top-4 right-4 text-white/20 text-8xl rotate-12 pointer-events-none">groups</span>

            <!-- Title -->
            <div class="relative z-10 text-center mb-6">
                <h1 class="text-white text-lg font-bold tracking-wide">Manajemen Santri</h1>
                <p class="text-blue-50 text-xs font-medium opacity-90">TPQ Daarul Gusmik Al-Hufadz</p>
            </div>

            <!-- Main Stats (Centered) -->
            <div class="relative z-10 flex flex-col items-center justify-center text-white mb-2">
                <p class="text-blue-100 text-sm font-medium mb-1">Total Santri Aktif</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-5xl font-extrabold tracking-tight">{{ $santri->total() }}</span>
                    <span class="text-lg font-medium opacity-80">Santri</span>
                </div>
            </div>
        </div>

        <!-- Floating Search Bar -->
        <div class="px-6 -mt-7 relative z-20">
            <label class="flex flex-col w-full">
                <div
                    class="flex w-full items-center rounded-2xl h-14 shadow-xl bg-white dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-700 ring-1 ring-black/5">
                    <div class="text-primary flex items-center justify-center pl-4">
                        <span class="material-symbols-outlined text-[24px]">search</span>
                    </div>
                    <input id="searchInput"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden text-[#111817] dark:text-white focus:outline-0 focus:ring-0 border-none bg-transparent focus:border-none h-full placeholder:text-slate-400 px-4 text-base font-medium"
                        placeholder="Cari nama atau NIS..." autocomplete="off" />
                </div>
            </label>
        </div>

        <!-- Santri List -->
        <div class="flex flex-col gap-3 p-4 pt-5 min-h-[50vh]" id="santriListContainer">
            @forelse($santri as $item)
            <div class="animate-enter santri-item group relative flex items-center gap-3 bg-white dark:bg-slate-800 px-3 min-h-[64px] py-2.5 justify-between rounded-xl shadow-sm border border-transparent hover:border-primary/20 transition-all cursor-pointer active:scale-[0.98]"
                style="animation-delay: {{ $loop->index * 100 }}ms"
                data-name="{{ strtolower($item->nama ?? $item->nama_lengkap) }}" data-nis="{{ $item->nis }}">

                <!-- Main Click Area -->
                <div class="flex items-center gap-4 flex-1">
                    <!-- Avatar - Click to Profile -->
                    <div class="cursor-pointer relative"
                        onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'">
                        @if($item->user && $item->user->foto)
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-12 w-12 border border-slate-200 dark:border-slate-700 ring-2 ring-offset-2 ring-offset-white ring-slate-50 dark:ring-offset-slate-900 dark:ring-slate-700"
                            style='background-image: url("{{ asset(' storage/' . $item->user->foto) }}");'></div>
                        @else
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-12 w-12 border border-slate-200 dark:border-slate-700 ring-2 ring-offset-2 ring-offset-white ring-slate-50 dark:ring-offset-slate-900 dark:ring-slate-700"
                            style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($item->nama ?? $item->nama_lengkap) }}&background=2563eb&color=fff&bold=true&font-size=0.35");'>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center cursor-pointer"
                        onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'">
                        <p class="text-[#111817] dark:text-white text-sm font-bold leading-tight line-clamp-1">
                            {{ $item->nama ?? $item->nama_lengkap }}
                        </p>
                        <p class="text-slate-500 dark:text-slate-400 text-[10px] font-medium leading-normal mt-0.5">
                            NIS: {{ $item->nis ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <!-- Actions -->
                <div class="flex items-center gap-2 relative z-10 w-auto justify-end">
                    <!-- Edit (Direct) -->
                    <button onclick="window.location.href='{{ route('ustadz.santri.edit', $item->id) }}'"
                        class="flex size-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors"
                        title="Edit">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </button>

                    <!-- Delete (Direct) -->
                    <form action="{{ route('ustadz.santri.destroy', $item->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus santri ini?');"
                        class="flex items-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="flex size-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-red-500 dark:text-red-400 hover:bg-red-500 hover:text-white transition-colors"
                            title="Hapus">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </form>

                    <!-- More Menu (Dropdown) -->
                    <div class="relative group/menu" tabindex="0">
                        <button
                            class="flex size-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[20px]">more_vert</span>
                        </button>

                        <div
                            class="dropdown-menu absolute right-0 top-9 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 z-50 overflow-hidden ring-1 ring-black/5 origin-top-right transition-all duration-200 opacity-0 invisible scale-95 group-focus-within/menu:opacity-100 group-focus-within/menu:visible group-focus-within/menu:scale-100">

                            <!-- Input Hafalan -->
                            <button onclick="window.location.href='{{ route('ustadz.hafalan.index') }}'"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors text-left group/item border-b border-slate-50 dark:border-slate-700/50">
                                <span
                                    class="material-symbols-outlined text-[18px] text-blue-500 group-hover/item:scale-110 transition-transform">menu_book</span>
                                <span class="font-medium">Input Hafalan</span>
                            </button>

                            <!-- Nilai Akhlak -->
                            <button
                                onclick="window.location.href='{{ route('ustadz.santri.akhlak.create', $item->id) }}'"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-amber-900/10 transition-colors text-left group/item">
                                <span
                                    class="material-symbols-outlined text-[18px] text-amber-500 group-hover/item:scale-110 transition-transform">hotel_class</span>
                                <span class="font-medium">Nilai Akhlak</span>
                            </button>

                            <!-- WhatsApp -->
                            @if($item->no_hp_orang_tua)
                            @php
                            $hp = $item->no_hp_orang_tua;
                            if (Str::startsWith($hp, '0')) {
                            $hp = '62' . substr($hp, 1);
                            }
                            @endphp
                            <a href="https://wa.me/{{ $hp }}" target="_blank"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors text-left group/item border-t border-slate-50 dark:border-slate-700/50">
                                <span
                                    class="material-symbols-outlined text-[18px] text-green-600 group-hover/item:scale-110 transition-transform">chat</span>
                                <span class="font-medium">Hubungi Wali</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div
                    class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-slate-400 text-3xl">person_off</span>
                </div>
                <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada data santri</p>
            </div>
            @endforelse

            <!-- Pagination -->
            <div class="pb-[120px]">
                {{ $santri->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Floating Action Button -->
        <div class="fixed bottom-6 right-6 z-50">
            <!-- Example: Add new santri (if allowed) or other action -->
            <!-- Currently Ustadz usually cannot add santri freely, but we keep the button from design as 'add activity' or similar -->
            <!-- Or correct it to something useful logic -->
        </div>

    </div>

    <!-- Client Search Script -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function (e) {
            const query = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.santri-item');

            items.forEach(item => {
                const name = item.dataset.name;
                const nis = item.dataset.nis;
                if (name.includes(query) || (nis && nis.includes(query))) {
                    item.classList.remove('hidden');
                    item.classList.add('flex');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('flex');
                }
            });
        });
    </script>
</body>

</html>
