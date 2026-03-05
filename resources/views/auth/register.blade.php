<!DOCTYPE html>
<html lang="id">
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#4A90B8">
    <title>Daftar Akun Baru</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
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
            animation: fadeIn 0.6s ease-out forwards;
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

<body class="min-h-screen overflow-auto bg-gray-100 dark:bg-gray-900 font-display no-scrollbar">

    {{-- DESKTOP LAYOUT: Split Screen --}}
    <div class="h-screen w-screen overflow-hidden flex flex-col lg:flex-row">

        {{-- LEFT PANEL - BRANDING (Hidden on mobile) --}}
        <div
            class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] items-center justify-center p-12 sticky top-0 h-screen">
            <div class="absolute inset-0 islamic-pattern opacity-20"></div>
            <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-[#2A5A78] rounded-full blur-3xl opacity-40">
            </div>

            <div class="relative z-10 text-center max-w-md">
                <img src="{{ asset('logo-tpq.png') }}" alt="Logo"
                    class="w-40 h-40 object-contain mx-auto mb-8 drop-shadow-2xl">
                <h1 class="text-4xl font-bold text-white mb-4">TPQ Daarul Gusmik<br>Al-Hufadz</h1>
                <p class="text-lg text-white/80 leading-relaxed">Bergabunglah bersama komunitas TPQ kami untuk
                    pengalaman belajar Al-Qur'an yang lebih baik.</p>

                {{-- Features List --}}
                <div class="mt-10 space-y-4 text-left">
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="material-symbols-rounded text-white text-2xl">school</span>
                        <div>
                            <h3 class="text-white font-semibold">Untuk Santri</h3>
                            <p class="text-white/70 text-sm">Pantau perkembangan hafalan Anda</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="material-symbols-rounded text-white text-2xl">supervisor_account</span>
                        <div>
                            <h3 class="text-white font-semibold">Untuk Ustadz</h3>
                            <p class="text-white/70 text-sm">Kelola santri dan hafalan dengan mudah</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                        <span class="material-symbols-rounded text-white text-2xl">verified</span>
                        <div>
                            <h3 class="text-white font-semibold">Gratis & Aman</h3>
                            <p class="text-white/70 text-sm">Data tersimpan dengan enkripsi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL - REGISTER FORM --}}
        <div class="w-full lg:w-1/2 xl:w-[45%] h-full relative overflow-hidden bg-gray-100 lg:bg-transparent">

            {{-- Mobile Background (Fixed) --}}
            <div class="lg:hidden absolute inset-0 bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] z-0">
                <div class="absolute inset-0 islamic-pattern opacity-30"></div>
                {{-- Removed heavy blur effects for performance --}}
            </div>

            {{-- Scrollable Content Wrapper --}}
            <div class="absolute inset-0 overflow-y-auto no-scrollbar z-10">
                <div class="min-h-full w-full flex flex-col items-center justify-start px-4 pt-2 pb-6 lg:p-8">

                    {{-- Form Card --}}
                    <div class="w-full max-w-md relative">

                        {{-- LOGO (Mobile Only) --}}
                        <div class="lg:hidden flex justify-center -mb-4 mt-2">
                            <img src="{{ asset('logo-tpq.png') }}" alt="Logo"
                                class="w-24 h-24 object-contain drop-shadow-lg">
                        </div>

                        {{-- TITLE --}}
                        <div class="text-center mb-6">
                            <h1
                                class="text-xl lg:text-3xl font-bold text-white lg:text-gray-800 dark:lg:text-white tracking-tight">
                                Buat Akun Baru
                            </h1>
                            <p class="text-xs text-white/80 lg:text-gray-500 dark:lg:text-gray-400 mt-1">
                                Bergabung bersama keluarga besar Yayasan
                            </p>
                        </div>

                        {{-- CARD CONTAINER FOR FORM --}}
                        <div
                            class="bg-white/10 lg:bg-white dark:lg:bg-surface-dark backdrop-blur-md lg:backdrop-blur-none border border-white/20 lg:border-gray-200 dark:lg:border-gray-700 rounded-3xl p-5 lg:p-8 shadow-xl lg:shadow-2xl">

                            {{-- ERROR ALERTS --}}
                            @if ($errors->any())
                            <div class="mb-6 rounded-2xl bg-red-500/20 border border-red-500/30 p-4">
                                <div class="flex items-start gap-3">
                                    <span class="material-symbols-rounded text-red-100 mt-0.5">error</span>
                                    <ul class="text-xs text-white space-y-1">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            {{-- FORM --}}
                            <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-2.5">
                                @csrf
                                {{-- FORM FIELDS --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                                    {{-- NAMA LENGKAP --}}
                                    <div class="group">
                                        <label
                                            class="block text-[10px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1 ml-1">Nama
                                            Lengkap</label>
                                        <div class="relative">
                                            <span
                                                class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-white transition-colors">person</span>
                                            <input name="name" type="text" required placeholder="Contoh: Ahmad Fulan"
                                                class="w-full h-[40px] lg:h-[52px] rounded-xl bg-gray-200/30 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-4 text-xs font-medium text-white lg:text-gray-800 dark:lg:text-white placeholder-white/50 lg:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm" />
                                        </div>
                                    </div>

                                    {{-- EMAIL --}}
                                    <div class="group">
                                        <label
                                            class="block text-[10px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1 ml-1">Email</label>
                                        <div class="relative">
                                            <span
                                                class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-white transition-colors">mail</span>
                                            <input name="email" type="email" required placeholder="nama@email.com"
                                                class="w-full h-[40px] lg:h-[52px] rounded-xl bg-gray-200/30 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-4 text-xs font-medium text-white lg:text-gray-800 dark:lg:text-white placeholder-white/50 lg:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm" />
                                        </div>
                                    </div>

                                    {{-- STATUS --}}
                                    <div class="group">
                                        <label
                                            class="block text-[10px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1 ml-1">Status
                                            Pendaftar</label>
                                        <div class="relative">
                                            <span
                                                class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-white transition-colors">badge</span>
                                            <select name="role" id="roleSelect" required onchange="togglePembimbing()"
                                                class="w-full h-[40px] lg:h-[52px] appearance-none rounded-xl bg-gray-200/30 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-4 text-xs font-medium text-white lg:text-gray-800 dark:lg:text-white focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm cursor-pointer [&>option]:bg-[#2E6B8A] lg:[&>option]:bg-white lg:[&>option]:text-gray-800 [&>option]:text-white">
                                                <option value="" disabled selected class="text-gray-400">Pilih Status
                                                </option>
                                                <option value="SANTRI" {{ old('role')=='SANTRI' ? 'selected' : '' }}>
                                                    Santri
                                                </option>
                                                <option value="USTADZ" {{ old('role')=='USTADZ' ? 'selected' : '' }}>
                                                    Ustadz
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- PEMBIMBING (Only for Santri) --}}
                                    <div id="pembimbingSection" class="group transition-all duration-300"
                                        style="display: none;">
                                        <label
                                            class="block text-[10px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1 ml-1">Ustadz
                                            Pembimbing</label>
                                        <div class="relative">
                                            <span
                                                class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-white transition-colors">school</span>
                                            <select name="pembimbing_nip" id="pembimbingSelect"
                                                class="w-full h-[40px] lg:h-[52px] appearance-none rounded-xl bg-gray-200/30 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-10 text-xs font-medium text-white lg:text-gray-800 dark:lg:text-white focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm cursor-pointer [&>option]:bg-[#2E6B8A] lg:[&>option]:bg-white lg:[&>option]:text-gray-800 [&>option]:text-white">
                                                <option value="" disabled selected class="text-gray-400">Pilih Ustadz
                                                </option>
                                                @if(isset($ustadazList))
                                                @foreach($ustadazList as $ustadz)
                                                <option value="{{ $ustadz->nip }}" {{ old('pembimbing_nip')==$ustadz->
                                                    nip ?
                                                    'selected' : ''
                                                    }}>
                                                    {{ $ustadz->name }}
                                                </option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span
                                                class="material-symbols-rounded absolute right-4 top-1/2 -translate-y-1/2 text-[20px] text-white/80 lg:text-gray-400 pointer-events-none">expand_more</span>
                                        </div>
                                        <p class="text-[10px] text-white/60 lg:text-gray-500 mt-1 ml-1">* Khusus Santri
                                            wajib
                                            memilih pembimbing</p>
                                    </div>

                                    {{-- PASSWORD & CONFIRM PASSWORD (Stacked) --}}
                                    <div class="space-y-2.5">
                                        <div class="group">
                                            <label
                                                class="block text-[10px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1 ml-1">Kata
                                                Sandi</label>
                                            <div class="relative">
                                                <span
                                                    class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-white transition-colors">lock</span>
                                                <input id="password" name="password" type="password" required
                                                    placeholder="Min 8 kar."
                                                    class="w-full h-[40px] lg:h-[52px] rounded-xl bg-gray-200/30 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-8 text-xs font-medium text-white lg:text-gray-800 dark:lg:text-white placeholder-white/50 lg:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm" />
                                                <button type="button" onclick="togglePassword()"
                                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-white lg:text-gray-400 hover:text-white lg:hover:text-primary transition-colors">
                                                    <span id="passwordIcon"
                                                        class="material-symbols-rounded text-[18px]">visibility_off</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="group pb-6">
                                            <label
                                                class="block text-[10px] font-bold text-white/80 lg:text-gray-600 dark:lg:text-gray-400 uppercase tracking-wider mb-1 ml-1">Ulangi
                                                Sandi</label>
                                            <div class="relative">
                                                <span
                                                    class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-[18px] text-white transition-colors">lock_reset</span>
                                                <input id="password_confirmation" name="password_confirmation"
                                                    type="password" required placeholder="Ulangi"
                                                    class="w-full h-[40px] lg:h-[52px] rounded-xl bg-gray-200/30 lg:bg-gray-50 dark:lg:bg-gray-800 border border-white/20 lg:border-gray-300 dark:lg:border-gray-600 pl-12 pr-8 text-xs font-medium text-white lg:text-gray-800 dark:lg:text-white placeholder-white/50 lg:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30 lg:focus:ring-primary/30 focus:border-white/50 lg:focus:border-primary transition-all shadow-sm" />
                                                <button type="button" onclick="togglePasswordConfirm()"
                                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-white lg:text-gray-400 hover:text-white lg:hover:text-primary transition-colors">
                                                    <span id="passwordConfirmIcon"
                                                        class="material-symbols-rounded text-[18px]">visibility_off</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BUTTON --}}
                                    <button id="registerButton" type="submit"
                                        class="mt-4 w-full h-[42px] bg-white lg:bg-gradient-to-r lg:from-primary lg:to-primary-dark text-primary lg:text-white hover:bg-white/90 lg:hover:shadow-lg lg:hover:shadow-primary/30 rounded-xl font-bold text-xs shadow-lg shadow-black/10 transform active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
                                        <span id="btnText">Buat Akun</span>
                                        <span id="arrowIcon"
                                            class="material-symbols-rounded text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                        <svg id="loadingSpinner"
                                            class="hidden animate-spin h-5 w-5 text-primary lg:text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4" />
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                                        </svg>
                                    </button>
                            </form>

                            <div class="mt-4 text-center">
                                <p class="text-[13px] text-white/80 lg:text-gray-600 dark:lg:text-gray-400">Sudah punya
                                    akun?
                                    <a href="{{ route('login.form') }}"
                                        class="font-bold text-white lg:text-primary hover:underline transition-colors">Masuk
                                        disini</a>
                                </p>
                            </div>
                        </div>

                        {{-- COPYRIGHT --}}
                        <div
                            class="text-center mt-8 text-[10px] text-white/40 lg:text-gray-400 font-medium tracking-wide">
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
                icon.classList.add('text-primary');
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
                icon.classList.remove('text-primary');
            }
        }

        function togglePasswordConfirm() {
            const input = document.getElementById('password_confirmation');
            const icon = document.getElementById('passwordConfirmIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
                icon.classList.add('text-primary');
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
                icon.classList.remove('text-primary');
            }
        }

        // Loading State
        document.getElementById('registerForm').addEventListener('submit', function () {
            const btn = document.getElementById('registerButton');
            document.getElementById('btnText').textContent = 'Memproses...';
            document.getElementById('arrowIcon').classList.add('hidden');
            document.getElementById('loadingSpinner').classList.remove('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });

        // Toggle Pembimbing Visibility
        function togglePembimbing() {
            const role = document.getElementById('roleSelect').value;
            const section = document.getElementById('pembimbingSection');
            const select = document.getElementById('pembimbingSelect');

            if (role === 'SANTRI') {
                section.style.display = 'block';
                select.setAttribute('required', 'required');
            } else {
                section.style.display = 'none';
                select.removeAttribute('required');
                select.value = "";
            }
        }

        // Logic for Fullscreen on Mobile
        document.addEventListener('DOMContentLoaded', () => {
            // Initial state check
            togglePembimbing();

            // Attempt to hide mobile address bar by scrolling
            setTimeout(() => {
                window.scrollTo(0, 1);
            }, 100);

            // Logic to request Fullscreen on first interaction
            const goFullscreen = () => {
                const doc = window.document;
                const docEl = doc.documentElement;

                const requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;

                if (requestFullScreen && !doc.fullscreenElement && window.innerWidth < 1024) {
                    requestFullScreen.call(docEl).catch(err => {
                        // Fail silently if user interaction is insufficient
                        // console.log("Fullscreen request failed based on standard logic.", err);
                    });
                }

                // Remove listener after first attempt to avoid annoyance
                document.body.removeEventListener('click', goFullscreen);
                document.body.removeEventListener('touchstart', goFullscreen);
            };

            // Add listener to the body for broad capture on first tap
            document.body.addEventListener('click', goFullscreen);
            document.body.addEventListener('touchstart', goFullscreen);
        });
    </script>
</body>

</html>
