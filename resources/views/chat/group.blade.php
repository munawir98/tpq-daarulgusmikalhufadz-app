@extends('layouts.mobile')

@section('title', 'Grup Chat')

@section('header')
<header
    class="flex items-center bg-white dark:bg-background-dark p-4 border-b border-slate-100 dark:border-slate-800 sticky top-0 z-10">
    <a href="{{ route('chat.index') }}" class="text-slate-900 dark:text-slate-100 p-1">
        <span class="material-symbols-outlined">arrow_back_ios</span>
    </a>
    <div class="flex flex-1 items-center gap-3 ml-2">
        <div
            class="size-10 rounded-full bg-primary/20 flex items-center justify-center overflow-hidden border border-primary/30">
            <span class="material-symbols-outlined text-primary text-xl"
                style="font-variation-settings: 'FILL' 1;">groups</span>
        </div>
        <div class="flex flex-col">
            <h2 class="text-slate-900 dark:text-slate-100 text-base font-bold leading-tight">{{ $groupName }}</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">{{ count($members) }} Anggota</p>
        </div>
    </div>
    <button class="text-slate-900 dark:text-slate-100 p-1">
        <span class="material-symbols-outlined">more_vert</span>
    </button>
</header>
@endsection

@section('content')
{{-- Chat Area --}}
<div id="messages" class="-mx-5 -mt-4 flex-1 overflow-y-auto p-4 space-y-6"
    style="max-height: calc(100vh - 180px); overflow-y: auto;">

    @php
    $lastDate = null;
    @endphp

    @forelse($messages as $message)
    @php
    $messageDate = $message->created_at->format('Y-m-d');
    $isMe = $message->sender_id == auth()->id();
    $sender = $message->sender;
    @endphp

    {{-- Date Separator --}}
    @if($lastDate !== $messageDate)
    <div class="flex justify-center">
        <span
            class="bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
            @if($message->created_at->isToday())
            Hari Ini
            @elseif($message->created_at->isYesterday())
            Kemarin
            @else
            {{ $message->created_at->translatedFormat('d M Y') }}
            @endif
        </span>
    </div>
    @php $lastDate = $messageDate; @endphp
    @endif

    @if($isMe)
    {{-- Outgoing Message --}}
    <div class="flex items-end gap-2 justify-end ml-auto max-w-[85%]">
        <div class="flex flex-col gap-1 items-end">
            <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold mr-1">Saya</span>
            <div class="bg-primary text-slate-900 p-3 rounded-2xl rounded-br-none shadow-sm">
                <p class="text-sm leading-relaxed font-medium">{{ $message->message }}</p>
                <div class="flex items-center justify-end gap-1 mt-1">
                    <p class="text-[10px] opacity-70">{{ $message->created_at->format('H:i') }}</p>
                    <span class="material-symbols-outlined text-[14px] opacity-70">done_all</span>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Incoming Message --}}
    <div class="flex items-end gap-2 max-w-[85%]">
        <div
            class="size-8 shrink-0 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
            @if($sender && $sender->foto)
            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $sender->foto) }}"
                alt="{{ $sender->name ?? 'User' }}" />
            @else
            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-sm">person</span>
            @endif
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold ml-1">{{ $sender->name ??
                'Unknown' }}</span>
            <div
                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-3 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                <p class="text-[10px] text-slate-400 mt-1 text-right">{{ $message->created_at->format('H:i') }}</p>
            </div>
        </div>
    </div>
    @endif
    @empty
    {{-- Sample messages when no real messages exist --}}
    {{-- Date Separator --}}
    <div class="flex justify-center">
        <span
            class="bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
            Hari Ini
        </span>
    </div>

    {{-- Incoming Message 1 --}}
    <div class="flex items-end gap-2 max-w-[85%]">
        <div
            class="size-8 shrink-0 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-sm">person</span>
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold ml-1">Ustadz Ahmad</span>
            <div
                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-3 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-sm leading-relaxed">Assalamualaikum, jangan lupa hafalan hari ini ya anak-anak. Target
                    kita sampai Surah Al-Mulk ayat 10.</p>
                <p class="text-[10px] text-slate-400 mt-1 text-right">08:00</p>
            </div>
        </div>
    </div>

    {{-- Outgoing Message 1 --}}
    <div class="flex items-end gap-2 justify-end ml-auto max-w-[85%]">
        <div class="flex flex-col gap-1 items-end">
            <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold mr-1">Saya</span>
            <div class="bg-primary text-slate-900 p-3 rounded-2xl rounded-br-none shadow-sm">
                <p class="text-sm leading-relaxed font-medium">Waalaikumussalam Ustadz, baik siap! Sedang dalam proses
                    murajaah.</p>
                <div class="flex items-center justify-end gap-1 mt-1">
                    <p class="text-[10px] opacity-70">08:05</p>
                    <span class="material-symbols-outlined text-[14px] opacity-70">done_all</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Incoming Message 2 --}}
    <div class="flex items-end gap-2 max-w-[85%]">
        <div
            class="size-8 shrink-0 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-sm">person</span>
        </div>
        <div class="flex flex-col gap-1">
            <span class="text-slate-500 dark:text-slate-400 text-[11px] font-semibold ml-1">Budi</span>
            <div
                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 p-3 rounded-2xl rounded-bl-none shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-sm leading-relaxed">Saya sudah hafal Surat Al-Mulk ayat 1-5 ustadz. Izin nanti setoran
                    via VN ya.</p>
                <p class="text-[10px] text-slate-400 mt-1 text-right">08:12</p>
            </div>
        </div>
    </div>

    {{-- System Info --}}
    <div class="flex justify-center my-2">
        <p
            class="text-slate-400 dark:text-slate-500 text-[11px] font-medium bg-slate-100 dark:bg-slate-800/50 px-3 py-1 rounded-lg">
            Lani ditambahkan oleh Ustadz Ahmad
        </p>
    </div>

    {{-- Outgoing Message 2 --}}
    <div class="flex items-end gap-2 justify-end ml-auto max-w-[85%]">
        <div class="flex flex-col gap-1 items-end">
            <div class="bg-primary text-slate-900 p-3 rounded-2xl rounded-br-none shadow-sm">
                <p class="text-sm leading-relaxed font-medium">Ustadz, apakah ada kelas tambahan sore ini?</p>
                <div class="flex items-center justify-end gap-1 mt-1">
                    <p class="text-[10px] opacity-70">08:45</p>
                    <span class="material-symbols-outlined text-[14px] opacity-70">done_all</span>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection

@section('bottom-nav')
{{-- Message Input Bar --}}
<div class="bg-white dark:bg-background-dark p-4 pb-6 border-t border-slate-100 dark:border-slate-800">
    <form id="messageForm" class="flex items-center gap-3">
        @csrf
        <div class="flex-1 flex items-center bg-slate-100 dark:bg-slate-800 rounded-full px-4 py-2">
            <button type="button" class="text-slate-500 dark:text-slate-400 mr-2">
                <span class="material-symbols-outlined">sentiment_satisfied</span>
            </button>
            <input id="messageInput" name="message"
                class="flex-1 bg-transparent border-none focus:ring-0 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-500 py-1"
                placeholder="Ketik pesan..." type="text" autocomplete="off" />
            <button type="button" class="text-slate-500 dark:text-slate-400 ml-2">
                <span class="material-symbols-outlined transform rotate-45">attach_file</span>
            </button>
        </div>
        <div class="flex gap-2">
            <button type="button"
                class="size-11 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 transition-colors">
                <span class="material-symbols-outlined">mic</span>
            </button>
            <button type="submit" id="sendBtn"
                class="size-11 rounded-full bg-primary flex items-center justify-center text-slate-900 shadow-lg shadow-primary/20 hover:scale-105 transition-transform active:scale-95">
                <span class="material-symbols-outlined text-[24px]">send</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .pb-24 {
        padding-bottom: 0 !important;
    }

    main {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        gap: 0 !important;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const messagesDiv = document.getElementById("messages");
        const form = document.getElementById("messageForm");
        const input = document.getElementById("messageInput");
        const sendBtn = document.getElementById("sendBtn");

        // Scroll to bottom on load
        if (messagesDiv) {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // Helper: Create message bubble
        function appendMessage(messageText) {
            // Remove sample messages if this is the first real message
            const emptyIndicator = messagesDiv.querySelector('.sample-messages');
            if (emptyIndicator) emptyIndicator.remove();

            const wrapper = document.createElement("div");
            wrapper.className = "flex items-end gap-2 justify-end ml-auto max-w-[85%]";

            const inner = document.createElement("div");
            inner.className = "flex flex-col gap-1 items-end";

            const label = document.createElement("span");
            label.className = "text-slate-500 text-[11px] font-semibold mr-1";
            label.textContent = "Saya";

            const bubble = document.createElement("div");
            bubble.className = "bg-primary text-slate-900 p-3 rounded-2xl rounded-br-none shadow-sm";

            const text = document.createElement("p");
            text.className = "text-sm leading-relaxed font-medium";
            text.textContent = messageText;

            const meta = document.createElement("div");
            meta.className = "flex items-center justify-end gap-1 mt-1";

            const time = document.createElement("p");
            time.className = "text-[10px] opacity-70";
            const now = new Date();
            time.textContent = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            const icon = document.createElement("span");
            icon.className = "material-symbols-outlined text-[14px] opacity-70";
            icon.textContent = "done";

            meta.appendChild(time);
            meta.appendChild(icon);
            bubble.appendChild(text);
            bubble.appendChild(meta);
            inner.appendChild(label);
            inner.appendChild(bubble);
            wrapper.appendChild(inner);
            messagesDiv.appendChild(wrapper);

            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // Form submit
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            const message = input.value.trim();
            if (!message) return;

            try {
                sendBtn.disabled = true;
                sendBtn.classList.add("opacity-50");

                const response = await fetch("{{ route('chat.group.send') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                });

                if (!response.ok) throw new Error("Server error");

                appendMessage(message);
                input.value = "";

            } catch (error) {
                console.error(error);
                alert("Gagal mengirim pesan. Silakan coba lagi.");
            } finally {
                sendBtn.disabled = false;
                sendBtn.classList.remove("opacity-50");
            }
        });
    });
</script>
@endpush
