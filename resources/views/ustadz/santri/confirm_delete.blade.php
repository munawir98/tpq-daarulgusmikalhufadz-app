<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Konfirmasi Hapus Santri</title>
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
                        "primary": "#ec1313", // Custom Red as requested
                        "background-light": "#f8f6f6",
                        "background-dark": "#221010",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
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
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark h-screen flex items-center justify-center p-4 overflow-hidden">
    <!-- Main Container (Mobile Form Factor) -->
    <div
        class="relative flex w-full max-w-[375px] flex-col bg-white dark:bg-[#1a0c0c] overflow-hidden rounded-[40px] shadow-2xl border-[8px] border-gray-900 dark:border-black max-h-full">

        <!-- Top App Bar -->
        <div class="flex items-center bg-white dark:bg-[#1a0c0c] p-4 pb-2 justify-center">
            <h2
                class="text-[#181111] dark:text-white text-base font-bold leading-tight tracking-[-0.015em] text-center">
                Konfirmasi Hapus
            </h2>
        </div>

        <div class="flex flex-col items-center px-6 pt-6 flex-grow overflow-y-auto no-scrollbar">
            <!-- Warning Icon -->
            <div class="bg-primary/10 p-4 rounded-full mb-4">
                <span class="material-symbols-outlined text-primary !text-4xl">warning</span>
            </div>

            <!-- Headline Text -->
            <h3 class="text-[#181111] dark:text-white tracking-light text-lg font-bold leading-tight text-center pb-2">
                Apakah Anda yakin ingin menghapus data santri ini?
            </h3>

            <!-- Body Text -->
            <p class="text-[#181111] dark:text-gray-300 text-sm font-normal leading-normal pb-6 pt-1 text-center">
                Tindakan ini tidak dapat dibatalkan dan semua data terkait akan dihapus secara permanen dari database.
            </p>

            <!-- Card: Santri Summary -->
            <div class="w-full">
                <div
                    class="p-3 border border-gray-100 dark:border-gray-800 rounded-xl bg-white dark:bg-[#2a1616] shadow-sm">
                    <div class="flex items-center gap-3">
                        <!-- Profile Image -->
                        @if($santri->user && $santri->user->foto)
                        <div class="size-14 rounded-full bg-cover bg-center border-2 border-primary/20"
                            style='background-image: url("{{ asset(' storage/' . $santri->user->foto) }}");'>
                        </div>
                        @else
                        <div class="size-14 rounded-full bg-cover bg-center border-2 border-primary/20"
                            style='background-image: url("https://ui-avatars.com/api/?name={{ urlencode($santri->nama_lengkap) }}&background=random&color=fff&bold=true");'>
                        </div>
                        @endif

                        <div class="flex flex-col gap-0.5">
                            <p class="text-[#181111] dark:text-white text-base font-bold leading-tight">{{
                                $santri->nama_lengkap }}</p>
                            <p class="text-[#896161] dark:text-gray-400 text-xs font-medium leading-normal">NIS: {{
                                $santri->nis }}</p>
                            <div
                                class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-[10px] font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider w-fit">
                                {{ $santri->kelas->nama_kelas ?? 'Belum ada kelas' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-grow"></div>

            <!-- Button Group (Action Buttons) -->
            <div class="bg-white dark:bg-[#1a0c0c] w-full pt-6 pb-4">
                <div class="flex flex-col gap-3 w-full">
                    <!-- Delete Button Form -->
                    <form action="{{ route('ustadz.santri.destroy', $santri->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="flex cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] w-full shadow-lg shadow-primary/20 hover:bg-red-600 active:scale-[0.98] transition-all">
                            <span class="material-symbols-outlined mr-2 !text-lg">delete</span>
                            <span class="truncate">Hapus Data</span>
                        </button>
                    </form>

                    <!-- Cancel Button -->
                    <a href="{{ route('ustadz.santri.index') }}"
                        class="flex cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 px-5 bg-[#f4f0f0] dark:bg-[#331d1d] text-[#181111] dark:text-white text-sm font-bold leading-normal tracking-[0.015em] w-full hover:bg-gray-200 dark:hover:bg-gray-800 active:scale-[0.98] transition-all">
                        <span class="truncate">Batal</span>
                    </a>
                </div>
            </div>

            <!-- iOS Indicator -->
            <div class="flex justify-center pb-2">
                <div class="w-24 h-1 bg-gray-300 dark:bg-gray-700 rounded-full"></div>
            </div>

        </div>
    </div>
</body>

</html>
