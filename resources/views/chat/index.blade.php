@extends('layouts.mobile')

@section('title', 'Pesan')

@section('header')
<header class="bg-blue-600 px-4 pt-4 pb-4 shadow-lg relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-center mb-2.5 relative">
            <h1 class="text-base font-bold text-white">Pesan</h1>
            <div class="absolute right-0 flex gap-2">
                <a href="{{ route('chat.new') }}"
                    class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                    <span class="material-symbols-outlined text-base">edit_square</span>
                </a>
            </div>
        </div>
        <div class="relative w-full mt-1.5 px-2">
            <div class="absolute inset-y-0 left-2 flex items-center pl-3 pointer-events-none text-white/70">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </div>
            <input id="searchInput" onkeyup="filterChats()"
                class="block w-full pl-9 pr-3 py-2 bg-white/15 backdrop-blur-sm border-none rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/30 text-[13px] font-medium"
                placeholder="Cari Ustadz atau Santri..." type="text" />
        </div>
    </div>
</header>
@endsection

@section('content')

@push('styles')
<style>
    .chat-bg {
        background-color: #efeae2;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23dfd8cf' fill-opacity='0.6' fill-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat: repeat;
    }

    .dark .chat-bg {
        background-color: #0b141a;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2319252c' fill-opacity='0.6' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
</style>
@endpush

{{-- Chat List wrapper with background --}}
<div class="relative min-h-screen">
    {{-- Chat Background overlay for pattern --}}
    <div class="absolute inset-0 chat-bg opacity-40 dark:opacity-5 pointer-events-none z-0"></div>

    <div id="chatList" class="flex flex-col gap-3 pb-24 relative z-10 px-4 pt-2">
        @forelse($conversations as $chat)
        @php
        $chatObj = is_array($chat) ? (object) $chat : $chat;
        $recipient = is_array($chatObj->recipient ?? null) ? (object) $chatObj->recipient : ($chatObj->recipient ??
        null);
        $isGroup = $chatObj->is_group ?? false;
        $unreadCount = $chatObj->unread_count ?? 0;
        $hasUnread = $unreadCount > 0;
        $lastMessage = $chatObj->last_message ?? 'Belum ada pesan';
        $chatName = $isGroup ? ($chatObj->name ?? 'Grup') : ($recipient->name ?? 'Tanpa Nama');

        // Generate unique color per contact
        $avatarColors = [
        ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600'],
        ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-600'],
        ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-600'],
        ['bg' => 'bg-rose-100 dark:bg-rose-900/30', 'text' => 'text-rose-600'],
        ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-600'],
        ['bg' => 'bg-cyan-100 dark:bg-cyan-900/30', 'text' => 'text-cyan-600'],
        ['bg' => 'bg-pink-100 dark:bg-pink-900/30', 'text' => 'text-pink-600'],
        ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'text' => 'text-indigo-600'],
        ['bg' => 'bg-teal-100 dark:bg-teal-900/30', 'text' => 'text-teal-600'],
        ['bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-600'],
        ];
        $colorIndex = crc32($chatName) % count($avatarColors);
        $avatarColor = $avatarColors[abs($colorIndex)];

        $chatUrl = $isGroup ? route('chat.group') : route('chat.room', $chatObj->id);
        @endphp
        <a href="{{ $chatUrl }}"
            class="chat-item p-2.5 flex items-center gap-3 relative transition-all duration-200 active:scale-[0.98] hover:bg-gray-50 dark:hover:bg-gray-800/50"
            data-name="{{ strtolower($chatName) }}">

            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden
                {{ $isGroup ? 'bg-gradient-to-br from-yellow-200 to-yellow-300' : $avatarColor['bg'] }}">
                    @if($isGroup)
                    <span class="material-symbols-outlined text-yellow-700 text-[18px]">group</span>
                    @elseif($recipient && ($recipient->foto ?? null))
                    <img alt="{{ $chatName }}" class="w-full h-full object-cover"
                        src="{{ asset('storage/' . $recipient->foto) }}" />
                    @else
                    <span class="text-sm font-bold {{ $avatarColor['text'] }}">{{ mb_substr($chatName, 0, 1) }}</span>
                    @endif
                </div>
                @if(!$isGroup && ($recipient->is_online ?? false))
                <div
                    class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-[1.5px] border-white dark:border-gray-800 rounded-full">
                </div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-baseline gap-2">
                    <h3
                        class="truncate text-[13px] {{ $hasUnread ? 'font-bold text-gray-900 dark:text-white' : 'font-semibold text-gray-700 dark:text-gray-200' }}">
                        {{ $chatName }}
                    </h3>
                    <span
                        class="text-[10px] shrink-0 {{ $hasUnread ? 'text-blue-600 font-semibold' : 'text-gray-400' }}">
                        @if($chatObj->last_message_at ?? null)
                        @php
                        $lastAt = $chatObj->last_message_at;
                        if (is_string($lastAt)) {
                        $lastAt = \Carbon\Carbon::parse($lastAt);
                        }
                        @endphp
                        {{ $lastAt->diffForHumans(short: true) }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center gap-2 mt-0.5">
                    <p
                        class="text-[11px] truncate {{ $hasUnread ? 'font-semibold text-gray-700 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">
                        {{ $lastMessage }}
                    </p>
                    @if($hasUnread)
                    <div
                        class="shrink-0 min-w-[16px] h-4 px-1 bg-blue-600 text-white text-[9px] font-bold rounded-full flex items-center justify-center shadow-sm">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </div>
                    @endif
                </div>
            </div>
        </a>
        @empty
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-14 text-center">
            <div
                class="size-16 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center mb-4 shadow-inner">
                <span class="material-symbols-outlined text-gray-400 dark:text-gray-500"
                    style="font-size: 32px;">chat_bubble_outline</span>
            </div>
            <h3 class="text-sm font-bold text-gray-800 dark:text-white mb-1">Belum Ada Percakapan</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 max-w-[200px] leading-relaxed">Mulai chat baru dengan
                ustadz,
                santri, atau wali santri</p>
            <a href="{{ route('chat.new') }}"
                class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-xs shadow-lg hover:shadow-xl transition-all active:scale-95 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-lg">add</span>
                Mulai Chat Baru
            </a>
        </div>
        @endforelse
    </div>
</div>

{{-- FAB --}}
@if(count($conversations) > 0)
<a href="{{ route('chat.new') }}"
    class="fixed bottom-24 right-6 size-11 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-blue-600/30 hover:shadow-xl hover:bg-blue-700 transition-all active:scale-95 z-40">
    <span class="material-symbols-outlined text-xl">chat_add_on</span>
</a>
@endif

@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-6 pt-3 pb-3 rounded-t-2xl shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
        <div class="flex justify-around items-center">
            {{-- Chat (Active) --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-blue-600 transition-all"
                href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat</span>
                <span class="text-[10px] font-bold">Chat</span>
            </a>
            {{-- Status --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="#">
                <span class="material-symbols-outlined">track_changes</span>
                <span class="text-[10px] font-medium">Status</span>
            </a>
            {{-- Komunitas --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.group') }}">
                <span class="material-symbols-outlined">groups</span>
                <span class="text-[10px] font-medium">Grup</span>
            </a>
            {{-- Panggilan --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.calls') }}">
                <span class="material-symbols-outlined">call</span>
                <span class="text-[10px] font-medium">Panggilan</span>
            </a>
        </div>

    </div>
</nav>
@endsection

@push('scripts')
<script>
    function filterChats() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.chat-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            item.style.display = name.includes(query) ? 'flex' : 'none';
        });
    }
</script>
@endpush
