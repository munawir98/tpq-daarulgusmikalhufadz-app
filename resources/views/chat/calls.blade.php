@extends('layouts.mobile')

@section('title', 'Panggilan')

@section('no-px', true)
@section('no-gap', true)
@section('no-pt', true)

@section('header')
<header class="bg-blue-600 px-4 pt-4 pb-4 shadow-lg relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-center mb-2.5 relative">
            <h1 class="text-base font-bold text-white">Riwayat Panggilan</h1>
        </div>
        <div class="relative w-full mt-1.5 px-2">
            <div class="absolute inset-y-0 left-2 flex items-center pl-3 pointer-events-none text-white/70">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input id="searchInput" onkeyup="filterCalls()"
                class="block w-full pl-9 pr-3 py-2 bg-white/15 backdrop-blur-sm border-none rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/30 text-[13px] font-medium"
                placeholder="Cari Riwayat Panggilan..." type="text" />
        </div>
    </div>
</header>
@endsection

@section('content')

{{-- Calls List --}}
<div id="callsList" class="flex flex-col gap-2 -mt-2 pb-24">

    @forelse($callLogs as $log)
    @php
    $isCaller = $log->caller_id == auth()->id();
    $otherUser = $isCaller ? $log->receiver : $log->caller;
    $avatarUrl = $otherUser->foto ? Storage::url($otherUser->foto) :
    'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&background=E2E8F0&color=475569';

    // Determine call direction and icon
    if ($log->status === 'missed') {
    $statusIcon = 'call_missed';
    $statusColor = 'text-red-500';
    $statusText = 'Tak terjawab';
    } elseif ($isCaller) {
    $statusIcon = 'call_made';
    $statusColor = 'text-green-500';
    $statusText = 'Keluar';
    } else {
    $statusIcon = 'call_received';
    $statusColor = 'text-blue-500';
    $statusText = 'Masuk';
    }
    @endphp

    <div
        class="bg-white dark:bg-slate-800 p-2.5 rounded-xl flex items-center justify-between shadow-sm border border-slate-100 dark:border-slate-700 transition-transform active:scale-[0.98]">
        <div class="flex items-center gap-2.5">
            <div class="relative">
                <div class="w-10 h-10 rounded-full bg-slate-200 bg-cover bg-center shrink-0 {{ $log->status === 'missed' ? 'border-2 border-red-100' : '' }}"
                    style="background-image: url('{{ $avatarUrl }}')">
                </div>
            </div>
            <div>
                <h3
                    class="font-bold {{ $log->status === 'missed' ? 'text-red-500' : 'text-slate-900 dark:text-slate-100' }} text-[13px]">
                    {{ $otherUser->name }}</h3>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined {{ $statusColor }} text-[12px] font-bold">{{ $statusIcon
                        }}</span>
                    <p
                        class="text-[10px] {{ $log->status === 'missed' ? 'text-red-400' : 'text-slate-500 dark:text-slate-400' }}">
                        {{ $statusText }}, {{ $log->created_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
        @php
        $hasPhone = !empty($otherUser->no_hp);
        $callLink = $hasPhone ? route('chat.calls.active', $otherUser->id) : 'javascript:void(0)';
        $onClick = $hasPhone ? '' : 'onclick="alert(\'Tidak bisa menghubungkan panggilan, belum ada nomor telepon.\')"';
        @endphp
        <a href="{{ $callLink }}" {!! $onClick !!}
            class="p-1 text-blue-600 hover:bg-blue-600/10 rounded-full transition-colors shrink-0 {{ !$hasPhone ? 'opacity-50 cursor-not-allowed text-slate-400' : '' }}">
            <span class="material-symbols-outlined text-[18px]">{{ $log->type === 'video' ? 'videocam' : 'call'
                }}</span>
        </a>
    </div>

    @empty
    <div class="flex flex-col items-center justify-center py-10 text-center">
        <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-full flex items-center justify-center mb-3">
            <span class="material-symbols-outlined text-3xl text-blue-500">history</span>
        </div>
        <h3 class="text-slate-700 dark:text-slate-300 font-medium text-sm">Belum ada riwayat panggilan</h3>
        <p class="text-slate-500 dark:text-slate-400 text-[11px] mt-1">Panggilan masuk dan keluar akan muncul di sini
        </p>
    </div>
    @endforelse

</div>

{{-- FAB --}}
<a href="{{ route('chat.calls.active', ['id' => auth()->id() ?? 0]) }}"
    class="fixed bottom-24 right-6 size-11 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-blue-600/30 hover:shadow-xl hover:bg-blue-700 transition-all active:scale-95 z-40">
    <span class="material-symbols-outlined text-xl">add_ic_call</span>
</a>

@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="relative bg-white dark:bg-gray-900 rounded-t-[28px] shadow-[0_-8px_30px_rgba(0,0,0,0.12)] pt-1.5 pb-1.5 px-2">
        <div class="flex justify-around items-end">
            {{-- Chat --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all active:scale-95"
                href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined text-[22px]">chat</span>
                <span class="text-[9px] font-semibold">Chat</span>
            </a>
            {{-- Status --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all active:scale-95"
                href="{{ route('chat.status') }}">
                <span class="material-symbols-outlined text-[22px]">track_changes</span>
                <span class="text-[9px] font-semibold">Status</span>
            </a>
            {{-- Komunitas --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all active:scale-95"
                href="{{ route('chat.group') }}">
                <span class="material-symbols-outlined text-[22px]">groups</span>
                <span class="text-[9px] font-semibold">Grup</span>
            </a>
            {{-- Panggilan (Active) --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-blue-600 transition-all active:scale-95"
                href="{{ route('chat.calls') }}">
                <span class="material-symbols-outlined text-[22px]"
                    style="font-variation-settings: 'FILL' 1;">call</span>
                <span class="text-[9px] font-semibold">Panggilan</span>
            </a>
        </div>
    </div>
</nav>
@endsection

@push('scripts')
<script>
    function filterCalls() {
        // Implement filtering when there are actual call items
    }
</script>
@endpush
