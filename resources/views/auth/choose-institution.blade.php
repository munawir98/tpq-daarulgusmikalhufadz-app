<!DOCTYPE html>
<html lang="id">
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Lembaga - Daarul Gusmik</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#4A90B8",
                        "primary-dark": "#2E6B8A",
                        "background-dark": "#121212",
                        "surface-dark": "#1E1E1E",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"]
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .islamic-pattern {
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.03) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.03) 50%, rgba(255, 255, 255, 0.03) 75%, transparent 75%, transparent);
            background-size: 25px 25px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                0 8px 25px -8px rgba(0, 0, 0, 0.3),
                inset 0 1px 1px 0 rgba(255, 255, 255, 0.1);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow:
                0 15px 35px -12px rgba(0, 0, 0, 0.4),
                inset 0 1px 2px 0 rgba(255, 255, 255, 0.2);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .float-animation {
            animation: float 4s ease-in-out infinite;
        }

        .glow-emerald {
            filter: drop-shadow(0 0 6px rgba(16, 185, 129, 0.5));
        }

        .glow-amber {
            filter: drop-shadow(0 0 6px rgba(245, 158, 11, 0.5));
        }

        .glow-indigo {
            filter: drop-shadow(0 0 6px rgba(99, 102, 241, 0.5));
        }

        .glow-cyan {
            filter: drop-shadow(0 0 6px rgba(6, 182, 212, 0.5));
        }

        .glow-rose {
            filter: drop-shadow(0 0 6px rgba(244, 63, 94, 0.5));
        }

        .glow-sky {
            filter: drop-shadow(0 0 6px rgba(14, 165, 233, 0.5));
        }

        .spotlight {
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.08) 0%, transparent 60%);
        }
    </style>
</head>

<body
    class="min-h-screen bg-[#1a3a4d] bg-gradient-to-br from-[#1a3a4d] via-[#152e3d] to-[#0f212c] font-display text-white selection:bg-white/30 overflow-x-hidden">

    {{-- Patterns & Spots --}}
    <div class="fixed inset-0 islamic-pattern pointer-events-none"></div>
    <div class="fixed inset-0 spotlight pointer-events-none opacity-40"></div>
    <div
        class="fixed top-[-15%] right-[-10%] w-[400px] h-[400px] bg-sky-500/10 rounded-full blur-[100px] pointer-events-none">
    </div>
    <div
        class="fixed bottom-[-15%] left-[-10%] w-[400px] h-[400px] bg-emerald-500/5 rounded-full blur-[100px] pointer-events-none">
    </div>

    <div class="relative z-10 container mx-auto px-4 py-6 min-h-screen flex flex-col items-center justify-center">

        {{-- Header --}}
        <div class="text-center mb-8 flex flex-col items-center">
            <div class="relative mb-8">
                <div class="absolute inset-0 bg-white/10 blur-3xl rounded-full scale-125"></div>
                <img src="{{ asset('logo-tpq.png') }}" alt="Logo"
                    class="w-44 h-44 lg:w-64 lg:h-64 object-contain relative z-10 float-animation filter drop-shadow(0 20px 20px rgba(0,0,0,0.4))">
            </div>
            <h1
                class="text-2xl lg:text-3xl font-bold tracking-tight mb-1 text-transparent bg-clip-text bg-gradient-to-b from-white to-white/70">
                Pilih Lembaga
            </h1>
            <p class="text-white/40 text-[10px] lg:text-xs font-medium tracking-wider uppercase">Yayasan Daarul Gusmik
                Al-Hufadz</p>
        </div>

        {{-- Institutions Grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 w-full max-w-2xl">

            {{-- Yayasan --}}
            <a href="{{ route('register.form', ['instansi' => 'yayasan']) }}" class="group">
                <div
                    class="glass-card rounded-[1.5rem] p-4 transition-all duration-500 hover:scale-[1.02] flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center mb-3 transition-all duration-500 group-hover:scale-110 group-hover:bg-blue-500 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                        <span
                            class="material-symbols-rounded text-xl text-blue-400 group-hover:text-white glow-indigo">account_balance</span>
                    </div>
                    <h3 class="text-sm font-bold tracking-wide group-hover:text-blue-300 transition-colors">Yayasan</h3>
                    <p class="hidden lg:block text-white/30 text-[9px] mt-1 leading-tight">Badan Hukum & Pusat</p>
                </div>
            </a>

            {{-- Madrasah --}}
            <a href="{{ route('register.form', ['instansi' => 'madrasah']) }}" class="group">
                <div
                    class="glass-card rounded-[1.5rem] p-4 transition-all duration-500 hover:scale-[1.02] flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center mb-3 transition-all duration-500 group-hover:scale-110 group-hover:bg-amber-500 group-hover:shadow-[0_0_15px_rgba(245,158,11,0.3)]">
                        <span
                            class="material-symbols-rounded text-xl text-amber-400 group-hover:text-white glow-amber">import_contacts</span>
                    </div>
                    <h3 class="text-sm font-bold tracking-wide group-hover:text-amber-300 transition-colors">Madrasah
                    </h3>
                    <p class="hidden lg:block text-white/30 text-[9px] mt-1 leading-tight">Lembaga Pen. Keagamaan</p>
                </div>
            </a>

            {{-- Masjid --}}
            <a href="{{ route('register.form', ['instansi' => 'masjid']) }}" class="group">
                <div
                    class="glass-card rounded-[1.5rem] p-4 transition-all duration-500 hover:scale-[1.02] flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-cyan-500/20 border border-cyan-500/30 flex items-center justify-center mb-3 transition-all duration-500 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:shadow-[0_0_15px_rgba(6,182,212,0.3)]">
                        <span
                            class="material-symbols-rounded text-xl text-cyan-400 group-hover:text-white glow-cyan">synagogue</span>
                    </div>
                    <h3 class="text-sm font-bold tracking-wide group-hover:text-cyan-300 transition-colors">Masjid</h3>
                    <p class="hidden lg:block text-white/30 text-[9px] mt-1 leading-tight">Lembaga Keagamaan</p>
                </div>
            </a>

            {{-- Majelis Taklim --}}
            <a href="{{ route('register.form', ['instansi' => 'majlis']) }}" class="group">
                <div
                    class="glass-card rounded-[1.5rem] p-4 transition-all duration-500 hover:scale-[1.02] flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center mb-3 transition-all duration-500 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:shadow-[0_0_15px_rgba(99,102,241,0.3)]">
                        <span
                            class="material-symbols-rounded text-xl text-indigo-400 group-hover:text-white glow-indigo">diversity_3</span>
                    </div>
                    <h3
                        class="text-sm font-bold tracking-wide group-hover:text-indigo-300 transition-colors text-nowrap">
                        Majelis Taklim</h3>
                    <p class="hidden lg:block text-white/30 text-[9px] mt-1 leading-tight">Lembaga Non-Formal</p>
                </div>
            </a>

            {{-- TPQ --}}
            <a href="{{ route('register.form', ['instansi' => 'tpq']) }}" class="group">
                <div
                    class="glass-card rounded-[1.5rem] p-4 transition-all duration-500 hover:scale-[1.02] flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center mb-3 transition-all duration-500 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:shadow-[0_0_15px_rgba(16,185,129,0.3)]">
                        <span
                            class="material-symbols-rounded text-xl text-emerald-400 group-hover:text-white glow-emerald">school</span>
                    </div>
                    <h3 class="text-sm font-bold tracking-wide group-hover:text-emerald-300 transition-colors">TPQ</h3>
                    <p class="hidden lg:block text-white/30 text-[9px] mt-1 leading-tight">Taman Pendidikan Quran</p>
                </div>
            </a>

            {{-- Language Courses --}}
            <a href="{{ route('register.form', ['instansi' => 'kursus']) }}" class="group">
                <div
                    class="glass-card rounded-[1.5rem] p-4 transition-all duration-500 hover:scale-[1.02] flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 rounded-xl bg-rose-500/20 border border-rose-500/30 flex items-center justify-center mb-3 transition-all duration-500 group-hover:scale-110 group-hover:bg-rose-500 group-hover:shadow-[0_0_15px_rgba(244,63,94,0.3)]">
                        <span
                            class="material-symbols-rounded text-xl text-rose-400 group-hover:text-white glow-rose">translate</span>
                    </div>
                    <h3 class="text-sm font-bold tracking-wide group-hover:text-rose-300 transition-colors">Courses</h3>
                    <p class="hidden lg:block text-white/30 text-[9px] mt-1 leading-tight">Skill & Int. Learning</p>
                </div>
            </a>

        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center">
            <p class="mt-6 text-[8px] text-white/10 font-medium tracking-[0.2em] uppercase">
                &copy; {{ date('Y') }} Yayasan Daarul Gusmik
            </p>
        </div>

    </div>
</body>

</html>
