<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Detail Notifikasi</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
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
        body {
            font-family: 'Poppins', sans-serif;
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

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-white min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
    <header
        class="sticky top-0 z-50 bg-background-light dark:bg-background-dark border-b border-gray-200 dark:border-gray-800">
        <div class="flex items-center px-4 py-3 justify-between">
            <a href="{{ url()->previous() }}"
                class="text-[#0e141b] dark:text-white flex size-10 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="material-symbols-outlined">chevron_left</span>
            </a>
            <h2
                class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">
                Detail Notifikasi</h2>
        </div>
    </header>
    <main class="flex-1 overflow-y-auto pb-24">
        <!-- Message Content Section -->
        <section class="mt-6">
            <h3 class="text-[#0e141b] dark:text-white text-base font-bold px-4 mb-2">Isi Pesan</h3>
            <div class="px-4">
                <div
                    class="flex flex-col items-stretch justify-start rounded-xl bg-white dark:bg-[#1c2630] border border-gray-100 dark:border-gray-800 overflow-hidden shadow-sm">
                    <!-- Optional Message Header Image/Graphic -->
                    <div class="w-full h-1 bg-primary"></div>
                    <div class="flex w-full flex-col p-5">
                        <div class="flex justify-between items-start mb-3">
                            <span
                                class="bg-primary/10 text-primary text-[10px] uppercase font-bold px-2 py-0.5 rounded">{{
                                $notification->data['title'] ?? 'Pengumuman' }}</span>
                            <span class="material-symbols-outlined text-gray-300">format_quote</span>
                        </div>
                        <p class="text-[#0e141b] dark:text-gray-200 text-base font-normal leading-relaxed italic">
                            "{{ $notification->data['message'] ?? $notification->data['content'] ?? 'Tidak ada konten.'
                            }}"
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Metadata Section -->
        <section class="mt-6 px-4">
            <div
                class="bg-white dark:bg-[#1c2630] rounded-xl border border-gray-100 dark:border-gray-800 divide-y divide-gray-100 dark:divide-gray-800">
                <div class="flex items-center justify-between p-4">
                    <p class="text-[#4e7397] dark:text-gray-400 text-sm font-medium">Tipe Pesan</p>
                    <p class="text-[#0e141b] dark:text-white text-sm font-semibold capitalize">{{ $notification->type ??
                        'Info Umum' }}</p>
                </div>
                <div class="flex items-center justify-between p-4">
                    <p class="text-[#4e7397] dark:text-gray-400 text-sm font-medium">Waktu</p>
                    <div class="flex items-center gap-2">
                        <span class="text-[#0e141b] dark:text-white text-sm font-semibold">{{
                            $notification->created_at->format('H:i, d M Y') }}</span>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
