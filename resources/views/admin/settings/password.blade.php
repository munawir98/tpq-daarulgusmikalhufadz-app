<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Ubah Kata Sandi - TPQ Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-[#111813] dark:text-white transition-colors duration-200">
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl">

        <!-- Header -->
        <header
            class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center justify-center px-5 py-4">
                <h2 class="text-xl font-bold">Ubah Kata Sandi</h2>
            </div>
            <main class="flex flex-col flex-1 px-5 pt-6 pb-20 overflow-y-auto">

                @if(session('success'))
                <div
                    class="mb-4 p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 text-sm font-medium">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div
                    class="mb-4 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-sm">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form action="/admin/settings/password" method="POST" class="flex flex-col h-full gap-3">
                    @csrf

                    <!-- Current Password -->
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1" for="current_password">
                            Kata Sandi Saat Ini
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <span
                                    class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                                    style="font-size: 20px;">lock</span>
                            </div>
                            <input
                                class="block w-full pl-11 pr-12 py-3.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all dark:text-white"
                                id="current_password" name="current_password" placeholder="Masukkan kata sandi lama"
                                type="password" required />
                            <button type="button" onclick="togglePassword('current_password', this)"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                                <span class="material-symbols-outlined" style="font-size: 20px;">visibility_off</span>
                            </button>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-800 my-0 border-dashed" />

                    <!-- New Passwords -->
                    <div class="flex flex-col gap-3">
                        <!-- New Password -->
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1" for="password">
                                Kata Sandi Baru
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span
                                        class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                                        style="font-size: 20px;">key</span>
                                </div>
                                <input
                                    class="block w-full pl-11 pr-12 py-3.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all dark:text-white"
                                    id="password" name="password" placeholder="Masukkan kata sandi baru" type="password"
                                    required oninput="checkPasswordStrength(this.value)" />
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                                    <span class="material-symbols-outlined"
                                        style="font-size: 20px;">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <!-- Password Strength -->
                        <div
                            class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex justify-between items-center mb-3">
                                <span
                                    class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kekuatan
                                    Kata Sandi</span>
                                <span id="strengthLabel" class="text-xs font-bold text-gray-400">Belum ada</span>
                            </div>
                            <div class="flex gap-1.5 h-1.5 w-full mb-4">
                                <div id="bar1"
                                    class="h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all duration-300">
                                </div>
                                <div id="bar2"
                                    class="h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all duration-300">
                                </div>
                                <div id="bar3"
                                    class="h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all duration-300">
                                </div>
                                <div id="bar4"
                                    class="h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700 transition-all duration-300">
                                </div>
                            </div>
                            <ul id="requirementsList" class="space-y-2">
                                <li id="check1" class="flex items-center gap-2.5 transition-all duration-300">
                                    <div
                                        class="p-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                                    </div>
                                    <span class="text-xs text-gray-600 dark:text-gray-300">Minimal 8 karakter</span>
                                </li>
                                <li id="check2" class="flex items-center gap-2.5 transition-all duration-300">
                                    <div
                                        class="p-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                                    </div>
                                    <span class="text-xs text-gray-600 dark:text-gray-300">Mengandung huruf besar &
                                        kecil</span>
                                </li>
                                <li id="check3" class="flex items-center gap-2.5 transition-all duration-300">
                                    <div
                                        class="p-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-500 dark:text-red-400">
                                        <span class="material-symbols-outlined" style="font-size: 14px;">close</span>
                                    </div>
                                    <span class="text-xs text-gray-600 dark:text-gray-300">Mengandung angka atau
                                        simbol</span>
                                </li>
                            </ul>
                            <!-- Success message when all requirements met -->
                            <div id="allPassedMessage"
                                class="hidden flex items-center gap-2 text-green-600 dark:text-green-400">
                                <span class="material-symbols-outlined" style="font-size: 20px;">verified</span>
                                <span class="text-sm font-medium">Semua syarat terpenuhi!</span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-bold text-gray-700 dark:text-gray-300 ml-1"
                                for="password_confirmation">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span
                                        class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors"
                                        style="font-size: 20px;">lock_reset</span>
                                </div>
                                <input
                                    class="block w-full pl-11 pr-12 py-3.5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all dark:text-white"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulangi kata sandi baru" type="password" required />
                                <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 focus:outline-none">
                                    <span class="material-symbols-outlined"
                                        style="font-size: 20px;">visibility_off</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-auto pt-6">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 p-4 rounded-2xl bg-primary text-[#102216] font-bold text-sm shadow-lg shadow-green-500/20 hover:shadow-green-500/30 hover:scale-[1.02] transition-all">
                            <span class="material-symbols-outlined" style="font-size: 20px;">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </main>
    </div>

    <script>
        // Dark mode check
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function () {
            // Password input listener
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function () {
                    checkPasswordStrength(this.value);
                });
            }
        });

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

        // Check password strength
        function checkPasswordStrength(password) {
            console.log('Password:', password, 'Length:', password.length);

            var bar1 = document.getElementById('bar1');
            var bar2 = document.getElementById('bar2');
            var bar3 = document.getElementById('bar3');
            var bar4 = document.getElementById('bar4');
            var label = document.getElementById('strengthLabel');

            var check1 = document.getElementById('check1');
            var check2 = document.getElementById('check2');
            var check3 = document.getElementById('check3');

            var strength = 0;

            // Check 1: minimum 8 characters
            var hasLength = password.length >= 8;
            console.log('Has 8+ chars:', hasLength);
            updateCheck(check1, hasLength);
            if (hasLength) strength++;

            // Check 2: has uppercase AND lowercase
            var hasLower = /[a-z]/.test(password);
            var hasUpper = /[A-Z]/.test(password);
            var hasCase = hasLower && hasUpper;
            console.log('Has case:', hasCase, 'Lower:', hasLower, 'Upper:', hasUpper);
            updateCheck(check2, hasCase);
            if (hasCase) strength++;

            // Check 3: has number OR symbol
            var hasNumber = /[0-9]/.test(password);
            var hasSymbol = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            var hasNumberSymbol = hasNumber || hasSymbol;
            console.log('Has number/symbol:', hasNumberSymbol, 'Number:', hasNumber, 'Symbol:', hasSymbol);
            updateCheck(check3, hasNumberSymbol);
            if (hasNumberSymbol) strength++;

            // Bonus for 12+ characters
            if (password.length >= 12) strength++;

            // Update strength bars
            var barColors = {
                1: 'bg-red-500',
                2: 'bg-orange-500',
                3: 'bg-yellow-500',
                4: 'bg-green-500'
            };

            var strengthTexts = {
                0: { text: 'Belum ada', color: 'text-gray-400' },
                1: { text: 'Lemah', color: 'text-red-500' },
                2: { text: 'Sedang', color: 'text-orange-500' },
                3: { text: 'Kuat', color: 'text-yellow-500' },
                4: { text: 'Sangat Kuat', color: 'text-green-500' }
            };

            var colorClass = barColors[strength] || 'bg-gray-200';

            // Reset all bars first
            bar1.className = 'h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700';
            bar2.className = 'h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700';
            bar3.className = 'h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700';
            bar4.className = 'h-full flex-1 rounded-full bg-gray-200 dark:bg-gray-700';

            // Fill bars based on strength
            if (strength >= 1) bar1.className = 'h-full flex-1 rounded-full ' + colorClass;
            if (strength >= 2) bar2.className = 'h-full flex-1 rounded-full ' + colorClass;
            if (strength >= 3) bar3.className = 'h-full flex-1 rounded-full ' + colorClass;
            if (strength >= 4) bar4.className = 'h-full flex-1 rounded-full ' + colorClass;

            // Update label
            var info = strengthTexts[strength] || strengthTexts[0];
            label.textContent = info.text;
            label.className = 'text-xs font-bold ' + info.color;

            console.log('Final strength:', strength);
        }

        function updateCheck(element, passed) {
            if (!element) return;

            if (passed) {
                // Hide the requirement when fulfilled (slide up animation)
                element.style.maxHeight = '0';
                element.style.opacity = '0';
                element.style.marginBottom = '0';
                element.style.overflow = 'hidden';
            } else {
                // Show the requirement when not fulfilled
                element.style.maxHeight = '50px';
                element.style.opacity = '1';
                element.style.marginBottom = '';
                element.style.overflow = '';
            }

            // Check if all requirements are met
            var check1 = document.getElementById('check1');
            var check2 = document.getElementById('check2');
            var check3 = document.getElementById('check3');
            var allPassedMessage = document.getElementById('allPassedMessage');
            var requirementsList = document.getElementById('requirementsList');

            var allHidden = (check1.style.opacity === '0' && check2.style.opacity === '0' && check3.style.opacity === '0');

            if (allHidden) {
                requirementsList.classList.add('hidden');
                allPassedMessage.classList.remove('hidden');
                allPassedMessage.classList.add('flex');
            } else {
                requirementsList.classList.remove('hidden');
                allPassedMessage.classList.add('hidden');
                allPassedMessage.classList.remove('flex');
            }
        }
    </script>
</body>

</html>
