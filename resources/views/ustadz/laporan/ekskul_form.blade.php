<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kegiatan Ekskul</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1a73e8',
                        'background-light': '#ffffff',
                        'background-dark': '#0f172a',
                    },
                    fontFamily: {
                        display: ['Poppins', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 font-display text-slate-800">
    <div class="relative flex min-h-screen w-full max-w-md mx-auto flex-col bg-white shadow-xl">
        <!-- Header -->
        <header class="sticky top-0 z-20 bg-primary">
            <div class="flex items-center p-4 gap-4">
                <a href="{{ route('ustadz.laporan.kegiatan') }}"
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-white/20 text-white">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="text-white text-lg font-semibold">Tambah Kegiatan Ekskul</h1>
            </div>
        </header>

        <!-- Form -->
        <form action="{{ route('ustadz.laporan.ekskul.store') }}" method="POST" enctype="multipart/form-data"
            class="flex-1 p-4 space-y-4">
            @csrf

            <!-- Tanggal -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal *</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                @error('tanggal')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Kegiatan -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Nama Kegiatan *</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                    placeholder="Contoh: Latihan Tahfidz, Pramuka..." required
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                @error('nama')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pelatih -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Pelatih (Opsional)</label>
                <input type="text" name="pelatih" value="{{ old('pelatih') }}" placeholder="Nama pelatih..."
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>

            <!-- Jumlah Peserta -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta', 0) }}" min="0"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="4" placeholder="Keterangan tambahan..."
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary resize-none">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Foto -->
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1">Foto (Opsional)</label>
                <input type="file" name="foto" accept="image/*"
                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                @error('foto')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</body>

</html>
