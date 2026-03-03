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
        <div class="relative z-20 w-full flex items-center justify-between px-6 pt-12 pb-4">
            <a href="javascript:history.back()"
                class="flex items-center justify-center size-10 rounded-full bg-white/10 text-slate-100 backdrop-blur-md">
                <span class="material-symbols-outlined">expand_more</span>
            </a>
            <div class="flex flex-col items-center">
                <span class="text-xs font-semibold uppercase tracking-widest text-primary/80">Panggilan Aktif</span>
                <div class="flex items-center gap-1.5 mt-1">
                    <div class="size-2 rounded-full bg-primary animate-pulse"></div>
                    <span class="text-sm font-medium text-slate-300">Enkripsi End-to-End</span>
                </div>
            </div>
            <button
                class="flex items-center justify-center size-10 rounded-full bg-white/10 text-slate-100 backdrop-blur-md">
                <span class="material-symbols-outlined">person_add</span>
            </button>
        </div>
        <!-- Center Profile Info -->
        <div class="relative z-20 flex flex-col items-center gap-6 mt-10">
            <div class="relative">
                <!-- Pulse Effect Rings -->
                <div class="absolute inset-0 rounded-full bg-primary/20 scale-125"></div>
                <div class="absolute inset-0 rounded-full bg-primary/10 scale-150"></div>
                <!-- Main Avatar -->
                <div
                    class="relative size-48 rounded-full border-4 border-primary/30 p-1 bg-background-dark overflow-hidden">
                    <img alt="{{ $user->name }} Profile" class="h-full w-full object-cover rounded-full"
                        src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('assets/images/default-avatar.png') }}" />
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-3xl font-bold text-white tracking-tight">{{ $user->name }}</h1>
                <p class="mt-2 text-lg font-medium text-primary tracking-widest uppercase" id="callDuration">00:00</p>
            </div>
        </div>
        <!-- Bottom Controls Container -->
        <div class="relative z-20 w-full px-8 pb-16 flex flex-col items-center gap-10">
            <!-- Auxiliary Controls -->
            <div class="grid grid-cols-3 w-full max-w-sm gap-4">
                <div class="flex flex-col items-center gap-3">
                    <button
                        class="size-16 rounded-full bg-white/10 text-white backdrop-blur-xl flex items-center justify-center hover:bg-white/20 transition-all active:scale-95 border border-white/10">
                        <span class="material-symbols-outlined text-2xl">mic_off</span>
                    </button>
                    <span class="text-xs font-medium text-slate-300">Mute</span>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <button
                        class="size-16 rounded-full bg-primary/20 text-primary backdrop-blur-xl flex items-center justify-center hover:bg-primary/30 transition-all active:scale-95 border border-primary/20">
                        <span class="material-symbols-outlined text-2xl">volume_up</span>
                    </button>
                    <span class="text-xs font-medium text-primary">Speaker</span>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <button
                        class="size-16 rounded-full bg-white/10 text-white backdrop-blur-xl flex items-center justify-center hover:bg-white/20 transition-all active:scale-95 border border-white/10">
                        <span class="material-symbols-outlined text-2xl">videocam</span>
                    </button>
                    <span class="text-xs font-medium text-slate-300">Video</span>
                </div>
            </div>
            <!-- Primary Action: End Call -->
            <a href="javascript:history.back()" class="group flex flex-col items-center gap-3">
                <div
                    class="size-20 rounded-full bg-red-500 text-white shadow-2xl shadow-red-500/30 flex items-center justify-center hover:bg-red-600 transition-all active:scale-90 ring-4 ring-red-500/20">
                    <span class="material-symbols-outlined text-4xl rotate-[135deg]">call</span>
                </div>
                <span class="text-sm font-bold text-red-400 uppercase tracking-widest">Akhiri Panggilan</span>
            </a>
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
