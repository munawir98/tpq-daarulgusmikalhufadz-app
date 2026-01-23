@extends('layouts.ustadz')

@section('content')
<div class="space-y-6 pb-20 px-6">


    <!-- Profile Card (Refactored & Colored) -->
    <div
        class="bg-gradient-to-br from-violet-600 to-indigo-700 rounded-2xl p-4 shadow-lg shadow-indigo-500/20 relative overflow-hidden text-white">
        <!-- Decorative bg pattern -->
        <div class="absolute top-0 right-0 p-8 opacity-10">
            <span class="material-symbols-rounded text-9xl transform rotate-12">person</span>
        </div>

        <div class="flex flex-col items-center justify-center gap-3 relative z-10 text-center">
            <!-- Avatar -->
            <div class="w-20 h-20 rounded-full p-1 shadow-md bg-white/20 backdrop-blur-sm">
                <div
                    class="w-full h-full rounded-full overflow-hidden bg-white/10 flex items-center justify-center border-2 border-white/50">
                    @if($santri->user && $santri->user->foto)
                    <img src="{{ asset('storage/' . $santri->user->foto) }}" class="w-full h-full object-cover">
                    @else
                    <span class="material-symbols-rounded text-4xl text-white/80">person</span>
                    @endif
                </div>
            </div>

            <!-- Info -->
            <div class="flex flex-col items-center gap-1">
                <h2 class="text-lg font-bold text-white leading-tight">{{ $santri->nama_lengkap }}</h2>
                <p class="text-xs text-indigo-100">{{ $santri->nis }}</p>

                <!-- Badges -->
                <div class="flex flex-wrap justify-center gap-2 mt-2">
                    <span
                        class="px-3 py-1 rounded-full bg-white/20 text-white text-xs font-medium backdrop-blur-sm border border-white/10">
                        {{ $santri->kelas?->nama_kelas ?? 'Tanpa Kelas' }}
                    </span>
                    <span
                        class="px-3 py-1 rounded-full {{ $santri->status_aktif ? 'bg-emerald-500/30 text-emerald-50' : 'bg-rose-500/30 text-rose-50' }} text-xs font-medium uppercase backdrop-blur-sm border border-white/10">
                        {{ $santri->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Hafalan -->
        <div
            class="bg-gradient-to-br from-blue-500 to-cyan-500 p-4 rounded-2xl shadow-lg shadow-blue-500/20 flex flex-col items-center gap-1 text-white relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 p-3 opacity-10 transform translate-x-1/4 -translate-y-1/4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-6xl">menu_book</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mb-1 backdrop-blur-sm">
                <span class="material-symbols-rounded text-2xl text-white">menu_book</span>
            </div>
            <span class="text-xs text-blue-50 font-medium">Hafalan</span>
            <span class="text-lg font-bold">0 Juz</span>
        </div>
        <!-- Kehadiran -->
        <div
            class="bg-gradient-to-br from-emerald-500 to-teal-500 p-4 rounded-2xl shadow-lg shadow-emerald-500/20 flex flex-col items-center gap-1 text-white relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 p-3 opacity-10 transform translate-x-1/4 -translate-y-1/4 group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-6xl">how_to_reg</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mb-1 backdrop-blur-sm">
                <span class="material-symbols-rounded text-2xl text-white">how_to_reg</span>
            </div>
            <span class="text-xs text-emerald-50 font-medium">Kehadiran</span>
            <span class="text-lg font-bold">0%</span>
        </div>
    </div>

    <!-- Riwayat Hafalan Cards (New) -->
    <div class="space-y-3">
        <h3 class="font-bold text-gray-800 dark:text-gray-200 px-1">Hafalan Terakhir</h3>
        @if(isset($riwayatHafalan) && $riwayatHafalan->count() > 0)
        @foreach($riwayatHafalan as $hafalan)
        <a href="{{ route('ustadz.hafalan.show', $hafalan->id) }}"
            class="block bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800 p-4 rounded-2xl shadow-sm active:scale-[0.98] transition-all border-l-4 border-blue-500">
            <div class="flex justify-between items-start mb-1">
                <h4 class="font-bold text-gray-800 dark:text-gray-100">{{ $hafalan->surah }}</h4>
                <span class="text-xs text-blue-600 bg-white/50 dark:bg-gray-700 px-2 py-1 rounded-full">
                    {{ \Carbon\Carbon::parse($hafalan->created_at)->format('d M') }}
                </span>
            </div>
            <div class="flex justify-between items-end">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Ayat {{ $hafalan->ayat_awal }} - {{ $hafalan->ayat_akhir }}
                </p>
                <span class="text-xs font-medium {{
                        $hafalan->nilai == 'Sempurna' || $hafalan->nilai == 'Mumtaz' ? 'text-green-600' :
                        ($hafalan->nilai == 'Lancar' || $hafalan->nilai == 'Jayyid Jiddan' ? 'text-blue-600' : 'text-orange-600')
                    }}">
                    {{ $hafalan->nilai }}
                </span>
            </div>
        </a>
        @endforeach
        @else
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm text-center">
            <p class="text-gray-400 text-sm">Belum ada data hafalan</p>
        </div>
        @endif
    </div>

    <!-- Menu Actions -->
    <div class="grid gap-3">
        <h3 class="font-bold text-gray-800 dark:text-gray-200 px-1">Menu Santri</h3>

        <!-- Input Hafalan -->
        <a href="#"
            class="bg-gradient-to-r from-orange-400 to-pink-500 p-4 rounded-2xl shadow-lg shadow-orange-500/20 flex items-center gap-4 active:scale-[0.98] transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-white text-2xl">mic</span>
            </div>
            <div class="flex-1 text-white">
                <h4 class="font-bold text-xs">Input Hafalan</h4>
                <p class="text-[10px] text-white/80">Tambah setoran hafalan baru</p>
            </div>
            <span class="material-symbols-rounded text-white/60">chevron_right</span>
        </a>

        <!-- Input Akhlak -->
        <a href="{{ route('ustadz.santri.akhlak.create', $santri->id) }}"
            class="bg-gradient-to-r from-violet-500 to-purple-600 p-4 rounded-2xl shadow-lg shadow-purple-500/20 flex items-center gap-4 active:scale-[0.98] transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-white text-2xl">psychology</span>
            </div>
            <div class="flex-1 text-white">
                <h4 class="font-bold text-xs">Catatan Akhlak</h4>
                <p class="text-[10px] text-white/80">Input penilaian perilaku</p>
            </div>
            <span class="material-symbols-rounded text-white/60">chevron_right</span>
        </a>

        <!-- Riwayat Absensi -->
        <a href="#"
            class="bg-gradient-to-r from-teal-400 to-emerald-500 p-4 rounded-2xl shadow-lg shadow-teal-500/20 flex items-center gap-4 active:scale-[0.98] transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-rounded text-white text-2xl">history</span>
            </div>
            <div class="flex-1 text-white">
                <h4 class="font-bold text-xs">Riwayat Absensi</h4>
                <p class="text-[10px] text-white/80">Lihat kehadiran santri</p>
            </div>
            <span class="material-symbols-rounded text-white/60">chevron_right</span>
        </a>
    </div>

    <!-- Biodata Lengkap -->
    <div
        class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-800 rounded-3xl p-5 shadow-sm space-y-4 border border-indigo-100 dark:border-gray-700">
        <h3
            class="font-bold border-b border-indigo-200 dark:border-gray-700 pb-2 text-indigo-900 dark:text-gray-200 flex items-center gap-2">
            <span class="material-symbols-rounded text-indigo-500">badge</span>
            Biodata Lengkap
        </h3>

        <div class="space-y-3 text-sm">
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
