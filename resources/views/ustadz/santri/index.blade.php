@extends('layouts.ustadz')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold">Data Santri</h1>
            <p class="text-xs text-gray-500">Daftar santri aktif TPQ</p>
        </div>
        <!-- Filter/Search Button -->
        <button
            class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 shadow-sm flex items-center justify-center text-gray-600 dark:text-gray-300">
            <span class="material-symbols-rounded">filter_list</span>
        </button>
    </div>

    <!-- Search Bar -->
    <div class="relative">
        <span class="material-symbols-rounded absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
        <input type="text" placeholder="Cari nama santri..."
            class="w-full pl-10 pr-4 py-3 rounded-2xl bg-white dark:bg-gray-800 border-none shadow-sm text-sm focus:ring-2 focus:ring-primary/50 placeholder:text-gray-400">
    </div>

    <!-- Santri List -->
    <div class="grid gap-3">
        @forelse($santri as $item)
        <a href="{{ route('ustadz.santri.show', $item->id) }}"
            class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm flex items-center gap-4 active:scale-[0.98] transition-transform">
            <!-- Avatar -->
            <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden flex-shrink-0">
                @if($item->user && $item->user->foto)
                <img src="{{ asset('storage/' . $item->user->foto) }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <span class="material-symbols-rounded text-2xl">person</span>
                </div>
                @endif
            </div>

            <!-- Info -->
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 truncate">{{ $item->nama_lengkap }}</h3>
                <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                    <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-medium text-[10px]">{{
                        $item->kelas?->nama ?? 'Belum Ada Kelas' }}</span>
                    <span>• {{ $item->nis }}</span>
                </div>
            </div>

            <!-- Arrow -->
            <span class="material-symbols-rounded text-gray-400">chevron_right</span>
        </a>
        @empty
        <div class="text-center py-10">
            <div
                class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                <span class="material-symbols-rounded text-3xl">sentiment_dissatisfied</span>
            </div>
            <p class="text-gray-500 text-sm">Belum ada data santri</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $santri->links() }}
    </div>
</div>
@endsection
