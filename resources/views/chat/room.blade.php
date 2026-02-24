<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat - {{ $recipient->name }}</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec5b",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                    },
                    fontFamily: {
                        display: ["Manrope", "sans-serif"]
                    },
                },
            },
        }
    </script>

    <style>
        html,
        body {
            height: 100%;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white">

    <div class="flex flex-col h-screen max-w-md mx-auto bg-white dark:bg-gray-900 shadow-xl">

        {{-- Header --}}
        <header
            class="sticky top-0 z-10 backdrop-blur bg-white/80 dark:bg-gray-900/80 border-b border-gray-200 dark:border-gray-800 px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div
                        class="size-11 rounded-full bg-primary/15 flex items-center justify-center text-primary font-bold text-lg shadow-sm">
                        @if($isGroup)
                        <span class="material-symbols-outlined text-primary">group</span>
                        @else
                        {{ substr($recipient->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <h2 class="font-semibold text-base">{{ $recipient->name }}</h2>
                        <p class="text-xs text-green-500 flex items-center gap-1">
                            @if($isGroup)
                            <span class="text-gray-500">{{ count($recipient->members) }} anggota</span>
                            @else
                            <span class="size-2 bg-green-500 rounded-full"></span>
                            Online
                            @endif
                        </p>
                    </div>
                </div>
                <button class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <span class="material-symbols-outlined text-gray-500">more_vert</span>
                </button>
            </div>
        </header>

        {{-- Messages --}}
        <div id="messages" class="flex-1 overflow-y-auto px-4 py-6 space-y-4 scroll-smooth">
            @foreach($messages as $message)
            @if($message->sender_id == auth()->id())
            {{-- Sent Message --}}
            <div class="flex justify-end">
                <div
                    class="max-w-[75%] bg-primary text-[#102216] rounded-2xl rounded-br-sm px-4 py-3 shadow-md transition-all duration-300">
                    <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                    <div class="flex items-center justify-end gap-1 mt-2">
                        <span class="text-[10px] opacity-70">{{ $message->created_at->format('H:i') }}</span>
                        <span class="material-symbols-outlined text-[12px] opacity-70">{{ $message->is_read ? 'done_all'
                            : 'done' }}</span>
                    </div>
                </div>
            </div>
            @else
            {{-- Received Message --}}
            <div class="flex justify-start">
                <div
                    class="max-w-[75%] bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl rounded-bl-sm px-4 py-3 shadow-md transition-all duration-300">
                    @if($isGroup)
                    <p class="text-xs font-bold text-primary mb-1">{{ $message->sender->name }}</p>
                    @endif
                    <p class="text-sm leading-relaxed text-[#111813] dark:text-white">{{ $message->message }}</p>
                    <span class="text-[10px] text-gray-400 mt-2 block">{{ $message->created_at->format('H:i') }}</span>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Input --}}
        <div
            class="sticky bottom-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur border-t border-gray-200 dark:border-gray-800 p-4">
            <form id="messageForm" class="flex items-end gap-3">
                @csrf
                <button type="button"
                    class="shrink-0 p-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <span class="material-symbols-outlined">attach_file</span>
                </button>
                <div class="flex-1 relative">
                    <textarea id="messageInput" name="message" rows="1"
                        class="w-full resize-none bg-gray-100 dark:bg-gray-800 rounded-2xl px-4 py-3 pr-12 text-sm focus:ring-2 focus:ring-primary/40 focus:outline-none transition"
                        placeholder="Ketik pesan..."></textarea>
                    <button type="button" class="absolute right-3 bottom-3 text-gray-400 hover:text-primary transition">
                        <span class="material-symbols-outlined">mood</span>
                    </button>
                </div>
                <button type="submit"
                    class="shrink-0 size-12 rounded-full bg-primary text-[#102216] flex items-center justify-center shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:scale-105 transition active:scale-95">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </form>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const messages = document.getElementById("messages");
            const form = document.getElementById("messageForm");
            const textarea = document.getElementById("messageInput");
            const submitBtn = form.querySelector('button[type="submit"]');

            // Scroll to bottom on load
            messages.scrollTop = messages.scrollHeight;

            // Auto resize textarea
            textarea.addEventListener("input", function () {
                this.style.height = "auto";
                this.style.height = Math.min(this.scrollHeight, 120) + "px";
            });

            // Helper: Create message bubble safely (NO XSS)
            function appendMessage(messageText) {
                const wrapper = document.createElement("div");
                wrapper.className = "flex justify-end";

                const bubble = document.createElement("div");
                bubble.className = "max-w-[75%] bg-primary text-[#102216] rounded-2xl rounded-tr-sm px-4 py-3 shadow-sm";

                const text = document.createElement("p");
                text.className = "text-sm";
                text.textContent = messageText;

                const meta = document.createElement("div");
                meta.className = "flex items-center justify-end gap-1 mt-1";

                const time = document.createElement("span");
                time.className = "text-[10px] opacity-70";
                time.textContent = "Baru saja";

                const icon = document.createElement("span");
                icon.className = "material-symbols-outlined text-[12px] opacity-70";
                icon.textContent = "done";

                meta.appendChild(time);
                meta.appendChild(icon);
                bubble.appendChild(text);
                bubble.appendChild(meta);
                wrapper.appendChild(bubble);
                messages.appendChild(wrapper);

                messages.scrollTop = messages.scrollHeight;
            }

            // Form submit
            form.addEventListener("submit", async function (e) {
                e.preventDefault();

                const message = textarea.value.trim();
                if (!message) return;

                try {
                    // Loading state
                    submitBtn.disabled = true;
                    submitBtn.classList.add("opacity-50");
                    submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span>';

                    const response = await fetch("{{ route('chat.send', $recipient->id) }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ message })
                    });

                    if (!response.ok) {
                        throw new Error("Server error");
                    }

                    const data = await response.json();

                    // Append message only if success
                    appendMessage(message);

                    // Reset input
                    textarea.value = "";
                    textarea.style.height = "auto";

                } catch (error) {
                    console.error(error);
                    alert("Gagal mengirim pesan. Silakan coba lagi.");
                } finally {
                    // Restore button
                    submitBtn.disabled = false;
                    submitBtn.classList.remove("opacity-50");
                    submitBtn.innerHTML = '<span class="material-symbols-outlined">send</span>';
                }
            });
        });
    </script>

</body>

</html>
