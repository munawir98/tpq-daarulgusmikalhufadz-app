<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Jurnal Aktivitas & Ekskul</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            -webkit-tap-highlight-color: transparent;
            min-height: 100dvh;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#0e141b] dark:text-slate-100">
    <div
        class="relative flex min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-xl">
        <!-- TopAppBar -->
        <header class="sticky top-0 z-20 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md">
            <div class="flex items-center pt-8 pb-2 px-4 justify-center">
                <h2
                    class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight tracking-[-0.015em] text-center">
                    Jurnal & Kegiatan</h2>
            </div>
        </header>

        <!-- Tabs -->
        <div class="sticky top-[64px] z-20 bg-background-light dark:bg-background-dark mb-4">
            <div class="flex border-b border-[#d0dbe7] dark:border-slate-700 px-4 justify-between">
                <button id="tabJurnal"
                    class="tab-btn flex flex-col items-center justify-center border-b-[3px] border-b-primary text-primary pb-[13px] pt-4 flex-1">
                    <p class="text-xs font-bold leading-normal tracking-[0.015em]">Jurnal Harian</p>
                </button>
                <button id="tabEkskul"
                    class="tab-btn flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7397] dark:text-slate-400 pb-[13px] pt-4 flex-1">
                    <p class="text-xs font-bold leading-normal tracking-[0.015em]">Kegiatan Ekskul</p>
                </button>
            </div>
        </div>

        <main class="flex-1 pb-0">
            <!-- Jurnal Harian Section -->
            <div id="sectionJurnal">
                <!-- SectionHeader -->
                <div class="flex items-center justify-between px-4 pb-2 pt-2">
                    <h3 class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight tracking-[-0.015em]">
                        Riwayat Jurnal</h3>
                    <span class="text-xs font-medium text-primary bg-primary/10 px-2 py-1 rounded-full">{{
                        now()->locale('id')->translatedFormat('F Y') }}</span>
                </div>

                @forelse($jurnals ?? [] as $jurnal)
                <!-- Card: Daily Journal -->
                <div class="p-4 @container {{ !$loop->first ? 'pt-0' : '' }}">
                    <div
                        class="flex flex-col items-stretch justify-start rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
                        @if($jurnal->foto)
                        <div class="w-full bg-center bg-no-repeat aspect-[16/7] bg-cover"
                            style="background-image: url('{{ asset('storage/' . $jurnal->foto) }}');">
                        </div>
                        @endif
                        <div class="flex w-full min-w-72 grow flex-col items-stretch justify-center gap-1 py-4 px-4">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="material-symbols-outlined text-sm text-[#4e7397]">calendar_today</span>
                                <p class="text-[#4e7397] dark:text-slate-400 text-sm font-normal leading-normal">
                                    {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d M Y') }}</p>
                            </div>
                            <p
                                class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight tracking-[-0.015em]">
                                {{ $jurnal->judul ?? 'Jurnal Harian' }}</p>
                            <div class="mt-2 space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-primary">school</span>
                                    <p class="text-[#4e7397] dark:text-slate-400 text-xs font-medium">
                                        {{ $jurnal->kelas->nama ?? 'Kelas Umum' }}</p>
                                </div>
                                <p class="text-[#4e7397] dark:text-slate-400 text-xs leading-relaxed">
                                    {{ $jurnal->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-2 text-center text-gray-500">
                    <span class="material-symbols-outlined text-3xl text-gray-300 mb-1">edit_note</span>
                    <p class="text-xs">Belum ada jurnal harian.</p>
                </div>
                @endforelse
            </div>

            <!-- Kegiatan Ekskul Section (Hidden by default) -->
            <div id="sectionEkskul" class="hidden">
                <h3
                    class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-2">
                    Kegiatan Ekskul Terbaru</h3>

                @forelse($ekskuls ?? [] as $ekskul)
                <!-- Card: Ekskul -->
                <div class="p-4 @container {{ !$loop->first ? 'pt-0' : '' }}">
                    <div
                        class="flex flex-col items-stretch justify-start rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden">
                        @if($ekskul->foto)
                        <div class="w-full bg-center bg-no-repeat aspect-[16/7] bg-cover"
                            style="background-image: url('{{ asset('storage/' . $ekskul->foto) }}');">
                        </div>
                        @endif
                        <div class="flex w-full min-w-72 grow flex-col items-stretch justify-center gap-1 py-4 px-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p
                                        class="text-[#0e141b] dark:text-white text-sm font-bold leading-tight tracking-[-0.015em]">
                                        {{ $ekskul->nama ?? 'Kegiatan Ekskul' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="material-symbols-outlined text-sm text-primary">person</span>
                                        <p class="text-[#4e7397] dark:text-slate-400 text-xs">Pelatih:
                                            {{ $ekskul->pelatih ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="bg-primary/10 text-primary px-3 py-1 rounded-full flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">groups</span>
                                    <span class="text-xs font-bold">{{ $ekskul->jumlah_peserta ?? 0 }} Santri</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-2 text-center text-gray-500">
                    <span class="material-symbols-outlined text-3xl text-gray-300 mb-1">sports_martial_arts</span>
                    <p class="text-xs">Belum ada kegiatan ekskul.</p>
                </div>
                @endforelse
            </div>
        </main>

        <!-- Floating Action Button -->
        <button
            class="fixed bottom-6 right-6 flex items-center justify-center bg-primary text-white w-12 h-12 rounded-full shadow-lg hover:bg-blue-600 transition-colors z-30">
            <span class="material-symbols-outlined text-xl">add</span>
        </button>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabJurnal = document.getElementById('tabJurnal');
            const tabEkskul = document.getElementById('tabEkskul');
            const sectionJurnal = document.getElementById('sectionJurnal');
            const sectionEkskul = document.getElementById('sectionEkskul');

            function setActiveTab(activeTab, activeSection, inactiveTab, inactiveSection) {
                activeTab.classList.add('border-b-primary', 'text-primary');
                activeTab.classList.remove('border-b-transparent', 'text-[#4e7397]', 'dark:text-slate-400');
                inactiveTab.classList.remove('border-b-primary', 'text-primary');
                inactiveTab.classList.add('border-b-transparent', 'text-[#4e7397]', 'dark:text-slate-400');
                activeSection.classList.remove('hidden');
                inactiveSection.classList.add('hidden');
            }

            tabJurnal.addEventListener('click', function () {
                setActiveTab(tabJurnal, sectionJurnal, tabEkskul, sectionEkskul);
            });

            tabEkskul.addEventListener('click', function () {
                setActiveTab(tabEkskul, sectionEkskul, tabJurnal, sectionJurnal);
            });

            // Enable hardware back button
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function (event) {
                window.location.href = "{{ route('ustadz.laporan.index') }}";
            });
        });
    </script>
</body>

</html>
