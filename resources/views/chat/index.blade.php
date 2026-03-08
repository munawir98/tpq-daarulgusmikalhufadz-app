@extends('layouts.mobile')

@section('title', 'Pesan')

@section('no-px', true)
@section('no-gap', true)
@section('no-pt', true)

@section('header')
<header class="bg-blue-600 dark:bg-[#1f2c34] px-4 pt-4 pb-4 shadow-sm z-50 relative">
    <div class="flex items-center justify-between mb-3 text-white">
        <h1 class="text-[20px] font-semibold">Pesan</h1>
        <div class="flex items-center gap-5">
            <button class="flex items-center justify-center"><span
                    class="material-symbols-outlined text-[22px]">camera_alt</span></button>
            <button onclick="document.getElementById('searchContainer').classList.toggle('hidden')"
                class="flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px]">search</span>
            </button>
            <button class="flex items-center justify-center"><span
                    class="material-symbols-outlined text-[24px]">more_vert</span></button>
        </div>
    </div>
    <div id="searchContainer" class="hidden relative w-full mb-1 transition-all">
        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
            <span class="material-symbols-outlined text-gray-500 text-[18px]">search</span>
        </div>
        <input id="searchInput" onkeyup="filterChats()"
            class="block w-full pl-10 pr-3 py-2 bg-white dark:bg-[#2a3942] rounded-full text-gray-800 dark:text-gray-200 focus:outline-none text-[15px]"
            placeholder="Cari..." type="text" />
    </div>
</header>
@endsection

@section('content')



{{-- Chat List wrapper --}}
<div class="relative bg-white dark:bg-[#111b21] h-screen">

    <div id="chatList" class="flex flex-col gap-0 pb-36 relative z-10">
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

        $hasPhone = $isGroup || !empty($recipient->no_hp);
        $chatUrl = $isGroup ? route('chat.group') : ($hasPhone ? route('chat.room', $chatObj->id) :
        'javascript:void(0)');
        $onClick = $hasPhone ? '' : 'onclick="alert(\'Tidak bisa terhubung\')"';
        @endphp
        <div class="chat-item-wrapper" data-name="{{ strtolower($chatName) }}">
            <a href="{{ $chatUrl }}" {!! $onClick !!}
                class="px-4 py-2.5 flex items-center gap-3.5 bg-white hover:bg-gray-50 dark:bg-[#111b21] dark:hover:bg-[#202c33] transition-colors {{ !$hasPhone ? 'opacity-70 cursor-not-allowed' : '' }}">

                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <div class="w-[46px] h-[46px] rounded-full flex items-center justify-center overflow-hidden
                    {{ $isGroup ? 'bg-gray-200 dark:bg-[#667781]' : $avatarColor['bg'] }}">
                        @if($isGroup)
                        <span class="material-symbols-outlined text-white text-[28px]"
                            style="font-variation-settings: 'FILL' 1;">groups</span>
                        @elseif($recipient && ($recipient->foto ?? null))
                        <img alt="{{ $chatName }}" class="w-full h-full object-cover"
                            src="{{ Str::startsWith($recipient->foto, 'data:') ? $recipient->foto : asset('storage/' . $recipient->foto) }}" />
                        @else
                        <span class="material-symbols-outlined text-[30px] {{ $avatarColor['text'] }}">person</span>
                        @endif
                    </div>
                </div>

                {{-- Content --}}
                <div
                    class="flex-1 min-w-0 flex flex-col justify-center border-b border-gray-200 dark:border-[#202c33] pb-2.5 pt-1.5 h-full">
                    <div class="flex justify-between items-baseline mb-0.5">
                        <h3
                            class="truncate text-[16px] {{ $hasUnread ? 'font-bold text-gray-900 dark:text-[#e9edef]' : 'font-semibold text-gray-900 dark:text-[#e9edef]' }}">
                            {{ $chatName }}
                        </h3>
                        <span
                            class="text-[12px] shrink-0 {{ $hasUnread ? 'text-blue-500 font-medium' : 'text-gray-500 dark:text-[#8696a0]' }}">
                            @if($chatObj->last_message_at ?? null)
                            @php
                            $lastAt = $chatObj->last_message_at;
                            if (is_string($lastAt)) {
                            $lastAt = \Carbon\Carbon::parse($lastAt);
                            }
                            @endphp
                            {{ $lastAt->isToday() ? $lastAt->format('H:i') : $lastAt->format('d/m/y') }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center gap-2">
                        <div class="flex items-center gap-1 min-w-0">
                            @if(isset($chatObj->last_message_sender_id) && $chatObj->last_message_sender_id ===
                            auth()->id())
                            <span class="material-symbols-outlined text-[16px] text-[#53bdeb]">done_all</span>
                            @endif
                            <p
                                class="text-[13px] truncate {{ $hasUnread ? 'text-gray-700 dark:text-[#d1d7db]' : 'text-gray-500 dark:text-[#8696a0]' }}">
                                {{ $lastMessage }}
                            </p>
                        </div>
                        @if($hasUnread)
                        <div
                            class="shrink-0 min-w-[20px] h-5 px-1.5 bg-blue-500 text-white text-[11px] font-bold rounded-full flex items-center justify-center">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </div>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @empty
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="size-20 bg-gray-100 dark:bg-[#202c33] rounded-full flex items-center justify-center mb-5">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400"
                    style="font-size: 40px;">chat</span>
            </div>
            <h3 class="text-[17px] font-medium text-gray-800 dark:text-[#e9edef] mb-2">Pesan Anda</h3>
            <p class="text-[14px] text-gray-500 dark:text-[#8696a0] max-w-[250px] leading-relaxed">Mulai obrolan pribadi
                atau grup dengan ustadz dan santri</p>
        </div>
        @endforelse
    </div>
</div>

@if(count($conversations) > 0)
<a href="{{ route('chat.new') }}" class="fixed bottom-24 right-5 size-14 bg-blue-600 text-white rounded-[16px] flex items-center justify-center shadow-lg
transition-transform active:scale-95 z-40">
    <span class="material-symbols-outlined text-[26px]" style="font-variation-settings: 'FILL' 1;">chat</span>
</a>
@endif

@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-6 pt-1.5 pb-1.5 rounded-t-2xl shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
        <div class="flex justify-around items-center">
            {{-- Chat (Active) --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-blue-600 transition-all"
                href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined text-[22px]"
                    style="font-variation-settings: 'FILL' 1;">chat</span>
                <span class="text-[9px] font-bold">Chat</span>
            </a>
            {{-- Status --}}
            <a class="flex flex-col items-center gap-0.5 py-0.5 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.status') }}">
                <span class="material-symbols-outlined text-[22px]">track_changes</span>
                <span class="text-[9px] font-medium">Status</span>
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

@push('scripts')
<script>
    function filterChats() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.chat-item-wrapper');

        items.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            item.style.display = name.includes(query) ? 'block' : 'none';
        });
    }
</script>
@endpush
