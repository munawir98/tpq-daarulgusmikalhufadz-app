<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Input Nilai Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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

        input[type=range] {
            -webkit-appearance: none;
            width: 100%;
            background: transparent;
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 6px;
            cursor: pointer;
            background: #e2e8f0;
            border-radius: 3px;
        }

        input[type=range]::-webkit-slider-thumb {
            height: 24px;
            width: 24px;
            border-radius: 50%;
            background: #197fe6;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -9px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dark input[type=range]::-webkit-slider-runnable-track {
            background: #334155;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-200 min-h-screen">
    <div
        class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden max-w-[480px] mx-auto bg-white dark:bg-background-dark shadow-xl">
        <!-- TopAppBar -->
        <div
            class="sticky top-0 z-20 flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md p-4 pb-2 justify-between border-b border-slate-100 dark:border-slate-800">
            <a href="{{ route('ustadz.nilai.index') }}"
                class="text-primary flex size-12 shrink-0 items-center justify-start cursor-pointer active:opacity-60 transition-opacity">
                <span class="material-symbols-outlined">arrow_back_ios</span>
            </a>
            <h2
                class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight tracking-[-0.015em] flex-1 text-center pr-12">
                Input Nilai Baru</h2>
        </div>

        <form action="{{ route('ustadz.nilai.store') }}" method="POST" id="nilaiForm">
            @csrf
            <div class="flex-1 overflow-y-auto p-4 space-y-6 pb-32">
                <!-- Pilih Santri -->
                <section class="space-y-3">
                    <label class="flex flex-col gap-2">
                        <p class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold">Pilih Santri</p>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-3 text-slate-400">search</span>
                            <select name="santri_id" required
                                class="form-select flex w-full appearance-none rounded-xl text-[#0e141b] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 h-12 pl-10 pr-10 text-sm font-normal">
                                <option value="">Cari Nama Santri...</option>
                                @foreach($santriList ?? [] as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->nama_lengkap }} (NIS: {{ $santri->nis ??
                                    '-' }})</option>
                                @endforeach
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-3 text-[#4e7397] pointer-events-none">expand_more</span>
                        </div>
                    </label>
                    @error('santri_id')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </section>

                <!-- Tahun Ajaran & Kategori -->
                <section class="grid grid-cols-2 gap-4">
                    <label class="flex flex-col gap-2">
                        <p class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold">Tahun Ajaran</p>
                        <div class="relative">
                            <select name="tahun_ajaran"
                                class="form-select flex w-full appearance-none rounded-xl text-[#0e141b] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 h-12 px-3 text-sm font-normal">
                                <option>2024/2025 Ganjil</option>
                                <option>2024/2025 Genap</option>
                                <option>2023/2024 Ganjil</option>
                                <option>2023/2024 Genap</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-2 top-3 text-slate-400 pointer-events-none scale-75">expand_more</span>
                        </div>
                    </label>
                    <label class="flex flex-col gap-2">
                        <p class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold">Kategori Nilai</p>
                        <div class="relative">
                            <select name="kategori"
                                class="form-select flex w-full appearance-none rounded-xl text-[#0e141b] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 h-12 px-3 text-sm font-normal">
                                <option>Penilaian Bulanan</option>
                                <option>Ujian Tengah Semester</option>
                                <option>Ujian Akhir Semester</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-2 top-3 text-slate-400 pointer-events-none scale-75">expand_more</span>
                        </div>
                    </label>
                </section>

                <!-- Input Komponen Nilai -->
                <section
                    class="bg-white dark:bg-slate-800/30 rounded-2xl border border-slate-100 dark:border-slate-800 p-5 space-y-6">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-wider mb-2">Input Komponen Nilai</h3>

                    <!-- Tilawah -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Tilawah</span>
                            <input name="tilawah" id="tilawahNumber"
                                class="w-16 h-8 text-center bg-slate-100 dark:bg-slate-700 border-none rounded-lg text-sm font-bold text-primary focus:ring-1 focus:ring-primary"
                                max="100" min="0" type="number" value="0" oninput="syncRange('tilawah')" />
                        </div>
                        <input id="tilawahRange" class="w-full" max="100" min="0" type="range" value="0"
                            oninput="syncNumber('tilawah')" />
                    </div>

                    <!-- Hafalan -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Hafalan</span>
                            <input name="hafalan" id="hafalanNumber"
                                class="w-16 h-8 text-center bg-slate-100 dark:bg-slate-700 border-none rounded-lg text-sm font-bold text-primary focus:ring-1 focus:ring-primary"
                                max="100" min="0" type="number" value="0" oninput="syncRange('hafalan')" />
                        </div>
                        <input id="hafalanRange" class="w-full" max="100" min="0" type="range" value="0"
                            oninput="syncNumber('hafalan')" />
                    </div>

                    <!-- Adab -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Adab</span>
                            <input name="adab" id="adabNumber"
                                class="w-16 h-8 text-center bg-slate-100 dark:bg-slate-700 border-none rounded-lg text-sm font-bold text-primary focus:ring-1 focus:ring-primary"
                                max="100" min="0" type="number" value="0" oninput="syncRange('adab')" />
                        </div>
                        <input id="adabRange" class="w-full" max="100" min="0" type="range" value="0"
                            oninput="syncNumber('adab')" />
                    </div>

                    <!-- Tajwid -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium">Tajwid</span>
                            <input name="tajwid" id="tajwidNumber"
                                class="w-16 h-8 text-center bg-slate-100 dark:bg-slate-700 border-none rounded-lg text-sm font-bold text-primary focus:ring-1 focus:ring-primary"
                                max="100" min="0" type="number" value="0" oninput="syncRange('tajwid')" />
                        </div>
                        <input id="tajwidRange" class="w-full" max="100" min="0" type="range" value="0"
                            oninput="syncNumber('tajwid')" />
                    </div>
                </section>

                <!-- Catatan Ustadz -->
                <section class="space-y-2">
                    <p class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold">Catatan Ustadz</p>
                    <textarea name="catatan"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 text-sm focus:ring-primary focus:border-primary placeholder:text-slate-400"
                        placeholder="Berikan feedback kualitatif untuk santri..." rows="3"></textarea>
                </section>

                <!-- Rata-rata & Predikat -->
                <section
                    class="bg-primary/5 dark:bg-primary/10 border border-primary/20 rounded-2xl p-4 flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase">Rata-rata</p>
                        <p id="rataRata" class="text-2xl font-bold text-primary">0.0</p>
                    </div>
                    <div class="h-12 w-px bg-primary/20"></div>
                    <div class="space-y-1 text-right">
                        <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase">Predikat</p>
                        <p id="predikat" class="text-2xl font-bold text-slate-400">-</p>
                    </div>
                </section>
            </div>

            <!-- Bottom Action -->
            <div
                class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-[480px] bg-white/90 dark:bg-background-dark/90 backdrop-blur-md border-t border-slate-100 dark:border-slate-800 p-4 pb-8 z-30">
                <button type="submit"
                    class="w-full bg-primary text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 active:scale-[0.98] transition-all shadow-lg shadow-primary/25">
                    <span class="material-symbols-outlined">save</span>
                    Simpan Nilai
                </button>
            </div>
        </form>
    </div>

    <script>
        function syncRange(name) {
            const number = document.getElementById(name + 'Number').value;
            document.getElementById(name + 'Range').value = number;
            updateRataRata();
        }

        function syncNumber(name) {
            const range = document.getElementById(name + 'Range').value;
            document.getElementById(name + 'Number').value = range;
            updateRataRata();
        }

        function updateRataRata() {
            const tilawah = parseInt(document.getElementById('tilawahNumber').value) || 0;
            const hafalan = parseInt(document.getElementById('hafalanNumber').value) || 0;
            const adab = parseInt(document.getElementById('adabNumber').value) || 0;
            const tajwid = parseInt(document.getElementById('tajwidNumber').value) || 0;

            const rata = (tilawah + hafalan + adab + tajwid) / 4;
            document.getElementById('rataRata').textContent = rata.toFixed(1);

            const predikatEl = document.getElementById('predikat');
            if (rata >= 90) {
                predikatEl.textContent = 'A+';
                predikatEl.className = 'text-2xl font-bold text-emerald-500';
            } else if (rata >= 80) {
                predikatEl.textContent = 'A';
                predikatEl.className = 'text-2xl font-bold text-primary';
            } else if (rata >= 70) {
                predikatEl.textContent = 'B';
                predikatEl.className = 'text-2xl font-bold text-amber-500';
            } else if (rata >= 60) {
                predikatEl.textContent = 'C';
                predikatEl.className = 'text-2xl font-bold text-orange-500';
            } else if (rata > 0) {
                predikatEl.textContent = 'D';
                predikatEl.className = 'text-2xl font-bold text-red-500';
            } else {
                predikatEl.textContent = '-';
                predikatEl.className = 'text-2xl font-bold text-slate-400';
            }
        }
    </script>
</body>

</html>
