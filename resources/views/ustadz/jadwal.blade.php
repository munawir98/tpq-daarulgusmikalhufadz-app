<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Jadwal Tahfidz</title>
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
                        "primary": "#13ecb6",
                        "accent-gold": "#d4a017",
                        "background-light": "#f6f8f8",
                        "background-dark": "#10221d",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen text-[#111816] dark:text-white pb-24 relative">

    <main class="max-w-md mx-auto pt-4 relative">
        <!-- Box Header -->
        <header
            class="flex items-center justify-center bg-gradient-to-br from-[#0f8b6b] to-primary h-16 px-4 shadow-lg shadow-primary/20 mx-4 rounded-2xl mb-6 relative z-30">
            <h1 class="text-white text-lg font-bold leading-tight text-center">Jadwal Tahfidz</h1>
        </header>

        <style>
            @keyframes marquee {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                animation: marquee 40s linear infinite;
                /* Slower for 31 days */
            }

            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>

        <!-- Calendar Strip (Marquee & Distinct Colors - Full Month) -->
        <div class="bg-white dark:bg-[#1a2e29] pt-6 pb-4 shadow-sm overflow-hidden">
            <div class="px-4 mb-4 flex justify-between items-center text-[#111816] dark:text-white">
                <h3 class="font-bold text-lg">Oktober 2023</h3>
                <span class="material-symbols-outlined text-primary">calendar_month</span>
            </div>

            <!-- Marquee Container -->
            <div class="relative w-full overflow-hidden">
                <div class="flex gap-3 px-4 w-max animate-marquee">
                    @php
                    // Mapping 0-6 to Day Names
                    $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

                    // Config: Day 1 matches Kamis (Index 4)
                    $offset = 3;
                    $totalDays = 31;
                    @endphp

                    {{-- Loop Set 1 --}}
                    @for ($i = 1; $i <= $totalDays; $i++) @php $dayIndex=($i + $offset) % 7;
                        $dayName=$dayNames[$dayIndex];
                        $colorClass="bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800"
                        ; $textClass="text-gray-500" ; $isActive=false; if ($dayName=='Rab' ) { $isActive=true;
                        $colorClass="bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/20 ring-2 ring-blue-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                        ; $textClass="opacity-90" ; } elseif ($dayName=='Kam' ) { $isActive=true;
                        $colorClass="bg-gradient-to-br from-purple-500 to-fuchsia-500 text-white shadow-lg shadow-purple-500/20 ring-2 ring-purple-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                        ; $textClass="opacity-90" ; } elseif ($dayName=='Sab' ) { $isActive=true;
                        $colorClass="bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-orange-500/20 ring-2 ring-orange-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                        ; $textClass="opacity-90" ; } elseif ($dayName=='Min' ) { $isActive=true;
                        $colorClass="bg-gradient-to-br from-teal-400 to-emerald-500 text-white shadow-lg shadow-teal-500/20 ring-2 ring-teal-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                        ; $textClass="opacity-90" ; } @endphp <div
                        class="flex flex-col items-center justify-center min-w-[60px] h-20 rounded-xl {{ $colorClass }}">
                        <p class="text-xs font-medium {{ $textClass }}">{{ $dayName }}</p>
                        <p class="text-xl font-bold">{{ $i }}</p>
                </div>
                @endfor

                {{-- Loop Set 2 (Duplicate for Seamless Loop) --}}
                @for ($i = 1; $i <= $totalDays; $i++) @php $dayIndex=($i + $offset) % 7; $dayName=$dayNames[$dayIndex];
                    $colorClass="bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800"
                    ; $textClass="text-gray-500" ; $isActive=false; if ($dayName=='Rab' ) { $isActive=true;
                    $colorClass="bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-500/20 ring-2 ring-blue-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                    ; $textClass="opacity-90" ; } elseif ($dayName=='Kam' ) { $isActive=true;
                    $colorClass="bg-gradient-to-br from-purple-500 to-fuchsia-500 text-white shadow-lg shadow-purple-500/20 ring-2 ring-purple-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                    ; $textClass="opacity-90" ; } elseif ($dayName=='Sab' ) { $isActive=true;
                    $colorClass="bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-orange-500/20 ring-2 ring-orange-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                    ; $textClass="opacity-90" ; } elseif ($dayName=='Min' ) { $isActive=true;
                    $colorClass="bg-gradient-to-br from-teal-400 to-emerald-500 text-white shadow-lg shadow-teal-500/20 ring-2 ring-teal-500 ring-offset-2 dark:ring-offset-[#1a2e29]"
                    ; $textClass="opacity-90" ; } @endphp <div
                    class="flex flex-col items-center justify-center min-w-[60px] h-20 rounded-xl {{ $colorClass }}">
                    <p class="text-xs font-medium {{ $textClass }}">{{ $dayName }}</p>
                    <p class="text-xl font-bold">{{ $i }}</p>
            </div>
            @endfor
        </div>
        </div>
        </div>

        <!-- Info Card -->
        <div class="px-4 py-4">
            <div class="bg-gradient-to-br from-[#0f8b6b] to-primary rounded-2xl p-4 text-white shadow-lg">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-xl">info</span>
                    <h4 class="font-bold">Info Jadwal Khusus</h4>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                        <p class="text-[10px] uppercase tracking-wider opacity-80 font-bold mb-1">Rabu &amp; Kamis</p>
                        <p class="text-sm font-semibold">16:00 - 17:30</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
                        <p class="text-[10px] uppercase tracking-wider opacity-80 font-bold mb-1">Sabtu &amp; Ahad</p>
                        <p class="text-sm font-semibold">06:00 - 08:00</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 pt-2 pb-2">
            <h3 class="text-[#111816] dark:text-gray-200 text-lg font-bold leading-tight">Rabu, 14 Oktober</h3>
        </div>

        <!-- Cards Container -->
        <div class="p-4 space-y-4">
            @forelse($jadwals as $jadwal)
            @php
            // Color logic based on day
            $gradient = match($jadwal->hari) {
            'Senin' => 'from-blue-500 to-indigo-600',
            'Selasa' => 'from-cyan-500 to-blue-500',
            'Rabu' => 'from-teal-400 to-emerald-500',
            'Kamis' => 'from-purple-500 to-fuchsia-500',
            'Jumat' => 'from-pink-500 to-rose-500',
            'Sabtu' => 'from-amber-400 to-orange-500',
            'Minggu' => 'from-red-500 to-orange-600',
            default => 'from-gray-500 to-slate-600',
            };
            $shadow = match($jadwal->hari) {
            'Senin' => 'blue',
            'Selasa' => 'cyan',
            'Rabu' => 'teal',
            'Kamis' => 'purple',
            'Jumat' => 'pink',
            'Sabtu' => 'orange',
            'Minggu' => 'red',
            default => 'gray',
            };
            @endphp
            <div
                class="flex flex-col items-stretch justify-start rounded-xl shadow-lg bg-gradient-to-br {{ $gradient }} text-white overflow-hidden relative transform transition-all active:scale-[0.98]">
                <!-- Decoration -->
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-6xl">school</span>
                </div>

                <div class="p-4 relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white border border-white/20 backdrop-blur-sm">
                            {{ $jadwal->hari }}
                        </span>
                    </div>
                    <h4 class="text-white text-lg font-bold">{{ $jadwal->kelas->nama_kelas ?? 'Kelas Tidak Ditemukan' }}
                    </h4>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center text-white/90 text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">schedule</span>
                            {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{
                            \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                        </div>
                        <div class="flex items-center text-white/90 text-sm">
                            <span class="material-symbols-outlined text-lg mr-2">person</span>
                            {{ $jadwal->ustadz->nama ?? '-' }}
                        </div>
                        @if($jadwal->materi)
                        <div
                            class="flex items-start text-white/90 text-sm bg-white/10 p-3 rounded-lg border border-white/10 mt-2 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-lg mr-2 text-white">menu_book</span>
                            <div>
                                <p class="font-semibold text-white">Materi:</p>
                                <p class="opacity-90">{{ $jadwal->materi }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center py-6 text-center opacity-60">
                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-2xl text-gray-400">event_busy</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Belum ada jadwal pelajaran.</p>
                <p class="text-[10px] text-gray-400 mt-0.5">Tekan tombol + untuk menambahkan.</p>
            </div>
            @endforelse
        </div>

        <!-- Quote -->

    </main>

    <!-- Floating Action Button -->
    <div class="fixed bottom-8 right-6 z-[60]">
        <a href="{{ route('ustadz.jadwal.create') }}"
            class="flex items-center justify-center w-14 h-14 rounded-full bg-primary text-white shadow-lg shadow-primary/40 hover:scale-105 active:scale-95 transition-all focus:outline-none focus:ring-4 focus:ring-primary/30">
            <span class="material-symbols-outlined text-3xl">add</span>
        </a>
    </div>

</body>

</html>
