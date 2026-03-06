<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Manajemen Daftar Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap"
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
                        "display": ["Poppins"]
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
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            overflow-y: auto;
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

<body
    class="bg-background-light dark:bg-background-dark flex justify-center items-start min-h-screen p-0 sm:py-4 transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark shadow-2xl pb-24">



        <!-- Stats Section (Plain Header, Colored Boxes - Compact) -->
        <div class="px-4 pt-4 pb-2">
            <div class="flex gap-2">
                <!-- Box 1: Avatar/Icon -->
                <div
                    class="shrink-0 flex items-center justify-center w-[60px] bg-indigo-500 rounded-xl shadow-lg shadow-indigo-500/20 text-white relative overflow-hidden">
                    <span class="material-symbols-outlined text-3xl relative z-10">groups</span>
                    <span
                        class="material-symbols-outlined absolute -bottom-2 -right-2 text-5xl text-white/10 pointer-events-none">bubble_chart</span>
                </div>

                <!-- Stats Container -->
                <div class="flex flex-1 gap-2">
                    <!-- Box 2: Total Aktif -->
                    <div
                        class="flex-1 bg-blue-600 rounded-xl p-2.5 shadow-lg shadow-blue-600/20 text-white flex flex-col justify-center relative overflow-hidden group">
                        <p class="text-[9px] font-bold opacity-80 uppercase tracking-wider relative z-10">Total Aktif
                        </p>
                        <p class="text-xl font-extrabold leading-tight relative z-10 mt-0.5">{{ $totalSantri }}</p>
                        <span
                            class="material-symbols-outlined absolute -right-3 -bottom-3 text-4xl text-white/10 group-hover:scale-110 transition-transform">person_check</span>
                    </div>

                    <!-- Box 3: Tanpa Kelas -->
                    <div
                        class="flex-1 bg-amber-500 rounded-xl p-2.5 shadow-lg shadow-amber-500/20 text-white flex flex-col justify-center relative overflow-hidden group">
                        <p class="text-[9px] font-bold opacity-80 uppercase tracking-wider relative z-10">Tanpa Kelas
                        </p>
                        <p class="text-xl font-extrabold leading-tight relative z-10 mt-0.5">{{ $totalTanpaKelas }}</p>
                        <span
                            class="material-symbols-outlined absolute -right-3 -bottom-3 text-4xl text-white/10 group-hover:scale-110 transition-transform">no_meeting_room</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Bar & Filter -->
        <div class="px-4 py-2">
            <form method="GET" action="{{ route('ustadz.santri.index') }}" class="flex gap-2 items-center">
                <!-- Search Input -->
                <div
                    class="flex flex-1 items-stretch rounded-xl h-10 shadow-sm bg-white dark:bg-slate-800 overflow-hidden border border-transparent focus-within:border-primary/30 transition-colors">
                    <button type="submit"
                        class="text-slate-400 flex items-center justify-center pl-3 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </button>
                    <input name="search" value="{{ request('search') }}"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden text-[#111817] dark:text-white focus:outline-0 focus:ring-0 border-none bg-transparent focus:border-none h-full placeholder:text-slate-400 px-3 pl-2 text-sm font-normal leading-normal"
                        placeholder="Cari nama atau NIS..." autocomplete="off" />
                </div>

                <!-- Kelas Filter Dropdown -->
                <div class="relative shrink-0 max-w-[90px]">
                    <select name="kelas_id" onchange="this.form.submit()"
                        style="-webkit-appearance: none; -moz-appearance: none; appearance: none; background-image: none !important;"
                        class="appearance-none h-10 w-full pl-2 pr-8 rounded-xl shadow-sm bg-white dark:bg-slate-800 border border-transparent focus:border-primary/30 text-xs font-medium text-slate-700 dark:text-white cursor-pointer truncate text-center {{ request('kelas_id') ? 'ring-2 ring-primary/30' : '' }}">
                        <option value="">Kelas</option>
                        @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" @if(request('kelas_id')==$kelas->id) selected @endif>{{
                            $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400">
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </div>
                </div>
            </form>

            <!-- Active Filters Display -->
        </div>

        <!-- Santri List -->
        <div class="flex flex-col gap-3 px-4 py-4 min-h-[50vh]" id="santriListContainer">
            @forelse($santri as $item)
            @php
            $gradients = [
            'from-pink-500 to-rose-500',
            'from-cyan-400 to-blue-500',
            'from-amber-400 to-orange-500',
            'from-emerald-400 to-teal-500',
            'from-violet-500 to-purple-500',
            'from-blue-400 to-indigo-500',
            'from-fuchsia-400 to-pink-500',
            'from-lime-400 to-green-500'
            ];
            $gradientRing = $gradients[$loop->index % count($gradients)];
            @endphp
            <div class="animate-enter santri-item group relative flex items-center gap-3 bg-white dark:bg-slate-800 px-3 min-h-[64px] py-2 justify-between rounded-2xl shadow-sm border border-transparent hover:border-primary/20 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300 cursor-pointer active:scale-[0.98]"
                style="animation-delay: {{ $loop->index * 100 }}ms"
                onclick="window.location.href='{{ route('ustadz.santri.show', $item->id) }}'"
                data-name="{{ strtolower($item->nama ?? $item->nama_lengkap) }}" data-nis="{{ $item->nis }}">

                <div class="flex items-center gap-3 min-w-0">
                    <!-- Avatar with Gradient Ring -->
                    <div class="relative flex-shrink-0 p-[2px] rounded-full bg-gradient-to-tr {{ $gradientRing }}"
                        onclick="event.stopPropagation(); window.location.href='{{ route('ustadz.santri.show', $item->id) }}'">
                        @if($item->user && $item->user->foto)
                        <div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 border-2 border-white dark:border-slate-800"
                            style='background-image: url("{{ Str::startsWith($item->user->foto, ' data:') ? $item->
                            user->foto : asset('storage/' . $item->user->foto) }}");'></div>
                        @else
                        <div class="bg-center bg-no-repeat bg-cover rounded-full h-10 w-10 border-2 border-white dark:border-slate-800"
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
                    <button
                        onclick="event.stopPropagation(); window.location.href='{{ route('ustadz.santri.edit', $item->id) }}'"
                        class="flex size-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors mx-1"
                        title="Edit">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </button>

                    <!-- Delete (Direct) -->
                    <!-- Delete (Direct) - Redirect to Confirmation Page -->
                    <button
                        onclick="event.stopPropagation(); window.location.href='{{ route('ustadz.santri.confirm-delete', $item->id) }}'"
                        class="flex size-8 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-red-500 dark:text-red-400 hover:bg-red-500 hover:text-white transition-colors"
                        title="Hapus">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>

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
