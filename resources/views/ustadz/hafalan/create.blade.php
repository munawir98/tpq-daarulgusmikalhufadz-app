<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Input Setoran Hafalan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Configuration -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#4A90B8", // Changed from Green to Blue
                        "primary-dark": "#2E6B8A",
                        "header-blue": "#3D7A9E",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1c2e22",
                    },
                    fontFamily: {
                        "display": ["Poppins", "sans-serif"] // Changed from Manrope to Poppins
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

        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Animated Border Glow on Focus */
        @keyframes borderGlow {
            0% {
                box-shadow: 0 0 0 2px rgba(74, 144, 184, 0.3);
            }

            50% {
                box-shadow: 0 0 8px 2px rgba(74, 144, 184, 0.6);
            }

            100% {
                box-shadow: 0 0 0 2px rgba(74, 144, 184, 0.3);
            }
        }

        input:focus,
        textarea:focus,
        select:focus {
            animation: borderGlow 2s ease-in-out infinite;
        }

        /* Subtle shimmer on hover */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .input-shimmer:hover {
            background: linear-gradient(90deg, transparent 0%, rgba(74, 144, 184, 0.05) 50%, transparent 100%);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased text-[#111813] dark:text-white transition-colors duration-200 flex justify-center items-start min-h-screen p-0 sm:py-4">
    <div
        class="relative w-full max-w-[480px] min-h-[100dvh] sm:min-h-0 sm:h-[850px] bg-background-light dark:bg-background-dark rounded-none sm:rounded-[40px] overflow-hidden shadow-none sm:shadow-2xl flex flex-col">

        <!-- Header Background -->
        <div
            class="absolute top-0 left-0 w-full h-[200px] bg-gradient-to-br from-[#4A90B8] via-[#3D7A9E] to-[#2E6B8A] z-0 rounded-b-[40px] overflow-hidden">
            <div class="absolute top-[-50px] right-[-50px] w-64 h-64 bg-[#5BA3CC] rounded-full blur-3xl opacity-60">
            </div>
            <div class="absolute bottom-[-20px] left-[-20px] w-48 h-48 bg-[#2A5A78] rounded-full blur-2xl opacity-50">
            </div>
        </div>

        <!-- Fixed Header Content -->
        <div class="relative z-20 px-4 pt-6 pb-4 text-white shrink-0">
            <div class="flex items-center justify-center">
                <h1 class="text-xl font-bold tracking-tight text-center">Input Setoran</h1>
            </div>
            <!-- Progress Bar -->
            <div class="mt-4 bg-white/20 rounded-full h-2 overflow-hidden">
                <div id="progressBar" class="h-full bg-white rounded-full transition-all duration-500"
                    style="width: 0%;"></div>
            </div>
            <p id="progressText" class="text-center text-white/80 text-xs mt-1">0% Lengkap</p>
        </div>

        <!-- Scrollable Content -->
        <div id="mainContentScroll" class="relative z-10 flex-1 overflow-y-auto no-scrollbar flex flex-col">
            <!-- Form Container -->
            <div class="flex-1 bg-white dark:bg-surface-dark rounded-t-[30px] shadow-soft relative z-20 flex flex-col">

                <!-- Form -->
                <form action="{{ route('ustadz.hafalan.store') }}" method="POST" id="setoranForm"
                    enctype="multipart/form-data" class="flex flex-col flex-1">
                    @csrf

                    <!-- Scrollable Content -->
                    <div class="flex-1 flex flex-col px-4 py-6 gap-6 pb-32">

                        <!-- Error Message -->
                        @if(session('error'))
                        <div
                            class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-red-600 dark:text-red-400 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                        @endif
                        @if($errors->any())
                        <div
                            class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-red-600 dark:text-red-400 text-sm">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        <!-- Santri Selection -->
                        <div class="flex flex-col gap-2">
                            <label
                                class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal ml-3 flex items-center gap-2">Nama
                                Santri <span id="checkSantri" class="hidden text-green-500 material-symbols-rounded"
                                    style="font-size: 16px;">check_circle</span></label>
                            <input type="hidden" name="santri_id" id="santriIdInput" required>
                            <div class="relative">
                                <input type="text" id="santriSearch" placeholder="Cari nama santri"
                                    class="peer flex w-full h-14 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white placeholder:text-gray-400 p-[15px] pr-12 text-sm font-medium leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow"
                                    onfocus="showSantriDropdown()" onclick="showSantriDropdown()"
                                    oninput="filterSantri(this.value)" autocomplete="off" />
                                <div id="santriIcon" onclick="clearSantri(event)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-primary flex items-center justify-center cursor-pointer transition-colors hover:text-red-500">
                                    <span class="material-symbols-rounded" style="font-size: 24px;">search</span>
                                </div>
                                <div id="santriDropdown"
                                    class="hidden absolute left-0 right-0 top-full mt-1 bg-surface-light dark:bg-surface-dark rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 max-h-48 overflow-y-auto z-40">
                                    @foreach($santriList as $santri)
                                    <button type="button"
                                        onclick="selectSantri(this.getAttribute('data-id'), this.getAttribute('data-name'))"
                                        data-id="{{ $santri->id }}" data-name="{{ $santri->name }}"
                                        class="santri-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-primary/10 transition-colors"
                                        data-search="{{ strtolower($santri->name) }}">
                                        <div
                                            class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">
                                            {{ substr($santri->name, 0, 1) }}</div>
                                        <span class="text-sm font-medium flex-1">{{ $santri->name }}</span>
                                    </button>
                                    @endforeach
                                    <div id="santriEmpty" class="hidden px-4 py-4 text-center text-gray-400 text-sm">
                                        Tidak
                                        ditemukan</div>
                                </div>
                            </div>
                            <!-- Auto-fill Banner -->
                            <div id="autoFillInfo"
                                class="hidden py-1.5 px-3 bg-blue-50/70 dark:bg-blue-900/30 backdrop-blur-md rounded-xl flex items-center gap-2 border border-blue-100/50 dark:border-blue-800/50 overflow-hidden shadow-sm">
                                <span class="material-symbols-rounded text-primary flex-shrink-0"
                                    style="font-size: 14px;">info</span>
                                <div class="overflow-hidden w-full relative h-[16px]">
                                    <span id="autoFillText"
                                        class="text-[10px] text-primary font-medium whitespace-nowrap absolute animate-marquee"
                                        style="animation: marquee 20s linear infinite;"></span>
                                </div>
                            </div>
                            <style>
                                @keyframes marquee {
                                    0% {
                                        transform: translateX(0%);
                                    }

                                    100% {
                                        transform: translateX(-100%);
                                    }
                                }

                                .animate-marquee {
                                    display: inline-block;
                                    padding-right: 20%;
                                    /* Add spacer at end */
                                }

                                @keyframes breathing {
                                    0% {
                                        transform: scale(1);
                                        box-shadow: 0 0 0 rgba(0, 0, 0, 0);
                                    }

                                    50% {
                                        transform: scale(1.02);
                                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                                    }

                                    100% {
                                        transform: scale(1);
                                        box-shadow: 0 0 0 rgba(0, 0, 0, 0);
                                    }
                                }
                            </style>
                        </div>



                        <!-- Hafalan Details -->
                        <div id="hafalanSection" class="scroll-mt-5 flex flex-col gap-4">
                            <div class="flex items-center justify-between">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal ml-3 flex items-center gap-2">Materi
                                    Hafalan <span id="checkSurah" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span></label>
                            </div>

                            <!-- Surah Searchable Dropdown -->
                            <div class="relative">
                                <input type="hidden" name="surah" id="surahInput" required>
                                <input type="text" id="surahSearch" placeholder="Cari surah (contoh: Al-Baqarah)"
                                    disabled
                                    class="peer flex w-full h-12 rounded-xl border-none bg-background-light dark:bg-background-dark text-[#111813] dark:text-white px-[15px] pr-10 text-sm font-medium leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed"
                                    onfocus="showSurahDropdown()" onclick="showSurahDropdown()"
                                    oninput="filterSurah(this.value)" autocomplete="off" />
                                <div id="surahIcon" onclick="clearSurah(event)"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 flex items-center justify-center cursor-pointer transition-colors hover:text-red-500">
                                    <span class="material-symbols-rounded"
                                        style="font-size: 24px;">keyboard_arrow_down</span>
                                </div>
                                <div id="surahDropdown"
                                    class="hidden absolute left-0 right-0 top-full mt-2 bg-white dark:bg-surface-dark rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 max-h-60 overflow-y-auto z-40">
                                    <!-- Populated by JS -->
                                    <div id="surahListContainer"></div>
                                    <div id="surahEmpty" class="hidden px-4 py-4 text-center text-gray-400 text-xs">
                                        Tidak ditemukan</div>
                                </div>
                            </div>

                            <!-- Ayat Range -->
                            <!-- Ayat Range -->
                            <div class="flex flex-col gap-4">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal ml-3 flex items-center gap-2">Rentang
                                    Ayat <span id="checkAyat" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span></label>
                                <div class="relative flex items-center gap-2">
                                    <!-- Left Button (+ Start) -->
                                    <button type="button" onclick="adjustAyat('ayat_awal', 1); highlightStepBtn(this)"
                                        disabled
                                        class="stepper-btn ayat-btn size-12 flex shrink-0 items-center justify-center rounded-xl bg-surface-light dark:bg-surface-dark ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span
                                            class="material-symbols-rounded text-gray-600 dark:text-gray-400">add</span>
                                    </button>

                                    <!-- Start Input -->
                                    <input name="ayat_awal" type="number" min="0" required placeholder="Awal" value="0"
                                        disabled oninput="syncAyatManual(this.value)"
                                        class="ayat-input flex-1 w-full h-12 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] text-center text-base font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed" />

                                    <!-- Middle Button (- End) -->
                                    <button type="button" onclick="adjustAyat('ayat_akhir', -1); highlightStepBtn(this)"
                                        disabled
                                        class="stepper-btn ayat-btn size-12 flex shrink-0 items-center justify-center rounded-xl bg-surface-light dark:bg-surface-dark ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed z-10">
                                        <span
                                            class="material-symbols-rounded text-gray-600 dark:text-gray-400">remove</span>
                                    </button>

                                    <!-- End Input -->
                                    <input name="ayat_akhir" type="number" min="0" required placeholder="Akhir"
                                        value="0" disabled oninput="checkQualityInput()"
                                        class="ayat-input flex-1 w-full h-12 rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] text-center text-base font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed" />

                                    <!-- Right Button (+ End) -->
                                    <button type="button" onclick="adjustAyat('ayat_akhir', 1); highlightStepBtn(this)"
                                        disabled
                                        class="stepper-btn ayat-btn size-12 flex shrink-0 items-center justify-center rounded-xl bg-surface-light dark:bg-surface-dark ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span
                                            class="material-symbols-rounded text-gray-600 dark:text-gray-400">add</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quality Evaluation -->
                        <div class="flex flex-col gap-4">
                            <label
                                class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal ml-3 flex items-center gap-2">Kualitas
                                Bacaan <span id="checkNilai" class="hidden text-green-500 material-symbols-rounded"
                                    style="font-size: 16px;">check_circle</span></label>
                            <div id="qualitySection"
                                class="flex flex-col gap-3 bg-surface-light dark:bg-surface-dark p-4 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 opacity-50 pointer-events-none transition-all">
                                <input type="hidden" name="nilai" id="nilaiInput" value="0">
                                <div class="flex items-center justify-center gap-3">
                                    @for($i = 1; $i <= 5; $i++) <button type="button" onclick="setRating({{ $i }})"
                                        class="star-btn group relative focus:outline-none transition-all duration-300">
                                        <span
                                            class="material-symbols-rounded text-gray-300 dark:text-gray-600 transition-all duration-300 group-hover:scale-125 group-hover:-rotate-12 group-hover:text-yellow-400 group-active:scale-95"
                                            style="font-size: 42px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">hotel_class</span>
                                        </button>
                                        @endfor
                                </div>
                                <div id="ratingLabelContainer" class="flex items-center justify-center">
                                    <span id="ratingLabel"
                                        class="inline-flex items-center rounded-full bg-yellow-50 dark:bg-yellow-900/30 px-2.5 py-0.5 text-xs font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">
                                        Belum Dinilai
                                    </span>
                                </div>
                                <div id="celebrationIcons"
                                    class="hidden flex items-center justify-center gap-4 animate-bounce duration-1000">
                                    <span class="text-4xl filter drop-shadow-lg">🏆</span>
                                    <span class="text-4xl filter drop-shadow-lg">🎁</span>
                                </div>
                                <p id="helperText"
                                    class="text-center text-gray-500 dark:text-gray-400 whitespace-nowrap"
                                    style="font-size: 10px;">Ketuk bintang untuk menilai</p>
                            </div>
                        </div>


                        <!-- Evidence Section (Restored Only) -->
                        <div class="flex flex-col gap-4">
                            <label
                                class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal ml-3">Rekaman
                                &
                                Catatan</label>

                            <!-- Voice Recorder Logic -->
                            <input type="file" name="voice_note" id="voiceNoteInput" accept="audio/*" class="hidden">

                            <!-- 1. Initial State (Click to Record) -->
                            <div id="recorderInitial" onclick="startRecording()"
                                class="flex items-center gap-4 p-4 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-surface-light dark:bg-surface-dark cursor-pointer hover:border-primary hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all group animate-[breathing_3s_ease-in-out_infinite]">
                                <div
                                    class="size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                    <span class="material-symbols-rounded animate-pulse"
                                        style="font-size: 24px;">mic</span>
                                </div>
                                <div class="flex flex-col flex-1">
                                    <span class="text-sm font-semibold text-[#111813] dark:text-white">Rekam
                                        Suara</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Ketuk untuk mulai
                                        merekam</span>
                                </div>
                            </div>

                            <!-- 2. Recording State (Timer + Stop) -->
                            <div id="recorderActive"
                                class="hidden flex items-center gap-4 p-4 rounded-xl border border-primary bg-red-50 dark:bg-red-900/10">
                                <div
                                    class="size-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center relative">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="material-symbols-rounded text-red-600 dark:text-red-400 relative z-10"
                                        style="font-size: 24px;">mic_off</span>
                                </div>
                                <div class="flex flex-col flex-1">
                                    <span class="text-sm font-bold text-red-600 dark:text-red-400">Merekam...</span>
                                    <span id="recordingTimer"
                                        class="text-xs font-mono text-gray-600 dark:text-gray-300">00:00</span>
                                </div>
                                <button type="button" onclick="stopRecording()"
                                    class="size-10 flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white shadow-lg transition-transform active:scale-95">
                                    <span class="material-symbols-rounded" style="font-size: 24px;">stop_circle</span>
                                </button>
                            </div>

                            <!-- 3. Preview State (Play + Delete) -->
                            <div id="recorderPreview"
                                class="hidden flex items-center gap-3 p-3 rounded-xl border border-primary/30 bg-blue-50 dark:bg-blue-900/10">
                                <button type="button" onclick="togglePlayInfo()" id="playBtn"
                                    class="size-10 flex shrink-0 items-center justify-center rounded-full bg-primary text-white hover:bg-primary-dark transition-colors">
                                    <span class="material-symbols-rounded pl-0.5"
                                        style="font-size: 24px;">play_arrow</span>
                                </button>
                                <div class="flex flex-col flex-1 overflow-hidden">
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">Rekaman
                                        Pesan</span>
                                    <span id="audioDuration" class="text-xs text-gray-500 dark:text-gray-400">Siap
                                        dikirim</span>
                                </div>
                                <button type="button" onclick="deleteRecording()"
                                    class="size-9 flex shrink-0 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-colors">
                                    <span class="material-symbols-rounded" style="font-size: 20px;">delete</span>
                                </button>
                            </div>

                            <!-- Notes -->
                            <textarea name="catatan"
                                class="flex w-full min-h-[120px] rounded-xl border-none bg-surface-light dark:bg-surface-dark text-[#111813] dark:text-white p-[15px] text-sm font-normal leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none resize-none transition-shadow"
                                placeholder="Tulis catatan untuk santri"></textarea>
                        </div>
                    </div>

                    <!-- Sticky Footer Action -->
                    <div
                        class="absolute bottom-0 left-0 right-0 p-6 bg-white/90 dark:bg-surface-dark/90 backdrop-blur-md z-30 border-t border-gray-100 dark:border-gray-800 rounded-t-[30px]">
                        <button type="submit" id="submitBtn"
                            class="w-full flex items-center justify-center gap-2 h-12 bg-primary hover:bg-primary-dark active:scale-[0.98] rounded-xl transition-all shadow-lg shadow-blue-500/20 animate-pulse hover:animate-none">
                            <span id="submitText" class="text-white text-base font-bold tracking-wide">Simpan
                                Setoran</span>
                            <span id="submitIcon" class="material-symbols-rounded text-white"
                                style="font-size: 20px;">check_circle</span>
                            <span id="submitSpinner"
                                class="hidden animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></span>
                        </button>
                    </div>
                </form>
            </div> <!-- End Form Container -->
        </div> <!-- End Scrollable Content -->
    </div> <!-- End Main Wrapper -->

    <script>
        function setRating(rating) {
            document.getElementById('nilaiInput').value = rating;
            const stars = document.querySelectorAll('.star-btn');
            const labels = ['Belum Dinilai', 'Tidak Lancar', 'Kurang Lancar', 'Lancar', 'Sangat Lancar', 'Sempurna'];
            stars.forEach((star, index) => {
                const icon = star.querySelector('.material-symbols-rounded');
                if (index < rating) {
                    // Active State
                    icon.classList.remove('text-gray-300', 'dark:text-gray-600');
                    icon.classList.add('text-yellow-400', 'drop-shadow-md'); // Add color & glow
                    icon.style.fontVariationSettings = "'FILL' 1";
                } else {
                    // Inactive State
                    icon.classList.add('text-gray-300', 'dark:text-gray-600');
                    icon.classList.remove('text-yellow-400', 'drop-shadow-md');
                    icon.style.fontVariationSettings = "'FILL' 0";
                }
            });
            document.getElementById('ratingLabel').textContent = labels[rating];

            const celebration = document.getElementById('celebrationIcons');
            const helper = document.getElementById('helperText');
            const labelContainer = document.getElementById('ratingLabelContainer'); // Target badge container
            const qualitySection = document.getElementById('qualitySection');

            // Dynamic Border Color based on rating
            qualitySection.classList.remove('ring-gray-200', 'dark:ring-gray-700', 'ring-red-400', 'dark:ring-red-500', 'ring-primary', 'ring-yellow-400');
            if (rating <= 2) {
                qualitySection.classList.add('ring-red-400', 'dark:ring-red-500'); // Red for poor
            } else if (rating <= 4) {
                qualitySection.classList.add('ring-primary'); // Blue for good
            } else {
                qualitySection.classList.add('ring-yellow-400'); // Gold for perfect
            }

            // Trigger Confetti & Show Icons if rating is 5 (Sempurna)
            if (rating === 5) {
                celebration.classList.remove('hidden');
                labelContainer.classList.add('hidden'); // Hide badge text
                helper.classList.add('hidden');

                confetti({
                    particleCount: 150,
                    spread: 80,
                    origin: { y: 0.6 },
                    scalar: 1.2
                });

                // Hide celebration after 3 seconds and Restore badge
                setTimeout(() => {
                    celebration.classList.add('hidden');
                    labelContainer.classList.remove('hidden'); // Restore badge text
                    helper.classList.remove('hidden');
                }, 3000);
            } else {
                celebration.classList.add('hidden');
                labelContainer.classList.remove('hidden'); // Ensure badge is visible for non-5 ratings
                helper.classList.remove('hidden');
            }
        }

        function showSantriDropdown() {
            document.getElementById('santriDropdown').classList.remove('hidden');
        }

        function selectSantri(id, name) {
            const input = document.getElementById('santriSearch');
            const hidden = document.getElementById('santriIdInput');

            input.value = name;
            hidden.value = id;
            document.getElementById('santriDropdown').classList.add('hidden');

            // Change Icon to Clear
            document.querySelector('#santriIcon span').textContent = 'close';

            // Enable Surah Input
            document.getElementById('surahSearch').disabled = false;

            // Fetch Last Hafalan
            // Fetch Last Hafalan
            // ULTIMATE FIX: Construct URL dynamically to avoid 404/500/CORS
            // Target:  [base]/last/{id}

            let basePath = window.location.href.split('?')[0].replace(/\/$/, "");
            if (basePath.endsWith('create')) basePath = basePath.slice(0, -6).replace(/\/$/, "");

            const url = `${basePath}/last/${id}`;
            console.log('Dynamic URL:', url);

            if (!id) return;

            fetch(url)
                .then(r => {
                    if (!r.ok) {
                        throw new Error(`HTTP Error ${r.status}`);
                    }
                    return r.json();
                })
                .then(result => {
                    console.log('Fetch Result:', result);
                    const info = document.getElementById('autoFillInfo');
                    const text = document.getElementById('autoFillText');

                    if (result.success && result.data) {
                        info.classList.remove('hidden');
                        let message = 'Lanjutan dari: ' + result.data.surah + ' ayat ' + result.data.ayat_akhir;

                        // Add progress info if available
                        if (result.data.progress_percent !== undefined) {
                            message += ` • Progres: ${result.data.progress_percent}%`;
                        }

                        // Duplicate text for seamless marquee
                        const duplicateContent = `<span class="px-4">${message}</span><span class="px-4">${message}</span><span class="px-4">${message}</span>`;
                        text.innerHTML = duplicateContent;
                        const nextAyat = parseInt(result.data.ayat_akhir) + 1;
                        document.querySelector('input[name="ayat_awal"]').value = nextAyat;
                        document.querySelector('input[name="ayat_akhir"]').value = nextAyat + 1;

                        // Enable Ayat inputs since Surah is filled
                        toggleAyatInputs(true);
                        checkQualityInput();

                        // Auto-fill Surah
                        document.getElementById('surahInput').value = result.data.surah;
                        document.getElementById('surahSearch').value = result.data.surah;
                        document.querySelector('#surahIcon span').textContent = 'close';
                    } else {
                        // alert('Info: Tidak ada riwayat hafalan untuk santri ini.'); // Optional debug
                        info.classList.add('hidden');
                        // Reset if no history "0"
                        document.querySelector('input[name="ayat_awal"]').value = 0;
                        document.querySelector('input[name="ayat_akhir"]').value = 0;
                        document.getElementById('surahInput').value = '';
                        document.getElementById('surahSearch').value = '';
                        document.querySelector('#surahIcon span').textContent = 'keyboard_arrow_down';

                        // Disable Ayat inputs
                        toggleAyatInputs(false);
                    }
                })
                .catch((err) => {
                    console.error('Fetch error:', err);
                    alert('Gagal mengambil data hafalan: ' + err); // Show error to user
                    document.getElementById('autoFillInfo').classList.add('hidden');
                });
        }

        function filterSantri(query) {
            const items = document.querySelectorAll('.santri-item');
            const q = query.toLowerCase();
            const icon = document.querySelector('#santriIcon span');

            // Force show dropdown when filtering
            document.getElementById('santriDropdown').classList.remove('hidden');

            // Toggle Icon
            if (query.length > 0) {
                icon.textContent = 'close';
            } else {
                icon.textContent = 'search';
            }

            let visible = 0;
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(q)) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });
            document.getElementById('santriEmpty').classList.toggle('hidden', visible > 0);
        }

        function clearSantri(e) {
            if (e) e.stopPropagation(); // Prevent closing dropdown immediately
            const input = document.getElementById('santriSearch');
            // Only clear if there is text, otherwise focus
            if (input.value.length > 0) {
                input.value = '';
                document.getElementById('santriIdInput').value = ''; // Reset ID too
                filterSantri(''); // Reset list

                // Clear all auto-filled data
                document.querySelector('input[name="ayat_awal"]').value = 0;
                document.querySelector('input[name="ayat_akhir"]').value = 0;
                document.getElementById('surahInput').value = '';
                document.getElementById('surahSearch').value = '';
                document.querySelector('#surahIcon span').textContent = 'keyboard_arrow_down';
                document.getElementById('autoFillInfo').classList.add('hidden');

                // Disable Surah Input
                document.getElementById('surahSearch').disabled = true;

                // Disable Ayat inputs
                toggleAyatInputs(false);
                setRating(0); // Reset Quality to 0 (Belum Dinilai)
                checkQualityInput();
            }
            showSantriDropdown(); // Explicitly show dropdown
            input.focus();
        }

        // Voice Recording Logic
        let mediaRecorder;
        let audioChunks = [];
        let recordStartTime;
        let recordTimerInterval;
        let audioBlob;
        let audioUrl;
        let currentAudio = null;

        async function startRecording() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Browser Anda tidak mendukung fitur perekaman suara.');
                return;
            }

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/mpeg' }); // or audio/webm
                    audioUrl = URL.createObjectURL(audioBlob);

                    // Create File object for input
                    const file = new File([audioBlob], "voice_note.mp3", { type: "audio/mpeg" });

                    // Transfer to hidden input
                    const container = new DataTransfer();
                    container.items.add(file);
                    document.getElementById('voiceNoteInput').files = container.files;

                    // Show preview
                    document.getElementById('recorderActive').classList.add('hidden');
                    document.getElementById('recorderPreview').classList.remove('hidden');

                    // Cleanup stream
                    stream.getTracks().forEach(track => track.stop());
                };

                mediaRecorder.start();

                // UI Updates
                document.getElementById('recorderInitial').classList.add('hidden');
                document.getElementById('recorderActive').classList.remove('hidden');

                // Timer
                recordStartTime = Date.now();
                updateTimer();
                recordTimerInterval = setInterval(updateTimer, 1000);

            } catch (err) {
                console.error("Error accessing microphone:", err);
                alert("Gagal mengakses mikrofon. Pastikan izin diberikan.");
            }
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                clearInterval(recordTimerInterval);
            }
        }

        function updateTimer() {
            const elapsed = Math.floor((Date.now() - recordStartTime) / 1000);
            const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
            const seconds = (elapsed % 60).toString().padStart(2, '0');
            document.getElementById('recordingTimer').textContent = `${minutes}:${seconds}`;
        }

        function deleteRecording() {
            if (confirm('Hapus rekaman ini?')) {
                // Clear input
                document.getElementById('voiceNoteInput').value = '';
                audioBlob = null;
                audioUrl = null;

                // Stop playing if any
                if (currentAudio) {
                    currentAudio.pause();
                    currentAudio = null;
                }

                // UI Reset
                document.getElementById('recorderPreview').classList.add('hidden');
                document.getElementById('recorderInitial').classList.remove('hidden');
            }
        }

        function togglePlayInfo() {
            const btnIcon = document.querySelector('#playBtn span');

            if (currentAudio && !currentAudio.paused) {
                currentAudio.pause();
                btnIcon.textContent = 'play_arrow';
            } else {
                if (!currentAudio) {
                    currentAudio = new Audio(audioUrl);
                    currentAudio.onended = () => {
                        btnIcon.textContent = 'play_arrow';
                        currentAudio = null;
                    };
                }
                currentAudio.play();
                btnIcon.textContent = 'pause';
            }
        }

        // Form validation
        document.getElementById('setoranForm').addEventListener('submit', function (e) {
            const ayatAwal = parseInt(document.querySelector('input[name="ayat_awal"]').value) || 0;
            const ayatAkhir = parseInt(document.querySelector('input[name="ayat_akhir"]').value) || 0;

            if (ayatAkhir < ayatAwal) {
                e.preventDefault();
                alert('Ayat Selesai harus >= Ayat Mulai!');
                return;
            }
            if (!document.getElementById('santriIdInput').value) {
                e.preventDefault();
                alert('Pilih santri terlebih dahulu!');
                return;
            }
            if (!document.getElementById('surahInput').value) {
                e.preventDefault();
                alert('Pilih surah terlebih dahulu!');
                return;
            }
            if (document.getElementById('nilaiInput').value < 1) {
                e.preventDefault();
                alert('Beri nilai kualitas bacaan!');
                return;
            }
        });

        // 114 Surah Data
        const allSurahs = [
            { n: 1, t: "Al-Fatihah", a: 7 }, { n: 2, t: "Al-Baqarah", a: 286 }, { n: 3, t: "Ali 'Imran", a: 200 }, { n: 4, t: "An-Nisa'", a: 176 },
            { n: 5, t: "Al-Ma'idah", a: 120 }, { n: 6, t: "Al-An'am", a: 165 }, { n: 7, t: "Al-A'raf", a: 206 }, { n: 8, t: "Al-Anfal", a: 75 },
            { n: 9, t: "At-Taubah", a: 129 }, { n: 10, t: "Yunus", a: 109 }, { n: 11, t: "Hud", a: 123 }, { n: 12, t: "Yusuf", a: 111 },
            { n: 13, t: "Ar-Ra'd", a: 43 }, { n: 14, t: "Ibrahim", a: 52 }, { n: 15, t: "Al-Hijr", a: 99 }, { n: 16, t: "An-Nahl", a: 128 },
            { n: 17, t: "Al-Isra'", a: 111 }, { n: 18, t: "Al-Kahf", a: 110 }, { n: 19, t: "Maryam", a: 98 }, { n: 20, t: "Ta-Ha", a: 135 },
            { n: 21, t: "Al-Anbiya'", a: 112 }, { n: 22, t: "Al-Hajj", a: 78 }, { n: 23, t: "Al-Mu'minun", a: 118 }, { n: 24, t: "An-Nur", a: 64 },
            { n: 25, t: "Al-Furqan", a: 77 }, { n: 26, t: "Asy-Syu'ara'", a: 227 }, { n: 27, t: "An-Naml", a: 93 }, { n: 28, t: "Al-Qasas", a: 88 },
            { n: 29, t: "Al-Ankabut", a: 69 }, { n: 30, t: "Ar-Rum", a: 60 }, { n: 31, t: "Luqman", a: 34 }, { n: 32, t: "As-Sajdah", a: 30 },
            { n: 33, t: "Al-Ahzab", a: 73 }, { n: 34, t: "Saba'", a: 54 }, { n: 35, t: "Fatir", a: 45 }, { n: 36, t: "Ya-Sin", a: 83 },
            { n: 37, t: "As-Saffat", a: 182 }, { n: 38, t: "Sad", a: 88 }, { n: 39, t: "Az-Zumar", a: 75 }, { n: 40, t: "Ghafir", a: 85 },
            { n: 41, t: "Fussilat", a: 54 }, { n: 42, t: "Asy-Syura", a: 53 }, { n: 43, t: "Az-Zukhruf", a: 89 }, { n: 44, t: "Ad-Dukhan", a: 59 },
            { n: 45, t: "Al-Jasiyah", a: 37 }, { n: 46, t: "Al-Ahqaf", a: 35 }, { n: 47, t: "Muhammad", a: 38 }, { n: 48, t: "Al-Fath", a: 29 },
            { n: 49, t: "Al-Hujurat", a: 18 }, { n: 50, t: "Qaf", a: 45 }, { n: 51, t: "Az-Zariyat", a: 60 }, { n: 52, t: "At-Tur", a: 49 },
            { n: 53, t: "An-Najm", a: 62 }, { n: 54, t: "Al-Qamar", a: 55 }, { n: 55, t: "Ar-Rahman", a: 78 }, { n: 56, t: "Al-Waqi'ah", a: 96 },
            { n: 57, t: "Al-Hadid", a: 29 }, { n: 58, t: "Al-Mujadilah", a: 22 }, { n: 59, t: "Al-Hashr", a: 24 }, { n: 60, t: "Al-Mumtahanah", a: 13 },
            { n: 61, t: "As-Saff", a: 14 }, { n: 62, t: "Al-Jumu'ah", a: 11 }, { n: 63, t: "Al-Munafiqun", a: 11 }, { n: 64, t: "At-Taghabun", a: 18 },
            { n: 65, t: "At-Talaq", a: 12 }, { n: 66, t: "At-Tahrim", a: 12 }, { n: 67, t: "Al-Mulk", a: 30 }, { n: 68, t: "Al-Qalam", a: 52 },
            { n: 69, t: "Al-Haqqah", a: 52 }, { n: 70, t: "Al-Ma'arij", a: 44 }, { n: 71, t: "Nuh", a: 28 }, { n: 72, t: "Al-Jinn", a: 28 },
            { n: 73, t: "Al-Muzzammil", a: 20 }, { n: 74, t: "Al-Muddassir", a: 56 }, { n: 75, t: "Al-Qiyamah", a: 40 }, { n: 76, t: "Al-Insan", a: 31 },
            { n: 77, t: "Al-Mursalat", a: 50 }, { n: 78, t: "An-Naba'", a: 40 }, { n: 79, t: "An-Naziat", a: 46 }, { n: 80, t: "'Abasa", a: 42 },
            { n: 81, t: "At-Takwir", a: 29 }, { n: 82, t: "Al-Infitar", a: 19 }, { n: 83, t: "Al-Mutaffifin", a: 36 }, { n: 84, t: "Al-Insyiqaq", a: 25 },
            { n: 85, t: "Al-Buruj", a: 22 }, { n: 86, t: "At-Tariq", a: 17 }, { n: 87, t: "Al-A'la", a: 19 }, { n: 88, t: "Al-Ghasyiyah", a: 26 },
            { n: 89, t: "Al-Fajr", a: 30 }, { n: 90, t: "Al-Balad", a: 20 }, { n: 91, t: "Asy-Syams", a: 15 }, { n: 92, t: "Al-Lail", a: 21 },
            { n: 93, t: "Ad-Duha", a: 11 }, { n: 94, t: "Al-Insyirah", a: 8 }, { n: 95, t: "At-Tin", a: 8 }, { n: 96, t: "Al-'Alaq", a: 19 },
            { n: 97, t: "Al-Qadr", a: 5 }, { n: 98, t: "Al-Bayyinah", a: 8 }, { n: 99, t: "Az-Zalzalah", a: 8 }, { n: 100, t: "Al-'Adiyat", a: 11 },
            { n: 101, t: "Al-Qari'ah", a: 11 }, { n: 102, t: "At-Takasur", a: 8 }, { n: 103, t: "Al-'Asr", a: 3 }, { n: 104, t: "Al-Humazah", a: 9 },
            { n: 105, t: "Al-Fil", a: 5 }, { n: 106, t: "Quraysh", a: 4 }, { n: 107, t: "Al-Ma'un", a: 7 }, { n: 108, t: "Al-Kautsar", a: 3 },
            { n: 109, t: "Al-Kafirun", a: 6 }, { n: 110, t: "An-Nasr", a: 3 }, { n: 111, t: "Al-Lahab", a: 5 }, { n: 112, t: "Al-Ikhlas", a: 4 },
            { n: 113, t: "Al-Falaq", a: 5 }, { n: 114, t: "An-Nas", a: 6 }
        ];

        // Init Surah Dropdown
        const surahContainer = document.getElementById('surahListContainer');
        allSurahs.forEach(s => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'surah-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-gray-50 dark:hover:bg-white/5 transition-colors border-b border-gray-100 dark:border-gray-800 last:border-0';
            btn.innerHTML = `
                <div class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold shrink-0">${s.n}</div>
                <div class="flex flex-col flex-1">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">${s.t}</span>
                    <span class="text-[10px] text-gray-400">${s.a} Ayat</span>
                </div>
            `;
            btn.onclick = () => selectSurah(s.t);
            btn.setAttribute('data-name', s.t.toLowerCase());
            surahContainer.appendChild(btn);
        });

        function showSurahDropdown() {
            document.getElementById('surahDropdown').classList.remove('hidden');
            // Native scroll with CSS offset support
            // Trigger twice to handle keyboard opening delay on mobile
            const scrollToSection = () => {
                const targetSection = document.getElementById('hafalanSection');
                const autoFillInfo = document.getElementById('autoFillInfo');

                if (targetSection) {
                    // Check if auto-fill banner is active (not hidden)
                    if (autoFillInfo && !autoFillInfo.classList.contains('hidden')) {
                        // Increase buffer if banner is present to prevent input from hiding behind header
                        // Dynamic inline style overrides the class
                        targetSection.style.scrollMarginTop = '140px';
                    } else {
                        // Default buffer increased to prevent it from going "too high"
                        targetSection.style.scrollMarginTop = '120px';
                    }

                    targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            };

            setTimeout(scrollToSection, 100);
            setTimeout(scrollToSection, 500); // Retry after keyboard likely open
        }

        // Helper for flexible search (Anas -> An-Nas, AliImron -> Ali 'Imran)
        function normalizeSurah(text) {
            return text.toLowerCase()
                .replace(/[^a-z]/g, '')       // Remove text symbols/spaces (ali 'imran -> aliimran)
                .replace(/o/g, 'a')           // Normalize vowels (imron -> imran)
                .replace(/(.)\1+/g, '$1');    // Dedupe letters (annas -> anas)
        }

        function filterSurah(query) {
            const items = document.querySelectorAll('.surah-item');
            const cleanQuery = normalizeSurah(query);
            const icon = document.querySelector('#surahIcon span');

            // Toggle Icon
            if (query.length > 0) {
                icon.textContent = 'close';
            } else {
                icon.textContent = 'keyboard_arrow_down';
            }

            let visible = 0;
            items.forEach(item => {
                const originalName = item.getAttribute('data-name'); // al-fatihah
                const cleanName = normalizeSurah(originalName);      // alfatihah

                // Check both original (for strict substring) and normalized (for fuzzy)
                if (cleanName.includes(cleanQuery) || originalName.includes(query.toLowerCase())) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });
            document.getElementById('surahEmpty').classList.toggle('hidden', visible > 0);
        }

        function clearSurah(e) {
            if (e) e.stopPropagation(); // Prevent closing dropdown immediately
            const input = document.getElementById('surahSearch');
            // Only clear if there is text
            if (input.value.length > 0) {
                input.value = '';
                document.getElementById('surahInput').value = ''; // Reset ID
                filterSurah(''); // Reset list

                // Disable Ayat inputs
                toggleAyatInputs(false);
            }
            showSurahDropdown(); // Explicitly show dropdownd trigger scroll
            input.focus();
        }

        function selectSurah(name) {
            document.getElementById('surahInput').value = name;
            document.getElementById('surahSearch').value = name;
            document.getElementById('surahDropdown').classList.add('hidden');
            document.querySelector('#surahIcon span').textContent = 'close';

            // Enable Ayat inputs
            toggleAyatInputs(true);
        }

        // Close dropdowns on outside click
        // Close dropdowns on outside click
        document.addEventListener('click', function (e) {
            // Santri Dropdown
            const sSearch = document.getElementById('santriSearch');
            const sDropdown = document.getElementById('santriDropdown');
            const sIcon = document.getElementById('santriIcon');
            if (sSearch && sDropdown && sIcon && !sSearch.contains(e.target) && !sDropdown.contains(e.target) && !sIcon.contains(e.target)) {
                sDropdown.classList.add('hidden');
            }

            // Surah Dropdown
            const surahSearch = document.getElementById('surahSearch');
            const surahDropdown = document.getElementById('surahDropdown');
            const surahIcon = document.getElementById('surahIcon');
            if (surahSearch && surahDropdown && surahIcon && !surahSearch.contains(e.target) && !surahDropdown.contains(e.target) && !surahIcon.contains(e.target)) {
                surahDropdown.classList.add('hidden');
            }
        });


        function adjustAyat(fieldName, delta) {
            const input = document.querySelector(`input[name="${fieldName}"]`);
            const otherInputName = fieldName === 'ayat_awal' ? 'ayat_akhir' : 'ayat_awal';
            const otherInput = document.querySelector(`input[name="${otherInputName}"]`);

            if (input && otherInput) {
                let currentVal = parseInt(input.value) || 0;
                let otherVal = parseInt(otherInput.value) || 0;
                let newVal = currentVal + delta;

                if (newVal < 1) newVal = 1;

                // Validation Rule: End >= Start
                if (fieldName === 'ayat_awal') {
                    // Changing Start
                    input.value = newVal;
                    // If Start > End, push End to match Start
                    if (newVal > otherVal) {
                        otherInput.value = newVal;
                    }
                } else {
                    // Changing End
                    // If End < Start, Prevent (Clamp to Start)
                    if (newVal < otherVal) {
                        newVal = otherVal;
                    }
                    input.value = newVal;
                }

                checkQualityInput();
            }
        }

        function syncAyatManual(val) {
            const startVal = parseInt(val) || 0;
            const endInput = document.querySelector('input[name="ayat_akhir"]');

            if (endInput) {
                const currentEndKey = parseInt(endInput.value) || 0;
                // Only push End if Start becomes greater than current End
                if (startVal > currentEndKey) {
                    endInput.value = startVal;
                }
                checkQualityInput();
            }
        }



        function toggleAyatInputs(enable) {
            const inputs = document.querySelectorAll('.ayat-input');
            const buttons = document.querySelectorAll('.ayat-btn');

            inputs.forEach(el => {
                el.disabled = !enable;
            });

            buttons.forEach(btn => {
                btn.disabled = !enable;
            });
        }

        // Quality Input Logic
        function checkQualityInput() {
            const ayatAkhir = document.querySelector('input[name="ayat_akhir"]');
            const qualityDisplay = document.getElementById('qualitySection');

            if (ayatAkhir && parseInt(ayatAkhir.value) > 0) {
                // Enable
                qualityDisplay.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                // Disable
                qualityDisplay.classList.add('opacity-50', 'pointer-events-none');
            }
        }

        // Highlight Stepper Logic
        function highlightStepBtn(btn) {
            // 1. Select all stepper buttons
            const allBtns = document.querySelectorAll('.stepper-btn');

            // 2. Reset Styles
            allBtns.forEach(b => {
                // Remove Active (Primary)
                b.classList.remove('bg-primary', 'text-white', 'hover:bg-primary-dark');
                // Add Inactive (Neutral)
                b.classList.add('bg-surface-light', 'dark:bg-surface-dark', 'hover:bg-gray-50', 'dark:hover:bg-gray-800');

                // Reset Icon color
                const icon = b.querySelector('span');
                if (icon) {
                    icon.classList.remove('text-white');
                    icon.classList.add('text-gray-600', 'dark:text-gray-400');
                }
            });

            // 3. Apply Active Style to Clicked Button
            // Remove Inactive
            btn.classList.remove('bg-surface-light', 'dark:bg-surface-dark', 'hover:bg-gray-50', 'dark:hover:bg-gray-800');
            // Add Active
            btn.classList.add('bg-primary', 'text-white', 'hover:bg-primary-dark');

            // Update Icon
            const activeIcon = btn.querySelector('span');
            if (activeIcon) {
                activeIcon.classList.remove('text-gray-600', 'dark:text-gray-400');
                activeIcon.classList.add('text-white');
            }
        }

        // Form Submit Loading State
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('setoranForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitIcon = document.getElementById('submitIcon');
            const submitSpinner = document.getElementById('submitSpinner');

            form.addEventListener('submit', function (e) {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75');
                submitText.textContent = 'Menyimpan...';
                submitIcon.classList.add('hidden');
                submitSpinner.classList.remove('hidden');

                // Clear draft on submit
                localStorage.removeItem('setoranDraft');
            });

            // Load draft on page load
            loadDraft();

            // Update progress on load
            updateProgress();
        });

        // Progress & Checkmark Logic
        function updateProgress() {
            let progress = 0;
            const santriId = document.getElementById('santriIdInput').value;
            const surahInput = document.getElementById('surahInput').value;
            const ayatAkhir = parseInt(document.querySelector('input[name="ayat_akhir"]').value) || 0;
            const nilai = parseInt(document.getElementById('nilaiInput').value) || 0;

            // Check each field and update checkmarks
            if (santriId) {
                progress += 25;
                document.getElementById('checkSantri').classList.remove('hidden');
            } else {
                document.getElementById('checkSantri').classList.add('hidden');
            }

            if (surahInput) {
                progress += 25;
                document.getElementById('checkSurah').classList.remove('hidden');
            } else {
                document.getElementById('checkSurah').classList.add('hidden');
            }

            if (ayatAkhir > 0) {
                progress += 25;
                document.getElementById('checkAyat').classList.remove('hidden');
            } else {
                document.getElementById('checkAyat').classList.add('hidden');
            }

            if (nilai > 0) {
                progress += 25;
                document.getElementById('checkNilai').classList.remove('hidden');
            } else {
                document.getElementById('checkNilai').classList.add('hidden');
            }

            // Update progress bar
            document.getElementById('progressBar').style.width = progress + '%';
            document.getElementById('progressText').textContent = progress + '% Lengkap';
        }

        // Auto-Save Draft
        function saveDraft() {
            const draft = {
                santriId: document.getElementById('santriIdInput').value,
                santriName: document.getElementById('santriSearch').value,
                surah: document.getElementById('surahInput').value,
                surahName: document.getElementById('surahSearch').value,
                ayatAwal: document.querySelector('input[name="ayat_awal"]').value,
                ayatAkhir: document.querySelector('input[name="ayat_akhir"]').value,
                nilai: document.getElementById('nilaiInput').value,
                catatan: document.querySelector('textarea[name="catatan"]').value
            };
            localStorage.setItem('setoranDraft', JSON.stringify(draft));
        }

        function loadDraft() {
            const saved = localStorage.getItem('setoranDraft');
            if (saved) {
                try {
                    const draft = JSON.parse(saved);
                    if (draft.santriId) {
                        document.getElementById('santriIdInput').value = draft.santriId;
                        document.getElementById('santriSearch').value = draft.santriName;
                        document.querySelector('#santriIcon span').textContent = 'close';
                        document.getElementById('surahSearch').disabled = false;
                    }
                    if (draft.surah) {
                        document.getElementById('surahInput').value = draft.surah;
                        document.getElementById('surahSearch').value = draft.surahName;
                        // Enable ayat inputs
                        document.querySelectorAll('.ayat-btn, .ayat-input').forEach(el => el.disabled = false);
                    }
                    if (draft.ayatAwal) document.querySelector('input[name="ayat_awal"]').value = draft.ayatAwal;
                    if (draft.ayatAkhir) document.querySelector('input[name="ayat_akhir"]').value = draft.ayatAkhir;
                    if (draft.nilai && parseInt(draft.nilai) > 0) {
                        setRating(parseInt(draft.nilai));
                        checkQualityInput(); // Enable quality section
                    }
                    if (draft.catatan) document.querySelector('textarea[name="catatan"]').value = draft.catatan;

                    updateProgress();
                } catch (e) {
                    console.error('Failed to load draft:', e);
                }
            }
        }

        // Call saveDraft on input changes
        document.addEventListener('input', function (e) {
            saveDraft();
            updateProgress();
        });
        document.addEventListener('click', function (e) {
            // Delayed save for click events (like selecting santri/surah)
            setTimeout(() => {
                saveDraft();
                updateProgress();
            }, 100);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        // Auto-Select Santri if ID present in URL or passed from Controller
        window.addEventListener('load', function () {
            @if (isset($selectedSantriId) && $selectedSantriId)
                // Find name from list
                const santriItem = document.querySelector(`.santri-item[data-id="{{ $selectedSantriId }}"]`);
            if (santriItem) {
                const name = santriItem.getAttribute('data-name');
                selectSantri("{{ $selectedSantriId }}", name);
            }
            @endif
        });
    </script>
</body>

</html>
