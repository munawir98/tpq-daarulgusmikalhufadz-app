<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat - {{ $groupName }}</title>

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
            overflow: hidden;
            touch-action: pan-y;
        }

        /* Custom scrollbar for webkit */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .chat-bg {
            background-color: #efeae2;
            background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
            background-repeat: repeat;
            background-size: 350px;
        }

        .dark .chat-bg {
            background-color: #0b141a;
            background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-black font-display text-[#111b21] dark:text-[#e9edef] overflow-hidden">

    <div id="appContainer"
        class="flex flex-col fixed inset-0 mx-auto w-full max-w-md bg-[#efeae2] dark:bg-[#0b141a] shadow-xl overflow-hidden">
        {{-- Chat Background overlay for pattern --}}
        <div class="absolute inset-0 chat-bg opacity-40 dark:opacity-5 pointer-events-none z-0"></div>

        {{-- Header --}}
        <header
            class="shrink-0 sticky top-0 z-20 bg-[#008069] dark:bg-[#1f2c34] px-1 py-1.5 flex items-center gap-1 shadow-sm">
            <a href="{{ route('chat.index') }}"
                class="text-white dark:text-[#e9edef] p-2 rounded-full hover:bg-white/10 dark:hover:bg-white/5 transition flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[24px]">arrow_back</span>
            </a>
            <div
                class="flex items-center flex-1 gap-2 cursor-pointer overflow-hidden py-1 px-1 rounded-xl hover:bg-white/5 transition">
                <div
                    class="size-[38px] rounded-full bg-white/20 dark:bg-gray-700 flex items-center justify-center text-white dark:text-gray-300 font-bold text-lg overflow-hidden shrink-0">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <div class="flex flex-col flex-1 overflow-hidden">
                    <h2 class="font-semibold text-base leading-tight text-white truncate">{{ $groupName }}</h2>
                    <p class="text-xs text-white/80 dark:text-[#8696a0] truncate w-full">
                        @foreach($members as $idx => $member)
                        {{ $member->name ?? 'User' }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1 text-white dark:text-[#aebac1] shrink-0">
                <button class="p-2 rounded-full hover:bg-white/10 dark:hover:bg-white/5 transition hidden sm:block">
                    <span class="material-symbols-outlined text-[20px]">videocam</span>
                </button>
                <button class="p-2 rounded-full hover:bg-white/10 dark:hover:bg-white/5 transition hidden sm:block">
                    <span class="material-symbols-outlined text-[20px]">call</span>
                </button>
                <button class="p-2 rounded-full hover:bg-white/10 dark:hover:bg-white/5 transition">
                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                </button>
            </div>
        </header>

        {{-- Messages --}}
        <div id="messages" class="flex-1 overflow-y-auto px-4 py-4 space-y-1 z-10 scroll-smooth">
            @foreach($messages as $index => $message)
            @php
            $prevMessage = $index > 0 ? $messages[$index - 1] : null;
            $showTail = !$prevMessage || $prevMessage->sender_id !== $message->sender_id;
            @endphp

            @if($message->sender_id == auth()->id())
            {{-- Sent Message --}}
            <div class="flex justify-end relative {{ $showTail ? 'mt-2' : '' }}">
                <div class="max-w-[85%] bg-[#dcf8c6] dark:bg-[#005c4b] text-[#111b21] dark:text-[#e9edef] rounded-lg px-2 pt-2 pb-1 shadow-sm relative text-[14.2px] break-words
                    {{ $showTail ? 'rounded-tr-none' : '' }}">

                    @if($showTail)
                    {{-- Tail SVGs --}}
                    <svg viewBox="0 0 8 13" width="8" height="13"
                        class="absolute top-0 -right-[7px] text-[#dcf8c6] dark:text-[#005c4b] fill-current">
                        <path opacity=".13" fill="#0000000" d="M1.533 3.118L8 12.118V1H0c.843 0 1.258.468 1.533 2.118z">
                        </path>
                        <path opacity=".08" fill="#0000000" d="M1.533 2.118L8 11.118V0H0c.843 0 1.258.468 1.533 2.118z">
                        </path>
                        <path d="M1.533 3.118L8 12.118V1H0c.843 0 1.258.468 1.533 2.118z"></path>
                    </svg>
                    @endif

                    <div class="flex flex-col">
                        @if($message->type === 'file' && $message->file_path)
                        <div
                            class="flex items-center gap-3 bg-black/5 dark:bg-white/5 p-3 rounded-lg mb-1 w-64 border border-black/5 dark:border-white/5">
                            <span class="material-symbols-outlined text-red-500 text-4xl">picture_as_pdf</span>
                            <div class="flex flex-col overflow-hidden">
                                <span class="font-medium text-[15px] truncate text-[#111b21] dark:text-[#e9edef]">{{
                                    basename($message->file_path) }}</span>
                                <span class="text-[12px] text-[#667781] dark:text-[#8696a0] uppercase">{{
                                    pathinfo($message->file_path, PATHINFO_EXTENSION) }}</span>
                            </div>
                        </div>
                        @elseif($message->type === 'image' && $message->file_path)
                        <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image"
                            class="max-w-full rounded-lg mb-1 cursor-pointer">
                        @endif

                        <div class="flex items-end content-end pr-14 relative">
                            <span class="leading-relaxed whitespace-pre-wrap">{!! nl2br(e($message->message)) !!}</span>
                        </div>
                    </div>

                    <div class="absolute bottom-1 right-2 flex items-center gap-1">
                        <span class="text-[11px] text-[#667781] dark:text-[#8696a0] leading-none">{{
                            $message->created_at->format('H:i') }}</span>
                        <span
                            class="material-symbols-outlined text-[14px] leading-none {{ $message->is_read ? 'text-[#53bdeb]' : 'text-[#667781] dark:text-[#8696a0]' }}">{{
                            $message->is_read ? 'done_all' : 'done' }}</span>
                    </div>
                </div>
            </div>
            @else
            {{-- Received Message --}}
            <div class="flex justify-start relative {{ $showTail ? 'mt-2' : '' }}">
                <div class="max-w-[85%] bg-white dark:bg-[#202c33] text-[#111b21] dark:text-[#e9edef] rounded-lg px-2 pt-2 pb-1 shadow-sm relative text-[14.2px] break-words
                    {{ $showTail ? 'rounded-tl-none' : '' }}">

                    @if($showTail)
                    {{-- Tail SVGs --}}
                    <svg viewBox="0 0 8 13" width="8" height="13"
                        class="absolute top-0 -left-[7px] text-white dark:text-[#202c33] fill-current transform scale-x-[-1]">
                        <path opacity=".13" fill="#0000000" d="M1.533 3.118L8 12.118V1H0c.843 0 1.258.468 1.533 2.118z">
                        </path>
                        <path opacity=".08" fill="#0000000" d="M1.533 2.118L8 11.118V0H0c.843 0 1.258.468 1.533 2.118z">
                        </path>
                        <path d="M1.533 3.118L8 12.118V1H0c.843 0 1.258.468 1.533 2.118z"></path>
                    </svg>
                    @endif

                    <div class="flex flex-col">
                        @if($showTail)
                        <span class="text-[13px] font-bold text-[#eb6b32] mb-1 leading-none">{{ $message->sender->name
                            ?? 'User'
                            }}</span>
                        @endif

                        @if($message->type === 'file' && $message->file_path)
                        <div
                            class="flex items-center gap-3 bg-black/5 dark:bg-white/5 p-3 rounded-lg mb-1 w-64 border border-black/5 dark:border-white/5">
                            <span class="material-symbols-outlined text-red-500 text-4xl">picture_as_pdf</span>
                            <div class="flex flex-col overflow-hidden">
                                <span class="font-medium text-[15px] truncate text-[#111b21] dark:text-[#e9edef]">{{
                                    basename($message->file_path) }}</span>
                                <span class="text-[12px] text-[#667781] dark:text-[#8696a0] uppercase">{{
                                    pathinfo($message->file_path, PATHINFO_EXTENSION) }}</span>
                            </div>
                        </div>
                        @elseif($message->type === 'image' && $message->file_path)
                        <img src="{{ asset('storage/' . $message->file_path) }}" alt="Image"
                            class="max-w-full rounded-lg mb-1 cursor-pointer">
                        @endif

                        <div class="flex items-end content-end pr-10 relative">
                            <span class="leading-relaxed whitespace-pre-wrap">{!! nl2br(e($message->message)) !!}</span>
                        </div>
                    </div>

                    <div class="absolute bottom-1 right-2 inline-flex gap-1 items-center">
                        <span class="text-[11px] text-[#667781] dark:text-[#8696a0] leading-none">{{
                            $message->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Input --}}
        <div class="shrink-0 bg-[#f0f2f5] dark:bg-[#202c33] px-2 py-2 flex items-end gap-2 z-20 w-full relative">

            {{-- Attachment Preview --}}
            <div id="attachmentPreview"
                class="hidden absolute bottom-full mb-2 left-2 bg-white dark:bg-[#2a3942] p-3 rounded-xl shadow-lg border border-gray-200 dark:border-[#202c33] flex items-center gap-3 min-w-[200px] z-20">
                <div class="bg-black/5 dark:bg-white/5 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-red-500 text-2xl">picture_as_pdf</span>
                </div>
                <div class="flex flex-col flex-1 overflow-hidden">
                    <span id="attachmentName" class="text-sm truncate font-medium dark:text-[#e9edef]"></span>
                    <span class="text-xs text-[#667781] dark:text-[#8696a0]">Lampiran siap dikirim</span>
                </div>
                <button type="button" id="removeAttachmentBtn"
                    class="text-[#54656f] dark:text-[#aebac1] hover:text-red-500 p-1 rounded-full transition hover:bg-black/5 dark:hover:bg-white/5">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <form id="messageForm" class="flex items-end gap-2 w-full" enctype="multipart/form-data"
                data-url="{{ route('chat.group.send') }}">
                @csrf
                <input type="file" id="attachmentInput" name="attachment" class="hidden"
                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">

                <div
                    class="flex-1 bg-white dark:bg-[#2a3942] rounded-3xl flex items-end overflow-hidden px-1 min-h-[44px]">
                    <button type="button" id="emojiBtn"
                        class="p-2.5 text-[#54656f] dark:text-[#8696a0] hover:bg-black/5 dark:hover:bg-white/5 rounded-full transition flex-shrink-0 self-end mb-[1px]">
                        <span class="material-symbols-outlined text-[24px]">sentiment_satisfied</span>
                    </button>

                    <textarea id="messageInput" name="message" rows="1"
                        class="flex-1 max-h-[100px] bg-transparent border-0 focus:ring-0 resize-none py-3 px-1 text-[15px] dark:text-[#e9edef] placeholder-[#667781] dark:placeholder-[#8696a0] self-center my-auto leading-tight"
                        placeholder="Ketik pesan"></textarea>

                    <button type="button" id="attachBtn"
                        class="p-2.5 text-[#54656f] dark:text-[#8696a0] hover:bg-black/5 dark:hover:bg-white/5 rounded-full transition flex-shrink-0 self-end mb-[1px]">
                        <span class="material-symbols-outlined text-[24px] transform -rotate-45">attach_file</span>
                    </button>
                    <button type="button"
                        class="p-2.5 text-[#54656f] dark:text-[#8696a0] hover:bg-black/5 dark:hover:bg-white/5 rounded-full transition flex-shrink-0 self-end mb-[1px] mr-1">
                        <span class="material-symbols-outlined text-[24px]">camera_alt</span>
                    </button>
                </div>

                {{-- Emoji Picker Container --}}
                <div id="emojiPickerContainer"
                    class="hidden absolute bottom-[50px] mb-2 left-2 z-[60] shadow-2xl rounded-xl overflow-hidden border border-gray-200 dark:border-[#202c33]">
                    <emoji-picker class="light"></emoji-picker>
                </div>

                <button type="submit" id="submitBtn"
                    class="flex-shrink-0 size-[48px] rounded-full bg-[#00a884] hover:bg-[#008f6f] text-white flex items-center justify-center shadow-sm transition active:scale-95 self-end">
                    <span class="material-symbols-outlined text-[24px]" id="submitBtnIcon">mic</span>
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

            // Fix for mobile keyboard pushing the header up
            const appContainer = document.getElementById('appContainer');
            if (window.visualViewport) {
                const resizeHandler = () => {
                    appContainer.style.height = window.visualViewport.height + 'px';
                    messages.scrollTop = messages.scrollHeight;
                };
                window.visualViewport.addEventListener('resize', resizeHandler);
                window.visualViewport.addEventListener('scroll', resizeHandler);
                resizeHandler(); // init
            }

            // Scroll to bottom on load
            messages.scrollTop = messages.scrollHeight;

            // Auto resize textarea & switch icon
            const submitBtnIcon = document.getElementById("submitBtnIcon");
            textarea.addEventListener("input", function () {
                this.style.height = "auto";
                this.style.height = Math.min(this.scrollHeight, 100) + "px";

                if (this.value.trim() !== "" || attachmentInput.value !== "") {
                    submitBtnIcon.textContent = "send";
                } else {
                    submitBtnIcon.textContent = "mic";
                }
            });

            // Helper: Create message bubble safely (NO XSS)
            function appendMessage(chat) {
                const wrapper = document.createElement("div");
                wrapper.className = "flex justify-end relative mt-2";

                const bubble = document.createElement("div");
                bubble.className = "max-w-[85%] bg-[#dcf8c6] dark:bg-[#005c4b] text-[#111b21] dark:text-[#e9edef] rounded-lg px-2 pt-2 pb-1 shadow-sm relative text-[14.2px] break-words rounded-tr-none";

                // Tail
                const tailSvg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                tailSvg.setAttribute("viewBox", "0 0 8 13");
                tailSvg.setAttribute("width", "8");
                tailSvg.setAttribute("height", "13");
                tailSvg.setAttribute("class", "absolute top-0 -right-[7px] text-[#dcf8c6] dark:text-[#005c4b] fill-current");
                tailSvg.innerHTML = `<path opacity=".13" fill="#0000000" d="M1.533 3.118L8 12.118V1H0c.843 0 1.258.468 1.533 2.118z"></path>
                    <path opacity=".08" fill="#0000000" d="M1.533 2.118L8 11.118V0H0c.843 0 1.258.468 1.533 2.118z"></path>
                    <path d="M1.533 3.118L8 12.118V1H0c.843 0 1.258.468 1.533 2.118z"></path>`;
                bubble.appendChild(tailSvg);

                const flexCol = document.createElement("div");
                flexCol.className = "flex flex-col";

                if (chat.type === 'image' && chat.file_path) {
                    const img = document.createElement("img");
                    img.src = '/storage/' + chat.file_path;
                    img.className = "max-w-full rounded-lg mb-1";
                    flexCol.appendChild(img);
                } else if (chat.type === 'file' && chat.file_path) {
                    const fileBox = document.createElement("div");
                    fileBox.className = "flex items-center gap-3 bg-black/5 dark:bg-white/5 p-3 rounded-lg mb-1 w-64 border border-black/5 dark:border-white/5";

                    const fileNameObj = chat.file_path.split('/').pop();
                    const fileExtObj = fileNameObj.split('.').pop().toUpperCase();

                    fileBox.innerHTML = `
                        <span class="material-symbols-outlined text-red-500 text-4xl">picture_as_pdf</span>
                        <div class="flex flex-col overflow-hidden">
                            <span class="font-medium text-[15px] truncate text-[#111b21] dark:text-[#e9edef]">${fileNameObj}</span>
                            <span class="text-[12px] text-[#667781] dark:text-[#8696a0]">${fileExtObj}</span>
                        </div>
                    `;
                    flexCol.appendChild(fileBox);
                }

                if (chat.message) {
                    const textWrap = document.createElement("div");
                    textWrap.className = "flex items-end content-end pr-14 relative";
                    const text = document.createElement("span");
                    text.className = "leading-relaxed whitespace-pre-wrap";
                    text.textContent = chat.message;
                    textWrap.appendChild(text);
                    flexCol.appendChild(textWrap);
                }

                bubble.appendChild(flexCol);

                const meta = document.createElement("div");
                meta.className = "absolute bottom-1 right-2 flex items-center gap-1";

                const time = document.createElement("span");
                time.className = "text-[11px] text-[#667781] dark:text-[#8696a0] leading-none";
                const d = new Date();
                time.textContent = String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');

                const icon = document.createElement("span");
                icon.className = "material-symbols-outlined text-[14px] leading-none text-[#667781] dark:text-[#8696a0]";
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

                    const url = form.dataset.url;

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
                    submitBtnIcon.textContent = "mic";

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
