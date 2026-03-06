<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ecb6",
                        "background-light": "#f6f8f8",
                        "background-dark": "#10221d",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                    borderRadius: { "DEFAULT": "1rem", "lg": "2rem", "xl": "3rem", "full": "9999px" },
                },
            },
        }
    </script>
    <title>Panggilan Aktif - {{ $user->name }}</title>
    <style>
        body {
            height: 100dvh;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased text-slate-900 dark:text-slate-100 overflow-hidden">
    <div class="relative flex h-screen w-full flex-col items-center justify-between overflow-hidden">
        <!-- Blurred Background Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-background-dark/80 backdrop-blur-3xl z-10"></div>
            <div class="h-full w-full bg-cover bg-center"
                style="background-image: url('{{ $user->foto ? (Str::startsWith($user->foto, 'data:') ? $user->foto : asset('storage/' . $user->foto)) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnBMnLTcY0iewSFjF0CZFjlKC4WP74ICMT-0oPzlVf2FJArsYqLdylJYoa9eOBNevhNESZABOZp6-_Gvionu8RoTYfS0WlvMN9GAJLU90237oVQ95u5dtD8YCVWS_tuOLBISTijHnvrDz6_mMNgCAC-7cO5jDl9fnuJzGnQHtPbia92uMoUPXOJexUskdVCVMyi1xSrgNDqWpkCa7w8SinXiKywrkzwCDHnVRtSFjkP9ZP4znPg5WFG1QuuLPkj32jA3mEn-E_g1qX' }}');">
            </div>
        </div>

        <!-- Top Bar -->
        <div class="relative z-20 w-full flex items-center justify-between px-6 pt-12 pb-4">
            <button onclick="window.history.back()"
                class="flex items-center justify-center size-10 rounded-full bg-white/10 text-slate-100 backdrop-blur-md hover:bg-white/20 transition-all">
                <span class="material-symbols-outlined">expand_more</span>
            </button>
            <div class="flex flex-col items-center">
                <span class="text-xs font-semibold uppercase tracking-widest text-primary/80">Panggilan Aktif</span>
                <div class="flex items-center gap-1.5 mt-1">
                    <div class="size-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-sm font-medium text-slate-300">Enkripsi End-to-End</span>
                </div>
            </div>
            <button
                class="flex items-center justify-center size-10 rounded-full bg-white/10 text-slate-100 backdrop-blur-md hover:bg-white/20 transition-all">
                <span class="material-symbols-outlined">person_add</span>
            </button>
        </div>

        <!-- Center Profile Info -->
        <div class="relative z-20 flex flex-col items-center gap-6 mt-10">
            <div class="relative">
                <!-- Pulse Effect Rings -->
                <div
                    class="absolute inset-0 rounded-full bg-primary/20 scale-125 animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite]">
                </div>
                <div
                    class="absolute inset-0 rounded-full bg-primary/10 scale-150 animate-[ping_3s_cubic-bezier(0,0,0.2,1)_infinite]">
                </div>

                <!-- Main Avatar -->
                <div
                    class="relative size-48 rounded-full border-4 border-primary/30 p-1 bg-background-dark overflow-hidden flex items-center justify-center shadow-lg shadow-primary/20">
                    @if($user->foto)
                    <img alt="{{ $user->name }}" class="h-full w-full object-cover rounded-full"
                        src="{{ Str::startsWith($user->foto, 'data:') ? $user->foto : asset('storage/' . $user->foto) }}" />
                    @else
                    <span class="text-6xl font-bold text-white tracking-widest">{{ mb_strtoupper(mb_substr($user->name
                        ?? 'U', 0, 1)) }}</span>
                    @endif
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-3xl font-bold text-white tracking-tight">{{ $user->name }}</h1>
                <p class="mt-2 text-lg font-medium text-primary tracking-widest uppercase font-mono" id="callDuration">
                    00:00</p>
            </div>
        </div>

        <!-- Bottom Controls Container -->
        <div class="relative z-20 w-full px-8 pb-16 flex flex-col items-center gap-10">
            <!-- Auxiliary Controls -->
            <div class="grid grid-cols-3 w-full max-w-sm gap-4">
                <div class="flex flex-col items-center gap-3">
                    <button id="muteBtn"
                        class="size-16 rounded-full bg-white/10 text-white backdrop-blur-xl flex items-center justify-center hover:bg-white/20 transition-all active:scale-95 border border-white/10 shadow-sm">
                        <span class="material-symbols-outlined text-2xl" id="muteIcon">mic_off</span>
                    </button>
                    <span class="text-xs font-medium text-slate-300">Mute</span>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <button id="speakerBtn"
                        class="size-16 rounded-full bg-primary/20 text-primary backdrop-blur-xl flex items-center justify-center hover:bg-primary/30 transition-all active:scale-95 border border-primary/20 shadow-sm">
                        <span class="material-symbols-outlined text-2xl">volume_up</span>
                    </button>
                    <span class="text-xs font-medium text-primary">Speaker</span>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <button id="videoBtn"
                        class="size-16 rounded-full bg-white/10 text-white backdrop-blur-xl flex items-center justify-center hover:bg-white/20 transition-all active:scale-95 border border-white/10 shadow-sm">
                        <span class="material-symbols-outlined text-2xl">videocam</span>
                    </button>
                    <span class="text-xs font-medium text-slate-300">Video</span>
                </div>
            </div>

            <!-- Primary Action: End Call -->
            <button onclick="endCall()" class="group flex flex-col items-center gap-3">
                <div
                    class="size-20 rounded-full bg-red-500 text-white shadow-2xl shadow-red-500/30 flex items-center justify-center hover:bg-red-600 transition-all active:scale-90 ring-4 ring-red-500/20">
                    <span class="material-symbols-outlined text-4xl rotate-[135deg]">call</span>
                </div>
                <span class="text-sm font-bold text-red-400 uppercase tracking-widest">Akhiri Panggilan</span>
            </button>
        </div>

        <!-- iOS Home Indicator style line -->
        <div class="relative z-20 w-32 h-1.5 bg-white/20 rounded-full mb-2"></div>
    </div>

    <!-- Hidden ZegoCloud container for audio -->
    <div id="root" class="hidden"></div>

    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    <script>
        let zp = null;
        let callTimer = null;
        let seconds = 0;

        function formatTime(sec) {
            const m = Math.floor(sec / 60).toString().padStart(2, '0');
            const s = (sec % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        }

        function startTimer() {
            callTimer = setInterval(() => {
                seconds++;
                document.getElementById('callDuration').innerText = formatTime(seconds);
            }, 1000);
        }

        function endCall() {
            if (zp) {
                zp.destroy();
            }
            clearInterval(callTimer);
            window.history.back();
        }

        window.onload = function () {
            startTimer();

            // Setup ZegoCloud logic invisibly
            const appID = {{ $appID }
        };
        const serverSecret = "{{ $serverSecret }}";
        const roomID = "{{ $roomID }}";
        const userID = "{{ $myUserId }}";
        const userName = "{{ $myName }}";

        try {
            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);
            zp = ZegoUIKitPrebuilt.create(kitToken);

            zp.joinRoom({
                container: document.querySelector("#root"),
                turnOnMicrophoneWhenJoining: true,
                turnOnCameraWhenJoining: false,
                showPreJoinView: false,
                showLayoutButton: false,
                showUserList: false,
                showTextChat: false,
                onLeaveRoom: () => {
                    endCall();
                }
            });

            // Control logic
            let isMuted = false;
            document.getElementById('muteBtn').onclick = () => {
                isMuted = !isMuted;
                zp.turnMicrophoneOn(!isMuted);
                document.getElementById('muteIcon').innerText = isMuted ? 'mic' : 'mic_off';
                const muteBtn = document.getElementById('muteBtn');
                if (isMuted) {
                    muteBtn.classList.remove('bg-white/10', 'text-white', 'hover:bg-white/20');
                    muteBtn.classList.add('bg-primary/20', 'text-primary', 'hover:bg-primary/30');
                } else {
                    muteBtn.classList.add('bg-white/10', 'text-white', 'hover:bg-white/20');
                    muteBtn.classList.remove('bg-primary/20', 'text-primary', 'hover:bg-primary/30');
                }
            };

            let isSpeaker = true;
            document.getElementById('speakerBtn').onclick = () => {
                isSpeaker = !isSpeaker;
                const speakerBtn = document.getElementById('speakerBtn');
                if (isSpeaker) {
                    speakerBtn.classList.add('bg-primary/20', 'text-primary', 'hover:bg-primary/30');
                    speakerBtn.classList.remove('bg-white/10', 'text-white', 'hover:bg-white/20');
                } else {
                    speakerBtn.classList.remove('bg-primary/20', 'text-primary', 'hover:bg-primary/30');
                    speakerBtn.classList.add('bg-white/10', 'text-white', 'hover:bg-white/20');
                }
            };
        } catch (e) {
            console.error("Zego init failed", e);
        }
        };
    </script>
</body>

</html>
