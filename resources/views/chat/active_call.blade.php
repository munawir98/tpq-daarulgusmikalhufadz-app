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
                style="background-image: url('{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/images/default-avatar.png') }}');">
            </div>
        </div>
        <!-- Top Bar -->
        <div class="relative z-20 w-full flex items-center justify-between px-5 pt-10 pb-2">
            <a href="javascript:history.back()"
                class="flex items-center justify-center size-8 rounded-full bg-white/10 text-slate-100 backdrop-blur-md">
                <span class="material-symbols-outlined text-[20px]">expand_more</span>
            </a>
            <div class="flex flex-col items-center">
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="material-symbols-outlined text-slate-300 text-[12px]">lock</span>
                    <span class="text-[11px] font-medium text-slate-300">Enkripsi End-to-End</span>
                </div>
            </div>
            <button
                class="flex items-center justify-center size-8 rounded-full bg-white/10 text-slate-100 backdrop-blur-md">
                <span class="material-symbols-outlined text-[18px]">person_add</span>
            </button>
        </div>

        <!-- Center Profile Info -->
        <div class="relative z-20 flex flex-col items-center gap-4 mt-8 flex-1">
            <div class="relative">
                <!-- Pulse Effect Rings -->
                <div class="absolute inset-0 rounded-full bg-primary/20 scale-110"></div>
                <div
                    class="relative size-32 rounded-full border-2 border-primary/30 p-1 bg-background-dark overflow-hidden flex items-center justify-center">
                    @if($user->foto)
                    <img alt="{{ $user->name }} Profile" class="h-full w-full object-cover rounded-full"
                        src="{{ asset('storage/' . $user->foto) }}" />
                    @else
                    <span class="material-symbols-outlined text-[60px] text-slate-400">person</span>
                    @endif
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-2xl font-semibold text-white tracking-tight">{{ $user->name }}</h1>
                <p class="mt-1 text-sm font-medium text-slate-300" id="callDuration">00:00</p>
            </div>
        </div>

        <!-- Bottom Controls Container (WhatsApp Style) -->
        <div class="relative z-20 w-full px-6 pb-12 flex flex-col items-center gap-6">
            <div
                class="w-full max-w-[280px] bg-background-dark/60 backdrop-blur-xl rounded-[2rem] p-4 border border-white/5 mx-auto">
                <div class="flex justify-between items-center px-2">
                    <!-- Speaker -->
                    <button class="flex flex-col items-center gap-1.5 group">
                        <div
                            class="size-12 rounded-full bg-white/10 text-white flex items-center justify-center group-active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-[22px]">volume_up</span>
                        </div>
                    </button>

                    <!-- Video (Disabled state usually) -->
                    <button class="flex flex-col items-center gap-1.5 group opacity-50">
                        <div
                            class="size-12 rounded-full bg-white/10 text-white flex items-center justify-center group-active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-[22px]">videocam</span>
                        </div>
                    </button>

                    <!-- Mute -->
                    <button class="flex flex-col items-center gap-1.5 group">
                        <div
                            class="size-12 rounded-full bg-white/10 text-white flex items-center justify-center group-active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-[22px]">mic_off</span>
                        </div>
                    </button>

                    <!-- End Call (Red, prominent) -->
                    <a href="javascript:history.back()" class="flex flex-col items-center gap-1.5 group">
                        <div
                            class="size-14 rounded-full bg-[#ff3b30] text-white flex items-center justify-center shadow-lg group-active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-[28px] rotate-[135deg]">call</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- iOS Home Indicator -->
        <div class="relative z-20 w-32 h-1.5 bg-white/20 rounded-full mb-2"></div>
    </div>

    <script>
        // Simple call duration timer
        let seconds = 0;
        const durationElement = document.getElementById('callDuration');
        setInterval(() => {
            seconds++;
            const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
            const secs = (seconds % 60).toString().padStart(2, '0');
            durationElement.textContent = `${mins}:${secs}`;
        }, 1000);
    </script>
</body>

</html>
