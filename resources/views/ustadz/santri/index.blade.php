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

        <!-- Header Sticky -->
        <div class="sticky top-0 z-30 flex items-center bg-primary p-4 pb-4 justify-between shadow-md">
            <div onclick="window.location.href='{{ route('ustadz.dashboard') }}'"
                class="text-white flex size-10 shrink-0 items-center justify-center cursor-pointer hover:bg-white/10 rounded-full transition-colors">
                <span class="material-symbols-outlined">arrow_back_ios_new</span>
            </div>
            <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center">Manajemen
                Daftar Santri</h2>
            <div class="flex w-10 items-center justify-end">
                <button
                    class="flex cursor-pointer items-center justify-center rounded-lg h-10 w-10 bg-transparent text-white hover:bg-white/10 transition-colors">
                    <span class="material-symbols-outlined">filter_list</span>
                </button>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="p-4">
            <div
                class="flex items-center justify-between gap-4 rounded-2xl bg-white dark:bg-slate-800 p-5 shadow-sm border border-primary/10">
                <div class="flex flex-col gap-1">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium leading-normal">Total Santri Saya
                    </p>
                    <p class="text-[#111817] dark:text-white text-3xl font-bold leading-tight">{{ $santri->total() }}
                    </p>
                </div>
                <div class="flex items-center justify-center bg-primary/10 rounded-full p-3">
                    <span class="material-symbols-outlined text-primary text-3xl">groups</span>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="px-4 py-2">
            <label class="flex flex-col min-w-40 h-12 w-full">
                <div
                    class="flex w-full flex-1 items-stretch rounded-2xl h-full shadow-sm bg-white dark:bg-slate-800 overflow-hidden border border-transparent focus-within:border-primary/30 transition-colors">
                    <div class="text-slate-400 flex items-center justify-center pl-4">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input id="searchInput"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden text-[#111817] dark:text-white focus:outline-0 focus:ring-0 border-none bg-transparent focus:border-none h-full placeholder:text-slate-400 px-4 pl-2 text-base font-normal leading-normal"
                        placeholder="Cari nama atau NIS santri..." autocomplete="off" />
                </div>
            </label>
        </div>

        <!-- Santri List -->
        <div class="flex flex-col gap-3 p-4 min-h-[50vh]" id="santriListContainer">
            @forelse($santri as $item)
            <div class="santri-item group relative flex items-center gap-4 bg-white dark:bg-slate-800 px-4 min-h-[80px] py-3 justify-between rounded-2xl shadow-sm border border-transparent hover:border-primary/20 transition-all cursor-pointer active:scale-[0.98]"
                data-name="{{ strtolower($item->nama ?? $item->nama_lengkap) }}" data-nis="{{ $item->nis }}">

                <!-- Main Click Area -->
                <div class="flex items-center gap-4 flex-1"
                    onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'">
                    <!-- Avatar -->
                    @if($item->user && $item->user->foto)
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-14 w-14 border-2 border-primary/10"
                        style='background-image: url("{{ asset(' storage/' . $item->user->foto) }}");'></div>
                    @else
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-14 w-14 border-2 border-primary/10"
                        style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($item->nama ?? $item->nama_lengkap) }}&background=2563eb&color=fff&bold=true");'>
                    </div>
                    @endif

                    <div class="flex flex-col justify-center">
                        <p class="text-[#111817] dark:text-white text-base font-bold leading-normal line-clamp-1">
                            {{ $item->nama ?? $item->nama_lengkap }}
                        </p>
                        <p class="text-slate-500 dark:text-slate-400 text-xs font-medium leading-normal">
                            NIS: {{ $item->nis ?? '-' }}
                        </p>
                        <!-- Kelas Badge -->
                        <span
                            class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] font-medium bg-primary/10 text-primary w-fit">
                            {{ $item->kelas->nama_kelas ?? 'Kelas -' }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-1 relative z-10">
                    <button onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'"
                        class="flex size-9 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                    </button>

                    <!-- Context Menu -->
                    <div class="relative group-menu" tabindex="0">
                        <button
                            class="flex size-9 items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">more_vert</span>
                        </button>
                        <div
                            class="dropdown-menu absolute right-0 top-10 w-40 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 z-50 overflow-hidden ring-1 ring-black/5">
                            <button onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-left">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                <span>Detail</span>
                            </button>
                            <button
                                onclick="window.location.href='{{ route('ustadz.santri.akhlak.create', $item->id) }}'"
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-left">
                                <span class="material-symbols-outlined text-base">hotel_class</span>
                                <span>Nilai Akhlak</span>
                            </button>
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
