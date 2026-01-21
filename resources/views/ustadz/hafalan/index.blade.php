<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Setoran Hafalan</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
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
                        "header-dark": "#2A5A78",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748",
                        "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -10px rgba(74, 144, 184, 0.15)',
                        'card': '0 10px 25px -5px rgba(0, 0, 0, 0.05)',
                    }
                },
            },
        };
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

        .circular-progress {
            transform: rotate(-90deg);
        }

        /* Glass effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass-nav {
            background: rgba(30, 30, 30, 0.85);
        }

        /* Hide default search clear button */
        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
            display: none;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 font-display flex justify-center items-center min-h-screen p-0 sm:p-4">
    <div
        class="relative w-full max-w-[400px] min-h-[100dvh] sm:min-h-0 sm:h-[850px] bg-background-light dark:bg-background-dark rounded-none sm:rounded-[40px] overflow-hidden shadow-none sm:shadow-2xl flex flex-col">

        <!-- Scrollable Content -->
        <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar pb-6">

            <!-- Header Slim Box -->
            <header
                class="flex items-center bg-gradient-to-r from-[#1A2980] to-[#26D0CE] h-14 px-4 shadow-lg shadow-blue-900/20 mx-6 rounded-2xl mt-6 mb-4">
                <div class="w-full flex items-center justify-center relative">
                    <h1 class="text-white dark:text-white text-base font-bold leading-tight tracking-tight text-center">
                        Setoran Hafalan</h1>
                </div>
            </header>

            <!-- Main Content Container -->
            <div class="mx-6 mb-6 pt-0 relative z-20">

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div
                    class="mx-4 mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl text-green-600 dark:text-green-400 text-sm font-medium">
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div
                    class="mx-4 mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl text-red-600 dark:text-red-400 text-sm">
                    {{ $errors->first() }}
                </div>
                @endif



                <!-- Tab Navigation -->
                <div class="flex gap-2 mb-4">
                    <button id="tabInputBaru" onclick="switchTab('input')"
                        class="tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-primary text-white shadow-lg shadow-primary/30">
                        <span class="material-symbols-rounded text-[18px]">add_circle</span>
                        <span>Input Baru</span>
                    </button>
                    <button id="tabEditSetoran" onclick="switchTab('edit')"
                        class="tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400">
                        <span class="material-symbols-rounded text-[18px]">edit_note</span>
                        <span>Edit Setoran</span>
                    </button>
                </div>

                <!-- Tab Content: Input Baru -->
                <div id="contentInputBaru" class="tab-content">
                    @if(isset($isScheduleActive) && !$isScheduleActive)
                    <div class="flex flex-col items-center justify-center py-6 px-4 text-center">
                        <div
                            class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-2">
                            <span class="material-symbols-rounded text-gray-400 text-[24px]">timer_off</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200">Input Hafalan Ditutup</h3>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 max-w-xs mt-1">{{ $scheduleMessage ??
                            'Mohon
                            input setoran sesuai jadwal KBM yang berlaku.' }}</p>
                    </div>
                    @else
                    <!-- Embedded Input Form -->
                    <form action="{{ route('ustadz.hafalan.store') }}" method="POST" id="setoranForm"
                        enctype="multipart/form-data" class="mb-6">
                        @csrf

                        <div class="flex flex-col gap-4">
                            <!-- Santri Selection -->
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">
                                    Nama Santri
                                    <span id="checkSantri" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span>
                                </label>
                                <input type="hidden" name="santri_id" id="santriIdInput" required>
                                <div class="relative">
                                    <input type="text" id="santriSearch" placeholder="Cari nama santri"
                                        class="peer flex w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark text-[#111813] dark:text-white placeholder:text-gray-400 p-[15px] pr-12 text-sm font-medium leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow"
                                        onfocus="showSantriDropdown()" onclick="showSantriDropdown()"
                                        oninput="filterSantri(this.value)" autocomplete="off" />
                                    <div id="santriIcon" onclick="clearSantri(event)"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-primary flex items-center justify-center cursor-pointer transition-colors hover:text-red-500">
                                        <span class="material-symbols-rounded" style="font-size: 24px;">search</span>
                                    </div>
                                    <div id="santriDropdown"
                                        class="hidden absolute left-0 right-0 top-full mt-1 bg-white dark:bg-surface-dark rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 max-h-48 overflow-y-auto z-40">
                                        @foreach($santriList as $santri)
                                        <button type="button"
                                            onclick="selectSantri(this.getAttribute('data-id'), this.getAttribute('data-name'))"
                                            data-id="{{ $santri->id }}" data-name="{{ $santri->name }}"
                                            class="santri-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-primary/10 transition-colors"
                                            data-search="{{ strtolower($santri->name) }}">
                                            <div
                                                class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">
                                                {{ substr($santri->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium flex-1">{{ $santri->name }}</span>
                                        </button>
                                        @endforeach
                                        <div id="santriEmpty"
                                            class="hidden px-4 py-4 text-center text-gray-400 text-sm">Tidak ditemukan
                                        </div>
                                    </div>
                                </div>
                                <!-- Auto-fill Banner -->
                                <div id="autoFillInfo"
                                    class="hidden py-1.5 px-3 bg-blue-50/70 dark:bg-blue-900/30 backdrop-blur-md rounded-xl flex items-center gap-2 border border-blue-100/50 dark:border-blue-800/50 overflow-hidden shadow-sm">
                                    <span class="material-symbols-rounded text-primary flex-shrink-0"
                                        style="font-size: 14px;">info</span>
                                    <div class="overflow-hidden w-full relative h-[16px]">
                                        <span id="autoFillText"
                                            class="text-[10px] text-primary font-medium whitespace-nowrap absolute"
                                            style="animation: marquee 20s linear infinite;"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Surah Selection -->
                            <div id="hafalanSection" class="scroll-mt-5 flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">
                                    Materi Hafalan
                                    <span id="checkSurah" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span>
                                </label>
                                <div class="relative">
                                    <input type="hidden" name="surah" id="surahInput" required>
                                    <input type="text" id="surahSearch" placeholder="Cari surah (contoh: Al-Baqarah)"
                                        disabled
                                        class="peer flex w-full h-12 rounded-xl border-none bg-gray-100 dark:bg-gray-800 text-[#111813] dark:text-white px-[15px] pr-10 text-sm font-medium leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed"
                                        onfocus="showSurahDropdown()" onclick="showSurahDropdown()"
                                        oninput="filterSurah(this.value)" autocomplete="off" />
                                    <div id="surahIcon" onclick="clearSurah(event)"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 flex items-center justify-center cursor-pointer transition-colors hover:text-red-500">
                                        <span class="material-symbols-rounded"
                                            style="font-size: 24px;">keyboard_arrow_down</span>
                                    </div>
                                    <div id="surahDropdown"
                                        class="hidden absolute left-0 right-0 top-full mt-2 bg-white dark:bg-surface-dark rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 max-h-60 overflow-y-auto z-40">
                                        <div id="surahListContainer"></div>
                                        <div id="surahEmpty" class="hidden px-4 py-4 text-center text-gray-400 text-xs">
                                            Tidak ditemukan</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ayat Range -->
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">
                                    Rentang Ayat
                                    <span id="checkAyat" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span>
                                </label>
                                <div class="relative flex items-center gap-2">
                                    <button type="button" onclick="adjustAyat('ayat_awal', 1); highlightStepBtn(this)"
                                        disabled
                                        class="stepper-btn ayat-btn size-10 flex shrink-0 items-center justify-center rounded-xl bg-white dark:bg-surface-dark ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span
                                            class="material-symbols-rounded text-gray-600 dark:text-gray-400">add</span>
                                    </button>
                                    <input name="ayat_awal" type="number" min="0" required placeholder="Awal" value="0"
                                        disabled oninput="syncAyatManual(this.value)"
                                        class="ayat-input flex-1 w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark text-[#111813] dark:text-white p-[10px] text-center text-sm font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed" />
                                    <button type="button" onclick="adjustAyat('ayat_akhir', -1); highlightStepBtn(this)"
                                        disabled
                                        class="stepper-btn ayat-btn size-10 flex shrink-0 items-center justify-center rounded-xl bg-white dark:bg-surface-dark ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed z-10">
                                        <span
                                            class="material-symbols-rounded text-gray-600 dark:text-gray-400">remove</span>
                                    </button>
                                    <input name="ayat_akhir" type="number" min="0" required placeholder="Akhir"
                                        value="0" disabled oninput="checkQualityInput()"
                                        class="ayat-input flex-1 w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark text-[#111813] dark:text-white p-[10px] text-center text-sm font-medium shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed" />
                                    <button type="button" onclick="adjustAyat('ayat_akhir', 1); highlightStepBtn(this)"
                                        disabled
                                        class="stepper-btn ayat-btn size-10 flex shrink-0 items-center justify-center rounded-xl bg-white dark:bg-surface-dark ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span
                                            class="material-symbols-rounded text-gray-600 dark:text-gray-400">add</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Quality Rating -->
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">
                                    Kualitas Bacaan
                                    <span id="checkNilai" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span>
                                </label>
                                <div id="qualitySection"
                                    class="flex flex-col gap-2 bg-white dark:bg-surface-dark p-3 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 opacity-50 pointer-events-none transition-all">
                                    <input type="hidden" name="nilai" id="nilaiInput" value="0">
                                    <div class="flex items-center justify-center gap-2">
                                        @for($i = 1; $i <= 5; $i++) <button type="button" onclick="setRating({{ $i }})"
                                            class="star-btn group relative focus:outline-none transition-all duration-300">
                                            <span
                                                class="material-symbols-rounded text-gray-300 dark:text-gray-600 transition-all duration-300 group-hover:scale-110 group-hover:text-yellow-400 group-active:scale-95"
                                                style="font-size: 32px;">hotel_class</span>
                                            </button>
                                            @endfor
                                    </div>
                                    <div id="ratingLabelContainer" class="flex items-center justify-center">
                                        <span id="ratingLabel"
                                            class="inline-flex items-center rounded-full bg-yellow-50 dark:bg-yellow-900/30 px-2 py-0.5 text-[10px] font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">
                                            Belum Dinilai
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Voice Recorder Section -->
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal">Rekaman
                                    Suara</label>
                                <input type="file" name="voice_note" id="voiceNoteInput" accept="audio/*"
                                    class="hidden">

                                <!-- 1. Initial State (Click to Record) -->
                                <div id="recorderInitial" onclick="startRecording()"
                                    class="flex items-center gap-3 p-3 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-dark cursor-pointer hover:border-primary hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all group">
                                    <div
                                        class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                        <span class="material-symbols-rounded animate-pulse"
                                            style="font-size: 20px;">mic</span>
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
                                    class="hidden flex items-center gap-3 p-3 rounded-xl border border-primary bg-red-50 dark:bg-red-900/10">
                                    <div
                                        class="size-10 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center relative">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span
                                            class="material-symbols-rounded text-red-600 dark:text-red-400 relative z-10"
                                            style="font-size: 20px;">mic_off</span>
                                    </div>
                                    <div class="flex flex-col flex-1">
                                        <span class="text-sm font-bold text-red-600 dark:text-red-400">Merekam...</span>
                                        <span id="recordingTimer"
                                            class="text-xs font-mono text-gray-600 dark:text-gray-300">00:00</span>
                                    </div>
                                    <button type="button" onclick="stopRecording()"
                                        class="size-9 flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white shadow-lg transition-transform active:scale-95">
                                        <span class="material-symbols-rounded"
                                            style="font-size: 20px;">stop_circle</span>
                                    </button>
                                </div>

                                <!-- 3. Preview State (Play + Delete) -->
                                <div id="recorderPreview"
                                    class="hidden flex items-center gap-3 p-3 rounded-xl border border-primary/30 bg-blue-50 dark:bg-blue-900/10">
                                    <button type="button" onclick="togglePlayInfo()" id="playBtn"
                                        class="size-9 flex shrink-0 items-center justify-center rounded-full bg-primary text-white hover:bg-primary-dark transition-colors">
                                        <span class="material-symbols-rounded pl-0.5"
                                            style="font-size: 20px;">play_arrow</span>
                                    </button>
                                    <div class="flex flex-col flex-1 overflow-hidden">
                                        <span
                                            class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">Rekaman
                                            Pesan</span>
                                        <span id="audioDuration" class="text-xs text-gray-500 dark:text-gray-400">Siap
                                            dikirim</span>
                                    </div>
                                    <button type="button" onclick="deleteRecording()"
                                        class="size-8 flex shrink-0 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-colors">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal">Catatan</label>
                                <textarea name="catatan" rows="2"
                                    class="flex w-full rounded-xl border-none bg-white dark:bg-surface-dark text-[#111813] dark:text-white p-3 text-sm font-normal leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none resize-none transition-shadow"
                                    placeholder="Tulis catatan untuk santri (opsional)"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn"
                                class="w-full flex items-center justify-center gap-2 h-12 bg-gradient-to-r from-primary to-[#3D7A9E] hover:from-primary-dark hover:to-[#2A5A78] active:scale-[0.98] rounded-xl transition-all shadow-lg shadow-primary/30">
                                <span id="submitText" class="text-white text-sm font-bold tracking-wide">Simpan
                                    Setoran</span>
                                <span id="submitIcon" class="material-symbols-rounded text-white"
                                    style="font-size: 18px;">check_circle</span>
                                <span id="submitSpinner"
                                    class="hidden animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                            </button>
                        </div>
                    </form>
                    @endif
                </div> <!-- End Tab Content: Input Baru -->

            </div> <!-- End Main Content Container (mx-6) -->

            <!-- Tab Content: Edit Setoran - OUTSIDE mx-6 for proper sticky behavior -->
            <div id="contentEditSetoran" class="tab-content hidden">
                <!-- Sticky Header - direct child of scrollable container -->
                <div class="sticky top-0 z-30 bg-background-light dark:bg-background-dark py-3 px-6 mb-4">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                            <span
                                class="material-symbols-rounded text-emerald-600 dark:text-emerald-400 text-[20px]">edit_note</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-sm text-text-main-light dark:text-white">Edit Setoran</h3>
                            <p class="text-text-sub-light dark:text-gray-400 text-xs">Pilih setoran untuk diedit</p>
                        </div>
                    </div>
                </div>

                <!-- Content with px-6 for margins -->
                <div class="px-6 pb-6">
                    @php
                    $sampleRiwayat = $riwayatSetoran ?? [];
                    @endphp

                    @if(count($sampleRiwayat) > 0)
                    <div class="flex flex-col gap-3">
                        @foreach($sampleRiwayat as $setoran)
                        @php
                        $nilaiStr = $setoran->nilai ?? '';
                        $nilaiMap = ['Tidak Lancar' => 1, 'Kurang Lancar' => 2, 'Lancar' => 3, 'Sangat Lancar' => 4,
                        'Sempurna' => 5];
                        $nilai = $nilaiMap[$nilaiStr] ?? (is_numeric($nilaiStr) ? intval($nilaiStr) : 0);
                        $nilaiLabels = ['', 'Kurang', 'Cukup', 'Jayyid', 'Jayyid Jiddan', 'Mumtaz'];
                        $nilaiColors = [
                        '',
                        'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                        'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400',
                        'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                        'bg-teal-100 text-teal-600 dark:bg-teal-900/30 dark:text-teal-400',
                        'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400'
                        ];
                        // Prepare data for modal with integer nilai
                        $setoranData = $setoran->toArray();
                        $setoranData['nilai'] = $nilai;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 group hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors {{ (isset($isScheduleActive) && !$isScheduleActive) ? 'cursor-not-allowed opacity-60' : 'cursor-pointer' }}"
                            @if(isset($isScheduleActive) && !$isScheduleActive)
                            onclick="alert('{{ $scheduleMessage ?? 'Jadwal input ditutup.' }}')" @else
                            onclick='openEditModal(@json($setoranData))' @endif>
                            <div
                                class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
                                <span
                                    class="material-symbols-rounded text-emerald-600 dark:text-emerald-400 text-[24px]">edit</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm text-text-main-light dark:text-white truncate">
                                    Surah {{ $setoran->surah ?? 'Surah' }}</h4>
                                <p class="text-text-sub-light dark:text-gray-400 text-xs mt-0.5">
                                    Ayat {{ $setoran->ayat_awal ?? '-' }}-{{ $setoran->ayat_akhir ?? '-' }} •
                                    {{ isset($setoran->santri_name) ? $setoran->santri_name : '' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span
                                    class="px-3 py-1.5 rounded-full text-[10px] font-bold flex-shrink-0 {{ $nilaiColors[$nilai] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $nilaiLabels[$nilai] ?? 'Nilai' }}
                                </span>
                                <span
                                    class="material-symbols-rounded text-gray-400 group-hover:text-emerald-500 transition-colors">chevron_right</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div
                        class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-8 text-center border border-gray-100 dark:border-gray-700">
                        <span class="material-symbols-rounded text-gray-300 dark:text-gray-600 mb-3"
                            style="font-size: 48px;">edit_off</span>
                        <p class="text-text-sub-light dark:text-gray-400 text-sm">Belum ada setoran untuk diedit</p>
                    </div>
                    @endif
                </div>
            </div> <!-- End Tab Content: Edit Setoran -->
        </div>
    </div>
    <script>
        // Ensure global functions are defined on window
        window.fuzzyMatch = function (needle, haystack) {
            if (!haystack) return false;

            // 1. Direct substring (fastest)
            if (haystack.includes(needle)) return true;

            // 2. Subsequence match (handling missing letters)
            let needleIdx = 0;
            let haystackIdx = 0;
            while (needleIdx < needle.length && haystackIdx < haystack.length) {
                if (needle[needleIdx] === haystack[haystackIdx]) {
                    needleIdx++;
                }
                haystackIdx++;
            }
            return needleIdx === needle.length;
        };

        window.filterSantriOptions = function (query) {
            const items = document.querySelectorAll('.santri-option');
            const allOption = document.getElementById('optionAllSantri');
            const emptyMsg = document.getElementById('filterSantriEmpty');
            const searchIcon = document.getElementById('searchIcon');
            const clearIcon = document.getElementById('clearIcon');

            const q = (query || '').toLowerCase();
            let visible = 0;

            // Handle "Semua Santri" explicitly
            if (allOption) {
                if (q.length > 0) {
                    allOption.classList.add('hidden');
                } else {
                    allOption.classList.remove('hidden');
                }
            }

            // Toggle Icons
            if (searchIcon && clearIcon) {
                if (q.length > 0) {
                    searchIcon.classList.add('hidden');
                    clearIcon.classList.remove('hidden');
                } else {
                    searchIcon.classList.remove('hidden');
                    clearIcon.classList.add('hidden');
                }
            }

            // Filter Items
            items.forEach((item) => {
                if (item.id === 'optionAllSantri') return;

                const name = item.getAttribute('data-name');
                if (window.fuzzyMatch(q, name)) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });

            // Toggle Empty Message
            if (emptyMsg) {
                if (visible > 0) {
                    emptyMsg.classList.add('hidden');
                } else {
                    emptyMsg.classList.remove('hidden');
                }
            }
        };

        window.clearSearch = function () {
            const input = document.getElementById('filterSantriSearch');
            if (input) {
                input.value = '';
                filterSantriOptions(''); // Call global
                input.focus();
            }
        };

        window.selectSantriFilter = function (id, name) {
            const idInput = document.getElementById('filterSantriId');
            const searchInput = document.getElementById('filterSantriSearch');
            const form = document.getElementById('filterForm');

            if (idInput && searchInput && form) {
                idInput.value = id;
                searchInput.value = name;
                form.submit();
            }
        };

        window.selectFirstVisibleSantri = function () {
            const items = document.querySelectorAll('.santri-option:not(.hidden)');
            if (items.length > 0) {
                // Simulate click on the first visible item
                // Use the data attributes to call selectSantriFilter directly for robustness
                const firstItem = items[0];
                const onclickAttr = firstItem.getAttribute('onclick');
                if (firstItem.onclick) {
                    firstItem.click();
                } else if (onclickAttr) {
                    // Fallback if onclick property isn't set but attribute is (rare)
                    firstItem.click();
                }
            }
        };

        // Event Listeners
        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('filterSantriDropdown');
            const search = document.getElementById('filterSantriSearch');
            if (dropdown && search && !search.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('filterSantriSearch');
            if (input && input.value) {
                window.filterSantriOptions(input.value);
            }
            // Initialize Surah List
            initSurahList();
        });

        // ===== INPUT FORM FUNCTIONS =====

        // 114 Surah Data
        const allSurahs = [
            { n: 1, t: "Al-Fatihah", a: 7 }, { n: 2, t: "Al-Baqarah", a: 286 }, { n: 3, t: "Ali 'Imran", a: 200 }, { n: 4, t: "An-Nisa'", a: 176 },
            { n: 5, t: "Al-Ma'idah", a: 120 }, { n: 6, t: "Al-An'am", a: 165 }, { n: 7, t: "Al-A'raf", a: 206 }, { n: 8, t: "Al-Anfal", a: 75 },
            { n: 9, t: "At-Taubah", a: 129 }, { n: 10, t: "Yunus", a: 109 }, { n: 11, t: "Hud", a: 123 }, { n: 12, t: "Yusuf", a: 111 },
            { n: 78, t: "An-Naba'", a: 40 }, { n: 79, t: "An-Nazi'at", a: 46 }, { n: 80, t: "'Abasa", a: 42 }, { n: 81, t: "At-Takwir", a: 29 },
            { n: 82, t: "Al-Infitar", a: 19 }, { n: 83, t: "Al-Mutaffifin", a: 36 }, { n: 84, t: "Al-Insyiqaq", a: 25 }, { n: 85, t: "Al-Buruj", a: 22 },
            { n: 86, t: "At-Tariq", a: 17 }, { n: 87, t: "Al-A'la", a: 19 }, { n: 88, t: "Al-Ghasyiyah", a: 26 }, { n: 89, t: "Al-Fajr", a: 30 },
            { n: 90, t: "Al-Balad", a: 20 }, { n: 91, t: "Asy-Syams", a: 15 }, { n: 92, t: "Al-Lail", a: 21 }, { n: 93, t: "Ad-Duha", a: 11 },
            { n: 94, t: "Al-Insyirah", a: 8 }, { n: 95, t: "At-Tin", a: 8 }, { n: 96, t: "Al-'Alaq", a: 19 }, { n: 97, t: "Al-Qadr", a: 5 },
            { n: 98, t: "Al-Bayyinah", a: 8 }, { n: 99, t: "Az-Zalzalah", a: 8 }, { n: 100, t: "Al-'Adiyat", a: 11 }, { n: 101, t: "Al-Qari'ah", a: 11 },
            { n: 102, t: "At-Takasur", a: 8 }, { n: 103, t: "Al-'Asr", a: 3 }, { n: 104, t: "Al-Humazah", a: 9 }, { n: 105, t: "Al-Fil", a: 5 },
            { n: 106, t: "Quraysh", a: 4 }, { n: 107, t: "Al-Ma'un", a: 7 }, { n: 108, t: "Al-Kautsar", a: 3 }, { n: 109, t: "Al-Kafirun", a: 6 },
            { n: 110, t: "An-Nasr", a: 3 }, { n: 111, t: "Al-Lahab", a: 5 }, { n: 112, t: "Al-Ikhlas", a: 4 }, { n: 113, t: "Al-Falaq", a: 5 },
            { n: 114, t: "An-Nas", a: 6 }
        ];

        function initSurahList() {
            const container = document.getElementById('surahListContainer');
            if (!container) return;

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
                container.appendChild(btn);
            });
        }

        // Santri Functions
        window.showSantriDropdown = function () {
            document.getElementById('santriDropdown').classList.remove('hidden');
        };

        window.selectSantri = function (id, name) {
            const input = document.getElementById('santriSearch');
            const hidden = document.getElementById('santriIdInput');

            input.value = name;
            hidden.value = id;
            document.getElementById('santriDropdown').classList.add('hidden');
            document.querySelector('#santriIcon span').textContent = 'close';

            // Enable Surah Input
            document.getElementById('surahSearch').disabled = false;

            // Fetch Last Hafalan
            let basePath = window.location.href.split('?')[0].replace(/\/$/, "");
            const url = `${basePath}/last/${id}`;

            if (!id) return;

            fetch(url)
                .then(r => r.ok ? r.json() : { success: false })
                .then(result => {
                    const info = document.getElementById('autoFillInfo');
                    const text = document.getElementById('autoFillText');

                    if (result.success && result.data) {
                        info.classList.remove('hidden');
                        let message = 'Lanjutan dari: ' + result.data.surah + ' ayat ' + result.data.ayat_akhir;
                        text.innerHTML = `<span class="px-4">${message}</span><span class="px-4">${message}</span>`;

                        const nextAyat = parseInt(result.data.ayat_akhir) + 1;
                        document.querySelector('input[name="ayat_awal"]').value = nextAyat;
                        document.querySelector('input[name="ayat_akhir"]').value = nextAyat + 1;

                        toggleAyatInputs(true);
                        checkQualityInput();

                        document.getElementById('surahInput').value = result.data.surah;
                        document.getElementById('surahSearch').value = result.data.surah;
                        document.querySelector('#surahIcon span').textContent = 'close';
                    } else {
                        info.classList.add('hidden');
                        document.querySelector('input[name="ayat_awal"]').value = 0;
                        document.querySelector('input[name="ayat_akhir"]').value = 0;
                        document.getElementById('surahInput').value = '';
                        document.getElementById('surahSearch').value = '';
                        toggleAyatInputs(false);
                    }
                })
                .catch(() => {
                    document.getElementById('autoFillInfo').classList.add('hidden');
                });
        };

        window.filterSantri = function (query) {
            const items = document.querySelectorAll('.santri-item');
            const q = query.toLowerCase();
            const icon = document.querySelector('#santriIcon span');

            document.getElementById('santriDropdown').classList.remove('hidden');
            icon.textContent = query.length > 0 ? 'close' : 'search';

            let visible = 0;
            items.forEach(item => {
                const name = item.getAttribute('data-search');
                if (name && name.includes(q)) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });
            document.getElementById('santriEmpty').classList.toggle('hidden', visible > 0);
        };

        window.clearSantri = function (e) {
            if (e) e.stopPropagation();
            const input = document.getElementById('santriSearch');
            if (input.value.length > 0) {
                input.value = '';
                document.getElementById('santriIdInput').value = '';
                filterSantri('');
                document.querySelector('input[name="ayat_awal"]').value = 0;
                document.querySelector('input[name="ayat_akhir"]').value = 0;
                document.getElementById('surahInput').value = '';
                document.getElementById('surahSearch').value = '';
                document.querySelector('#surahIcon span').textContent = 'keyboard_arrow_down';
                document.getElementById('autoFillInfo').classList.add('hidden');
                document.getElementById('surahSearch').disabled = true;
                toggleAyatInputs(false);
                setRating(0);
                checkQualityInput();
            }
            showSantriDropdown();
            input.focus();
        };

        // Surah Functions
        window.showSurahDropdown = function () {
            document.getElementById('surahDropdown').classList.remove('hidden');
        };

        window.filterSurah = function (query) {
            const items = document.querySelectorAll('.surah-item');
            const q = query.toLowerCase().replace(/[^a-z]/g, '');
            const icon = document.querySelector('#surahIcon span');

            icon.textContent = query.length > 0 ? 'close' : 'keyboard_arrow_down';

            let visible = 0;
            items.forEach(item => {
                const name = item.getAttribute('data-name').replace(/[^a-z]/g, '');
                if (name.includes(q)) {
                    item.classList.remove('hidden');
                    visible++;
                } else {
                    item.classList.add('hidden');
                }
            });
            document.getElementById('surahEmpty').classList.toggle('hidden', visible > 0);
        };

        window.clearSurah = function (e) {
            if (e) e.stopPropagation();
            const input = document.getElementById('surahSearch');
            if (input.value.length > 0) {
                input.value = '';
                document.getElementById('surahInput').value = '';
                filterSurah('');
                toggleAyatInputs(false);
            }
            showSurahDropdown();
            input.focus();
        };

        window.selectSurah = function (name) {
            document.getElementById('surahInput').value = name;
            document.getElementById('surahSearch').value = name;
            document.getElementById('surahDropdown').classList.add('hidden');
            document.querySelector('#surahIcon span').textContent = 'close';
            toggleAyatInputs(true);
        };

        // Ayat Functions
        window.toggleAyatInputs = function (enable) {
            const inputs = document.querySelectorAll('.ayat-input');
            const buttons = document.querySelectorAll('.ayat-btn');
            inputs.forEach(el => el.disabled = !enable);
            buttons.forEach(btn => btn.disabled = !enable);
        };

        window.adjustAyat = function (fieldName, delta) {
            const input = document.querySelector(`input[name="${fieldName}"]`);
            const otherName = fieldName === 'ayat_awal' ? 'ayat_akhir' : 'ayat_awal';
            const otherInput = document.querySelector(`input[name="${otherName}"]`);

            if (input && otherInput) {
                let val = parseInt(input.value) || 0;
                let otherVal = parseInt(otherInput.value) || 0;
                let newVal = val + delta;
                if (newVal < 1) newVal = 1;

                if (fieldName === 'ayat_awal') {
                    input.value = newVal;
                    if (newVal > otherVal) otherInput.value = newVal;
                } else {
                    if (newVal < otherVal) newVal = otherVal;
                    input.value = newVal;
                }
                checkQualityInput();
            }
        };

        window.syncAyatManual = function (val) {
            const startVal = parseInt(val) || 0;
            const endInput = document.querySelector('input[name="ayat_akhir"]');
            if (endInput && startVal > parseInt(endInput.value || 0)) {
                endInput.value = startVal;
            }
            checkQualityInput();
        };

        window.highlightStepBtn = function (btn) {
            const allBtns = document.querySelectorAll('.stepper-btn');
            allBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-white');
                b.classList.add('bg-white', 'dark:bg-surface-dark');
            });
            btn.classList.remove('bg-white', 'dark:bg-surface-dark');
            btn.classList.add('bg-primary', 'text-white');
        };

        // Quality Functions
        window.checkQualityInput = function () {
            const ayatAkhir = document.querySelector('input[name="ayat_akhir"]');
            const section = document.getElementById('qualitySection');
            if (ayatAkhir && parseInt(ayatAkhir.value) > 0) {
                section.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                section.classList.add('opacity-50', 'pointer-events-none');
            }
        };

        window.setRating = function (rating) {
            document.getElementById('nilaiInput').value = rating;
            const stars = document.querySelectorAll('.star-btn');
            const labels = ['Belum Dinilai', 'Tidak Lancar', 'Kurang Lancar', 'Lancar', 'Sangat Lancar', 'Sempurna'];

            stars.forEach((star, idx) => {
                const icon = star.querySelector('.material-symbols-rounded');
                if (idx < rating) {
                    icon.classList.remove('text-gray-300', 'dark:text-gray-600');
                    icon.classList.add('text-yellow-400');
                } else {
                    icon.classList.add('text-gray-300', 'dark:text-gray-600');
                    icon.classList.remove('text-yellow-400');
                }
            });
            document.getElementById('ratingLabel').textContent = labels[rating];
        };

        // Close dropdowns on outside click
        document.addEventListener('click', function (e) {
            const santriSearch = document.getElementById('santriSearch');
            const santriDropdown = document.getElementById('santriDropdown');
            if (santriSearch && santriDropdown && !santriSearch.contains(e.target) && !santriDropdown.contains(e.target)) {
                santriDropdown.classList.add('hidden');
            }

            const surahSearch = document.getElementById('surahSearch');
            const surahDropdown = document.getElementById('surahDropdown');
            if (surahSearch && surahDropdown && !surahSearch.contains(e.target) && !surahDropdown.contains(e.target)) {
                surahDropdown.classList.add('hidden');
            }
        });

        // Form Submit
        document.getElementById('setoranForm')?.addEventListener('submit', function (e) {
            const ayatAwal = parseInt(document.querySelector('input[name="ayat_awal"]').value) || 0;
            const ayatAkhir = parseInt(document.querySelector('input[name="ayat_akhir"]').value) || 0;

            if (ayatAkhir < ayatAwal) {
                e.preventDefault();
                alert('Ayat Akhir harus >= Ayat Awal!');
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

            const btn = document.getElementById('submitBtn');
            const text = document.getElementById('submitText');
            const icon = document.getElementById('submitIcon');
            const spinner = document.getElementById('submitSpinner');

            btn.disabled = true;
            btn.classList.add('opacity-75');
            text.textContent = 'Menyimpan...';
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
        });

        // ===== VOICE RECORDER FUNCTIONS =====
        let mediaRecorder = null;
        let audioChunks = [];
        let recordingInterval = null;
        let audioBlob = null;
        let audioURL = null;
        let audioPlayer = null;

        window.startRecording = async function () {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = (e) => {
                    audioChunks.push(e.data);
                };

                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    audioURL = URL.createObjectURL(audioBlob);

                    // Create file for form submission
                    const file = new File([audioBlob], 'recording.webm', { type: 'audio/webm' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('voiceNoteInput').files = dataTransfer.files;

                    // Show preview
                    document.getElementById('recorderActive').classList.add('hidden');
                    document.getElementById('recorderPreview').classList.remove('hidden');

                    // Set duration
                    const audio = new Audio(audioURL);
                    audio.onloadedmetadata = () => {
                        const dur = Math.floor(audio.duration);
                        document.getElementById('audioDuration').textContent = `${Math.floor(dur / 60)}:${(dur % 60).toString().padStart(2, '0')}`;
                    };
                    audioPlayer = audio;
                };

                mediaRecorder.start();

                // Show recording UI
                document.getElementById('recorderInitial').classList.add('hidden');
                document.getElementById('recorderActive').classList.remove('hidden');

                // Start timer
                let seconds = 0;
                recordingInterval = setInterval(() => {
                    seconds++;
                    const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
                    const secs = (seconds % 60).toString().padStart(2, '0');
                    document.getElementById('recordingTimer').textContent = `${mins}:${secs}`;
                }, 1000);

            } catch (err) {
                alert('Tidak dapat mengakses mikrofon. Pastikan izin sudah diberikan.');
                console.error('Recording error:', err);
            }
        };

        window.stopRecording = function () {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
            if (recordingInterval) {
                clearInterval(recordingInterval);
                recordingInterval = null;
            }
        };

        window.togglePlayInfo = function () {
            const btn = document.getElementById('playBtn');
            const icon = btn.querySelector('.material-symbols-rounded');

            if (audioPlayer) {
                if (audioPlayer.paused) {
                    audioPlayer.play();
                    icon.textContent = 'pause';
                } else {
                    audioPlayer.pause();
                    icon.textContent = 'play_arrow';
                }

                audioPlayer.onended = () => {
                    icon.textContent = 'play_arrow';
                };
            }
        };

        window.deleteRecording = function () {
            if (audioPlayer) {
                audioPlayer.pause();
                audioPlayer = null;
            }
            audioBlob = null;
            audioURL = null;
            audioChunks = [];

            // Clear file input
            document.getElementById('voiceNoteInput').value = '';

            // Reset UI
            document.getElementById('recorderPreview').classList.add('hidden');
            document.getElementById('recorderInitial').classList.remove('hidden');
            document.getElementById('recordingTimer').textContent = '00:00';
        };

        // Tab Switching Function
        window.switchTab = function (tab) {
            const tabInputBaru = document.getElementById('tabInputBaru');
            const tabEditSetoran = document.getElementById('tabEditSetoran');
            const contentInputBaru = document.getElementById('contentInputBaru');
            const contentEditSetoran = document.getElementById('contentEditSetoran');

            if (tab === 'input') {
                // Activate Input Baru Tab (Blue)
                tabInputBaru.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-primary text-white shadow-lg shadow-primary/30';
                tabEditSetoran.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400';

                // Show/Hide Content
                contentInputBaru.classList.remove('hidden');
                contentEditSetoran.classList.add('hidden');
            } else {
                // Activate Edit Setoran Tab (Green/Emerald)
                tabEditSetoran.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-emerald-500 text-white shadow-lg shadow-emerald-500/30';
                tabInputBaru.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-primary/10 hover:text-primary';

                // Show/Hide Content
                contentEditSetoran.classList.remove('hidden');
                contentInputBaru.classList.add('hidden');
            }
        };

        // Edit Modal Functions
        window.openEditModal = function (setoran) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            if (modal && form) {
                // Set form action with dynamic ID
                form.action = '/ustadz/hafalan/' + setoran.id;

                // Populate form with setoran data
                document.getElementById('editSetoranId').value = setoran.id || '';
                document.getElementById('editSurah').value = setoran.surah || '';
                document.getElementById('editAyatAwal').value = setoran.ayat_awal || '';
                document.getElementById('editAyatAkhir').value = setoran.ayat_akhir || '';
                document.getElementById('editNilai').value = setoran.nilai || 1;
                document.getElementById('editCatatan').value = setoran.catatan || '';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        };

        window.closeEditModal = function () {
            const modal = document.getElementById('editModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        };
    </script>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        onclick="if(event.target === this) closeEditModal()">
        <div class="bg-white dark:bg-surface-dark rounded-3xl shadow-2xl w-full max-w-[380px] max-h-[90vh] overflow-hidden"
            onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-4 text-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold">Edit Setoran</h3>
                    <button onclick="closeEditModal()"
                        class="size-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors">
                        <span class="material-symbols-rounded text-[20px]">close</span>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="editForm" method="POST" class="p-4 space-y-4 overflow-y-auto max-h-[60vh]">
                @csrf
                @method('PUT')
                <input type="hidden" id="editSetoranId" name="setoran_id">

                <!-- Surah -->
                <div>
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Surah</label>
                    <input type="text" id="editSurah" name="surah" readonly
                        class="w-full h-12 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700">
                </div>

                <!-- Ayat Range -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Ayat
                            Awal</label>
                        <input type="number" id="editAyatAwal" name="ayat_awal" min="1"
                            class="w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Ayat
                            Akhir</label>
                        <input type="number" id="editAyatAkhir" name="ayat_akhir" min="1"
                            class="w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>

                <!-- Nilai -->
                <div>
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Nilai (1-5)</label>
                    <select id="editNilai" name="nilai"
                        class="w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="1">1 - Kurang</option>
                        <option value="2">2 - Cukup</option>
                        <option value="3">3 - Jayyid</option>
                        <option value="4">4 - Jayyid Jiddan</option>
                        <option value="5">5 - Mumtaz</option>
                    </select>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Catatan</label>
                    <textarea id="editCatatan" name="catatan" rows="3"
                        class="w-full rounded-xl border-none bg-white dark:bg-surface-dark p-4 text-sm font-normal ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none resize-none"
                        placeholder="Catatan untuk santri"></textarea>
                </div>
            </form>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex gap-3">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-semibold text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    Batal
                </button>
                <button type="submit" form="editForm"
                    class="flex-1 h-12 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold text-sm hover:from-emerald-600 hover:to-teal-600 shadow-lg shadow-emerald-500/30 transition-all">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</body>

</html>
