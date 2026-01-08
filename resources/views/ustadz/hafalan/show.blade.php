@extends('layouts.ustadz')

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header with Back Button -->
    <div class="flex items-center gap-3">
        <a href="javascript:history.back()"
            class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm text-gray-600 dark:text-gray-300">
            <span class="material-symbols-rounded">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold">Detail Setoran</h1>
    </div>

    <!-- Main Card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-blue-500"></div>

        <div class="flex flex-col items-center text-center mb-6 mt-2">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-1">{{ $hafalan->surah }}</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">Ayat {{ $hafalan->ayat_awal }} - {{ $hafalan->ayat_akhir
                }}</p>
        </div>

        <div class="space-y-4">
            <!-- Santri Info -->
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                <div
                    class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                    {{ substr($hafalan->santri->name ?? 'S', 0, 1) }}
                </div>
                <div>
                    <label class="text-xs text-gray-500 block">Nama Santri</label>
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $hafalan->santri->name ?? '-' }}</span>
                </div>
            </div>

            <!-- Nilai -->
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                <div class="w-10 h-10 rounded-full {{
                    $hafalan->nilai == 'Sempurna' || $hafalan->nilai == 'Mumtaz' ? 'bg-green-100 text-green-600' :
                    ($hafalan->nilai == 'Lancar' || $hafalan->nilai == 'Jayyid Jiddan' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600')
                }} flex items-center justify-center">
                    <span class="material-symbols-rounded">verified</span>
                </div>
                <div>
                    <label class="text-xs text-gray-500 block">Predikat</label>
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $hafalan->nilai }}</span>
                </div>
            </div>

            <!-- Waktu -->
            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-2xl">
                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center">
                    <span class="material-symbols-rounded">calendar_today</span>
                </div>
                <div>
                    <label class="text-xs text-gray-500 block">Waktu Setoran</label>
                    <span class="font-bold text-gray-800 dark:text-gray-200">
                        {{ \Carbon\Carbon::parse($hafalan->created_at)->format('d F Y, H:i') }}
                    </span>
                </div>
            </div>

            <!-- Catatan -->
            @if($hafalan->catatan)
            <div
                class="p-4 bg-yellow-50 dark:bg-yellow-900/10 rounded-2xl border border-yellow-100 dark:border-yellow-900/20">
                <label
                    class="text-xs text-yellow-600 dark:text-yellow-500 font-bold mb-1 block flex items-center gap-1">
                    <span class="material-symbols-rounded text-sm">note</span> Catatan Ustadz
                </label>
                <p class="text-gray-700 dark:text-gray-300 italic">"{{ $hafalan->catatan }}"</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Edit Button (Optional, maybe for future) -->
    <!--
    <a href="#" class="block w-full text-center py-3 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold">
        Edit Data
    </a>
    -->
</div>
@endsection
