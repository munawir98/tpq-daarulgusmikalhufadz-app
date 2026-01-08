@extends('layouts.ustadz')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header with Back Button -->
    <div class="flex items-center gap-3">
        <a href="{{ route('ustadz.santri.index') }}"
            class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm text-gray-600 dark:text-gray-300">
            <span class="material-symbols-rounded">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold">Detail Santri</h1>
    </div>

    <!-- Profile Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm text-center relative overflow-hidden">
        <div
            class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-primary/20 to-primary/5 dark:from-primary/10">
        </div>

        <div class="relative z-10">
            <div class="w-24 h-24 rounded-full bg-white dark:bg-gray-700 p-1 mx-auto shadow-md mb-4">
                <div
                    class="w-full h-full rounded-full overflow-hidden bg-gray-100 dark:bg-gray-600 flex items-center justify-center">
                    @if($santri->user && $santri->user->foto)
                    <img src="{{ asset('storage/' . $santri->user->foto) }}" class="w-full h-full object-cover">
                    @else
                    <span class="material-symbols-rounded text-4xl text-gray-400">person</span>
                    @endif
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $santri->nama_lengkap }}</h2>
            <p class="text-sm text-gray-500">{{ $santri->nis }}</p>

            <div class="flex justify-center gap-2 mt-3">
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-medium">
                    {{ $santri->kelas?->nama ?? 'Tanpa Kelas' }}
                </span>
                <span
                    class="px-3 py-1 rounded-full {{ $santri->status_aktif ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} text-xs font-medium uppercase">
                    {{ $santri->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Hafalan -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm flex flex-col items-center gap-1">
            <span class="material-symbols-rounded text-2xl text-blue-500">menu_book</span>
            <span class="text-xs text-gray-500">Hafalan</span>
            <span class="text-lg font-bold">0 Juz</span>
        </div>
        <!-- Kehadiran -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm flex flex-col items-center gap-1">
            <span class="material-symbols-rounded text-2xl text-teal-500">how_to_reg</span>
            <span class="text-xs text-gray-500">Kehadiran</span>
            <span class="text-lg font-bold">0%</span>
        </div>
    </div>

    <!-- Menu Actions -->
    <div class="grid gap-3">
        <h3 class="font-bold text-gray-800 dark:text-gray-200 px-1">Menu Santri</h3>

        <!-- Input Hafalan -->
        <a href="#"
            class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm flex items-center gap-4 active:scale-[0.98] transition-all">
            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                <span class="material-symbols-rounded">mic</span>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-sm">Input Hafalan</h4>
                <p class="text-xs text-gray-500">Tambah setoran hafalan baru</p>
            </div>
            <span class="material-symbols-rounded text-gray-400">chevron_right</span>
        </a>

        <!-- Input Akhlak -->
        <a href="{{ route('ustadz.santri.akhlak.create', $santri->id) }}"
            class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm flex items-center gap-4 active:scale-[0.98] transition-all">
            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-rounded">psychology</span>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-sm">Catatan Akhlak</h4>
                <p class="text-xs text-gray-500">Input penilaian perilaku</p>
            </div>
            <span class="material-symbols-rounded text-gray-400">chevron_right</span>
        </a>

        <!-- Riwayat Absensi -->
        <a href="#"
            class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm flex items-center gap-4 active:scale-[0.98] transition-all">
            <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-600 flex items-center justify-center">
                <span class="material-symbols-rounded">history</span>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-sm">Riwayat Absensi</h4>
                <p class="text-xs text-gray-500">Lihat kehadiran santri</p>
            </div>
            <span class="material-symbols-rounded text-gray-400">chevron_right</span>
        </a>
    </div>

    <!-- Biodata Lengkap -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 shadow-sm space-y-4">
        <h3 class="font-bold border-b pb-2 dark:border-gray-700">Biodata Lengkap</h3>

        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Tempat Lahir</span>
                <span class="font-medium">{{ $santri->tempat_lahir ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Lahir</span>
                <span class="font-medium">{{ $santri->tanggal_lahir ? $santri->tanggal_lahir->format('d M Y') : '-'
                    }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Jenis Kelamin</span>
                <span class="font-medium">{{ $santri->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Nama Ayah</span>
                <span class="font-medium">{{ $santri->nama_ayah ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">No. HP Ortu</span>
                <span class="font-medium">{{ $santri->no_hp_orang_tua ?? '-' }}</span>
            </div>
            <div class="col-span-2">
                <span class="text-gray-500 block mb-1">Alamat</span>
                <p class="font-medium">{{ $santri->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
