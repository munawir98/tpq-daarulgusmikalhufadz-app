<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Notifikasi - TPQ Digital</title>
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
        html,
        body {
            height: 100%;
            min-height: 100dvh;
        }

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
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200 min-h-screen">
    <div
        class="relative flex min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl pb-24">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between px-5 py-4 relative">
                <div class="w-10"></div> <!-- Spacer for centering -->
                <h2 class="text-lg font-bold leading-tight tracking-tight text-[#111813] dark:text-white text-center">
                    Notifikasi
                </h2>
                <button id="markAllReadBtn"
                    class="text-xs font-bold text-primary hover:text-green-600 transition-colors px-2 py-1">
                    Baca Semua
                </button>
            </div>
        </header>

        <main class="flex flex-col flex-1 gap-6 px-5 pt-6">
            @php
            $today = [];
            $yesterday = [];
            $lastWeek = [];
            $older = [];

            $now = now();

            foreach($notifications ?? [] as $notification) {
            $createdAt = \Carbon\Carbon::parse($notification['created_at'] ?? $notification->created_at ?? now());

            if ($createdAt->isToday()) {
            $today[] = $notification;
            } elseif ($createdAt->isYesterday()) {
            $yesterday[] = $notification;
            } elseif ($createdAt->greaterThan($now->copy()->subWeek())) {
            $lastWeek[] = $notification;
            } else {
            $older[] = $notification;
            }
            }
            @endphp

            @if(count($today) > 0)
            <!-- Hari Ini -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Hari Ini</h3>

                @foreach($today as $notification)
                @php
                $isRead = $notification['read_at'] ?? $notification->read_at ?? null;
                $type = $notification['type'] ?? $notification->data['type'] ?? 'info';
                $title = $notification['title'] ?? $notification->data['title'] ?? 'Notifikasi';
                $message = $notification['message'] ?? $notification->data['message'] ?? '';
                $time = \Carbon\Carbon::parse($notification['created_at'] ?? $notification->created_at)->format('H:i') .
                ' WIB';
                $id = $notification['id'] ?? $notification->id ?? '';

                // Icon & color based on type
                $iconConfig = [
                'payment' => ['icon' => 'payments', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' =>
                'text-primary'],
                'hafalan' => ['icon' => 'menu_book', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' =>
                'text-blue-600'],
                'announcement' => ['icon' => 'campaign', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' =>
                'text-orange-600'],
                'info' => ['icon' => 'info', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600'],
                'welcome' => ['icon' => 'waving_hand', 'bg' => 'bg-teal-50 dark:bg-teal-900/20', 'text' =>
                'text-teal-600'],
                'presensi' => ['icon' => 'check_circle', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' =>
                'text-emerald-600'],
                'chat' => ['icon' => 'chat', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600'],
                ];
                $config = $iconConfig[$type] ?? $iconConfig['info'];
                @endphp
                <div class="notification-item group relative flex flex-col gap-3 {{ $isRead ? 'bg-white/60 dark:bg-gray-800/60' : 'bg-white dark:bg-gray-800' }} p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md active:scale-[0.99] cursor-pointer"
                    data-id="{{ $id }}" onclick="markAsRead('{{ $id }}')">
                    @if(!$isRead)
                    <div
                        class="absolute top-4 right-4 size-2.5 rounded-full bg-red-500 ring-4 ring-white dark:ring-gray-800">
                    </div>
                    @endif
                    <div
                        class="flex items-start gap-4 {{ $isRead ? 'opacity-80 group-hover:opacity-100 transition-opacity' : '' }}">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                            <span class="material-symbols-outlined text-[20px]">{{ $config['icon'] }}</span>
                        </div>
                        <div class="flex-1 pr-4">
                            <div class="flex justify-between items-start mb-1">
                                <h4
                                    class="text-sm {{ $isRead ? 'font-semibold' : 'font-bold' }} text-[#111813] dark:text-white">
                                    {{ $title }}</h4>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">{{ $message
                                }}</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">{{ $time }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(count($yesterday) > 0)
            <!-- Kemarin -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Kemarin</h3>

                @foreach($yesterday as $notification)
                @php
                $isRead = $notification['read_at'] ?? $notification->read_at ?? null;
                $type = $notification['type'] ?? $notification->data['type'] ?? 'info';
                $title = $notification['title'] ?? $notification->data['title'] ?? 'Notifikasi';
                $message = $notification['message'] ?? $notification->data['message'] ?? '';
                $time = 'Kemarin, ' . \Carbon\Carbon::parse($notification['created_at'] ??
                $notification->created_at)->format('H:i');
                $id = $notification['id'] ?? $notification->id ?? '';

                $iconConfig = [
                'payment' => ['icon' => 'payments', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' =>
                'text-primary'],
                'hafalan' => ['icon' => 'menu_book', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' =>
                'text-blue-600'],
                'announcement' => ['icon' => 'campaign', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' =>
                'text-orange-600'],
                'info' => ['icon' => 'info', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600'],
                'welcome' => ['icon' => 'waving_hand', 'bg' => 'bg-teal-50 dark:bg-teal-900/20', 'text' =>
                'text-teal-600'],
                'presensi' => ['icon' => 'check_circle', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' =>
                'text-emerald-600'],
                'chat' => ['icon' => 'chat', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600'],
                ];
                $config = $iconConfig[$type] ?? $iconConfig['info'];
                @endphp
                <div class="notification-item group relative flex flex-col gap-3 {{ $isRead ? 'bg-white/60 dark:bg-gray-800/60' : 'bg-white dark:bg-gray-800' }} p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-800 active:scale-[0.99] cursor-pointer"
                    data-id="{{ $id }}" onclick="markAsRead('{{ $id }}')">
                    @if(!$isRead)
                    <div
                        class="absolute top-4 right-4 size-2.5 rounded-full bg-red-500 ring-4 ring-white dark:ring-gray-800">
                    </div>
                    @endif
                    <div
                        class="flex items-start gap-4 {{ $isRead ? 'opacity-80 group-hover:opacity-100 transition-opacity' : '' }}">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                            <span class="material-symbols-outlined text-[20px]">{{ $config['icon'] }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4
                                    class="text-sm {{ $isRead ? 'font-semibold' : 'font-bold' }} text-[#111813] dark:text-white">
                                    {{ $title }}</h4>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">{{ $message
                                }}</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">{{ $time }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(count($lastWeek) > 0)
            <!-- Minggu Lalu -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Minggu Lalu</h3>

                @foreach($lastWeek as $notification)
                @php
                $isRead = $notification['read_at'] ?? $notification->read_at ?? null;
                $type = $notification['type'] ?? $notification->data['type'] ?? 'info';
                $title = $notification['title'] ?? $notification->data['title'] ?? 'Notifikasi';
                $message = $notification['message'] ?? $notification->data['message'] ?? '';
                $time = \Carbon\Carbon::parse($notification['created_at'] ?? $notification->created_at)->format('d M');
                $id = $notification['id'] ?? $notification->id ?? '';

                $iconConfig = [
                'payment' => ['icon' => 'payments', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' =>
                'text-primary'],
                'hafalan' => ['icon' => 'menu_book', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' =>
                'text-blue-600'],
                'announcement' => ['icon' => 'campaign', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' =>
                'text-orange-600'],
                'info' => ['icon' => 'info', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600'],
                'welcome' => ['icon' => 'waving_hand', 'bg' => 'bg-teal-50 dark:bg-teal-900/20', 'text' =>
                'text-teal-600'],
                'presensi' => ['icon' => 'check_circle', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' =>
                'text-emerald-600'],
                'chat' => ['icon' => 'chat', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600'],
                ];
                $config = $iconConfig[$type] ?? $iconConfig['info'];
                @endphp
                <div class="notification-item group relative flex flex-col gap-3 bg-white/60 dark:bg-gray-800/60 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-800 active:scale-[0.99] cursor-pointer"
                    data-id="{{ $id }}" onclick="markAsRead('{{ $id }}')">
                    @if(!$isRead)
                    <div
                        class="absolute top-4 right-4 size-2.5 rounded-full bg-red-500 ring-4 ring-white dark:ring-gray-800">
                    </div>
                    @endif
                    <div class="flex items-start gap-4 opacity-80 group-hover:opacity-100 transition-opacity">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                            <span class="material-symbols-outlined text-[20px]">{{ $config['icon'] }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-semibold text-[#111813] dark:text-white">{{ $title }}</h4>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">{{ $message
                                }}</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">{{ $time }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(count($older) > 0)
            <!-- Lebih Lama -->
            <div class="flex flex-col gap-3">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pl-1">Lebih Lama</h3>

                @foreach($older as $notification)
                @php
                $isRead = $notification['read_at'] ?? $notification->read_at ?? null;
                $type = $notification['type'] ?? $notification->data['type'] ?? 'info';
                $title = $notification['title'] ?? $notification->data['title'] ?? 'Notifikasi';
                $message = $notification['message'] ?? $notification->data['message'] ?? '';
                $time = \Carbon\Carbon::parse($notification['created_at'] ?? $notification->created_at)->format('d M');
                $id = $notification['id'] ?? $notification->id ?? '';

                $iconConfig = [
                'payment' => ['icon' => 'payments', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'text' =>
                'text-primary'],
                'hafalan' => ['icon' => 'menu_book', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' =>
                'text-blue-600'],
                'announcement' => ['icon' => 'campaign', 'bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' =>
                'text-orange-600'],
                'info' => ['icon' => 'info', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600'],
                'welcome' => ['icon' => 'waving_hand', 'bg' => 'bg-teal-50 dark:bg-teal-900/20', 'text' =>
                'text-teal-600'],
                'presensi' => ['icon' => 'check_circle', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/20', 'text' =>
                'text-emerald-600'],
                'chat' => ['icon' => 'chat', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'text' => 'text-indigo-600'],
                ];
                $config = $iconConfig[$type] ?? $iconConfig['info'];
                @endphp
                <div class="notification-item group relative flex flex-col gap-3 bg-white/60 dark:bg-gray-800/60 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:bg-white dark:hover:bg-gray-800 active:scale-[0.99] cursor-pointer"
                    data-id="{{ $id }}" onclick="markAsRead('{{ $id }}')">
                    <div class="flex items-start gap-4 opacity-80 group-hover:opacity-100 transition-opacity">
                        <div
                            class="flex-shrink-0 flex items-center justify-center size-10 rounded-full {{ $config['bg'] }} {{ $config['text'] }}">
                            <span class="material-symbols-outlined text-[20px]">{{ $config['icon'] }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-semibold text-[#111813] dark:text-white">{{ $title }}</h4>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2">{{ $message
                                }}</p>
                            <p class="text-[10px] font-medium text-gray-400 mt-2">{{ $time }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(count($notifications ?? []) === 0)
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center flex-1 min-h-[60vh] gap-4">
                <div class="flex items-center justify-center size-20 rounded-full bg-gray-100 dark:bg-gray-800">
                    <span class="material-symbols-outlined text-gray-400 text-[40px]">notifications_off</span>
                </div>
                <div class="text-center">
                    <h4 class="text-base font-bold text-gray-600 dark:text-gray-300 mb-1">Belum Ada Notifikasi</h4>
                    <p class="text-sm text-gray-400">Notifikasi akan muncul di sini</p>
                </div>
            </div>
            @endif

            <div class="h-8"></div>
        </main>

        <!-- Bottom Navigation -->
        <nav
            class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 pb-5 pt-3 px-6 z-50">
            <div class="flex justify-between items-center">
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="{{ $dashboardUrl }}">
                    <span class="material-symbols-outlined">home</span>
                    <span class="text-[10px] font-medium">Beranda</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/notifications">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="text-[10px] font-medium">Notifikasi</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    href="/chat">
                    <span class="material-symbols-outlined">chat</span>
                    <span class="text-[10px] font-medium">Chat</span>
                </a>
                <a class="flex flex-col items-center gap-1 text-primary" href="/profile">
                    <span class="material-symbols-outlined filled">settings</span>
                    <span class="text-[10px] font-medium">Pengaturan</span>
                </a>
            </div>
        </nav>
    </div>

    <script>
        // Dark mode check
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        // Mark single notification as read
        function markAsRead(id) {
            if (!id) return;

            fetch(`/profile/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove red dot and update styling
                        const item = document.querySelector(`[data-id="${id}"]`);
                        if (item) {
                            const dot = item.querySelector('.bg-red-500');
                            if (dot) dot.remove();

                            item.classList.remove('bg-white', 'dark:bg-gray-800');
                            item.classList.add('bg-white/60', 'dark:bg-gray-800/60');
                        }

                        // Navigate if URL provided
                        if (data.url) {
                            window.location.href = data.url;
                        }
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        // Mark all as read
        document.getElementById('markAllReadBtn').addEventListener('click', function () {
            fetch('/profile/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove all red dots
                        document.querySelectorAll('.notification-item .bg-red-500').forEach(dot => {
                            dot.remove();
                        });

                        // Update all items styling
                        document.querySelectorAll('.notification-item').forEach(item => {
                            item.classList.remove('bg-white', 'dark:bg-gray-800');
                            item.classList.add('bg-white/60', 'dark:bg-gray-800/60');
                        });
                    }
                })
                .catch(err => console.error('Error:', err));
        });
    </script>
</body>

</html>
