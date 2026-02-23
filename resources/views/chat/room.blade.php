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

    <div class="flex flex-col h-screen max-w-md mx-auto">

        {{-- Header --}}
        <header
            class="sticky top-0 z-10 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 px-4 py-3">
            <div class="flex items-center justify-center relative">
                <div class="flex-1 flex flex-col items-center justify-center">
                    <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center mb-1">
                        @if($isGroup)
                        <span class="material-symbols-outlined text-primary">group</span>
                        @else
                        <span class="text-lg font-bold text-primary">{{ substr($recipient->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="text-center">
                        <h2 class="font-bold text-[#111813] dark:text-white leading-tight">{{ $recipient->name }}</h2>
                        <p class="text-xs text-gray-500">{{ $isGroup ? count($recipient->members) . ' anggota' :
                            'Online' }}
                        </p>
                    </div>
                </div>
                <div class="absolute right-0">
                    <button class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <span class="material-symbols-outlined text-gray-500">more_vert</span>
                    </button>
                </div>
            </div>
        </header>

        {{-- Messages --}}
        <div id="messages" class="flex-1 overflow-y-auto px-4 py-4 space-y-4">
            @foreach($messages as $message)
            @if($message->sender_id == auth()->id())
            {{-- Sent Message --}}
            <div class="flex justify-end">
                <div class="max-w-[75%] bg-primary text-[#102216] rounded-2xl rounded-tr-sm px-4 py-3 shadow-sm">
                    <p class="text-sm">{{ $message->message }}</p>
                    <div class="flex items-center justify-end gap-1 mt-1">
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
                    class="max-w-[75%] bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm">
                    @if($isGroup)
                    <p class="text-xs font-bold text-primary mb-1">{{ $message->sender->name }}</p>
                    @endif
                    <p class="text-sm text-[#111813] dark:text-white">{{ $message->message }}</p>
                    <span class="text-[10px] text-gray-400 mt-1 block">{{ $message->created_at->format('H:i') }}</span>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Input --}}
        <div class="sticky bottom-0 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 p-4">
            <form id="messageForm" class="flex items-end gap-3">
                @csrf
                <button type="button"
                    class="shrink-0 p-2.5 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200 transition">
                    <span class="material-symbols-outlined">attach_file</span>
                </button>
                <div class="flex-1 relative">
                    <textarea id="messageInput" name="message" rows="1"
                        class="w-full resize-none bg-gray-100 dark:bg-gray-800 border-0 rounded-2xl px-4 py-3 pr-12 text-sm focus:ring-2 focus:ring-primary/50"
                        placeholder="Ketik pesan..."></textarea>
                    <button type="button"
                        class="absolute right-3 bottom-2.5 text-gray-400 hover:text-primary transition">
                        <span class="material-symbols-outlined">mood</span>
                    </button>
                </div>
                <button type="submit"
                    class="shrink-0 size-12 rounded-full bg-primary text-[#102216] flex items-center justify-center shadow-lg shadow-primary/25 hover:shadow-primary/40 transition active:scale-95">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </form>
        </div>

    </div>

    <script>
        // Scroll to bottom on load
        const messages = document.getElementById('messages');
        messages.scrollTop = messages.scrollHeight;

        // Auto-resize textarea
        const textarea = document.getElementById('messageInput');
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Send message
        document.getElementById('messageForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const message = textarea.value.trim();
            if (!message) return;

            fetch('{{ route("chat.send", $recipient->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            })
                .then(response => response.json())
                .then(data => {
                    // Add message to UI
                    const html = `
                    <div class="flex justify-end">
                        <div class="max-w-[75%] bg-primary text-[#102216] rounded-2xl rounded-tr-sm px-4 py-3 shadow-sm">
                            <p class="text-sm">${message}</p>
                            <div class="flex items-center justify-end gap-1 mt-1">
                                <span class="text-[10px] opacity-70">Baru saja</span>
                                <span class="material-symbols-outlined text-[12px] opacity-70">done</span>
                            </div>
                        </div>
                    </div>
                `;
                    messages.insertAdjacentHTML('beforeend', html);
                    messages.scrollTop = messages.scrollHeight;
                    textarea.value = '';
                    textarea.style.height = 'auto';
                })
                .catch(console.error);
        });
    </script>

</body>

</html>
