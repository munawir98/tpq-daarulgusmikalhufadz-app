@extends('layouts.mobile')

@section('title', 'Status')

@section('no-px', true)
@section('no-gap', true)

@section('header')
<header class="bg-blue-600 px-4 pt-4 pb-4 shadow-lg relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-between relative pl-3 pr-1">
            <h1 class="text-[17px] font-bold text-white tracking-wide">Status</h1>
            <div class="flex gap-1.5 items-center">
                <button
                    class="text-white/80 hover:text-white p-1.5 rounded-full hover:bg-white/10 transition flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">search</span>
                </button>
                <button
                    class="text-white/80 hover:text-white p-1.5 rounded-full hover:bg-white/10 transition flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">more_vert</span>
                </button>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<style>
    .status-ring {
        padding: 2px;
        background: conic-gradient(from 0deg, #2563eb 0% 25%, transparent 25% 30%, #2563eb 30% 60%, transparent 60% 65%, #2563eb 65% 100%);
    }

    .status-ring-single {
        padding: 2px;
        background: #2563eb;
    }
</style>

<!-- Main Content -->
<div class="relative flex-1 overflow-y-auto pb-24">
    <!-- My Status Section -->
    <div class="px-5 py-3.5 bg-white dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-3 cursor-pointer"
            onclick="document.getElementById('textStatusModal').classList.remove('hidden')">
            <div class="relative">
                <div class="h-[42px] w-[42px] rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                    style="background-image: url('{{ auth()->user()?->foto ? (Str::startsWith(auth()->user()->foto, 'data:') ? auth()->user()->foto : asset('storage/' . auth()->user()->foto)) : asset('assets/images/default-avatar.png') }}');">
                </div>
                <div
                    class="absolute bottom-0 right-[-2px] bg-blue-600 border-[1.5px] border-white dark:border-gray-800 rounded-full h-[18px] w-[18px] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[11px] font-bold mt-[1px]">add</span>
                </div>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100">Status Saya</h2>
                <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5">
                    {{ $myStatuses->count() > 0 ? $myStatuses->count() . ' pembaruan aktif' : 'Ketuk untuk menambahkan
                    pembaruan status' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Recent Updates Section -->
    <div class="mt-2">
        <h3 class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 px-5">Pembaruan
            Terbaru</h3>

        <div class="flex flex-col">
            @forelse($recentUpdates as $update)
            <!-- Status Item -->
            <div
                class="flex items-center gap-3 px-5 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer border-b border-gray-100 dark:border-gray-800">
                <div
                    class="{{ $update->statuses->count() > 1 ? 'status-ring' : 'status-ring-single' }} rounded-full p-[1.5px] shrink-0">
                    <div class="h-[38px] w-[38px] rounded-full border-2 border-white dark:border-gray-900 bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                        style="background-image: url('{{ $update->user?->foto ? (Str::startsWith($update->user->foto, 'data:') ? $update->user->foto : asset('storage/' . $update->user->foto)) : asset('assets/images/default-avatar.png') }}');">
                    </div>
                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <h4 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100 truncate">{{ $update->user->name
                        }}</h4>
                    <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">{{
                        $update->last_updated->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="px-5 py-4 text-center">
                <p class="text-[12px] text-gray-500 dark:text-gray-400">Belum ada pembaruan status dari kontak Anda.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<div class="fixed bottom-24 right-6 flex flex-col gap-4 items-center z-40">
    <button onclick="document.getElementById('textStatusModal').classList.remove('hidden')"
        class="bg-white dark:bg-[#1a2e28] text-slate-600 dark:text-slate-300 shadow-md p-3.5 flex items-center justify-center rounded-full hover:scale-105 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-[24px]">edit</span>
    </button>
    <button onclick="document.getElementById('imageStatusModal').classList.remove('hidden')"
        class="bg-blue-600 dark:bg-blue-600 text-white shadow-lg p-3.5 flex items-center justify-center rounded-full hover:scale-105 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-[24px]">photo_camera</span>
    </button>
</div>

<!-- Modals for Status Creation -->
<div id="textStatusModal" class="hidden fixed inset-0 z-[60] bg-black/80 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-sm p-5 relative">
        <button type="button" onclick="document.getElementById('textStatusModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Buat Status Teks</h3>
        <form action="{{ route('chat.status.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="text">
            <textarea name="content" rows="4"
                class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Ketik status Anda..."></textarea>
            <button type="submit"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl transition-colors">
                Kirim Status
            </button>
        </form>
    </div>
</div>

<div id="imageStatusModal" class="hidden fixed inset-0 z-[60] bg-black/80 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-sm p-5 relative">
        <button type="button" onclick="document.getElementById('imageStatusModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Kirim Foto/Video</h3>
        <form action="{{ route('chat.status.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="image">
            <input type="file" name="media" accept="image/*,video/*"
                class="w-full mb-3 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-white">
            <input type="text" name="caption"
                class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-3 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tambahkan keterangan...">
            <button type="submit"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl transition-colors">
                Kirim
            </button>
        </form>
    </div>
</div>
@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-6 pt-1.5 pb-2 rounded-t-2xl shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
        <div class="flex justify-around items-center">
            {{-- Chat --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined text-[22px]">chat</span>
                <span class="text-[9px] font-medium">Chat</span>
            </a>
            {{-- Status (Active) --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-blue-600 dark:text-blue-500 transition-all relative"
                href="{{ route('chat.status') }}">
                <span class="material-symbols-outlined fill-1 text-[22px]">donut_large</span>
                <span class="text-[9px] font-bold">Status</span>
                <div class="absolute -top-0.5 w-1 h-1 bg-blue-600 dark:bg-blue-500 rounded-full"></div>
            </a>
            {{-- Komunitas --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.group') }}">
                <span class="material-symbols-outlined text-[22px]">groups</span>
                <span class="text-[9px] font-medium">Grup</span>
            </a>
            {{-- Panggilan --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.calls') }}">
                <span class="material-symbols-outlined text-[22px]">call</span>
                <span class="text-[9px] font-medium">Panggilan</span>
            </a>
        </div>
    </div>
</nav>
@endsection
