<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tambah Jurnal Harian</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
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
                        "display": ["Manrope"]
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
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24
        }

        body {
            font-family: "Manrope", sans-serif
        }

        select {
            appearance: none;
            background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuBDeJ_mSRrCCwm1v1k00_1DpOt51DQSa1Tf9oF2v5MS2Sv9onc9FyY32BqGWLX2sTb1frc1ZFs_O3-1UAgQU4j27ckqZm7oZ6Ie6eHRhTh9W2VZTTtHQZvhmOQCC6cKxYZSR1mmRZnecWP8UxbpAOcIslThmUaoAUC_YRLKbKjx3IH1TWHbyqiUZcuupdPWE2AYJFrPl7DkgT26UadDVwhuqdHUqiXfxMjTi7J4Cf5W71RT5Cc_ar-ebG3o7RoIBKt1tClpDCLtlHN3);
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem
        }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-[#0e141b] dark:text-slate-100 min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
    <header
        class="sticky top-0 z-50 bg-white dark:bg-background-dark border-b border-slate-200 dark:border-slate-800 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('ustadz.laporan.kegiatan') }}"
                class="flex items-center justify-center size-10 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined text-[#0e141b] dark:text-white">arrow_back_ios_new</span>
            </a>
            <h1 class="text-[#0e141b] dark:text-white text-lg font-bold leading-tight">Tambah Jurnal Harian</h1>
        </div>
        <div class="size-10"></div>
    </header>

    <!-- Form Content -->
    <form action="{{ route('ustadz.laporan.jurnal.store') }}" method="POST" enctype="multipart/form-data"
        class="flex-1 flex flex-col">
        @csrf
        <main class="flex-1 overflow-y-auto px-4 py-6 max-w-md mx-auto w-full">
            <div class="space-y-6">
                <!-- Date Selection -->
                <div class="flex flex-col gap-2">
                    <label class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold px-1">Tanggal
                        Kegiatan</label>
                    <div class="relative flex w-full items-stretch rounded-lg shadow-sm">
                        <input name="tanggal" type="date" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="form-input flex w-full min-w-0 flex-1 rounded-lg text-[#0e141b] dark:text-white border border-[#d0dbe7] dark:border-slate-700 bg-white dark:bg-slate-900 focus:border-primary focus:ring-1 focus:ring-primary h-14 p-[15px] pr-12 text-base font-normal" />
                    </div>
                    @error('tanggal')
                    <p class="text-red-500 text-xs px-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class Selection Dropdown -->
                <div class="flex flex-col gap-2">
                    <label class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold px-1">Pilih Kelas</label>
                    <select name="kelas_id"
                        class="form-select w-full rounded-lg text-[#0e141b] dark:text-white border border-[#d0dbe7] dark:border-slate-700 bg-white dark:bg-slate-900 focus:border-primary focus:ring-1 focus:ring-primary h-14 p-[15px] text-base font-normal">
                        <option disabled selected value="">Pilih Nama Kelas</option>
                        @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ old('kelas_id')==$kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Activity Title -->
                <div class="flex flex-col gap-2">
                    <label class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold px-1">Judul Kegiatan</label>
                    <input name="judul" type="text" value="{{ old('judul') }}" required
                        class="form-input w-full rounded-lg text-[#0e141b] dark:text-white border border-[#d0dbe7] dark:border-slate-700 bg-white dark:bg-slate-900 focus:border-primary focus:ring-1 focus:ring-primary h-14 p-[15px] text-base font-normal"
                        placeholder="Contoh: Pembelajaran Tajwid" />
                    @error('judul')
                    <p class="text-red-500 text-xs px-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Material & Notes -->
                <div class="flex flex-col gap-2">
                    <label class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold px-1">Materi &amp;
                        Catatan</label>
                    <textarea name="deskripsi"
                        class="form-textarea w-full rounded-lg text-[#0e141b] dark:text-white border border-[#d0dbe7] dark:border-slate-700 bg-white dark:bg-slate-900 focus:border-primary focus:ring-1 focus:ring-primary min-h-[140px] p-[15px] text-base font-normal resize-none"
                        placeholder="Detailkan materi yang diajarkan atau catatan penting lainnya...">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Photo Upload Proof -->
                <div class="flex flex-col gap-2">
                    <label class="text-[#0e141b] dark:text-slate-200 text-sm font-semibold px-1">Foto
                        Dokumentasi</label>
                    <label for="foto-input"
                        class="border-2 border-dashed border-[#d0dbe7] dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900/50 p-8 flex flex-col items-center justify-center gap-3 transition-all hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer group">
                        <div
                            class="size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">add_a_photo</span>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-bold text-[#0e141b] dark:text-white" id="foto-label">Ambil Foto
                                Kegiatan</p>
                            <p class="text-xs text-[#4e7397] mt-1">Gunakan kamera atau pilih dari galeri</p>
                        </div>
                        <input type="file" name="foto" id="foto-input" accept="image/*" class="hidden"
                            onchange="updateFotoLabel(this)" />
                    </label>
                    @error('foto')
                    <p class="text-red-500 text-xs px-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Space for scroll -->
                <div class="h-10"></div>
            </div>
        </main>

        <!-- Bottom Action Button -->
        <footer class="p-4 bg-white dark:bg-background-dark border-t border-slate-200 dark:border-slate-800">
            <button type="submit"
                class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Simpan Jurnal
            </button>
        </footer>
    </form>

    <script>
        function updateFotoLabel(input) {
            const label = document.getElementById('foto-label');
            if (input.files && input.files[0]) {
                label.textContent = input.files[0].name;
            } else {
                label.textContent = 'Ambil Foto Kegiatan';
            }
        }
    </script>
</body>

</html>
