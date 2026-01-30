<!DOCTYPE html>
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
                        primary: "#4A90B8", "primary-dark": "#2E6B8A", "header-blue": "#3D7A9E", "header-dark": "#2A5A78",
                        "background-light": "#F2F4F8", "background-dark": "#121212", "surface-light": "#FFFFFF", "surface-dark": "#1E1E1E",
                        "text-main-light": "#2D3748", "text-sub-light": "#A0AEC0",
                    },
                    fontFamily: { display: ["Poppins", "sans-serif"] },
                    boxShadow: { 'soft': '0 20px 40px -10px rgba(74, 144, 184, 0.15)', 'card': '0 10px 25px -5px rgba(0, 0, 0, 0.05)' }
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

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass-nav {
            background: rgba(30, 30, 30, 0.85);
        }

        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
            display: none;
        }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark') { document.documentElement.classList.add('dark'); } else { document.documentElement.classList.remove('dark'); }
    </script>
</head>

<body
    class="bg-background-light dark:bg-background-dark min-h-screen flex justify-center items-start p-0 sm:py-4 transition-colors duration-200">

    <!-- Mobile Wrapper -->
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl pb-24">
        <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar pb-6">
            <header
                class="flex items-center bg-white dark:bg-surface-dark h-14 px-4 shadow-sm mx-6 rounded-2xl mt-6 mb-4 border border-gray-100 dark:border-gray-800">
                <div class="w-full flex items-center justify-center relative">
                    <h1
                        class="text-gray-800 dark:text-white text-base font-bold leading-tight tracking-tight text-center">
                        Setoran Hafalan</h1>
                </div>
            </header>

            <div class="mx-6 mb-6 pt-0 relative z-20">
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

                <div class="flex gap-2 mb-4">
                    <button id="tabInputBaru" onclick="switchTab('input')"
                        class="tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-primary text-white shadow-lg shadow-primary/30">
                        <span class="material-symbols-rounded text-[18px]">add_circle</span><span>Input Baru</span>
                    </button>
                    <button id="tabEditSetoran" onclick="switchTab('edit')"
                        class="tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400">
                        <span class="material-symbols-rounded text-[18px]">edit_note</span><span>Edit Setoran</span>
                    </button>
                </div>

                <div id="contentInputBaru" class="tab-content">
                    @if(isset($isScheduleActive) && !$isScheduleActive)
                    <div class="flex flex-col items-center justify-center py-6 px-4 text-center">
                        <div
                            class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-2">
                            <span class="material-symbols-rounded text-gray-400 text-[24px]">timer_off</span>
                        </div>
                        <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200">Input Hafalan Ditutup</h3>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 max-w-xs mt-1">{{ $scheduleMessage ??
                            'Mohon input setoran sesuai jadwal KBM yang berlaku.' }}</p>
                    </div>
                    @else
                    <form action="{{ route('ustadz.hafalan.store') }}" method="POST" id="setoranForm"
                        enctype="multipart/form-data" class="mb-6">
                        @csrf
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">Nama
                                    Santri <span id="checkSantri" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span></label>
                                <input type="hidden" name="santri_id" id="santriIdInput" required>
                                <div class="relative z-50">
                                    <input type="text" id="santriSearch" placeholder="Cari nama santri"
                                        class="peer flex w-full h-14 rounded-xl border-none bg-white dark:bg-surface-dark text-[#111813] dark:text-white placeholder:text-gray-400 p-[15px] pr-12 text-sm font-medium leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow relative z-10"
                                        onfocus="showSantriDropdown()" onclick="showSantriDropdown()"
                                        oninput="filterSantri(this.value)" autocomplete="off" />
                                    <div id="santriIcon" onclick="clearSantri(event)"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-primary flex items-center justify-center cursor-pointer transition-colors hover:text-red-500 z-20">
                                        <span class="material-symbols-rounded" style="font-size: 24px;">search</span>
                                    </div>
                                    <div id="santriDropdown"
                                        class="hidden absolute left-0 right-0 top-full mt-1 bg-white dark:bg-surface-dark rounded-xl shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 max-h-48 overflow-y-auto z-[100]">
                                        @foreach($santriList as $santri)
                                        <button type="button"
                                            onclick="selectSantri('{{ $santri->id }}', '{{ addslashes($santri->name) }}')"
                                            data-id="{{ $santri->id }}" data-name="{{ $santri->name }}"
                                            class="santri-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-primary/10 transition-colors"
                                            data-search="{{ strtolower($santri->name) }}">
                                            <div
                                                class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm font-bold">
                                                {{ substr($santri->name, 0, 1) }}</div>
                                            <span class="text-sm font-medium flex-1">{{ $santri->name }}</span>
                                        </button>
                                        @endforeach
                                        <div id="santriEmpty"
                                            class="hidden px-4 py-4 text-center text-gray-400 text-sm">Tidak ditemukan
                                        </div>
                                    </div>
                                </div>
                                <div id="autoFillInfo" class="hidden animate-enter mt-1">
                                    <div
                                        class="relative overflow-hidden bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50 rounded-xl p-4 flex gap-4">
                                        <div class="shrink-0 flex flex-col items-center justify-center gap-1">
                                            <div
                                                class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-800/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                                                <span class="material-symbols-rounded text-xl">history_edu</span>
                                            </div>
                                            <span
                                                class="text-[10px] uppercase font-bold text-amber-600/80 dark:text-amber-400/80 tracking-wider">Terakhir</span>
                                        </div>
                                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                                            <div class="flex items-baseline gap-2 mb-1">
                                                <h4 id="lastSurahName"
                                                    class="font-bold text-base text-gray-800 dark:text-white truncate">
                                                    Al-Baqarah</h4>
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Ayat
                                                    <span id="lastAyatNum"
                                                        class="font-mono font-bold text-amber-600 dark:text-amber-400">105</span></span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs">
                                                <span class="text-gray-500 dark:text-gray-400">Lanjut ke:</span>
                                                <span id="nextAyatBadge"
                                                    class="px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-800/40 text-amber-700 dark:text-amber-300 font-bold font-mono">Ayat
                                                    106</span>
                                            </div>
                                        </div>
                                        <span
                                            class="material-symbols-rounded absolute -right-2 -bottom-4 text-[64px] text-amber-500/5 pointer-events-none">auto_stories</span>
                                    </div>
                                </div>
                            </div>

                            <div id="hafalanSection" class="scroll-mt-5 flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">Materi
                                    Hafalan <span id="checkSurah" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span></label>
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

                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">Rentang
                                    Ayat <span id="checkAyat" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span></label>
                                <div class="relative flex items-center gap-2">
                                    <button type="button" onclick="adjustAyat('ayat_awal', 1)" disabled
                                        class="stepper-btn ayat-btn size-10 flex shrink-0 items-center justify-center rounded-full bg-white dark:bg-surface-dark text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 active:bg-primary active:text-white transition-all disabled:opacity-50 disabled:cursor-not-allowed"><span
                                            class="material-symbols-rounded">add</span></button>
                                    <input name="ayat_awal" type="number" min="0" required placeholder="Awal" value="0"
                                        disabled oninput="syncAyatManual(this.value)"
                                        class="ayat-input flex-1 w-full h-12 rounded-xl border-none bg-transparent text-[#111813] dark:text-white p-[10px] text-center text-sm font-medium shadow-none ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed" />
                                    <button type="button" onclick="adjustAyat('ayat_akhir', -1)" disabled
                                        class="stepper-btn ayat-btn size-10 flex shrink-0 items-center justify-center rounded-full bg-white dark:bg-surface-dark text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 active:bg-primary active:text-white transition-all disabled:opacity-50 disabled:cursor-not-allowed z-10"><span
                                            class="material-symbols-rounded">remove</span></button>
                                    <input name="ayat_akhir" type="number" min="0" required placeholder="Akhir"
                                        value="0" disabled oninput="checkQualityInput()"
                                        class="ayat-input flex-1 w-full h-12 rounded-xl border-none bg-transparent text-[#111813] dark:text-white p-[10px] text-center text-sm font-medium shadow-none ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none transition-shadow disabled:opacity-50 disabled:cursor-not-allowed" />
                                    <button type="button" onclick="adjustAyat('ayat_akhir', 1)" disabled
                                        class="stepper-btn ayat-btn size-10 flex shrink-0 items-center justify-center rounded-full bg-white dark:bg-surface-dark text-gray-600 dark:text-gray-400 ring-1 ring-inset ring-gray-200 dark:ring-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 active:scale-95 active:bg-primary active:text-white transition-all disabled:opacity-50 disabled:cursor-not-allowed"><span
                                            class="material-symbols-rounded">add</span></button>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal flex items-center gap-2">Kualitas
                                    Bacaan <span id="checkNilai" class="hidden text-green-500 material-symbols-rounded"
                                        style="font-size: 16px;">check_circle</span></label>
                                <div id="qualitySection"
                                    class="flex flex-col gap-2 bg-white dark:bg-surface-dark px-4 py-6 rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-700 opacity-50 pointer-events-none transition-all w-full">
                                    <input type="hidden" name="nilai" id="nilaiInput" value="0">
                                    <div class="flex items-center justify-center gap-4 w-full">
                                        @for($i=1; $i<=5; $i++) <button type="button" onclick="setRating({{ $i }})"
                                            class="star-btn group relative focus:outline-none transition-all duration-300">
                                            <span
                                                class="material-symbols-rounded text-gray-300 dark:text-gray-600 transition-all duration-300 group-hover:scale-110 group-hover:text-yellow-400 group-active:scale-95"
                                                style="font-size: 32px;">hotel_class</span>
                                            </button>
                                            @endfor
                                    </div>
                                    <div id="ratingLabelContainer" class="flex items-center justify-center">
                                        <span id="ratingLabel"
                                            class="inline-flex items-center rounded-full bg-yellow-50 dark:bg-yellow-900/30 px-2 py-0.5 text-[10px] font-medium text-yellow-800 dark:text-yellow-300 ring-1 ring-inset ring-yellow-600/20">Belum
                                            Dinilai</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal">Rekaman
                                    Suara</label>
                                <input type="file" name="voice_note" id="voiceNoteInput" accept="audio/*"
                                    class="hidden">
                                <div id="recorderInitial" onclick="startRecording()"
                                    class="flex items-center gap-3 p-3 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-white dark:bg-surface-dark cursor-pointer hover:border-primary hover:bg-blue-50/50 dark:hover:bg-blue-900/10 transition-all group">
                                    <div
                                        class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                        <span class="material-symbols-rounded animate-pulse"
                                            style="font-size: 20px;">mic</span>
                                    </div>
                                    <div class="flex flex-col flex-1"><span
                                            class="text-sm font-semibold text-[#111813] dark:text-white">Rekam
                                            Suara</span><span class="text-xs text-gray-500 dark:text-gray-400">Ketuk
                                            untuk mulai merekam</span></div>
                                </div>
                                <div id="recorderActive"
                                    class="hidden flex items-center gap-3 p-3 rounded-xl border border-primary bg-red-50 dark:bg-red-900/10">
                                    <div
                                        class="size-10 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center relative">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
                                            class="material-symbols-rounded text-red-600 dark:text-red-400 relative z-10"
                                            style="font-size: 20px;">mic_off</span>
                                    </div>
                                    <div class="flex flex-col flex-1"><span
                                            class="text-sm font-bold text-red-600 dark:text-red-400">Merekam...</span><span
                                            id="recordingTimer"
                                            class="text-xs font-mono text-gray-600 dark:text-gray-300">00:00</span>
                                    </div>
                                    <button type="button" onclick="stopRecording()"
                                        class="size-9 flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white shadow-lg transition-transform active:scale-95"><span
                                            class="material-symbols-rounded"
                                            style="font-size: 20px;">stop_circle</span></button>
                                </div>
                                <div id="recorderPreview"
                                    class="hidden flex items-center gap-3 p-3 rounded-xl border border-primary/30 bg-blue-50 dark:bg-blue-900/10">
                                    <button type="button" onclick="togglePlayInfo()" id="playBtn"
                                        class="size-9 flex shrink-0 items-center justify-center rounded-full bg-primary text-white hover:bg-primary-dark transition-colors"><span
                                            class="material-symbols-rounded pl-0.5"
                                            style="font-size: 20px;">play_arrow</span></button>
                                    <div class="flex flex-col flex-1 overflow-hidden"><span
                                            class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">Rekaman
                                            Pesan</span><span id="audioDuration"
                                            class="text-xs text-gray-500 dark:text-gray-400">Siap dikirim</span></div>
                                    <button type="button" onclick="deleteRecording()"
                                        class="size-8 flex shrink-0 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-900/30 dark:hover:text-red-400 transition-colors"><span
                                            class="material-symbols-rounded"
                                            style="font-size: 18px;">delete</span></button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label
                                    class="text-[#111813] dark:text-gray-200 text-sm font-bold leading-normal">Catatan</label>
                                <textarea name="catatan" rows="7"
                                    class="flex w-full rounded-xl border-none bg-white dark:bg-surface-dark text-[#111813] dark:text-white p-3 text-sm font-normal leading-normal shadow-sm ring-1 ring-inset ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-primary focus:outline-none resize-none transition-shadow"
                                    placeholder="Tulis catatan untuk santri (opsional)"></textarea>
                            </div>
                            <div class="h-24"></div>
                            <div
                                class="fixed bottom-0 left-0 right-0 px-6 py-4 bg-white dark:bg-surface-dark border-t border-gray-200 dark:border-gray-800 z-40 transform translate-y-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
                                <button type="submit" id="submitBtn"
                                    class="w-full flex items-center justify-center gap-2 h-12 bg-gradient-to-r from-primary to-[#3D7A9E] hover:from-primary-dark hover:to-[#2A5A78] active:scale-[0.98] rounded-xl transition-all shadow-lg shadow-primary/30">
                                    <span id="submitText" class="text-white text-sm font-bold tracking-wide">Simpan
                                        Setoran</span><span id="submitIcon" class="material-symbols-rounded text-white"
                                        style="font-size: 18px;">check_circle</span><span id="submitSpinner"
                                        class="hidden animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>

                <div id="contentEditSetoran" class="tab-content hidden">
                    <div id="editSetoranStickyHeader"
                        class="sticky top-0 z-30 bg-background-light dark:bg-background-dark py-3 px-6 mb-4">
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
                    <div class="px-6 pb-6">
                        @if(isset($riwayatSetoran) && count($riwayatSetoran) > 0)
                        <div class="flex flex-col gap-3">
                            @foreach($riwayatSetoran as $setoran)
                            @php
                            $nilaiStr = $setoran->nilai ?? '';
                            $nilaiMap = ['Tidak Lancar' => 1, 'Kurang Lancar' => 2, 'Lancar' => 3, 'Sangat Lancar' => 4,
                            'Sempurna' => 5];
                            $nilai = $nilaiMap[$nilaiStr] ?? (is_numeric($nilaiStr) ? intval($nilaiStr) : 0);
                            $nilaiLabels = ['', 'Kurang', 'Cukup', 'Jayyid', 'Jayyid Jiddan', 'Mumtaz'];
                            $nilaiColors = ['', 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                            'bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400', 'bg-blue-100
                            text-blue-600 dark:bg-blue-900/30 dark:text-blue-400', 'bg-teal-100 text-teal-600
                            dark:bg-teal-900/30 dark:text-teal-400', 'bg-green-100 text-green-600 dark:bg-green-900/30
                            dark:text-green-400'];
                            @endphp
                            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4 group hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors cursor-pointer"
                                onclick="openEditModalById({{ $setoran->id }})">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
                                    <span
                                        class="material-symbols-rounded text-emerald-600 dark:text-emerald-400 text-[24px]">edit</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-text-main-light dark:text-white truncate">
                                        Surah {{ $setoran->surah }}</h4>
                                    <p class="text-text-sub-light dark:text-gray-400 text-xs mt-0.5">Ayat {{
                                        $setoran->ayat_awal }}-{{ $setoran->ayat_akhir }} • {{ $setoran->santri->name ??
                                        'Santri' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[10px] font-bold flex-shrink-0 {{ $nilaiColors[$nilai] ?? 'bg-gray-100 text-gray-600' }}">{{
                                        $nilaiLabels[$nilai] ?? 'Nilai' }}</span>
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
                </div>
            </div>
        </div>
    </div>
    <script>
        window.setoranData = {};
        @if (isset($riwayatSetoran))
            @foreach($riwayatSetoran as $s)
        window.setoranData[{{ $s -> id }}] = @json($s);
        window.setoranData[{{ $s -> id }}].nilai_numeric = {{ $nilaiMap[$s -> nilai] ?? (is_numeric($s -> nilai) ? intval($s -> nilai) : 0) }};
        window.setoranData[{{ $s -> id }}].santri_name = "{{ $s->santri->name ?? '' }}";
        @endforeach
        @endif

        const allSurahs = [
            { n: 1, t: "Al-Fatihah", a: 7 }, { n: 2, t: "Al-Baqarah", a: 286 }, { n: 3, t: "Ali 'Imran", a: 200 }, { n: 4, t: "An-Nisa'", a: 176 }, { n: 5, t: "Al-Ma'idah", a: 120 }, { n: 6, t: "Al-An'am", a: 165 }, { n: 7, t: "Al-A'raf", a: 206 }, { n: 8, t: "Al-Anfal", a: 75 }, { n: 9, t: "At-Taubah", a: 129 }, { n: 10, t: "Yunus", a: 109 }, { n: 11, t: "Hud", a: 123 }, { n: 12, t: "Yusuf", a: 111 },
            { n: 78, t: "An-Naba'", a: 40 }, { n: 79, t: "An-Nazi'at", a: 46 }, { n: 80, t: "'Abasa", a: 42 }, { n: 81, t: "At-Takwir", a: 29 }, { n: 82, t: "Al-Infitar", a: 19 }, { n: 83, t: "Al-Mutaffifin", a: 36 }, { n: 84, t: "Al-Insyiqaq", a: 25 }, { n: 85, t: "Al-Buruj", a: 22 }, { n: 86, t: "At-Tariq", a: 17 }, { n: 87, t: "Al-A'la", a: 19 }, { n: 88, t: "Al-Ghasyiyah", a: 26 }, { n: 89, t: "Al-Fajr", a: 30 }, { n: 90, t: "Al-Balad", a: 20 }, { n: 91, t: "Asy-Syams", a: 15 }, { n: 92, t: "Al-Lail", a: 21 }, { n: 93, t: "Ad-Duha", a: 11 }, { n: 94, t: "Al-Insyirah", a: 8 }, { n: 95, t: "At-Tin", a: 8 }, { n: 96, t: "Al-'Alaq", a: 19 }, { n: 97, t: "Al-Qadr", a: 5 }, { n: 98, t: "Al-Bayyinah", a: 8 }, { n: 99, t: "Az-Zalzalah", a: 8 }, { n: 100, t: "Al-'Adiyat", a: 11 }, { n: 101, t: "Al-Qari'ah", a: 11 }, { n: 102, t: "At-Takasur", a: 8 }, { n: 103, t: "Al-'Asr", a: 3 }, { n: 104, t: "Al-Humazah", a: 9 }, { n: 105, t: "Al-Fil", a: 5 }, { n: 106, t: "Quraysh", a: 4 }, { n: 107, t: "Al-Ma'un", a: 7 }, { n: 108, t: "Al-Kautsar", a: 3 }, { n: 109, t: "Al-Kafirun", a: 6 }, { n: 110, t: "An-Nasr", a: 3 }, { n: 111, t: "Al-Lahab", a: 5 }, { n: 112, t: "Al-Ikhlas", a: 4 }, { n: 113, t: "Al-Falaq", a: 5 }, { n: 114, t: "An-Nas", a: 6 }
        ];

        function initSurahList() {
            const container = document.getElementById('surahListContainer');
            if (container) {
                allSurahs.forEach(s => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'surah-item w-full flex items-center gap-3 px-4 py-3 text-left hover:bg-gray-50 dark:hover:bg-white/5 transition-colors border-b border-gray-100 dark:border-gray-800 last:border-0';
                    btn.innerHTML = `<div class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold shrink-0">${s.n}</div><div class="flex flex-col flex-1"><span class="text-sm font-medium text-gray-700 dark:text-gray-200">${s.t}</span><span class="text-[10px] text-gray-400">${s.a} Ayat</span></div>`;
                    btn.onclick = () => selectSurah(s.t);
                    btn.setAttribute('data-name', s.t.toLowerCase());
                    container.appendChild(btn);
                });
            }
        }

        window.showSantriDropdown = function () {
            document.getElementById('santriDropdown').classList.remove('hidden');
            document.querySelectorAll('.santri-item').forEach(item => item.classList.remove('hidden'));
            document.getElementById('santriEmpty').classList.add('hidden');
        };

        window.selectSantri = function (id, name) {
            document.getElementById('santriSearch').value = name;
            document.getElementById('santriIdInput').value = id;
            document.getElementById('santriDropdown').classList.add('hidden');
            document.querySelector('#santriIcon span').textContent = 'close';
            document.getElementById('surahSearch').disabled = false;
            let basePath = window.location.href.split('?')[0].replace(/\/$/, "");
            fetch(`${basePath}/last/${id}`).then(r => r.ok ? r.json() : { success: false }).then(result => {
                const info = document.getElementById('autoFillInfo');
                if (result.success && result.data) {
                    info.classList.remove('hidden');
                    document.getElementById('lastSurahName').textContent = result.data.surah;
                    document.getElementById('lastAyatNum').textContent = result.data.ayat_akhir;
                    const nextAyat = parseInt(result.data.ayat_akhir) + 1;
                    document.getElementById('nextAyatBadge').textContent = 'Ayat ' + nextAyat;
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
            }).catch(() => document.getElementById('autoFillInfo').classList.add('hidden'));
        };

        window.filterSantri = function (query) {
            const items = document.querySelectorAll('.santri-item');
            const q = query.toLowerCase();
            document.querySelector('#santriIcon span').textContent = query.length > 0 ? 'close' : 'search';
            document.getElementById('santriDropdown').classList.remove('hidden');
            let visible = 0;
            items.forEach(item => {
                if (item.getAttribute('data-search').includes(q)) {
                    item.classList.remove('hidden'); visible++;
                } else { item.classList.add('hidden'); }
            });
            document.getElementById('santriEmpty').classList.toggle('hidden', visible > 0);
        };

        window.clearSantri = function (e) {
            e.stopPropagation();
            if (document.getElementById('santriSearch').value.length > 0) {
                document.getElementById('santriSearch').value = '';
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
            document.getElementById('santriSearch').focus();
        };

        window.showSurahDropdown = function () { document.getElementById('surahDropdown').classList.remove('hidden'); };
        window.filterSurah = function (query) {
            const items = document.querySelectorAll('.surah-item');
            const q = query.toLowerCase().replace(/[^a-z]/g, '');
            document.querySelector('#surahIcon span').textContent = query.length > 0 ? 'close' : 'keyboard_arrow_down';
            let visible = 0;
            items.forEach(item => {
                if (item.getAttribute('data-name').replace(/[^a-z]/g, '').includes(q)) {
                    item.classList.remove('hidden'); visible++;
                } else { item.classList.add('hidden'); }
            });
            document.getElementById('surahEmpty').classList.toggle('hidden', visible > 0);
        };
        window.clearSurah = function (e) {
            e.stopPropagation();
            if (document.getElementById('surahSearch').value.length > 0) {
                document.getElementById('surahSearch').value = '';
                document.getElementById('surahInput').value = '';
                filterSurah('');
                toggleAyatInputs(false);
            }
            showSurahDropdown();
            document.getElementById('surahSearch').focus();
        };
        window.selectSurah = function (name) {
            document.getElementById('surahInput').value = name;
            document.getElementById('surahSearch').value = name;
            document.getElementById('surahDropdown').classList.add('hidden');
            document.querySelector('#surahIcon span').textContent = 'close';
            toggleAyatInputs(true);
        };
        window.toggleAyatInputs = function (enable) {
            document.querySelectorAll('.ayat-input').forEach(el => el.disabled = !enable);
            document.querySelectorAll('.ayat-btn').forEach(btn => btn.disabled = !enable);
        };
        window.adjustAyat = function (fieldName, delta) {
            const input = document.querySelector(`input[name="${fieldName}"]`);
            const otherName = fieldName === 'ayat_awal' ? 'ayat_akhir' : 'ayat_awal';
            const otherInput = document.querySelector(`input[name="${otherName}"]`);
            if (input && otherInput) {
                let val = parseInt(input.value) || 0, otherVal = parseInt(otherInput.value) || 0;
                let newVal = Math.max(1, val + delta);
                if (fieldName === 'ayat_awal') { input.value = newVal; if (newVal > otherVal) otherInput.value = newVal; }
                else { if (newVal < otherVal) otherInput.value = newVal; input.value = newVal; }
                checkQualityInput();
            }
        };
        window.syncAyatManual = function (val) {
            const startVal = parseInt(val) || 0;
            const endInput = document.querySelector('input[name="ayat_akhir"]');
            if (endInput && startVal > parseInt(endInput.value || 0)) endInput.value = startVal;
            checkQualityInput();
        };
        window.checkQualityInput = function () {
            const ayatAkhir = document.querySelector('input[name="ayat_akhir"]');
            const section = document.getElementById('qualitySection');
            if (ayatAkhir && parseInt(ayatAkhir.value) > 0) section.classList.remove('opacity-50', 'pointer-events-none');
            else section.classList.add('opacity-50', 'pointer-events-none');
        };
        window.setRating = function (rating) {
            document.getElementById('nilaiInput').value = rating;
            const labels = ['Belum Dinilai', 'Tidak Lancar', 'Kurang Lancar', 'Lancar', 'Sangat Lancar', 'Sempurna'];
            document.querySelectorAll('.star-btn').forEach((star, idx) => {
                const icon = star.querySelector('.material-symbols-rounded');
                if (idx < rating) { icon.classList.remove('text-gray-300', 'dark:text-gray-600'); icon.classList.add('text-yellow-400'); }
                else { icon.classList.add('text-gray-300', 'dark:text-gray-600'); icon.classList.remove('text-yellow-400'); }
            });
            document.getElementById('ratingLabel').textContent = labels[rating];
        };

        // Voice
        let mediaRecorder = null, audioChunks = [], recordingInterval = null, audioBlob = null, audioURL = null, audioPlayer = null;
        window.startRecording = async function () {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];
                mediaRecorder.ondataavailable = (e) => audioChunks.push(e.data);
                mediaRecorder.onstop = () => {
                    audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    audioURL = URL.createObjectURL(audioBlob);
                    const file = new File([audioBlob], 'recording.webm', { type: 'audio/webm' });
                    const dt = new DataTransfer(); dt.items.add(file);
                    document.getElementById('voiceNoteInput').files = dt.files;
                    document.getElementById('recorderActive').classList.add('hidden');
                    document.getElementById('recorderPreview').classList.remove('hidden');
                    const audio = new Audio(audioURL);
                    audio.onloadedmetadata = () => { const dur = Math.floor(audio.duration); document.getElementById('audioDuration').textContent = `${Math.floor(dur / 60)}:${(dur % 60).toString().padStart(2, '0')}`; };
                    audioPlayer = audio;
                };
                mediaRecorder.start();
                document.getElementById('recorderInitial').classList.add('hidden');
                document.getElementById('recorderActive').classList.remove('hidden');
                let sec = 0; recordingInterval = setInterval(() => { sec++; document.getElementById('recordingTimer').textContent = `${Math.floor(sec / 60).toString().padStart(2, '0')}:${(sec % 60).toString().padStart(2, '0')}`; }, 1000);
            } catch (e) { alert('Mic blocked'); }
        };
        window.stopRecording = function () { if (mediaRecorder && mediaRecorder.state === 'recording') { mediaRecorder.stop(); mediaRecorder.stream.getTracks().forEach(t => t.stop()); } if (recordingInterval) { clearInterval(recordingInterval); recordingInterval = null; } };
        window.togglePlayInfo = function () {
            const btn = document.getElementById('playBtn'), icon = btn.querySelector('.material-symbols-rounded');
            if (audioPlayer) {
                if (audioPlayer.paused) { audioPlayer.play(); icon.textContent = 'pause'; } else { audioPlayer.pause(); icon.textContent = 'play_arrow'; }
                audioPlayer.onended = () => icon.textContent = 'play_arrow';
            }
        };
        window.deleteRecording = function () {
            if (audioPlayer) { audioPlayer.pause(); audioPlayer = null; }
            audioBlob = null; audioURL = null; audioChunks = [];
            document.getElementById('voiceNoteInput').value = '';
            document.getElementById('recorderPreview').classList.add('hidden');
            document.getElementById('recorderInitial').classList.remove('hidden');
            document.getElementById('recordingTimer').textContent = '00:00';
        };

        window.switchTab = function (tab) {
            const iBtn = document.getElementById('tabInputBaru'), eBtn = document.getElementById('tabEditSetoran'), iCon = document.getElementById('contentInputBaru'), eCon = document.getElementById('contentEditSetoran');
            if (tab === 'input') {
                iBtn.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-primary text-white shadow-lg shadow-primary/30';
                eBtn.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400';
                iCon.classList.remove('hidden'); eCon.classList.add('hidden');
            } else {
                eBtn.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-emerald-500 text-white shadow-lg shadow-emerald-500/30';
                iBtn.className = 'tab-btn flex-1 flex items-center justify-center gap-2 h-12 rounded-xl font-semibold text-sm transition-all duration-300 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-primary/10 hover:text-primary';
                eCon.classList.remove('hidden'); iCon.classList.add('hidden');
            }
        };

        window.openEditModalById = function (id) {
            const setoran = window.setoranData[id];
            if (setoran) {
                const form = document.getElementById('editForm');
                form.action = '/ustadz/hafalan/' + setoran.id;
                document.getElementById('editSetoranId').value = setoran.id;
                document.getElementById('editSurah').value = setoran.surah;
                document.getElementById('editAyatAwal').value = setoran.ayat_awal;
                document.getElementById('editAyatAkhir').value = setoran.ayat_akhir;
                document.getElementById('editNilai').value = setoran.nilai_numeric || 1;
                document.getElementById('editCatatan').value = setoran.catatan || '';
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('flex');
            }
        };
        window.closeEditModal = function () { document.getElementById('editModal').classList.add('hidden'); document.getElementById('editModal').classList.remove('flex'); };

        document.addEventListener('click', function (e) {
            const sd = document.getElementById('santriDropdown'), ss = document.getElementById('santriSearch');
            if (ss && sd && !ss.contains(e.target) && !sd.contains(e.target)) sd.classList.add('hidden');
            const surd = document.getElementById('surahDropdown'), surs = document.getElementById('surahSearch');
            if (surs && surd && !surs.contains(e.target) && !surd.contains(e.target)) surd.classList.add('hidden');
        });

        document.addEventListener('DOMContentLoaded', function () {
            initSurahList();
            @if (isset($selectedSantriId) && $selectedSantriId)
                const btn = document.querySelector(`.santri-item[data-id="{{ $selectedSantriId }}"]`);
            if (btn) selectSantri('{{ $selectedSantriId }}', btn.getAttribute('data-name'));
            @endif
        });
    </script>

    <div id="editModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        onclick="if(event.target === this) closeEditModal()">
        <div class="bg-white dark:bg-surface-dark rounded-3xl shadow-2xl w-full max-w-[380px] max-h-[90vh] overflow-hidden"
            onclick="event.stopPropagation()">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 p-4 text-white">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold">Edit Setoran</h3><button onclick="closeEditModal()"
                        class="size-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center transition-colors"><span
                            class="material-symbols-rounded text-[20px]">close</span></button>
                </div>
            </div>
            <form id="editForm" method="POST" class="p-4 space-y-4 overflow-y-auto max-h-[60vh]">
                @csrf @method('PUT') <input type="hidden" id="editSetoranId" name="setoran_id">
                <div><label
                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Surah</label><input
                        type="text" id="editSurah" name="surah" readonly
                        class="w-full h-12 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Ayat
                            Awal</label><input type="number" id="editAyatAwal" name="ayat_awal" min="1"
                            class="w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                    <div><label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Ayat
                            Akhir</label><input type="number" id="editAyatAkhir" name="ayat_akhir" min="1"
                            class="w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>
                <div><label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Nilai
                        (1-5)</label>
                    <select id="editNilai" name="nilai"
                        class="w-full h-12 rounded-xl border-none bg-white dark:bg-surface-dark px-4 text-sm font-medium ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="1">1 - Kurang</option>
                        <option value="2">2 - Cukup</option>
                        <option value="3">3 - Jayyid</option>
                        <option value="4">4 - Jayyid Jiddan</option>
                        <option value="5">5 - Mumtaz</option>
                    </select>
                </div>
                <div><label
                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Catatan</label><textarea
                        id="editCatatan" name="catatan" rows="5"
                        class="w-full rounded-xl border-none bg-white dark:bg-surface-dark p-4 text-sm font-normal ring-1 ring-gray-200 dark:ring-gray-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none resize-none"
                        placeholder="Catatan untuk santri"></textarea></div>
            </form>
            <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex gap-3">
                <button type="button" onclick="closeEditModal()"
                    class="flex-1 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-semibold text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">Batal</button>
                <button type="submit" form="editForm"
                    class="flex-1 h-12 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold text-sm hover:from-emerald-600 hover:to-teal-600 shadow-lg shadow-emerald-500/30 transition-all">Simpan</button>
            </div>
        </div>
    </div>
</body>

</html>
