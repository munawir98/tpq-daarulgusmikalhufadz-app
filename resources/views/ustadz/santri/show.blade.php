@extends('layouts.ustadz')

@section('content')
<div class="space-y-5 pb-20 px-5">
    <!-- Header -->
    <div class="flex items-center gap-4 pt-2">
        <a href="{{ route('ustadz.santri.index') }}"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 shadow-sm hover:bg-primary hover:text-white transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-lg font-bold flex-1 text-center pr-10 text-slate-800 dark:text-white">Detail Santri</h1>
    </div>

    <!-- Profile Card (Refactored & Colored) -->
    <div
        class="bg-gradient-to-br from-violet-600 to-indigo-700 rounded-2xl p-2.5 shadow-lg shadow-indigo-500/20 relative overflow-hidden text-white">
        <!-- Decorative bg pattern -->
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <span class="material-symbols-rounded text-9xl transform rotate-12">person</span>
        </div>

        <div class="flex flex-col items-center justify-center gap-3 relative z-10 text-center">
            <!-- Avatar -->
            <div class="w-16 h-16 rounded-full p-1 shadow-md bg-white/20 backdrop-blur-sm">
                <div
                    class="w-full h-full rounded-full overflow-hidden bg-white/10 flex items-center justify-center border-2 border-white/50">
                    @if($santri->user && $santri->user->foto)
                    <img src="{{ asset('storage/' . $santri->user->foto) }}" class="w-full h-full object-cover">
                    @else
                    <span class="material-symbols-rounded text-3xl text-white/80">person</span>
                    @endif
                </div>
            </div>

            <!-- Info -->
            <div class="flex flex-col items-center gap-1">
                <h2 class="text-base font-bold text-white leading-tight">{{ $santri->nama_lengkap }}</h2>
                <p class="text-[10px] text-indigo-100">{{ $santri->nis }}</p>

                <!-- Badges -->
                <div class="flex flex-wrap justify-center gap-2 mt-2">
                    <span
                        class="px-2.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-medium backdrop-blur-sm border border-white/10">
                        {{ $santri->kelas?->nama_kelas ?? 'Tanpa Kelas' }}
                    </span>
                    <span
                        class="px-2.5 py-0.5 rounded-full {{ $santri->status_aktif ? 'bg-emerald-500/30 text-emerald-50' : 'bg-rose-500/30 text-rose-50' }} text-[10px] font-medium uppercase backdrop-blur-sm border border-white/10">
                        {{ $santri->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 gap-3">
        <!-- Hafalan -->
        <div
            class="bg-gradient-to-br from-blue-500 to-cyan-500 p-2.5 rounded-2xl shadow-lg shadow-blue-500/20 flex flex-col items-center gap-1 text-white relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 p-3 opacity-10 transform translate-x-1/4 -translate-y-1/4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-6xl">menu_book</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mb-1 backdrop-blur-sm">
                <span class="material-symbols-rounded text-xl text-white">menu_book</span>
            </div>
            <span class="text-[10px] text-blue-50 font-medium">Hafalan</span>
            <span class="text-sm font-bold">0 Juz</span>
        </div>
        <!-- Kehadiran -->
        <div
            class="bg-gradient-to-br from-emerald-500 to-teal-500 p-2.5 rounded-2xl shadow-lg shadow-emerald-500/20 flex flex-col items-center gap-1 text-white relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 p-3 opacity-10 transform translate-x-1/4 -translate-y-1/4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-6xl">how_to_reg</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mb-1 backdrop-blur-sm">
                <span class="material-symbols-rounded text-xl text-white">how_to_reg</span>
            </div>
            <span class="text-[10px] text-emerald-50 font-medium">Kehadiran</span>
            <span class="text-sm font-bold">0%</span>
        </div>
    </div>

    <!-- Riwayat Hafalan Cards (New) -->
    <div class="space-y-2.5">
        <h3 class="font-bold text-gray-800 dark:text-gray-200 px-1 text-sm">Hafalan Terakhir</h3>
        @if(isset($riwayatHafalan) && $riwayatHafalan->count() > 0)
        @foreach($riwayatHafalan as $hafalan)
        <a href="{{ route('ustadz.hafalan.show', $hafalan->id) }}"
            class="block bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800 p-2.5 rounded-xl shadow-sm active:scale-[0.98] transition-all border-l-4 border-blue-500">
            <div class="flex justify-between items-start mb-1">
                <h4 class="font-bold text-gray-800 dark:text-gray-100 text-sm">{{ $hafalan->surah }}</h4>
                <span class="text-[10px] text-blue-600 bg-white/50 dark:bg-gray-700 px-2 py-0.5 rounded-full">
                    {{ \Carbon\Carbon::parse($hafalan->created_at)->format('d M') }}
                </span>
            </div>
            <div class="flex justify-between items-end">
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    Ayat {{ $hafalan->ayat_awal }} - {{ $hafalan->ayat_akhir }}
                </p>
                <span class="text-[10px] font-medium {{
                        $hafalan->nilai == 'Sempurna' || $hafalan->nilai == 'Mumtaz' ? 'text-green-600' :
                        ($hafalan->nilai == 'Lancar' || $hafalan->nilai == 'Jayyid Jiddan' ? 'text-blue-600' : 'text-orange-600')
                    }}">
                    {{ $hafalan->nilai }}
                </span>
            </div>
        </a>
        @endforeach
        @else
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm text-center">
            <p class="text-gray-400 text-xs">Belum ada data hafalan</p>
        </div>
        @endif
    </div>

    <!-- Menu Actions -->
    <div class="grid gap-2.5">
        <h3 class="font-bold text-gray-800 dark:text-gray-200 px-1 text-sm">Menu Santri</h3>

        <!-- Input Hafalan -->
        <a href="#"
            class="bg-gradient-to-r from-orange-400 to-pink-500 p-2.5 rounded-xl shadow-lg shadow-orange-500/20 flex items-center gap-3 active:scale-[0.98] transition-all group">
            <div
                class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-white text-xl">mic</span>
            </div>
            <div class="flex-1 text-white">
                <h4 class="font-bold text-xs">Input Hafalan</h4>
                <p class="text-[10px] text-white/80">Tambah setoran hafalan baru</p>
            </div>
            <span class="material-symbols-rounded text-white/60 text-lg">chevron_right</span>
        </a>

        <!-- Input Akhlak -->
        <a href="{{ route('ustadz.santri.akhlak.create', $santri->id) }}"
            class="bg-gradient-to-r from-violet-500 to-purple-600 p-2.5 rounded-xl shadow-lg shadow-purple-500/20 flex items-center gap-3 active:scale-[0.98] transition-all group">
            <div
                class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-white text-xl">psychology</span>
            </div>
            <div class="flex-1 text-white">
                <h4 class="font-bold text-xs">Catatan Akhlak</h4>
                <p class="text-[10px] text-white/80">Input penilaian perilaku</p>
            </div>
            <span class="material-symbols-rounded text-white/60 text-lg">chevron_right</span>
        </a>

        <!-- Riwayat Absensi -->
        <a href="#"
            class="bg-gradient-to-r from-teal-400 to-emerald-500 p-2.5 rounded-xl shadow-lg shadow-teal-500/20 flex items-center gap-3 active:scale-[0.98] transition-all group">
            <div
                class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-white text-xl">history</span>
            </div>
            <div class="flex-1 text-white">
                <h4 class="font-bold text-xs">Riwayat Absensi</h4>
                <p class="text-[10px] text-white/80">Lihat kehadiran santri</p>
            </div>
            <span class="material-symbols-rounded text-white/60 text-lg">chevron_right</span>
        </a>
    </div>

    <!-- Biodata Lengkap -->
    <div
        class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-800 rounded-2xl p-4 shadow-sm space-y-3 border border-indigo-100 dark:border-gray-700">
        <h3
            class="font-bold border-b border-indigo-200 dark:border-gray-700 pb-2 text-indigo-900 dark:text-gray-200 flex items-center gap-2 text-sm">
            <span class="material-symbols-rounded text-indigo-500 text-lg">badge</span>
            Biodata Lengkap
        </h3>

        <div class="space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-gray-500">Tempat Lahir</span>
                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $santri->tempat_lahir ?? '-' }}</span>
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
