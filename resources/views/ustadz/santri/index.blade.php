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



        <!-- Stats Card -->
        <div class="px-4 pt-4 pb-2">
            <div
                class="bg-gradient-to-r from-violet-600 to-indigo-600 rounded-2xl p-4 shadow-lg shadow-indigo-500/20 border border-indigo-500/20 flex items-center justify-between relative overflow-hidden group">
                <!-- Decorative BG Icon -->
                <span
                    class="material-symbols-outlined absolute -right-6 -bottom-6 text-[8rem] text-white/10 rotate-12 z-0 pointer-events-none group-hover:scale-110 transition-transform duration-500">
                    groups
                </span>

                <div class="relative z-10 text-white">
                    <p class="text-indigo-100 text-xs font-medium mb-1">Total Santri Aktif</p>
                    <p class="text-3xl font-bold leading-tight text-white tracking-tight flex items-center gap-2">
                        <span class="material-symbols-outlined text-2xl text-indigo-200">person</span>
                        {{ $santri->total() }}
                        <span class="text-lg font-medium text-indigo-200">Santri</span>
                    </p>
                </div>
                <div
                    class="flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full p-3 relative z-10 border border-white/10">
                    <span class="material-symbols-outlined text-white text-2xl">groups</span>
                </div>
            </div>
        </div>

        <!-- Search Bar & Filter -->
        <div class="px-4 py-2">
            <form method="GET" action="{{ route('ustadz.santri.index') }}" class="flex gap-2 items-center">
                <!-- Search Input -->
                <div
                    class="flex flex-1 items-stretch rounded-xl h-10 shadow-sm bg-white dark:bg-slate-800 overflow-hidden border border-transparent focus-within:border-primary/30 transition-colors">
                    <div class="text-slate-400 flex items-center justify-center pl-3">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                    <input name="search" value="{{ request('search') }}"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden text-[#111817] dark:text-white focus:outline-0 focus:ring-0 border-none bg-transparent focus:border-none h-full placeholder:text-slate-400 px-3 pl-2 text-sm font-normal leading-normal"
                        placeholder="Cari nama atau NIS..." autocomplete="off" />
                    @if(request('search'))
                    <a href="{{ route('ustadz.santri.index', request('kelas_id') ? ['kelas_id' => request('kelas_id')] : []) }}"
                        class="text-slate-400 flex items-center justify-center pr-3 hover:text-red-500">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                    @endif
                </div>

                <!-- Kelas Filter Dropdown -->
                <div class="relative shrink-0 max-w-[90px]">
                    <select name="kelas_id" onchange="this.form.submit()"
                        style="-webkit-appearance: none; -moz-appearance: none;"
                        class="appearance-none h-10 w-full pl-2 pr-6 rounded-xl shadow-sm bg-white dark:bg-slate-800 border border-transparent focus:border-primary/30 text-xs font-medium text-slate-700 dark:text-white cursor-pointer truncate {{ request('kelas_id') ? 'ring-2 ring-primary/30' : '' }}">
                        <option value="">Kelas</option>
                        @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" @if(request('kelas_id')==$kelas->id) selected @endif>{{
                            $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1.5 text-slate-400">
                        <span class="material-symbols-outlined text-[14px]">expand_more</span>
                    </div>
                </div>
            </form>

            <!-- Active Filters Display -->
            @if(request('kelas_id') || request('search'))
            <div class="flex items-center gap-2 mt-2 flex-wrap">
                @if(request('kelas_id'))
                <a href="{{ route('ustadz.santri.index', request('search') ? ['search' => request('search')] : []) }}"
                    class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary text-xs rounded-full hover:bg-primary/20 transition-colors">
                    <span>{{ $kelasList->find(request('kelas_id'))->nama_kelas ?? 'Kelas' }}</span>
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </a>
                @endif
                @if(request('search'))
                <span class="text-xs text-slate-500">Hasil pencarian: "{{ request('search') }}"</span>
                @endif
            </div>
            @endif
        </div>

        <!-- Santri List -->
        <div class="flex flex-col gap-3 p-4 min-h-[50vh]" id="santriListContainer">
            @forelse($santri as $item)
            @php
            $colors = ['ring-pink-500', 'ring-cyan-500', 'ring-amber-500', 'ring-emerald-500', 'ring-violet-500',
            'ring-rose-500', 'ring-sky-500', 'ring-lime-500'];
            $ringColor = $colors[$loop->index % count($colors)];
            @endphp
            <div class="animate-enter santri-item group relative flex items-center gap-3 bg-white dark:bg-slate-800 px-3 min-h-[64px] py-2.5 justify-between rounded-xl shadow-sm border border-transparent hover:border-primary/20 transition-all cursor-pointer active:scale-[0.98]"
                style="animation-delay: {{ $loop->index * 100 }}ms"
                onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'"
                data-name="{{ strtolower($item->nama ?? $item->nama_lengkap) }}" data-nis="{{ $item->nis }}">

                <div class="flex items-center gap-3 min-w-0">
                    <!-- Avatar -->
                    <div class="relative flex-shrink-0"
                        onclick="event.stopPropagation(); window.location.href='{{ route('ustadz.santri.show', $item->id) }}'">
                        @if($item->user && $item->user->foto)
                        <div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 border border-slate-100 dark:border-slate-700 ring-2 ring-offset-2 ring-offset-white dark:ring-offset-slate-800 {{ $ringColor }}"
                            style='background-image: url("{{ asset(' storage/' . $item->user->foto) }}");'></div>
                        @else
                        <div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 border border-slate-100 dark:border-slate-700 ring-2 ring-offset-2 ring-offset-white dark:ring-offset-slate-800 {{ $ringColor }}"
                            style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($item->nama ?? $item->nama_lengkap) }}&background=random&color=fff&bold=true&font-size=0.35&rounded=true");'>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center">
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
                    <div class="relative" id="dropdown-container-{{ $item->id }}">
                        <button onclick="toggleDropdown(event, '{{ $item->id }}')" id="dropdown-btn-{{ $item->id }}"
                            class="flex size-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[20px]">more_vert</span>
                        </button>

                        <div id="dropdown-menu-{{ $item->id }}"
                            class="dropdown-content hidden absolute right-0 top-9 w-auto min-w-[180px] bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 z-[9999] overflow-hidden ring-1 ring-black/5 origin-top-right transition-all duration-200">

                            <!-- Input Setoran Hafalan -->
                            <button
                                onclick="event.stopPropagation(); window.location.href='{{ route('ustadz.hafalan.index', ['santri_id' => $item->id]) }}'"
                                class="w-full flex items-center gap-3 px-4 py-2 text-xs whitespace-nowrap text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors text-left border-b border-slate-50 dark:border-slate-700/50">
                                <span
                                    class="material-symbols-outlined text-[16px] text-blue-500 transition-transform group-hover:scale-110">menu_book</span>
                                <span class="font-medium">Input Setoran Hafalan</span>
                            </button>

                            <!-- Input Nilai Akhlak -->
                            <button
                                onclick="event.stopPropagation(); window.location.href='{{ route('ustadz.santri.akhlak.create', $item->id) }}'"
                                class="w-full flex items-center gap-3 px-4 py-2 text-xs whitespace-nowrap text-slate-700 dark:text-slate-200 hover:bg-amber-50 dark:hover:bg-amber-900/10 transition-colors text-left">
                                <span
                                    class="material-symbols-outlined text-[16px] text-amber-500 transition-transform group-hover:scale-110">hotel_class</span>
                                <span class="font-medium">Input Nilai Akhlak</span>
                            </button>

                            <!-- WhatsApp -->
                            @if($item->no_hp_orang_tua)
                            @php
                            $hp = $item->no_hp_orang_tua;
                            if (Str::startsWith($hp, '0')) {
                            $hp = '62' . substr($hp, 1);
                            }
                            @endphp
                            <a href="https://wa.me/{{ $hp }}" target="_blank" onclick="event.stopPropagation()"
                                class="w-full flex items-center gap-3 px-4 py-2 text-xs whitespace-nowrap text-slate-700 dark:text-slate-200 hover:bg-green-50 dark:hover:bg-green-900/10 transition-colors text-left border-t border-slate-50 dark:border-slate-700/50">
                                <span
                                    class="material-symbols-outlined text-[16px] text-green-600 transition-transform group-hover:scale-110">chat</span>
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
        <a href="{{ route('ustadz.santri.create') }}"
            class="fixed bottom-24 right-6 z-50 flex items-center justify-center w-14 h-14 bg-gradient-to-br from-primary to-primary-dark text-white rounded-full shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:scale-110 active:scale-95 transition-all duration-200">
            <span class="material-symbols-outlined text-2xl">add</span>
        </a>

    </div>

    <script>
        // Dropdown Toggle Logic
        function toggleDropdown(event, id) {
            event.stopPropagation(); // Stop row click

            // Reset all list items z-index first
            document.querySelectorAll('.santri-item').forEach(item => {
                item.style.zIndex = '';
            });

            // Close all other dropdowns
            document.querySelectorAll('.dropdown-content').forEach(el => {
                if (el.id !== `dropdown-menu-${id}`) {
                    el.classList.add('hidden');
                    el.classList.remove('opacity-100', 'visible', 'scale-100');
                    el.classList.add('opacity-0', 'invisible', 'scale-95');
                }
            });

            // Reset all buttons
            document.querySelectorAll('[id^="dropdown-btn-"]').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                btn.classList.add('bg-slate-100', 'text-slate-600', 'dark:bg-slate-700', 'dark:text-slate-300');
            });

            // Toggle active state for current dropdown
            const menu = document.getElementById(`dropdown-menu-${id}`);
            const btn = document.getElementById(`dropdown-btn-${id}`);
            const parentItem = btn.closest('.santri-item');

            if (menu.classList.contains('hidden')) {
                // OPEN - Raise parent z-index
                parentItem.style.zIndex = '100';

                menu.classList.remove('hidden');
                // Small delay to allow transition
                setTimeout(() => {
                    menu.classList.remove('opacity-0', 'invisible', 'scale-95');
                    menu.classList.add('opacity-100', 'visible', 'scale-100');
                }, 10);

                // Add active style to button
                btn.classList.add('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                btn.classList.remove('bg-slate-100', 'text-slate-600', 'dark:bg-slate-700', 'dark:text-slate-300');
            } else {
                // CLOSE - Reset parent z-index
                parentItem.style.zIndex = '';

                menu.classList.add('opacity-0', 'invisible', 'scale-95');
                menu.classList.remove('opacity-100', 'visible', 'scale-100');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 200);

                // Remove active style from button
                btn.classList.remove('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                btn.classList.add('bg-slate-100', 'text-slate-600', 'dark:bg-slate-700', 'dark:text-slate-300');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            // Reset all list items z-index
            document.querySelectorAll('.santri-item').forEach(item => {
                item.style.zIndex = '';
            });

            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('opacity-0', 'invisible', 'scale-95');
                    menu.classList.remove('opacity-100', 'visible', 'scale-100');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 200);

                    // Reset all buttons
                    document.querySelectorAll('[id^="dropdown-btn-"]').forEach(btn => {
                        btn.classList.remove('bg-primary', 'text-white', 'ring-4', 'ring-primary/20');
                        btn.classList.add('bg-slate-100', 'text-slate-600', 'dark:bg-slate-700', 'dark:text-slate-300');
                    });
                }
            });
        });
    </script>
</body>

</html>
