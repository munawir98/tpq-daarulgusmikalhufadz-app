@extends('layouts.mobile')

@section('title', 'Pesan')

@section('header')
<header class="bg-blue-600 px-6 pt-12 pb-6 shadow-lg relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-center mb-4 relative">
            <h1 class="text-lg font-bold text-white">Pesan</h1>
            <div class="absolute right-0 flex gap-2">
                <a href="{{ route('chat.new') }}"
                    class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                    <span class="material-symbols-outlined text-lg">edit_square</span>
                </a>
            </div>
        </div>
        <div class="relative w-full mt-2">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white/70">
                <span class="material-symbols-outlined text-xl">search</span>
            </div>
            <input id="searchInput" onkeyup="filterChats()"
                class="block w-full pl-10 pr-4 py-3 bg-white/15 backdrop-blur-sm border-none rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/30 text-sm font-medium"
                placeholder="Cari Ustadz atau Santri..." type="text" />
        </div>
    </div>
</header>
@endsection

@section('content')

{{-- Chat List --}}
<div id="chatList" class="flex flex-col gap-3 -mt-2">
    @forelse($conversations as $chat)
    @php
    $chatObj = is_array($chat) ? (object) $chat : $chat;
    $recipient = is_array($chatObj->recipient ?? null) ? (object) $chatObj->recipient : ($chatObj->recipient ?? null);
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
    @endphp
    <a href="{{ route('chat.room', $chatObj->id) }}"
        class="chat-item bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm hover:shadow-md flex items-center gap-4 relative transition-all duration-200 active:scale-[0.98] border border-gray-100 dark:border-gray-700"
        data-name="{{ strtolower($chatName) }}">

        {{-- Avatar --}}
        <div class="relative shrink-0">
            <div class="size-14 rounded-full flex items-center justify-center overflow-hidden
                {{ $isGroup ? 'bg-gradient-to-br from-yellow-200 to-yellow-300' : $avatarColor['bg'] }}">
                @if($isGroup)
                <span class="material-symbols-outlined text-yellow-700 text-2xl">group</span>
                @elseif($recipient && ($recipient->foto ?? null))
                <img alt="{{ $chatName }}" class="w-full h-full object-cover"
                    src="{{ asset('storage/' . $recipient->foto) }}" />
                @else
                <span class="text-xl font-bold {{ $avatarColor['text'] }}">{{ mb_substr($chatName, 0, 1) }}</span>
                @endif
            </div>
            @if(!$isGroup && ($recipient->is_online ?? false))
            <div
                class="absolute bottom-0 right-0 size-3.5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full">
            </div>
            @endif
        </div>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <div class="flex justify-between items-baseline gap-2">
                <h3
                    class="truncate {{ $hasUnread ? 'font-bold text-gray-900 dark:text-white' : 'font-semibold text-gray-700 dark:text-gray-200' }}">
                    {{ $chatName }}
                </h3>
                <span class="text-xs shrink-0 {{ $hasUnread ? 'text-blue-600 font-semibold' : 'text-gray-400' }}">
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
                    class="text-sm truncate {{ $hasUnread ? 'font-semibold text-gray-700 dark:text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">
                    {{ $lastMessage }}
                </p>
                @if($hasUnread)
                <div
                    class="shrink-0 min-w-[20px] h-5 px-1.5 bg-blue-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </div>
                @endif
            </div>
        </div>
    </a>
    @empty
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div
            class="size-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center mb-5 shadow-inner">
            <span class="material-symbols-outlined text-gray-400 dark:text-gray-500"
                style="font-size: 48px;">chat_bubble_outline</span>
        </div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Belum Ada Percakapan</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-[240px] leading-relaxed">Mulai chat baru dengan ustadz,
            santri, atau wali santri</p>
        <a href="{{ route('chat.new') }}"
            class="mt-6 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all active:scale-95 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span>
            Mulai Chat Baru
        </a>
    </div>
    @endforelse
</div>

{{-- FAB --}}
@if(count($conversations) > 0)
<a href="{{ route('chat.new') }}"
    class="fixed bottom-24 right-6 size-14 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-blue-600/30 hover:shadow-xl hover:bg-blue-700 transition-all active:scale-95 z-40">
    <span class="material-symbols-outlined text-[28px]">chat_add_on</span>
</a>
@endif

@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-6 pt-3 pb-1 rounded-t-2xl shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
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
                href="#">
                <span class="material-symbols-outlined">groups</span>
                <span class="text-[10px] font-medium">Komunitas</span>
            </a>
            {{-- Panggilan --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="#">
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
