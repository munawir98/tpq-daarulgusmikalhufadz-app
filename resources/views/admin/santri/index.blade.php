@extends('layouts.mobile')

@section('title', 'Kelola Santri')

@section('header')
<header
    class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="flex items-center justify-between px-5 py-4">
        <h2 class="text-xl font-bold">Kelola Santri</h2>
        <a href="{{ route('admin.santri.create') }}"
            class="flex items-center gap-1 px-3 py-2 bg-primary text-[#102216] text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-primary/25 transition">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
            Tambah
        </a>
    </div>
</header>
@endsection

@section('content')

{{-- Search --}}
<div class="relative">
    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
    <input type="text" id="searchInput" placeholder="Cari santri..."
        class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-sm focus:ring-2 focus:ring-primary/50" />
</div>

{{-- Stats --}}
<div class="grid grid-cols-3 gap-3">
    <div
        class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 text-center shadow-sm">
        <span class="block text-2xl font-bold text-primary">{{ $santriList->count() }}</span>
        <span class="text-xs text-gray-500">Total</span>
    </div>
    <div
        class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 text-center shadow-sm">
        <span class="block text-2xl font-bold text-green-500">{{ $santriList->where('status', 'aktif')->count()
            }}</span>
        <span class="text-xs text-gray-500">Aktif</span>
    </div>
    <div
        class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 text-center shadow-sm">
        <span class="block text-2xl font-bold text-gray-400">{{ $santriList->where('status', '!=', 'aktif')->count()
            }}</span>
        <span class="text-xs text-gray-500">Non-Aktif</span>
    </div>
</div>

{{-- List --}}
<div id="santriList" class="flex flex-col gap-2">
    @forelse($santriList as $santri)
    <div class="santri-item bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm"
        data-name="{{ strtolower($santri['name']) }}">
        @php
            $lastHafalan = \App\Models\Hafalan::where('santri_id', $santri['id'])->orderBy('created_at', 'desc')->first();
        @endphp
        <div class="flex items-center gap-4">
            {{-- Avatar --}}
            <div class="shrink-0 size-12 rounded-full bg-primary/10 flex items-center justify-center">
                @if($santri['foto'] ?? false)
                <img src="{{ asset('storage/' . $santri['foto']) }}" class="w-full h-full object-cover rounded-full" />
                @else
                <span class="text-lg font-bold text-primary">{{ substr($santri['name'], 0, 1) }}</span>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <h4 class="font-bold text-[#111813] dark:text-white truncate">{{ $santri['name'] }}</h4>
                <div class="flex items-center gap-2">
                    <p class="text-sm text-gray-500">{{ $santri['nis'] ?? '-' }}</p>
                    @if($lastHafalan)
                    <span class="text-[10px] text-gray-400">•</span>
                    <span class="text-[10px] text-primary">{{ $lastHafalan->surah }} • {{ $lastHafalan->ayat_akhir }}</span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.santri.edit', $santri['id']) }}"
                    class="p-2 rounded-xl text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition">
                    <span class="material-symbols-outlined" style="font-size: 20px;">edit</span>
                </a>
                <button onclick="confirmDelete({{ $santri['id'] }}, '{{ $santri['name'] }}')"
                    class="p-2 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition">
                    <span class="material-symbols-outlined" style="font-size: 20px;">delete</span>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div class="size-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-gray-400" style="font-size: 32px;">group</span>
        </div>
        <h3 class="font-bold text-[#111813] dark:text-white mb-1">Belum Ada Santri</h3>
        <p class="text-sm text-gray-500">Tap "Tambah" untuk menambahkan</p>
    </div>
    @endforelse
</div>

{{-- Delete Form (Hidden) --}}
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
    // Search filter
    document.getElementById('searchInput').addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.santri-item').forEach(item => {
            const name = item.dataset.name;
            item.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    // Delete confirmation
    function confirmDelete(id, name) {
        if (confirm(`Yakin hapus santri "${name}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/santri/${id}`;
            form.submit();
        }
    }
</script>
@endpush
