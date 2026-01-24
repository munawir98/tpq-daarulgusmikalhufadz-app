<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Data Santri</title>
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
                        "primary": "#13ecc8",
                        "background-light": "#f6f8f8",
                        "background-dark": "#10221f",
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

        .ios-shadow {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-input:focus {
            border-color: #13ecc8;
            box-shadow: 0 0 0 1px #13ecc8;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen font-display">
    <form action="{{ route('ustadz.santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <header
            class="sticky top-0 z-50 bg-white dark:bg-background-dark border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-between px-4 py-4">
                <a href="{{ route('ustadz.santri.index') }}" aria-label="Back"
                    class="flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[28px]">chevron_left</span>
                </a>
                <h1 class="text-[#111817] dark:text-white text-lg font-bold flex-1 text-center pr-8">Edit Data Santri
                </h1>
            </div>
        </header>
        <main class="pb-32">
            <div class="flex flex-col items-center py-8">
                <div class="relative group">
                    <div
                        class="size-32 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden ios-shadow bg-gray-200">
                        @if($santri->user && $santri->user->foto)
                        <img alt="Foto Santri" class="w-full h-full object-cover" id="preview-foto"
                            src="{{ asset('storage/' . $santri->user->foto) }}" />
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 text-3xl font-bold"
                            id="placeholder-foto">
                            {{ substr($santri->nama_lengkap, 0, 1) }}
                        </div>
                        <img src="" class="w-full h-full object-cover hidden" id="preview-foto">
                        @endif
                    </div>
                    <label for="foto"
                        class="absolute bottom-0 right-0 bg-primary text-white p-2 rounded-full shadow-lg flex items-center justify-center border-2 border-white dark:border-gray-800 cursor-pointer hover:bg-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                    </label>
                    <input type="file" id="foto" name="foto" class="hidden" accept="image/jpeg,image/png,image/jpg"
                        onchange="previewImage(this)">
                </div>
                <button type="button" onclick="document.getElementById('foto').click()"
                    class="mt-4 text-sm font-bold text-primary px-4 py-2 bg-primary/10 rounded-lg outline-none focus:ring-2 focus:ring-primary/50">
                    Ubah Foto
                </button>
            </div>
            <div class="px-4 space-y-6">

                @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 ios-shadow">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Informasi Pribadi</h3>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Nama Lengkap</label>
                        <input
                            class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                            placeholder="Masukkan nama lengkap" type="text" name="nama_lengkap"
                            value="{{ old('nama_lengkap', $santri->nama_lengkap) }}" />
                    </div>
                    <!-- Nama Panggilan (Hidden in UI Design, keeping hidden input or omitting if not strictly required by controller validation but good to keep) -->
                    <input type="hidden" name="nama_panggilan"
                        value="{{ old('nama_panggilan', $santri->nama_panggilan) }}">

                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Nama Ayah</label>
                        <input
                            class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                            placeholder="Masukkan nama ayah" type="text" name="nama_ayah"
                            value="{{ old('nama_ayah', $santri->nama_ayah) }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">NIS</label>
                        <input
                            class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                            placeholder="Nomor Induk Santri" type="text" name="nis"
                            value="{{ old('nis', $santri->nis) }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Tempat &amp; Tanggal
                            Lahir</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input
                                class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                                placeholder="Kota" type="text" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $santri->tempat_lahir) }}" />
                            <input
                                class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                                type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $santri->tanggal_lahir ? $santri->tanggal_lahir->format('Y-m-d') : '') }}" />
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Jenis Kelamin</label>
                        <div class="flex gap-2">
                            <!-- Laki-laki -->
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="L" class="peer hidden" {{
                                    old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                                <div
                                    class="py-3 px-4 rounded-lg border border-[#dbe6e4] dark:border-gray-700 text-gray-500 dark:text-gray-400 font-medium text-sm text-center peer-checked:border-2 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary peer-checked:font-bold transition-all">
                                    Laki-laki
                                </div>
                            </label>
                            <!-- Perempuan -->
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="jenis_kelamin" value="P" class="peer hidden" {{
                                    old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                                <div
                                    class="py-3 px-4 rounded-lg border border-[#dbe6e4] dark:border-gray-700 text-gray-500 dark:text-gray-400 font-medium text-sm text-center peer-checked:border-2 peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary peer-checked:font-bold transition-all">
                                    Perempuan
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 ios-shadow">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Kontak &amp; Alamat</h3>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Nama Orang Tua /
                            Wali</label>
                        <input
                            class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                            placeholder="Nama orang tua/wali" type="text" name="nama_ibu"
                            value="{{ old('nama_ibu', $santri->nama_ibu) }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">No HP Ortu</label>
                        <input
                            class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 text-base focus:ring-0"
                            placeholder="Contoh: 081234567890" type="tel" name="no_hp_orang_tua"
                            value="{{ old('no_hp_orang_tua', $santri->no_hp_orang_tua) }}" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Alamat</label>
                        <textarea
                            class="form-input w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white p-4 text-base focus:ring-0"
                            placeholder="Alamat lengkap tempat tinggal" rows="3"
                            name="alamat">{{ old('alamat', $santri->alamat) }}</textarea>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-900 rounded-xl p-4 space-y-4 ios-shadow">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Akademik</h3>
                    <div class="flex flex-col gap-2">
                        <label class="text-[#111817] dark:text-gray-200 text-sm font-semibold">Pilih Kelas</label>
                        <div class="relative">
                            <select
                                class="form-select w-full rounded-lg border-[#dbe6e4] dark:border-gray-700 dark:bg-gray-800 dark:text-white h-12 px-4 pr-10 text-base focus:ring-0 appearance-none outline-none"
                                name="kelas_id">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id', $santri->kelas_id) == $kelas->id ?
                                    'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <div
            class="fixed bottom-0 left-0 right-0 bg-white dark:bg-background-dark p-6 border-t border-gray-100 dark:border-gray-800 flex justify-center z-50">
            <button
                class="w-full max-w-[480px] bg-primary hover:brightness-95 active:scale-[0.98] transition-all text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-primary/20">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('preview-foto').src = e.target.result;
                    document.getElementById('preview-foto').classList.remove('hidden');
                    // Hide placeholder if it exists
                    var placeholder = document.getElementById('placeholder-foto');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
