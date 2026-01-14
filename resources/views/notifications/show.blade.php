<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Detail Riwayat Notifikasi</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
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
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Lexend', sans-serif;
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
            <button onclick="history.back()"
                class="text-[#0e141b] dark:text-white flex size-10 items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <h2
                class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-10">
                Detail Notifikasi</h2>
        </div>
    </header>
    <main class="flex-1 pb-24">
        <!-- Student & Parent Information -->
        <section class="mt-4 px-4">
            <div
                class="flex items-center gap-4 bg-white dark:bg-[#1c2630] p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full h-16 w-16 border-2 border-primary/20"
                    data-alt="Avatar portrait of a young student"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCpx9zIFrgZ9L4z1vLWRGLa-GryOks0o9zhpbW0FSLhOaCasoJnH9OTB6tKuWJwbjsM_o0qCQLjx0DoOPsRWe_d8IE144tCsklS0atfeizPb3ZbRmxWgUZGL0_h4-RL7tVUVoO_YrJw_2IwUxtbjwmhae2zNed57SthhK0tv2jKkGd3l0E-X93QCIgIVuGgVlIrg0jCWKKqXjtF9FI35b_0ook268ZMt3IehZYuXiu8ZtFHy6SptYYuphOCGjS3yWIh-QjFDwRJmfem");'>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight">Ahmad Fauzi</p>
                    <p class="text-[#4e7397] dark:text-gray-400 text-sm font-medium leading-normal">Kelas Al-Jazari •
                        Bpk. Ridwan</p>
                    <div class="mt-1 flex items-center gap-1 text-primary text-xs font-semibold">
                        <span class="material-symbols-outlined text-[14px]">person</span>
                        Wali Santri
                    </div>
                </div>
            </div>
        </section>
        <!-- Message Delivery Status Banner -->
        <section class="mt-4 px-4">
            <div
                class="flex flex-col items-start justify-between gap-3 rounded-xl border border-green-100 dark:border-green-900/30 bg-green-50 dark:bg-green-900/10 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex size-8 items-center justify-center rounded-full bg-green-500 text-white">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-green-800 dark:text-green-400 text-sm font-bold leading-tight">Terkirim via
                            WhatsApp</p>
                        <p class="text-green-700/70 dark:text-green-500/70 text-xs font-normal">Terkirim pada 14:02, 24
                            Okt 2023</p>
                    </div>
                </div>
                <a class="text-xs font-bold leading-normal tracking-[0.015em] flex items-center gap-1 text-green-800 dark:text-green-400 hover:underline"
                    href="#">
                    Lihat Log Pengiriman
                    <span class="material-symbols-outlined text-sm">arrow_right_alt</span>
                </a>
            </div>
        </section>
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
                                class="bg-primary/10 text-primary text-[10px] uppercase font-bold px-2 py-0.5 rounded">Pengumuman</span>
                            <span class="material-symbols-outlined text-gray-300">format_quote</span>
                        </div>
                        <p class="text-[#0e141b] dark:text-gray-200 text-base font-normal leading-relaxed italic">
                            "Assalamu’alaikum, menginfokan bahwa Ahmad tidak hadir di kelas hari ini tanpa keterangan.
                            Mohon konfirmasinya melalui aplikasi atau hubungi Ustadz pengampu. Terima kasih."
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
                    <p class="text-[#0e141b] dark:text-white text-sm font-semibold">Peringatan Absensi</p>
                </div>
                <div class="flex items-center justify-between p-4">
                    <p class="text-[#4e7397] dark:text-gray-400 text-sm font-medium">ID Pengiriman</p>
                    <p class="text-[#0e141b] dark:text-white text-sm font-mono">#NTF-99281</p>
                </div>
                <div class="flex items-center justify-between p-4">
                    <p class="text-[#4e7397] dark:text-gray-400 text-sm font-medium">Waktu Dibaca</p>
                    <div class="flex items-center gap-2">
                        <span class="text-[#0e141b] dark:text-white text-sm font-semibold">14:30</span>
                        <span class="material-symbols-outlined text-blue-500 text-sm">done_all</span>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4">
                    <p class="text-[#4e7397] dark:text-gray-400 text-sm font-medium">Pengirim</p>
                    <p class="text-[#0e141b] dark:text-white text-sm font-semibold">Ustd. Mansur</p>
                </div>
            </div>
        </section>
    </main>
    <!-- Fixed Bottom Action Area -->
    <footer
        class="fixed bottom-0 left-0 right-0 bg-white dark:bg-[#111921] border-t border-gray-200 dark:border-gray-800 p-4 pb-8">
        <div class="max-w-md mx-auto flex gap-3">
            <button
                class="flex-1 flex items-center justify-center gap-2 bg-primary text-white py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 active:scale-[0.98] transition-all">
                <span class="material-symbols-outlined text-lg">refresh</span>
                Kirim Ulang
            </button>
            <button
                class="flex size-[52px] items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#0e141b] dark:text-white">
                <span class="material-symbols-outlined">share</span>
            </button>
        </div>
    </footer>
</body>

</html>
