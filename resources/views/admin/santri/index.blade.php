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
                        <p class="text-lg font-bold dark:text-white text-teal-600">{{ $santriList->count() }} <span
                                class="text-slate-400 font-medium">Anak</span></p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mb-6">
                <div class="flex-1 relative">
                    <span
                        class="material-icons-round absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input id="searchInput"
                        class="w-full pl-12 pr-4 py-3 bg-white dark:bg-card-dark border-none rounded-2xl text-sm shadow-sm focus:ring-2 focus:ring-teal-500 dark:placeholder-slate-500"
                        placeholder="Cari Nama atau NIS..." type="text" />
                </div>
                <button class="bg-white dark:bg-card-dark p-3 rounded-2xl shadow-sm text-slate-500">
                    <span class="material-icons-round">tune</span>
                </button>
            </div>
            <div class="space-y-3" id="santriListContainer">
                @forelse($santriList as $santri)
                <div class="santri-item bg-white dark:bg-card-dark p-4 rounded-2xl shadow-sm border border-slate-50 dark:border-slate-800 flex items-center gap-4 group cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors active:scale-[0.99]"
                    onclick="window.location.href='/admin/santri/{{ $santri->id }}'"
                    data-name="{{ strtolower($santri->nama ?? $santri->name) }}" data-nis="{{ $santri->nis }}">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-teal-50 dark:border-slate-700">
                        @if($santri->foto)
                        <img alt="Santri" class="w-full h-full object-cover"
                            src="{{ asset('storage/' . $santri->foto) }}" />
                        @else
                        <img alt="Santri" class="w-full h-full object-cover"
                            src="https://ui-avatars.com/api/?name={{ urlencode($santri->nama ?? $santri->name) }}&background=0d9488&color=fff" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 dark:text-white leading-tight">{{ $santri->nama ??
                            $santri->name }}</h3>
                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">NIS: {{ $santri->nis ?? '-' }}</p>
                        <div
                            class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 text-[9px] font-bold uppercase tracking-wider">
                            Kelas {{ $santri->kelas->nama_kelas ?? 'Belum ada' }}
                        </div>
                    </div>
                    <button class="text-slate-300 group-hover:text-teal-500 transition-colors">
                        <span class="material-icons-round">chevron_right</span>
                    </button>
                </div>
                @empty
                <div class="text-center p-8 text-gray-500">
                    <p>Belum ada data santri</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div
        class="fixed bottom-0 left-0 w-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-t border-slate-100 dark:border-slate-800 px-6 pt-4 pb-10 z-50">
        <a href="{{ route('admin.santri.create') }}"
            class="w-full flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white py-4 px-6 rounded-2xl font-bold shadow-lg shadow-teal-500/30 transition-all active:scale-[0.98]">
            <span class="material-icons-round">person_add</span>
            <span>Tambah Santri Baru</span>
        </a>
    </div>

    <script>
        // Search filter
        document.getElementById('searchInput').addEventListener('input', function (e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.santri-item').forEach(item => {
                const name = item.dataset.name;
                const nis = item.dataset.nis || '';
                if (name.includes(query) || nis.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
