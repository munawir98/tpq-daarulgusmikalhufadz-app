@extends('layouts.ustadz')
{{-- Fix for blade compiler --}}

@section('content')
<div class="space-y-6 pb-20">
    <!-- Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('ustadz.santri.show', $santri->id) }}"
            class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm text-gray-600 dark:text-gray-300">
            <span class="material-symbols-rounded">arrow_back</span>
        </a>
        <div>
            <h1 class="text-xl font-bold">Catatan Akhlak</h1>
            <p class="text-xs text-gray-500">{{ $santri->nama_lengkap }} ({{ $santri->nis }})</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-2xl flex items-center gap-2"
        role="alert">
        <span class="material-symbols-rounded">check_circle</span>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('ustadz.santri.akhlak.store', $santri->id) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Tanggal Penilaian -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 shadow-sm space-y-4">
            <h3 class="font-bold border-b pb-2 dark:border-gray-700">Waktu Penilaian</h3>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal</label>
                <input type="date" name="tanggal_penilaian" value="{{ date('Y-m-d') }}"
                    class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 focus:ring-primary focus:border-primary text-sm">
            </div>
        </div>

        <!-- Penilaian Grid (Star Rating Style) -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 shadow-sm space-y-6">
            <h3 class="font-bold border-b pb-2 dark:border-gray-700">Penilaian Karakter</h3>

            @foreach(['disiplin' => 'Kedisiplinan', 'kerajinan' => 'Kerajinan', 'kesopanan' => 'Kesopanan & Adab'] as
            $key => $label)
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
                    <span class="text-xs font-bold text-primary" id="{{ $key }}_text">Sangat Baik</span>
                </div>

                <!-- Range Slider with Steps -->
                <div class="relative pt-1">
                    <input type="range" name="{{ $key }}" id="{{ $key }}" min="1" max="5" value="5" step="1"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary"
                        oninput="updateLabel('{{ $key }}', this.value)">
                    <div class="flex justify-between text-[10px] text-gray-400 mt-1 px-1">
                        <span>Kurang</span>
                        <span>Cukup</span>
                        <span>Baik</span>
                        <span>Sgt Baik</span>
                        <span>Mumtaz</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Catatan -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 shadow-sm space-y-4">
            <h3 class="font-bold border-b pb-2 dark:border-gray-700">Catatan Tambahan</h3>
            <textarea name="catatan" rows="4" placeholder="Tulis catatan perkembangan akhlak santri..."
                class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 focus:ring-primary focus:border-primary text-sm"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="fixed bottom-0 left-0 right-0 p-4 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md z-40">
            <button type="submit"
                class="w-full py-4 rounded-2xl bg-primary text-white font-bold shadow-lg shadow-primary/30 hover:bg-primary-dark active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-rounded">save</span>
                Simpan Penilaian
            </button>
        </div>
    </form>

    <!-- Riwayat Terakhir -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl p-5 shadow-sm space-y-4">
        <h3 class="font-bold border-b pb-2 dark:border-gray-700">Riwayat Terakhir</h3>
        <div class="space-y-3">
            @forelse($riwayat as $item)
            <div
                class="flex items-start gap-3 text-sm pb-3 border-b border-dashed border-gray-100 dark:border-gray-700 last:border-0 last:pb-0">
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-bold text-gray-800 dark:text-gray-200">{{
                            \Carbon\Carbon::parse($item->tanggal_penilaian)->format('d M Y') }}</span>
                        <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                            Avg: {{ number_format(($item->disiplin + $item->kerajinan + $item->kesopanan) / 3, 1) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-xs text-gray-500">
                        <span>Dis: <strong class="text-primary">{{ $item->disiplin }}</strong></span>
                        <span>Ker: <strong class="text-primary">{{ $item->kerajinan }}</strong></span>
                        <span>Sop: <strong class="text-primary">{{ $item->kesopanan }}</strong></span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 text-xs py-2">Belum ada riwayat penilaian.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    const labels = {
        1: 'Kurang',
        2: 'Cukup',
        3: 'Baik',
        4: 'Sangat Baik',
        5: 'Mumtaz'
    };

    function updateLabel(key, value) {
        document.getElementById(key + '_text').textContent = labels[value];
    }
</script>
@endsection
