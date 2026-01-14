<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Riwayat Notifikasi Ustadz</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#197fe6",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111921",
                    },
                    fontFamily: {
                        "display": ["Poppins", "sans-serif"]
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
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-100">
    <div
        class="relative flex min-h-screen w-full flex-col overflow-x-hidden max-w-[430px] mx-auto bg-white dark:bg-background-dark shadow-xl">
        <!-- Header -->
        <header
            class="sticky top-0 z-50 flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md p-4 border-b border-slate-100 dark:border-slate-800">
            <button onclick="history.back()"
                class="text-primary flex size-9 items-center justify-center rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined text-[20px]">arrow_back_ios</span>
            </button>
            <h1
                class="text-[#0e141b] dark:text-white text-base font-semibold leading-tight tracking-tight flex-1 text-center pr-10">
                Riwayat Notifikasi</h1>
        </header>

        <!-- Search Bar -->
        <div class="px-4 py-3">
            <form action="{{ route('ustadz.notifications.index') }}" method="GET"
                class="flex flex-col min-w-40 h-10 w-full">
                <!-- Preserve existing filter if searching -->
                @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
                <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm">
                    <div class="text-[#4e7397] flex border-none bg-[#e7edf3] dark:bg-slate-800 items-center justify-center pl-4 rounded-l-xl"
                        data-icon="search">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </div>
                    <input type="text" name="search"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-xl text-[#0e141b] dark:text-white focus:outline-0 focus:ring-0 border-none bg-[#e7edf3] dark:bg-slate-800 placeholder:text-[#4e7397] px-4 pl-2 text-sm font-normal leading-normal"
                        placeholder="Cari nama santri..." value="{{ $currentSearch ?? '' }}" />
                </div>
            </form>
        </div>

        <!-- Filter Chips -->
        <div class="flex gap-2 px-4 pb-4 overflow-x-auto no-scrollbar">
            <a href="{{ route('ustadz.notifications.index', ['search' => request('search')]) }}"
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full px-4 {{ !$currentFilter ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-[#e7edf3] dark:bg-slate-800 text-[#0e141b] dark:text-slate-300' }}">
                <p class="text-xs font-medium leading-normal">Semua</p>
            </a>
            <a href="{{ route('ustadz.notifications.index', ['filter' => 'sent', 'search' => request('search')]) }}"
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full px-4 {{ $currentFilter == 'sent' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-[#e7edf3] dark:bg-slate-800 text-[#0e141b] dark:text-slate-300' }}">
                <p class="text-xs font-medium leading-normal">Terkirim</p>
            </a>
            <a href="{{ route('ustadz.notifications.index', ['filter' => 'read', 'search' => request('search')]) }}"
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full px-4 {{ $currentFilter == 'read' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-[#e7edf3] dark:bg-slate-800 text-[#0e141b] dark:text-slate-300' }}">
                <p class="text-xs font-medium leading-normal">Dibaca</p>
            </a>
            <a href="{{ route('ustadz.notifications.index', ['filter' => 'failed', 'search' => request('search')]) }}"
                class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full px-4 {{ $currentFilter == 'failed' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-[#e7edf3] dark:bg-slate-800 text-[#0e141b] dark:text-slate-300' }}">
                <p class="text-xs font-medium leading-normal">Gagal</p>
            </a>
        </div>

        <!-- History List -->
        <main class="flex-1 flex flex-col gap-1 px-2">
            @forelse($notifications as $notification)
            @php
            $data = $notification['data'] ?? [];
            // Fallback helpers
            $type = $notification['type'] ?? 'Notification';
            $isRead = !empty($notification['read_at']);

            // Logic to determine icon vs image, status text, etc.
            // Assuming raw data structure. Adjust if model access differs.
            // For now, using placeholders for dynamic fields not yet fully standardized.
            $title = $data['title'] ?? 'Notifikasi Baru';
            $body = $data['body'] ?? 'Detail notifikasi...';
            $date = \Carbon\Carbon::parse($notification['created_at'])->format('d M Y');
            $time = \Carbon\Carbon::parse($notification['created_at'])->format('H:i');
            $status = $data['status'] ?? 'sent'; // sent, failed, etc

            // Simple logic for status display
            $statusColor = 'text-primary bg-primary/10 dark:bg-primary/20';
            $statusIcon = 'notifications_active';
            $statusLabel = 'Terkirim';

            if ($status == 'failed') {
            $statusColor = 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30';
            $statusIcon = 'error_outline';
            $statusLabel = 'Gagal';
            } elseif ($isRead) {
            $statusColor = 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30';
            $statusIcon = 'done_all';
            $statusLabel = 'Dibaca';
            }
            @endphp

            <div onclick="window.location.href='{{ route('ustadz.notifications.show', $notification['id']) }}'"
                class="flex gap-3 bg-white dark:bg-background-dark px-4 py-3 rounded-xl active:bg-slate-50 dark:active:bg-slate-800/50 transition-colors cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/30">
                <div class="relative">
                    <div
                        class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-[48px] w-[48px] border-2 border-slate-100 dark:border-slate-800 flex items-center justify-center bg-slate-50 dark:bg-slate-800">
                        <!-- Placeholder Icon or Initial if no image -->
                        <span class="material-symbols-outlined text-slate-400">person</span>
                    </div>
                    <!-- Status Badge Mini -->
                    <div class="absolute -bottom-1 -right-1 bg-white dark:bg-slate-800 rounded-full p-0.5">
                        <span
                            class="material-symbols-outlined {{ $status == 'failed' ? 'text-red-500' : ($isRead ? 'text-green-500' : 'text-primary') }} text-[16px] leading-none">
                            {{ $status == 'failed' ? 'error' : 'chat_bubble' }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-1 flex-col justify-center">
                    <div class="flex justify-between items-start">
                        <p class="text-[#0e141b] dark:text-white text-sm font-semibold leading-none">{{ $title }}</p>
                        <span class="text-[#4e7397] text-[10px] font-normal">{{ $time }}</span>
                    </div>
                    <p class="text-primary text-xs font-medium mt-1 line-clamp-1">{{ $body }}</p>
                    <p class="text-[#4e7397] dark:text-slate-400 text-[10px] mt-0.5">{{ $date }}</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="{{ $statusColor }} px-2.5 py-0.5 rounded-full text-[10px] font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">{{ $statusIcon }}</span>
                        {{ $statusLabel }}
                    </div>
                </div>
            </div>

            <div class="mx-4 h-[1px] bg-slate-100 dark:bg-slate-800 last:hidden"></div>

            @empty
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center p-12 text-center min-h-[50vh]">
                <div class="w-48 h-48 mb-6 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center">
                    <span
                        class="material-symbols-outlined text-slate-300 dark:text-slate-600 text-8xl">notifications_off</span>
                </div>
                <h3 class="text-lg font-bold text-[#0e141b] dark:text-white">Tidak ada riwayat</h3>
                <p class="text-[#4e7397] dark:text-slate-400 mt-2">Belum ada notifikasi{{ request('search') ? ' yang
                    cocok dengan pencarian' : '' }}.
                </p>
            </div>
            @endforelse
        </main>
        <!-- Empty State (Hidden by default, shown if list is empty) -->
        <div class="hidden flex-1 flex-col items-center justify-center p-12 text-center">
            <div class="w-48 h-48 mb-6 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center">
                <span
                    class="material-symbols-outlined text-slate-300 dark:text-slate-600 text-8xl">notifications_off</span>
            </div>
            <h3 class="text-lg font-bold text-[#0e141b] dark:text-white">Tidak ada riwayat</h3>
            <p class="text-[#4e7397] dark:text-slate-400 mt-2">Data notifikasi yang Anda cari tidak ditemukan di server.
            </p>
        </div>
        <!-- FAB for New Notification -->
        <button
            class="fixed bottom-8 right-8 flex size-12 items-center justify-center rounded-full bg-primary text-white shadow-xl hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined">add_comment</span>
        </button>



    </div>
</body>

</html>
