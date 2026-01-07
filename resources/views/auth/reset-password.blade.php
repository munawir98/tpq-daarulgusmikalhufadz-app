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
    <title>Reset Kata Sandi - TPQ Digital</title>

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
        }
    </style>
</head>


<!-- Headline & Illustration -->
<div class="flex flex-col items-center text-center">
    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-primary/10 mb-5 ring-8 ring-primary/5">
        <span class="material-symbols-outlined text-primary text-[40px]">key</span>
    </div>
    <h1 class="text-[#111813] dark:text-white tracking-tight text-2xl font-bold leading-tight mb-2">
        Buat Kata Sandi Baru
    </h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed max-w-[300px]">
        Masukkan kata sandi baru untuk akun Anda
    </p>
</div>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
<div
    class="w-full p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl text-green-600 dark:text-green-400 text-sm text-center">
    {{ session('success') }}
</div>
@endif

{{-- ERROR MESSAGE --}}
@if($errors->any())
<div
    class="w-full p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-600 dark:text-red-400 text-sm text-center flex items-center justify-center gap-2">
    <span class="material-symbols-outlined text-[20px]">error</span>
    <span>{{ $errors->first() }}</span>
</div>
@endif

<!-- Form Section -->
<form action="/reset-password" method="POST" class="flex flex-col gap-4 w-full">
    @csrf

    <!-- New Password -->
    <div class="flex flex-col w-full gap-2">
        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">
            Kata Sandi Baru
        </label>
        <div class="relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400" style="font-size: 20px;">lock</span>
            </div>
            <input name="password" type="password" id="password" required
                class="block w-full pl-11 pr-12 py-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm placeholder-gray-400 transition-all"
                placeholder="Minimal 8 karakter" />
            <button type="button" onclick="togglePassword('password', this)"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined" style="font-size: 20px;">visibility_off</span>
            </button>
        </div>
    </div>

    <!-- Confirm Password -->
    <div class="flex flex-col w-full gap-2">
        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider ml-1">
            Konfirmasi Kata Sandi
        </label>
        <div class="relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400" style="font-size: 20px;">lock_reset</span>
            </div>
            <input name="password_confirmation" type="password" id="password_confirmation" required
                class="block w-full pl-11 pr-12 py-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm placeholder-gray-400 transition-all"
                placeholder="Ulangi kata sandi baru" />
            <button type="button" onclick="togglePassword('password_confirmation', this)"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined" style="font-size: 20px;">visibility_off</span>
            </button>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl bg-primary hover:bg-[#0fd650] active:bg-[#0ec248] text-[#102216] font-bold text-sm shadow-lg shadow-primary/25 hover:shadow-primary/40 hover:scale-[1.02] transition-all mt-2">
        <span class="material-symbols-outlined" style="font-size: 20px;">save</span>
        Simpan Kata Sandi Baru
    </button>
</form>

<!-- Footer Link -->
<div class="flex justify-center pt-2">
    <a href="/login"
        class="group flex items-center justify-center gap-1.5 text-gray-500 dark:text-gray-400 hover:text-[#111813] dark:hover:text-white transition-colors py-2 text-sm font-medium">
        <span
            class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
        <span>Kembali ke Login</span>
    </a>
</div>
</div>

<!-- Bottom decorative branding -->
<div class="mt-6 flex items-center gap-2 opacity-40 justify-center">
    <span class="material-symbols-outlined text-[#111813] dark:text-white text-[16px]">verified_user</span>
    <p class="text-xs font-semibold text-[#111813] dark:text-white tracking-widest uppercase">TPQ Secure
        Access</p>
</div>
</div>
</div>

<script>
    // Dark mode check
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }

    // Toggle password visibility
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('.material-symbols-outlined');
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility_off';
        }
    }
</script>
</body>

</html>
