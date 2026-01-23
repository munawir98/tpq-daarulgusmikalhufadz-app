@extends('layouts.ustadz')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header -->
    <div class="flex items-center gap-4 pt-2 px-6">
        <a href="{{ route('ustadz.santri.index') }}"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-primary hover:text-white transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold flex-1 text-center pr-10">Edit Santri</h1>
    </div>

    <form action="{{ route('ustadz.santri.update', $santri->id) }}" method="POST" enctype="multipart/form-data"
        class="px-6 space-y-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Profile Photo -->
        <div class="flex flex-col items-center gap-3">
            <div class="relative group">
                <div
                    class="w-24 h-24 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-800 border-2 border-slate-200 dark:border-slate-700">
                    @if($santri->user && $santri->user->foto)
                    <img src="{{ asset('storage/' . $santri->user->foto) }}" class="w-full h-full object-cover"
                        id="preview-foto">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-primary/10 text-primary text-3xl font-bold"
                        id="placeholder-foto">
                        {{ substr($santri->nama_lengkap, 0, 1) }}
                    </div>
                    <img src="" class="w-full h-full object-cover hidden" id="preview-foto">
                    @endif
                </div>
                <label for="foto"
                    class="absolute bottom-0 right-0 p-2 bg-primary text-white rounded-full cursor-pointer shadow-lg hover:bg-primary-dark transition-colors">
                    <span class="material-symbols-outlined text-lg">photo_camera</span>
                </label>
                <input type="file" id="foto" name="foto" class="hidden" accept="image/jpeg,image/png,image/jpg"
                    onchange="previewImage(this)">
            </div>
            <p class="text-xs text-slate-500">Ketuk kamera untuk ubah foto</p>
        </div>

        <!-- Form Inputs -->
        <div class="space-y-4">
            <!-- NIS -->
            <div class="space-y-1">
                <label for="nis" class="text-sm font-medium text-slate-700 dark:text-slate-300">NIS</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis', $santri->nis) }}"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3"
                    placeholder="Nomor Induk Santri">
            </div>

            <!-- Nama Lengkap -->
            <div class="space-y-1">
                <label for="nama_lengkap" class="text-sm font-medium text-slate-700 dark:text-slate-300">Nama
                    Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap"
                    value="{{ old('nama_lengkap', $santri->nama_lengkap) }}"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3"
                    placeholder="Nama Lengkap Santri">
            </div>

            <!-- Nama Panggilan -->
            <div class="space-y-1">
                <label for="nama_panggilan" class="text-sm font-medium text-slate-700 dark:text-slate-300">Nama
                    Panggilan</label>
                <input type="text" name="nama_panggilan" id="nama_panggilan"
                    value="{{ old('nama_panggilan', $santri->nama_panggilan) }}"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3"
                    placeholder="Nama Panggilan">
            </div>

            <!-- Jenis Kelamin -->
            <div class="space-y-1">
                <label class="text-sm font-medium text-slate-700 dark:text-slate-300">Jenis Kelamin</label>
                <div class="grid grid-cols-2 gap-4">
                    <label
                        class="flex items-center gap-3 p-3 rounded-xl border {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'border-primary bg-primary/5' : 'border-slate-200 dark:border-slate-700' }} cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" class="text-primary focus:ring-primary" {{
                            old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                        <span class="text-sm text-slate-700 dark:text-slate-300">Laki-laki</span>
                    </label>
                    <label
                        class="flex items-center gap-3 p-3 rounded-xl border {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'border-primary bg-primary/5' : 'border-slate-200 dark:border-slate-700' }} cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" class="text-primary focus:ring-primary" {{
                            old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'checked' : '' }}>
                        <span class="text-sm text-slate-700 dark:text-slate-300">Perempuan</span>
                    </label>
                </div>
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label for="tempat_lahir" class="text-sm font-medium text-slate-700 dark:text-slate-300">Tempat
                        Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                        value="{{ old('tempat_lahir', $santri->tempat_lahir) }}"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3"
                        placeholder="Kota">
                </div>
                <div class="space-y-1">
                    <label for="tanggal_lahir" class="text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal
                        Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $santri->tanggal_lahir ? $santri->tanggal_lahir->format('Y-m-d') : '') }}"
                        class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3">
                </div>
            </div>

            <!-- Alamat -->
            <div class="space-y-1">
                <label for="alamat" class="text-sm font-medium text-slate-700 dark:text-slate-300">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3 placeholder:text-slate-400"
                    placeholder="Alamat lengkap santri">{{ old('alamat', $santri->alamat) }}</textarea>
            </div>

            <!-- Nama Ayah -->
            <div class="space-y-1">
                <label for="nama_ayah" class="text-sm font-medium text-slate-700 dark:text-slate-300">Nama Ayah</label>
                <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $santri->nama_ayah) }}"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3"
                    placeholder="Nama Orang Tua">
            </div>

            <!-- No HP Ortu -->
            <div class="space-y-1">
                <label for="no_hp_orang_tua" class="text-sm font-medium text-slate-700 dark:text-slate-300">No. HP Orang
                    Tua</label>
                <input type="tel" name="no_hp_orang_tua" id="no_hp_orang_tua"
                    value="{{ old('no_hp_orang_tua', $santri->no_hp_orang_tua) }}"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 focus:border-primary focus:ring-primary px-4 py-3"
                    placeholder="0812...">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 hover:bg-primary-dark transition-all active:scale-[0.98]">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview-foto').src = e.target.result;
                document.getElementById('preview-foto').classList.remove('hidden');
                var placeholder = document.getElementById('placeholder-foto');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
