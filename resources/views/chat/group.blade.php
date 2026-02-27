@extends('layouts.mobile')

@section('no-pb', 'true')

@section('title', 'Grup Chat')

@section('header')
<header
    class="flex items-center bg-white dark:bg-background-dark px-3 py-3 border-b border-slate-100 dark:border-slate-800 sticky top-0 z-10">
    <a href="{{ route('chat.index') }}" class="text-slate-900 dark:text-slate-100 p-1 -ml-1">
        <span class="material-symbols-outlined text-[22px]">arrow_back</span>
    </a>
    <div class="flex flex-1 items-center gap-3 ml-1">
        <div
            class="size-10 rounded-full bg-primary/20 flex items-center justify-center overflow-hidden border border-primary/30">
            <span class="material-symbols-outlined text-primary text-xl"
                style="font-variation-settings: 'FILL' 1;">groups</span>
        </div>
        <div class="flex flex-col leading-tight">
            <h2 class="text-slate-900 dark:text-slate-100 text-[15px] font-bold truncate max-w-[180px]">{{ $groupName }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-[11px] font-medium">{{ count($members) }} Anggota</p>
        </div>
    </div>
    <button class="text-slate-900 dark:text-slate-100 p-1">
        <span class="material-symbols-outlined text-[22px]">more_vert</span>
    </button>
</header>
@endsection

@section('content')
{{-- Chat Messages Area --}}
<div id="messages" class="group-chat-messages flex-1 overflow-y-auto space-y-4 px-3 py-3">

    @php $lastDate = null; @endphp

    @forelse($messages as $message)
    @php
    $messageDate = $message->created_at->format('Y-m-d');
    $isMe = $message->sender_id == auth()->id();
    $sender = $message->sender;
    @endphp

    {{-- Date Separator --}}
    @if($lastDate !== $messageDate)
    <div class="flex justify-center my-2">
        <span
            class="bg-slate-200/80 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
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
    <div class="flex justify-end">
        <div class="max-w-[80%]">
            <div class="bg-primary text-slate-900 px-3 py-2 rounded-2xl rounded-br-sm shadow-sm">
                <p class="text-[13px] leading-relaxed font-medium">{{ $message->message }}</p>
                <div class="flex items-center justify-end gap-1 mt-0.5">
                    <p class="text-[10px] opacity-60">{{ $message->created_at->format('H:i') }}</p>
                    <span class="material-symbols-outlined text-[13px] opacity-60">done_all</span>
                </div>
            </div>
        </div>
    </div>
    @else
    {{-- Incoming Message --}}
    <div class="flex items-end gap-2">
        <div
            class="size-7 shrink-0 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
            @if($sender && $sender->foto)
            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $sender->foto) }}"
                alt="{{ $sender->name ?? 'User' }}" />
            @else
            <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 text-[14px]">person</span>
            @endif
        </div>
        <div class="max-w-[80%]">
            <span class="text-primary text-[11px] font-semibold ml-1 block mb-0.5">{{ $sender->name ?? 'Unknown'
                }}</span>
            <div
                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-3 py-2 rounded-2xl rounded-bl-sm shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-[13px] leading-relaxed">{{ $message->message }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5 text-right">{{ $message->created_at->format('H:i') }}</p>
            </div>
        </div>
    </div>
    @endif

    @empty
    {{-- ====== SAMPLE MESSAGES ====== --}}

    {{-- Date Separator --}}
    <div class="flex justify-center my-2">
        <span
            class="bg-slate-200/80 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full">
            Hari Ini
        </span>
    </div>

    {{-- Incoming 1 --}}
    <div class="flex items-end gap-2">
        <div
            class="size-7 shrink-0 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
            <span class="material-symbols-outlined text-slate-400 text-[14px]">person</span>
        </div>
        <div class="max-w-[80%]">
            <span class="text-primary text-[11px] font-semibold ml-1 block mb-0.5">Ustadz Ahmad</span>
            <div
                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-3 py-2 rounded-2xl rounded-bl-sm shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-[13px] leading-relaxed">Assalamualaikum, jangan lupa hafalan hari ini ya anak-anak.
                    Target kita sampai Surah Al-Mulk ayat 10.</p>
                <p class="text-[10px] text-slate-400 mt-0.5 text-right">08:00</p>
            </div>
        </div>
    </div>

    {{-- Outgoing 1 --}}
    <div class="flex justify-end">
        <div class="max-w-[80%]">
            <div class="bg-primary text-slate-900 px-3 py-2 rounded-2xl rounded-br-sm shadow-sm">
                <p class="text-[13px] leading-relaxed font-medium">Waalaikumussalam Ustadz, baik siap! Sedang dalam
                    proses murajaah.</p>
                <div class="flex items-center justify-end gap-1 mt-0.5">
                    <p class="text-[10px] opacity-60">08:05</p>
                    <span class="material-symbols-outlined text-[13px] opacity-60">done_all</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Incoming 2 --}}
    <div class="flex items-end gap-2">
        <div
            class="size-7 shrink-0 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
            <span class="material-symbols-outlined text-slate-400 text-[14px]">person</span>
        </div>
        <div class="max-w-[80%]">
            <span class="text-primary text-[11px] font-semibold ml-1 block mb-0.5">Budi</span>
            <div
                class="bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-3 py-2 rounded-2xl rounded-bl-sm shadow-sm border border-slate-100 dark:border-slate-700">
                <p class="text-[13px] leading-relaxed">Saya sudah hafal Surat Al-Mulk ayat 1-5 ustadz. Izin nanti
                    setoran via VN ya.</p>
                <p class="text-[10px] text-slate-400 mt-0.5 text-right">08:12</p>
            </div>
        </div>
    </div>

    {{-- System Info --}}
    <div class="flex justify-center my-1">
        <p
            class="text-slate-400 dark:text-slate-500 text-[11px] font-medium bg-slate-100 dark:bg-slate-800/50 px-3 py-1 rounded-lg">
            Lani ditambahkan oleh Ustadz Ahmad
        </p>
    </div>

    {{-- Outgoing 2 --}}
    <div class="flex justify-end">
        <div class="max-w-[80%]">
            <div class="bg-primary text-slate-900 px-3 py-2 rounded-2xl rounded-br-sm shadow-sm">
                <p class="text-[13px] leading-relaxed font-medium">Ustadz, apakah ada kelas tambahan sore ini?</p>
                <div class="flex items-center justify-end gap-1 mt-0.5">
                    <p class="text-[10px] opacity-60">08:45</p>
                    <span class="material-symbols-outlined text-[13px] opacity-60">done_all</span>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection

@section('bottom-nav')
{{-- Message Input Bar --}}
<div
    class="group-chat-input fixed bottom-0 left-0 right-0 w-full max-w-md md:max-w-2xl mx-auto z-50 bg-[#f0f2f5] dark:bg-background-dark px-2 py-2 border-t border-slate-200 dark:border-slate-800 flex items-end gap-2">
    <form id="messageForm" class="flex-1 flex items-end gap-2 w-full">
        @csrf
        {{-- Input Pill --}}
        <div class="flex-1 flex items-center bg-white dark:bg-slate-800 rounded-3xl px-1.5 py-1 min-h-[44px] shadow-sm">
            <button type="button"
                class="text-slate-500 hover:text-slate-600 dark:text-slate-400 p-2 shrink-0 transition-colors">
                <span class="material-symbols-outlined text-[24px]">sentiment_satisfied</span>
            </button>
            <input id="messageInput" name="message"
                class="flex-1 bg-transparent border-none focus:ring-0 text-[15px] text-slate-900 dark:text-slate-100 placeholder:text-slate-500 py-2 px-1 leading-tight"
                placeholder="Ketik pesan" type="text" autocomplete="off" />
            <button type="button"
                class="text-slate-500 hover:text-slate-600 dark:text-slate-400 p-2 shrink-0 transition-colors transform -rotate-45">
                <span class="material-symbols-outlined text-[22px]">attach_file</span>
            </button>
            <button type="button"
                class="text-slate-500 hover:text-slate-600 dark:text-slate-400 p-2 shrink-0 transition-colors hidden sm:block">
                <span class="material-symbols-outlined text-[22px]">photo_camera</span>
            </button>
        </div>

        {{-- Send/Mic Button --}}
        <button type="submit" id="sendBtn"
            class="size-[44px] shrink-0 rounded-full bg-[#00a884] hover:bg-[#008f6f] flex items-center justify-center text-white shadow-sm transition-all active:scale-95">
            <span class="material-symbols-outlined text-[20px] ml-0.5"
                style="font-variation-settings: 'FILL' 1;">send</span>
        </button>
    </form>
</div>
@endsection

@push('styles')
<style>
    /* Body: no padding, no scroll, full screen */
    body:has(.group-chat-messages) {
        padding: 0 !important;
        margin: 0 !important;
        overflow: hidden !important;
        height: 100dvh !important;
    }

    /* Wrapper: full width, full height, no bottom padding */
    div:has(> main:has(.group-chat-messages)) {
        max-width: 100% !important;
        width: 100% !important;
        height: 100dvh !important;
        min-height: 100dvh !important;
        max-height: 100dvh !important;
        padding-bottom: 0 !important;
        overflow: hidden !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }

    /* Main: no padding, flex fill */
    main:has(.group-chat-messages) {
        padding: 0 !important;
        margin: 0 !important;
        gap: 0 !important;
        flex: 1 1 0;
        display: flex;
        flex-direction: column;
        min-height: 0;
        overflow: hidden;
    }

    /* Messages: scrollable, fill space */
    .group-chat-messages {
        flex: 1 1 0;
        min-height: 0;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 80px !important;
        background-image:
            radial-gradient(circle at 20% 80%, rgba(19, 236, 91, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(19, 236, 91, 0.02) 0%, transparent 50%);
    }

    /* Input bar: stick to very bottom */
    .group-chat-input {
        flex-shrink: 0;
        padding-bottom: env(safe-area-inset-bottom);
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
            setTimeout(() => { messagesDiv.scrollTop = messagesDiv.scrollHeight; }, 100);
        }

        // Create outgoing message bubble
        function appendMessage(messageText) {
            const wrapper = document.createElement("div");
            wrapper.className = "flex justify-end";

            const inner = document.createElement("div");
            inner.className = "max-w-[80%]";

            const bubble = document.createElement("div");
            bubble.className = "bg-primary text-slate-900 px-3 py-2 rounded-2xl rounded-br-sm shadow-sm";

            const text = document.createElement("p");
            text.className = "text-[13px] leading-relaxed font-medium";
            text.textContent = messageText;

            const meta = document.createElement("div");
            meta.className = "flex items-center justify-end gap-1 mt-0.5";

            const time = document.createElement("p");
            time.className = "text-[10px] opacity-60";
            const now = new Date();
            time.textContent = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            const icon = document.createElement("span");
            icon.className = "material-symbols-outlined text-[13px] opacity-60";
            icon.textContent = "done";

            meta.appendChild(time);
            meta.appendChild(icon);
            bubble.appendChild(text);
            bubble.appendChild(meta);
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
