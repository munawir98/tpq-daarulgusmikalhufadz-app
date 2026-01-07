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
    <title>Verifikasi Kode - TPQ Digital</title>

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

{{-- ERROR MESSAGE --}}
@if($errors->any())
<div
    class="w-full p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl text-red-600 dark:text-red-400 text-sm text-center flex items-center justify-center gap-2">
    <span class="material-symbols-outlined text-[20px]">error</span>
    <span>{{ $errors->first() }}</span>
</div>
@endif

{{-- DEBUG: Show OTP for testing (remove in production) --}}
@if(config('app.debug') && session('reset_otp'))
<div
    class="w-full p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl text-blue-600 dark:text-blue-400 text-sm text-center">
    <p class="font-medium mb-1">🔧 Mode Testing</p>
    <p>Kode OTP: <span class="font-bold text-xl tracking-widest">{{ session('reset_otp') }}</span></p>
    <p class="text-xs mt-1 opacity-70">(Hapus ini di production)</p>
</div>
@endif

<!-- Form Section -->
<form action="/verify-otp" method="POST" id="otpForm" class="flex flex-col gap-4 w-full">
    @csrf

    <!-- OTP Inputs -->
    <div class="flex justify-center w-full">
        <fieldset class="relative flex gap-3 justify-center">
            <input name="otp1" autofocus
                class="flex h-16 w-14 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-center text-2xl font-bold text-[#111813] dark:text-white shadow-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50 transition-all caret-primary placeholder-gray-300 dark:placeholder-gray-600"
                inputmode="numeric" maxlength="1" pattern="[0-9]*" type="text" />
            <input name="otp2"
                class="flex h-16 w-14 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-center text-2xl font-bold text-[#111813] dark:text-white shadow-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50 transition-all caret-primary placeholder-gray-300 dark:placeholder-gray-600"
                inputmode="numeric" maxlength="1" pattern="[0-9]*" type="text" />
            <input name="otp3"
                class="flex h-16 w-14 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-center text-2xl font-bold text-[#111813] dark:text-white shadow-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50 transition-all caret-primary placeholder-gray-300 dark:placeholder-gray-600"
                inputmode="numeric" maxlength="1" pattern="[0-9]*" type="text" />
            <input name="otp4"
                class="flex h-16 w-14 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-center text-2xl font-bold text-[#111813] dark:text-white shadow-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/50 transition-all caret-primary placeholder-gray-300 dark:placeholder-gray-600"
                inputmode="numeric" maxlength="1" pattern="[0-9]*" type="text" />
        </fieldset>
    </div>

    <!-- Timer / Resend -->
    <div class="flex flex-col items-center gap-2 mt-2">
        <div id="timerContainer"
            class="flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-gray-900 rounded-full border border-gray-100 dark:border-gray-800">
            <span class="material-symbols-outlined text-gray-500 text-[18px]">timer</span>
            <p class="text-gray-600 dark:text-gray-300 text-sm font-medium">
                Kirim ulang dalam <span id="countdown" class="text-primary font-bold tabular-nums">00:30</span>
            </p>
        </div>
        <button type="button" id="resendBtn"
            class="hidden text-sm font-bold text-primary hover:text-green-500 transition-colors py-2">
            Kirim Ulang Kode
        </button>
    </div>

    <!-- Submit Button -->
    <button type="submit"
        class="w-full flex items-center justify-center gap-2 py-3.5 rounded-2xl bg-primary hover:bg-[#0fd650] active:bg-[#0ec248] text-[#102216] font-bold text-sm shadow-lg shadow-primary/25 hover:shadow-primary/40 hover:scale-[1.02] transition-all mt-2">
        <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
        Verifikasi Kode
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

    // Auto-focus for OTP inputs
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            if (e.target.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    // Countdown timer
    let timeLeft = 30;
    const countdownEl = document.getElementById('countdown');
    const timerContainer = document.getElementById('timerContainer');
    const resendBtn = document.getElementById('resendBtn');

    const timer = setInterval(() => {
        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        countdownEl.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        if (timeLeft <= 0) {
            clearInterval(timer);
            timerContainer.classList.add('hidden');
            resendBtn.classList.remove('hidden');
        }
    }, 1000);

    resendBtn.addEventListener('click', () => {
        alert('Kode verifikasi baru telah dikirim!');
        timeLeft = 30;
        timerContainer.classList.remove('hidden');
        resendBtn.classList.add('hidden');
    });
</script>
</body>

</html>
