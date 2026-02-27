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

    {{-- Emoji Picker --}}
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@1/index.js"></script>

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
            class="sticky bottom-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur border-t border-gray-200 dark:border-gray-800 p-3">
            <form id="messageForm" class="flex flex-col gap-2" enctype="multipart/form-data"
                data-is-group="{{ $isGroup ? 'true' : 'false' }}" data-url-group="{{ route('chat.group.send') }}"
                data-url-private="{{ route('chat.send', $recipient->id ?? 0) }}">
                @csrf
                <input type="file" id="attachmentInput" name="attachment" class="hidden"
                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">

                <div id="attachmentPreview"
                    class="hidden bg-white dark:bg-gray-800 p-2 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex items-center gap-2 w-fit">
                    <span class="material-symbols-outlined text-gray-500">description</span>
                    <span id="attachmentName" class="text-sm truncate max-w-[200px]"></span>
                    <button type="button" id="removeAttachmentBtn"
                        class="text-red-500 hover:bg-red-50 p-1 rounded-lg ml-auto">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>

                <div
                    class="relative bg-gray-100 dark:bg-gray-800 rounded-2xl border border-transparent focus-within:border-primary/40 focus-within:ring-2 focus-within:ring-primary/20 transition-all overflow-hidden flex flex-col">
                    <textarea id="messageInput" name="message" rows="1"
                        class="w-full resize-none bg-transparent border-none px-4 py-3 text-[14px] text-gray-900 dark:text-gray-100 placeholder:text-gray-500 focus:ring-0 focus:outline-none"
                        placeholder="Ketik pesan..."></textarea>

                    <div class="flex items-center justify-between px-2 pb-2">
                        <div class="flex items-center gap-1">
                            <button type="button" id="emojiBtn"
                                class="p-2 text-gray-500 hover:text-primary transition rounded-full hover:bg-gray-200/50 dark:hover:bg-gray-700/50 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">mood</span>
                            </button>
                            <button type="button" id="attachBtn"
                                class="p-2 text-gray-500 hover:text-primary transition rounded-full hover:bg-gray-200/50 dark:hover:bg-gray-700/50 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[22px]">attach_file</span>
                            </button>
                        </div>

                        <button type="submit"
                            class="size-10 rounded-full bg-primary text-[#102216] flex items-center justify-center shadow-md hover:shadow-lg hover:scale-105 transition active:scale-95 shrink-0 mr-1">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                        </button>
                    </div>

                    {{-- Emoji Picker Container --}}
                    <div id="emojiPickerContainer"
                        class="hidden absolute bottom-full mb-2 right-0 z-50 shadow-2xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800">
                        <emoji-picker class="light"></emoji-picker>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const messages = document.getElementById("messages");
            const form = document.getElementById("messageForm");
            const textarea = document.getElementById("messageInput");
            const submitBtn = form.querySelector('button[type="submit"]');

            const attachBtn = document.getElementById("attachBtn");
            const attachmentInput = document.getElementById("attachmentInput");
            const attachmentPreview = document.getElementById("attachmentPreview");
            const attachmentName = document.getElementById("attachmentName");
            const removeAttachmentBtn = document.getElementById("removeAttachmentBtn");

            const emojiBtn = document.getElementById("emojiBtn");
            const emojiPickerContainer = document.getElementById("emojiPickerContainer");
            const emojiPicker = document.querySelector("emoji-picker");

            // Toggle emoji picker
            emojiBtn.addEventListener("click", () => {
                emojiPickerContainer.classList.toggle("hidden");
            });

            // Insert emoji
            emojiPicker.addEventListener("emoji-click", event => {
                const startPos = textarea.selectionStart;
                const endPos = textarea.selectionEnd;
                textarea.value = textarea.value.substring(0, startPos) + event.detail.unicode + textarea.value.substring(endPos, textarea.value.length);
                textarea.selectionStart = startPos + event.detail.unicode.length;
                textarea.selectionEnd = startPos + event.detail.unicode.length;
                textarea.focus();

                // Auto resize trigger
                textarea.style.height = "auto";
                textarea.style.height = Math.min(textarea.scrollHeight, 120) + "px";
            });

            // Close emoji picker when clicking outside
            document.addEventListener("click", (e) => {
                if (!emojiPickerContainer.contains(e.target) && !emojiBtn.contains(e.target)) {
                    emojiPickerContainer.classList.add("hidden");
                }
            });

            // Attach button click
            attachBtn.addEventListener("click", () => {
                attachmentInput.click();
            });

            // File selected
            attachmentInput.addEventListener("change", function () {
                if (this.files && this.files[0]) {
                    attachmentName.textContent = this.files[0].name;
                    attachmentPreview.classList.remove("hidden");
                }
            });

            // Remove attachment
            removeAttachmentBtn.addEventListener("click", () => {
                attachmentInput.value = "";
                attachmentPreview.classList.add("hidden");
            });

            // Scroll to bottom on load
            messages.scrollTop = messages.scrollHeight;

            // Auto resize textarea
            textarea.addEventListener("input", function () {
                this.style.height = "auto";
                this.style.height = Math.min(this.scrollHeight, 120) + "px";
            });

            // Helper: Create message bubble safely (NO XSS)
            function appendMessage(chat) {
                const wrapper = document.createElement("div");
                wrapper.className = "flex justify-end";

                const bubble = document.createElement("div");
                bubble.className = "max-w-[75%] bg-primary text-[#102216] rounded-2xl rounded-tr-sm px-4 py-3 shadow-sm";

                if (chat.type === 'image' && chat.file_path) {
                    const img = document.createElement("img");
                    img.src = '/storage/' + chat.file_path;
                    img.className = "max-w-full rounded-lg mb-2";
                    bubble.appendChild(img);
                } else if (chat.type === 'file' && chat.file_path) {
                    const fileLink = document.createElement("a");
                    fileLink.href = '/storage/' + chat.file_path;
                    fileLink.className = "flex items-center gap-2 text-sm bg-black/10 p-2 rounded-lg mb-2";
                    fileLink.target = "_blank";
                    fileLink.innerHTML = `<span class="material-symbols-outlined">description</span> <span>Lampiran File</span>`;
                    bubble.appendChild(fileLink);
                }

                if (chat.message) {
                    const text = document.createElement("p");
                    text.className = "text-sm";
                    text.textContent = chat.message;
                    bubble.appendChild(text);
                }

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
                bubble.appendChild(meta);
                wrapper.appendChild(bubble);
                messages.appendChild(wrapper);

                messages.scrollTop = messages.scrollHeight;
            }

            // Form submit
            form.addEventListener("submit", async function (e) {
                e.preventDefault();

                const message = textarea.value.trim();
                const file = attachmentInput.files[0];

                if (!message && !file) return;

                try {
                    // Loading state
                    submitBtn.disabled = true;
                    submitBtn.classList.add("opacity-50");
                    submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span>';

                    const formData = new FormData();
                    if (message) formData.append('message', message);
                    if (file) formData.append('attachment', file);

                    const isGroup = form.dataset.isGroup === 'true';
                    const url = isGroup ? form.dataset.urlGroup : form.dataset.urlPrivate;

                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error("Server error");
                    }

                    const data = await response.json();

                    // Append message only if success
                    appendMessage(data.message);

                    // Reset input
                    textarea.value = "";
                    textarea.style.height = "auto";
                    attachmentInput.value = "";
                    attachmentPreview.classList.add("hidden");

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
