@extends('layouts.mobile')

@section('title', 'Chat')

@section('content')

{{-- Search Bar --}}
<div class="relative">
    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
    <input type="text" placeholder="Cari percakapan..."
        class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-sm focus:ring-2 focus:ring-primary/50 focus:border-transparent" />
</div>

{{-- Chat List --}}
<div class="flex flex-col gap-2">
    @forelse($conversations as $chat)
    <a href="{{ route('chat.room', $chat->id) }}"
        class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:border-primary/30 transition">

        {{-- Avatar --}}
        <div class="relative shrink-0">
            <div
                class="size-12 rounded-full {{ $chat->is_group ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'bg-primary/10' }} flex items-center justify-center">
                @if($chat->is_group)
                <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">group</span>
                @elseif($chat->recipient->foto)
                <img alt="{{ $chat->recipient->name }}" class="w-full h-full object-cover rounded-full"
                    src="{{ asset('storage/' . $chat->recipient->foto) }}" />
                @else
                <span class="text-lg font-bold text-primary">{{ substr($chat->recipient->name, 0, 1) }}</span>
                @endif
            </div>
            @if(!$chat->is_group && $chat->recipient->is_online)
            <span
                class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
            @endif
        </div>

        {{-- Content --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between gap-2">
                <h4
                    class="font-bold text-[#111813] dark:text-white truncate {{ $chat->unread_count > 0 ? '' : 'font-semibold' }}">
                    {{ $chat->is_group ? $chat->name : $chat->recipient->name }}
                </h4>
                <span
                    class="text-xs shrink-0 {{ $chat->unread_count > 0 ? 'text-primary font-medium' : 'text-gray-400' }}">
                    {{ $chat->last_message_at?->diffForHumans(short: true) ?? '' }}
                </span>
            </div>
            <div class="flex items-center justify-between gap-2 mt-1">
                <p
                    class="text-sm truncate {{ $chat->unread_count > 0 ? 'text-[#111813] dark:text-white font-medium' : 'text-gray-500' }}">
                    {{ $chat->last_message ?? 'Belum ada pesan' }}
                </p>
                @if($chat->unread_count > 0)
                <span
                    class="shrink-0 min-w-[20px] h-5 px-1.5 bg-primary text-[#102216] text-xs font-bold rounded-full flex items-center justify-center">
                    {{ $chat->unread_count > 99 ? '99+' : $chat->unread_count }}
                </span>
                @endif
            </div>
        </div>
    </a>
    @empty
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="size-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-gray-400" style="font-size: 40px;">chat_bubble_outline</span>
        </div>
        <h3 class="text-lg font-bold text-[#111813] dark:text-white mb-1">Belum Ada Percakapan</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Mulai chat dengan ustadz atau teman</p>
    </div>
    @endforelse
</div>

{{-- FAB --}}
<a href="{{ route('chat.new') }}"
    class="fixed bottom-24 right-6 size-14 bg-primary text-[#102216] rounded-full flex items-center justify-center shadow-lg shadow-primary/25 hover:shadow-primary/40 transition active:scale-95 z-40">
    <span class="material-symbols-outlined" style="font-size: 28px;">chat</span>
</a>

@endsection
