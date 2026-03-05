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
    <title>Masuk Aplikasi</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#4A90B8",
                        "primary-dark": "#2E6B8A",
                        "header-blue": "#3D7A9E",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"]
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -10px rgba(74, 144, 184, 0.15)',
                        'card': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                    }
                },
            },
        }
    </script>

    <style>
        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes moveBackground {
            from {
                background-position: 0 0;
            }

            to {
                background-position: -40px 0;
            }
        }

        .islamic-pattern {
            background-image:
                linear-gradient(45deg,
                    rgba(255, 255, 255, 0.05) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.05) 50%,
                    rgba(255, 255, 255, 0.05) 75%,
                    transparent 75%,
                    transparent);
            background-size: 40px 40px;
            animation: moveBackground 3s linear infinite;
        }

        /* Faster spin for loading */
        @keyframes spinFast {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-fast {
            animation: spinFast 0.5s linear infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
            /* Sped up from 0.6s to 0.3s */
        }

        /* Custom scrollbar for the "no-scrollbar" class */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-display no-scrollbar">

    {{-- DESKTOP LAYOUT: Split Screen --}}
    <div class="h-screen w-screen overflow-hidden flex flex-col lg:flex-row">

        {{-- LEFT PANEL - BRANDING (Hidden on mobile) --}}
        <div
            class="hidden lg:flex lg:w-1/2 xl:w-[55%] h-full relative bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] items-center justify-center p-12">
            <div class="absolute inset-0 islamic-pattern opacity-20"></div>
            <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-[#2A5A78] rounded-full blur-3xl opacity-40">
            </div>

            <div class="relative z-10 text-center max-w-md">
                <img src="{{ asset('logo-tpq.png') }}" alt="Logo"
                    class="w-40 h-40 object-contain mx-auto mb-8 drop-shadow-2xl">
                <h1 class="text-4xl font-bold text-white mb-4">TPQ Daarul Gusmik<br>Al-Hufadz</h1>
                <p class="text-lg text-white/80 leading-relaxed">Platform Digital untuk Manajemen TPQ Modern. Kelola
                    presensi, hafalan, dan perkembangan santri dengan mudah.</p>

                {{-- Features List --}}
                <div class="mt-10 space-y-4 text-left">
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="material-symbols-rounded text-white text-2xl">fact_check</span>
                        <div>
                            <h3 class="text-white font-semibold">Presensi Digital</h3>
                            <p class="text-white/70 text-sm">Pencatatan kehadiran otomatis & akurat</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="material-symbols-rounded text-white text-2xl">menu_book</span>
                        <div>
                            <h3 class="text-white font-semibold">Tracking Hafalan</h3>
                            <p class="text-white/70 text-sm">Pantau progress hafalan secara real-time</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="material-symbols-rounded text-white text-2xl">analytics</span>
                        <div>
                            <h3 class="text-white font-semibold">Laporan Lengkap</h3>
                            <p class="text-white/70 text-sm">Statistik & laporan komprehensif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL - LOGIN FORM --}}
        <div class="w-full lg:w-1/2 xl:w-[45%] h-full relative overflow-hidden bg-gray-100 lg:bg-transparent">

            {{-- Mobile Background (Fixed) --}}
            <div class="lg:hidden absolute inset-0 bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] z-0">
                <div class="absolute inset-0 islamic-pattern opacity-30"></div>
                <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-[#2A5A78] rounded-full blur-3xl opacity-40">
                </div>
            </div>

            {{-- Fixed Content Wrapper (No Scroll) --}}
            <div class="absolute inset-0 overflow-hidden z-10">
                <div class="h-full w-full flex flex-col items-center justify-center px-4">

                    {{-- Form Card --}}
                    <div class="w-full max-w-md relative">

                        {{-- LOGO (Mobile Only) --}}
                        <div class="lg:hidden flex justify-center -mb-4 mt-6">
                            <img src="{{ asset('logo-tpq.png') }}" alt="Logo"
                                class="w-28 h-28 object-contain drop-shadow-lg">
                        </div>

                        {{-- TITLE --}}
                        <div class="text-center mb-6">
                            <h1
                                class="text-xl lg:text-2xl font-bold text-white lg:text-gray-800 dark:lg:text-white tracking-tight">
                                Selamat Datang</h1>
                            <p class="text-sm text-white/80 lg:text-gray-500 dark:lg:text-gray-400 mt-1">Silahkan
                                masuk untuk
                                melanjutkan</p>
                        </div>

                        {{-- CARD CONTAINER FOR FORM --}}
                        <div
                            class="bg-white/10 lg:bg-white dark:lg:bg-surface-dark backdrop-blur-md lg:backdrop-blur-none border border-white/20 lg:border-gray-200 dark:lg:border-gray-700 rounded-3xl px-6 py-10 lg:p-8 shadow-xl lg:shadow-2xl">

                            {{-- SUCCESS ALERT --}}
                            @if (session('success'))
                            <div
                                class="mb-6 rounded-2xl bg-green-500/20 border border-green-500/30 p-4 flex items-center gap-3">
                                <span class="material-symbols-rounded text-green-100">check_circle</span>
                                <p class="text-xs font-medium text-white">{{ session('success') }}</p>
                            </div>
                            @endif

                            {{-- ERROR ALERT --}}
                            @if ($errors->any())
                            <div
                                class="mb-6 rounded-2xl bg-red-500/20 border border-red-500/30 p-4 flex items-center gap-3">
                                <span class="material-symbols-rounded text-red-100">error</span>
                                <p class="text-xs font-medium text-white">{{ $errors->first() }}</p>
                            </div>
                            @endif

                            {{-- FORM --}}
                            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-5">
                                @csrf

                                {{-- NIS/EMAIL --}}
                                <div class="group">
                                    <label
                                        class="block text-[11px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">NIS
                                        atau Email</label>
                                    <div class="relative">
                                        <span
                                            class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-white/80 lg:text-gray-400 group-focus-within:text-white lg:group-focus-within:text-primary transition-colors">person</span>
                                        <input id="nis" name="nis" type="text" value="{{ old('nis') }}" required
                                            autofocus placeholder="Masukkan NIS / Email"
                                            class="w-full h-[50px] lg:h-[52px] rounded-2xl bg-white/10 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-4 text-sm font-medium text-white lg:text-gray-800 dark:lg:text-white placeholder-white/50 lg:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm" />
                                    </div>
                                </div>

                                {{-- PASSWORD --}}
                                <div class="group">
                                    <label
                                        class="block text-[11px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1.5 ml-1">Kata
                                        Sandi</label>
                                    <div class="relative">
                                        <span
                                            class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-white/80 lg:text-gray-400 group-focus-within:text-white lg:group-focus-within:text-primary transition-colors">lock</span>
                                        <input id="password" name="password" type="password" required
                                            placeholder="Masukkan kata sandi"
                                            class="w-full h-[50px] lg:h-[52px] rounded-2xl bg-white/10 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-12 text-sm font-medium text-white lg:text-gray-800 dark:lg:text-white placeholder-white/50 lg:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm" />
                                        <button type="button" onclick="togglePassword()"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-white/60 lg:text-gray-400 hover:text-white lg:hover:text-primary transition-colors">
                                            <span id="passwordIcon"
                                                class="material-symbols-rounded text-[20px]">visibility_off</span>
                                        </button>
                                    </div>
                                </div>

                                {{-- REMEMBER & FORGOT --}}
                                <div class="flex items-center justify-between text-xs mt-2">
                                    <label class="flex items-center gap-2 cursor-pointer group">
                                        <input type="checkbox" name="remember"
                                            class="rounded border-white/30 lg:border-gray-300 bg-white/10 lg:bg-white text-white lg:text-primary focus:ring-white/30 lg:focus:ring-primary/30 w-4 h-4 cursor-pointer">
                                        <span
                                            class="text-white/80 lg:text-gray-600 dark:lg:text-gray-400 group-hover:text-white lg:group-hover:text-gray-800 transition-colors">Ingat
                                            Saya</span>
                                    </label>
                                    <a href="/forgot-password"
                                        class="font-semibold text-white/90 lg:text-primary hover:text-white lg:hover:text-primary-dark transition-colors">Lupa
                                        Sandi?</a>
                                </div>

                                {{-- BUTTON --}}
                                <button id="loginButton" type="submit"
                                    class="mt-8 w-full h-[56px] bg-white lg:bg-gradient-to-r lg:from-primary lg:to-primary-dark text-primary lg:text-white hover:bg-white/90 lg:hover:shadow-lg lg:hover:shadow-primary/30 rounded-2xl font-bold text-sm shadow-lg shadow-black/10 transform active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
                                    <span id="btnText">Masuk Aplikasi</span>
                                    <span
                                        class="material-symbols-rounded group-hover:translate-x-1 transition-transform">login</span>
                                    <svg id="loadingSpinner"
                                        class="hidden animate-spin-fast h-5 w-5 text-primary lg:text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4" />
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                                    </svg>
                                </button>
                            </form>

                            {{-- FOOTER --}}
                            <div class="mt-6 text-center">
                                <p class="text-sm text-white/80 lg:text-gray-600 dark:lg:text-gray-400">
                                    Belum memiliki akun?
                                    <a href="{{ route('register') }}"
                                        class="font-bold text-white lg:text-primary hover:underline transition-colors">Daftar
                                        Sekarang</a>
                                </p>
                            </div>
                        </div>

                        {{-- COPYRIGHT --}}
                        <div
                            class="text-center mt-6 text-[10px] text-white/40 lg:text-gray-400 font-medium tracking-wide">
                            &copy; {{ date('Y') }} TPQ Daarul Gusmik Al-Hufadz
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('passwordIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('loginButton');
            document.getElementById('btnText').textContent = 'Memproses...';
            document.getElementById('loadingSpinner').classList.remove('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });
    </script>

</body>

</html>
