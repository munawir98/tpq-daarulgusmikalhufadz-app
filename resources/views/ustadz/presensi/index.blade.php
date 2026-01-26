<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport" />
    <title>Presensi Selfie</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#4A90B8",
                        "primary-dark": "#2E6B8A",
                        "background-light": "#F2F4F8",
                        "background-dark": "#121212",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                    },
                    boxShadow: {
                        'soft': '0 20px 40px -10px rgba(74, 144, 184, 0.15)',
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

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #slideContainer {
            touch-action: pan-x;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
        }

        #slideContainer>div {
            scroll-snap-align: center;
            scroll-snap-stop: always;
        }

        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes soft-pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(74, 144, 184, 0.4);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(74, 144, 184, 0);
            }
        }

        .pulse-btn {
            animation: soft-pulse 2s ease-in-out infinite;
        }

        /* Gradient Texture Overlay */
        @keyframes moveTexture {
            from {
                background-position: 0 0;
            }

            to {
                background-position: -40px 0;
            }
        }

        .highlight-overlay {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.02) 25%, transparent 50%, rgba(255, 255, 255, 0.02) 75%, rgba(255, 255, 255, 0.08) 100%);
        }

        .islamic-pattern {
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.05) 50%, rgba(255, 255, 255, 0.05) 75%, transparent 75%, transparent);
            background-size: 40px 40px;
            animation: moveTexture 3s linear infinite;
        }

        body {
            overscroll-behavior-y: none;
            height: 100dvh;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen flex justify-center items-start p-0 sm:py-4">

    <!-- Mobile Wrapper -->
    <div
        class="relative flex h-full min-h-screen sm:min-h-0 sm:h-[850px] sm:rounded-[40px] w-full flex-col max-w-[480px] mx-auto bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl">

        <!-- Header Background -->
        <div
            class="absolute top-0 left-0 w-full h-[260px] bg-gradient-to-r from-[#1A2980] to-[#26D0CE] z-0 rounded-b-[40px] overflow-hidden">
            <div class="absolute top-[-50px] right-[-50px] w-64 h-64 bg-[#5BA3CC] rounded-full blur-3xl opacity-60">
            </div>
            <div class="absolute bottom-[-20px] left-[-20px] w-48 h-48 bg-[#2A5A78] rounded-full blur-2xl opacity-50">
            </div>
            <div class="absolute inset-0 highlight-overlay"></div>
            <div class="absolute inset-0 islamic-pattern"></div>
        </div>

        <!-- Scrollable Content -->
        <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar flex flex-col">

            <!-- Top Header -->
            <div
                class="px-6 pt-8 pb-4 text-white flex flex-col gap-2 pt-[calc(2rem+env(safe-area-inset-top))] shrink-0">
                <div class="flex items-center justify-center text-center w-full">
                    <div>
                        <h1 class="text-xl font-bold leading-tight">Presensi Kehadiran</h1>
                        <p class="text-white/70 text-xs">Ustadz & Pengajar</p>
                    </div>
                </div>
            </div>

            <!-- White Container Wrapper -->
            <div id="whiteContainer"
                class="w-full bg-white dark:bg-[#1E1E1E] rounded-t-[30px] shadow-soft pt-5 relative z-20 flex-grow min-h-0 pb-[calc(10px+env(safe-area-inset-bottom))] transition-all duration-300">

                <!-- Main Attendance Card -->
                <div id="mainCard"
                    class="mx-4 bg-gray-50 dark:bg-gray-800/50 rounded-[24px] p-5 relative z-20 mb-6 shadow-sm overflow-hidden">

                    <!-- Hidden Native Camera Input -->
                    <input type="file" id="cameraInput" accept="image/*" capture="user" class="hidden" />

                    <!-- Presensi Selfie View -->
                    <div id="presensiView" class="transition-all duration-300">
                        <div class="flex justify-between items-center mb-5 mt-2">
                            <div>
                                <h2
                                    class="text-sm font-bold text-gray-800 dark:text-white flex items-center gap-2 uppercase tracking-wide">
                                    Presensi Selfie
                                    <span class="material-symbols-rounded text-primary text-[18px]">camera_front</span>
                                </h2>
                                <p class="text-[9px] font-medium text-gray-400 mt-0.5">Ambil foto untuk konfirmasi</p>
                            </div>
                            <div id="radiusBadge"
                                class="px-2.5 py-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center gap-1.5 border border-gray-200 dark:border-gray-700 shadow-sm">
                                <span id="radiusDot" class="relative flex h-2 w-2">
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-gray-400"></span>
                                </span>
                                <span id="radiusText"
                                    class="text-[9px] font-bold text-gray-500 dark:text-gray-400">Mendeteksi...</span>
                            </div>
                        </div>

                        <div class="flex gap-4 mb-3">
                            <!-- Button Action -->
                            <div id="ambilFotoBtn" onclick="handleMainAction()"
                                class="w-24 h-24 shrink-0 bg-blue-50 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-blue-200 dark:border-gray-700 flex flex-col items-center justify-center gap-1 cursor-pointer group hover:bg-blue-100 dark:hover:bg-gray-700 transition-colors pulse-btn overflow-hidden relative">
                                <div id="fotoIconContainer" class="flex flex-col items-center justify-center gap-1">
                                    <span id="fotoIcon"
                                        class="material-symbols-rounded text-blue-400 dark:text-gray-500 group-hover:text-primary transition-colors text-3xl">add_a_photo</span>
                                    <span id="fotoBtnText"
                                        class="text-[8px] font-bold text-blue-400 dark:text-gray-500 group-hover:text-primary transition-colors text-center leading-tight">Ambil<br />Foto</span>
                                </div>
                                <img id="fotoPreview" src="" alt="Foto Presensi"
                                    class="w-full h-full object-cover absolute inset-0 hidden" />
                                <div id="fotoOverlay"
                                    class="absolute inset-0 bg-black/40 hidden flex items-center justify-center">
                                    <span
                                        class="material-symbols-rounded text-white text-2xl animate-bounce">check_circle</span>
                                </div>

                                <!-- Action Label Overlay -->
                                <div id="actionLabel"
                                    class="absolute bottom-0 inset-x-0 bg-primary/90 text-white text-[7px] font-bold text-center py-1 hidden">
                                    KIRIM
                                </div>
                            </div>

                            <!-- Status List -->
                            <div class="flex-1 flex flex-col justify-center gap-1.5">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-2 flex justify-between items-center border border-gray-100 dark:border-gray-700 shadow-sm">
                                    <span class="text-[10px] text-gray-500 font-medium">Jam Masuk</span>
                                    <span class="text-[10px] font-bold text-gray-800 dark:text-gray-200">{{ $jamMasuk ?
                                        \Carbon\Carbon::parse($jamMasuk->jam)->format('H:i') : '--:--' }}</span>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-2 flex justify-between items-center border border-gray-100 dark:border-gray-700 shadow-sm">
                                    <span class="text-[10px] text-gray-500 font-medium">Jam Keluar</span>
                                    <span class="text-[10px] font-bold text-gray-800 dark:text-gray-200">{{ $jamPulang ?
                                        \Carbon\Carbon::parse($jamPulang->jam)->format('H:i') : '--:--' }}</span>
                                </div>
                                <div id="presensiStatus"
                                    class="bg-gray-50 dark:bg-gray-800 rounded-lg px-2 py-1 flex justify-between items-center border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <span class="text-[9px] text-gray-500 font-medium">Status</span>
                                    @php
                                    $statusText = 'Belum Absen';
                                    if ($jamMasuk && !$jamPulang) $statusText = 'Sedang Mengajar';
                                    if ($jamMasuk && $jamPulang) $statusText = 'Selesai';
                                    @endphp
                                    <span class="text-[9px] font-bold text-primary">{{ $statusText }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info/Slider Section -->
                        <div class="mt-6 mb-3">
                            <!-- Swipeable Container -->
                            <div id="slideContainer"
                                class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbar"
                                style="scroll-snap-type: x mandatory; scroll-behavior: smooth;">

                                <!-- Slide 1: Map -->
                                <div class="snap-center snap-always shrink-0 w-full" style="min-width: 100%;">
                                    <div id="mapWrapper"
                                        class="relative w-full h-[150px] rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm">
                                        <div id="map" class="w-full h-full z-0 bg-gray-200 dark:bg-gray-700"></div>

                                        <!-- Controls -->
                                        <div
                                            class="absolute top-1/2 -translate-y-1/2 right-2 z-[400] flex flex-col gap-1.5">
                                            <button onclick="mapZoomIn()"
                                                class="w-6 h-6 bg-white dark:bg-gray-700 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                                <span
                                                    class="material-symbols-rounded text-gray-600 dark:text-gray-300 text-[14px]">add</span>
                                            </button>
                                            <button onclick="mapReset()"
                                                class="w-6 h-6 bg-white dark:bg-gray-700 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                                <span
                                                    class="material-symbols-rounded text-primary text-[14px]">restart_alt</span>
                                            </button>
                                            <button onclick="mapZoomOut()"
                                                class="w-6 h-6 bg-white dark:bg-gray-700 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 flex items-center justify-center">
                                                <span
                                                    class="material-symbols-rounded text-gray-600 dark:text-gray-300 text-[14px]">remove</span>
                                            </button>
                                        </div>

                                        <!-- Location Info -->
                                        <div
                                            class="absolute bottom-0 left-0 z-[400] m-1.5 px-1.5 py-0.5 bg-white/90 dark:bg-gray-800/90 rounded-md shadow-sm">
                                            <p class="text-[8px] font-mono font-bold text-primary truncate tracking-tight"
                                                id="userLocation">Mendeteksi...</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 2: Riwayat Presensi -->
                                <div class="snap-center snap-always shrink-0 w-full px-1" style="min-width: 100%;">
                                    <div
                                        class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-3 h-[150px] overflow-y-auto hide-scrollbar border border-gray-100 dark:border-gray-700">
                                        <h3 class="text-[10px] font-bold text-gray-500 mb-2 uppercase tracking-wide">
                                            Riwayat Pekan Ini</h3>
                                        @forelse($riwayat as $item)
                                        <div
                                            class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0 last:mb-0 last:pb-0">
                                            <div
                                                class="w-8 h-8 rounded-lg flex items-center justify-center {{ $item->tipe == 'masuk' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                                <span class="material-symbols-rounded text-sm">{{ $item->tipe == 'masuk'
                                                    ? 'login' : 'logout' }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-bold text-gray-800 dark:text-gray-200">{{
                                                    $item->tipe == 'masuk' ? 'Masuk' : 'Pulang' }}</p>
                                                <p class="text-[10px] text-gray-400">{{
                                                    \Carbon\Carbon::parse($item->jam)->format('H:i') }} • {{
                                                    \Carbon\Carbon::parse($item->tanggal)->format('d M') }}</p>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="flex flex-col items-center justify-center h-full opacity-50">
                                            <span class="material-symbols-rounded text-2xl">history</span>
                                            <p class="text-[10px] mt-1">Belum ada data</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>

                            </div>

                            <!-- Dot Indicators -->
                            <div class="flex justify-center gap-2 mt-2">
                                <button id="dot0" onclick="goToSlide(0)"
                                    class="w-1.5 h-1.5 rounded-full bg-primary transition-all"></button>
                                <button id="dot1" onclick="goToSlide(1)"
                                    class="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600 transition-all"></button>
                            </div>
                        </div>

                        <!-- Swipe Hint -->
                        <div class="flex justify-center items-center gap-1 mt-6 opacity-40">
                            <span
                                class="material-symbols-rounded text-gray-400 text-xs animate-bounce-x">compare_arrows</span>
                            <span class="text-[7px] text-gray-400 font-medium">Geser untuk melihat riwayat</span>
                        </div>

                        <!-- Calendar Section (New) -->
                        <div class="mt-6 -mx-5 -mb-5">
                            <!-- Toggle Header -->
                            <button onclick="toggleKehadiran()"
                                class="w-full p-4 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between hover:bg-slate-100 dark:hover:bg-slate-800/40 transition-colors border-t border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xs font-bold uppercase text-slate-500">Tanggal Kehadiran</h4>
                                    <span
                                        class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">{{
                                        $presensiCount ?? 0 }} Hari Hadir</span>
                                </div>
                                <span id="toggleIcon"
                                    class="material-symbols-rounded text-slate-400 transition-transform duration-300">expand_more</span>
                            </button>

                            <!-- Collapsible Content -->
                            <div id="kehadiranContent" class="hidden p-4 pt-4 bg-slate-50/50 dark:bg-slate-800/20 mt-0">
                                @php
                                $daysInMonth = \Carbon\Carbon::createFromDate($year, $month, 1)->daysInMonth;
                                $attendanceMap = [];
                                if(isset($presensiDetails)) {
                                foreach($presensiDetails as $detail) {
                                $d = \Carbon\Carbon::parse($detail->tanggal)->day;
                                if (!isset($attendanceMap[$d])) $attendanceMap[$d] = [];
                                $attendanceMap[$d][] = [
                                'jam' => $detail->jam,
                                'status' => $detail->status_presensi
                                ];
                                }
                                }
                                @endphp

                                <div class="rounded-lg">
                                    <div class="grid grid-cols-7 gap-1.5 text-center">
                                        <span class="text-[10px] font-bold text-slate-400">Sn</span>
                                        <span class="text-[10px] font-bold text-slate-400">Sl</span>
                                        <span class="text-[10px] font-bold text-slate-400">Rb</span>
                                        <span class="text-[10px] font-bold text-slate-400">Km</span>
                                        <span class="text-[10px] font-bold text-slate-400">Jm</span>
                                        <span class="text-[10px] font-bold text-slate-400">Sb</span>
                                        <span class="text-[10px] font-bold text-slate-400">Mg</span>

                                        {{-- Empty slots for start of month --}}
                                        @php
                                        $firstDayOfWeek = \Carbon\Carbon::createFromDate($year, $month,
                                        1)->dayOfWeekIso;
                                        @endphp
                                        @for($i = 1; $i < $firstDayOfWeek; $i++) <span></span> @endfor

                                            {{-- Days --}}
                                            @for($day = 1; $day <= $daysInMonth; $day++) @php
                                                $hasData=isset($attendanceMap[$day]); $events=$hasData ?
                                                $attendanceMap[$day] : []; $dataAttr=$hasData ?
                                                htmlspecialchars(json_encode($events), ENT_QUOTES, 'UTF-8' ) : '' ;
                                                @endphp <button
                                                onclick="showAttendanceDetail('{{ $day }} {{ $fullPeriodName }}', this.getAttribute('data-events'))"
                                                data-events="{{ $dataAttr }}"
                                                class="aspect-square flex flex-col items-center justify-center rounded-lg text-[10px] font-medium transition-all {{ $hasData ? 'bg-green-500 text-white shadow-sm hover:bg-green-600 active:scale-95' : 'text-slate-400 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700' }}">
                                                {{ $day }}
                                                </button>
                                                @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // CONFIG
        const SENTRA_LAT = -6.551824; // Sesuaikan dengan config
        const SENTRA_LNG = 106.816065;
        const RADIUS_METER = 50;

        // STATE
        let map, userMarker, circle, radiusCircle;
        let currentLat = null;
        let currentLng = null;
        let isWithinRadius = false;
        let capturedPhotoData = null;

        // DETERMINE MODE: 'masuk', 'pulang', or 'selesai'
        const hasMasuk = @json($jamMasuk ? true : false);
        const hasPulang = @json($jamPulang ? true : false);
        let currentMode = 'masuk';

        if (hasMasuk && !hasPulang) currentMode = 'pulang';
        if (hasMasuk && hasPulang) currentMode = 'selesai';

        // INIT
        document.addEventListener("DOMContentLoaded", function () {
            initMap();
            initGeolocation();
            updateButtonDisplay();
            initSlider();

            // Camera Input Change Listener
            const cameraInput = document.getElementById('cameraInput');
            cameraInput.addEventListener('change', function (e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (ev) {
                        capturedPhotoData = ev.target.result;
                        document.getElementById('fotoPreview').src = capturedPhotoData;
                        document.getElementById('fotoPreview').classList.remove('hidden');
                        updateButtonDisplay();
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });

        // ACTION HANDLER
        function handleMainAction() {
            if (currentMode === 'selesai') {
                Swal.fire('Selesai', 'Anda sudah melakukan presensi hari ini.', 'info');
                return;
            }

            if (!capturedPhotoData) {
                // Step 1: Ambil Foto
                document.getElementById('cameraInput').click();
            } else {
                // Step 2: Kirim Data
                submitPresensi();
            }
        }

        function updateButtonDisplay() {
            const btn = document.getElementById('ambilFotoBtn');
            const icon = document.getElementById('fotoIcon');
            const text = document.getElementById('fotoBtnText');
            const overlay = document.getElementById('fotoOverlay');
            const label = document.getElementById('actionLabel');

            if (currentMode === 'selesai') {
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                text.textContent = 'Selesai';
                icon.textContent = 'check_circle';
                return;
            }

            if (capturedPhotoData) {
                // Ready to Send
                btn.classList.remove('pulse-btn');
                btn.classList.add('ring-2', 'ring-green-500');
                overlay.classList.remove('hidden');
                label.classList.remove('hidden');
                label.textContent = currentMode === 'masuk' ? 'KIRIM MASUK' : 'KIRIM PULANG';
                label.classList.remove('bg-primary/90');
                label.classList.add('bg-green-600/90');
            } else {
                // Default
                btn.classList.add('pulse-btn');
                btn.classList.remove('ring-2', 'ring-green-500');
                overlay.classList.add('hidden');
                label.classList.add('hidden');
                icon.textContent = 'add_a_photo';
                text.innerHTML = currentMode === 'masuk' ? 'Foto<br>Masuk' : 'Foto<br>Pulang';
            }
        }

        // SUBMIT LOGIC
        function submitPresensi() {
            if (!currentLat || !currentLng) {
                Swal.fire('GPS', 'Tunggu lokasi terkunci.', 'warning');
                return;
            }
            if (!isWithinRadius) {
                Swal.fire('Radius', 'Anda berada di luar jangkauan.', 'error');
                return;
            }

            Swal.fire({
                title: 'Mengirim...',
                didOpen: () => Swal.showLoading(),
                allowOutsideClick: false
            });

            const url = currentMode === 'masuk' ? '{{ route("presensi.masuk") }}' : '{{ route("presensi.pulang") }}';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: currentLat,
                    longitude: currentLng,
                    foto: capturedPhotoData
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil', data.message, 'success').then(() => window.location.reload());
                    } else {
                        Swal.fire('Gagal', data.message, 'error');
                    }
                })
                .catch(err => Swal.fire('Error', 'Gagal koneksi server', 'error'));
        }

        // MAP & GEO LOGIC (Ported from Dashboard)
        function initMap() {
            map = L.map('map', { zoomControl: false, attributionControl: false }).setView([SENTRA_LAT, SENTRA_LNG], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

            // Red Icon
            var smallIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [17, 28], iconAnchor: [8, 28], popupAnchor: [1, -24], shadowSize: [28, 28]
            });

            L.marker([SENTRA_LAT, SENTRA_LNG], { icon: smallIcon }).addTo(map);
            radiusCircle = L.circle([SENTRA_LAT, SENTRA_LNG], { color: '#ef4444', fillColor: '#ef4444', fillOpacity: 0.2, radius: RADIUS_METER }).addTo(map);
        }

        function initGeolocation() {
            if (!navigator.geolocation) return;

            navigator.geolocation.watchPosition(
                (pos) => {
                    currentLat = pos.coords.latitude;
                    currentLng = pos.coords.longitude;
                    const acc = pos.coords.accuracy;

                    // Update Badge
                    const dist = map.distance([currentLat, currentLng], [SENTRA_LAT, SENTRA_LNG]);
                    isWithinRadius = dist <= RADIUS_METER;
                    updateRadiusBadge(dist);

                    // Update Map Marker
                    if (!userMarker) {
                        userMarker = L.circleMarker([currentLat, currentLng], { radius: 6, fillColor: '#3b82f6', color: '#fff', weight: 2, fillOpacity: 0.9 }).addTo(map);
                        map.flyTo([currentLat, currentLng], 17);
                    } else {
                        userMarker.setLatLng([currentLat, currentLng]);
                    }

                    document.getElementById('userLocation').textContent = `${currentLat.toFixed(5)}, ${currentLng.toFixed(5)}`;
                },
                (err) => console.error(err),
                { enableHighAccuracy: true }
            );
        }

        function updateRadiusBadge(dist) {
            const badgeText = document.getElementById('radiusText');
            const dot = document.getElementById('radiusDot');

            if (isWithinRadius) {
                badgeText.textContent = `Dalam Radius (${Math.round(dist)}m)`;
                badgeText.className = 'text-[9px] font-bold text-green-600';
                dot.innerHTML = '<span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>';
                if (radiusCircle) radiusCircle.setStyle({ color: '#22c55e', fillColor: '#22c55e' });
            } else {
                badgeText.textContent = `Luar Radius (${Math.round(dist)}m)`;
                badgeText.className = 'text-[9px] font-bold text-red-500';
                dot.innerHTML = '<span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>';
                if (radiusCircle) radiusCircle.setStyle({ color: '#ef4444', fillColor: '#ef4444' });
            }
        }

        function mapZoomIn() { map.zoomIn(); }
        function mapZoomOut() { map.zoomOut(); }
        function mapReset() { map.setView([SENTRA_LAT, SENTRA_LNG], 16); }

        // SLIDER LOGIC
        function initSlider() {
            const container = document.getElementById('slideContainer');
            container.addEventListener('scroll', () => {
                const index = Math.round(container.scrollLeft / container.offsetWidth);
                const dots = [document.getElementById('dot0'), document.getElementById('dot1')];
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                        dot.classList.add('bg-primary');
                    } else {
                        dot.classList.remove('bg-primary');
                        dot.classList.add('bg-gray-300', 'dark:bg-gray-600');
                    }
                });
            });
        }
        function goToSlide(index) {
            const container = document.getElementById('slideContainer');
            container.scrollTo({ left: index * container.offsetWidth, behavior: 'smooth' });
        }

        // CALENDAR LOGIC
        function toggleKehadiran() {
            const content = document.getElementById('kehadiranContent');
            const icon = document.getElementById('toggleIcon');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        function showAttendanceDetail(dateStr, eventsJson) {
            if (!eventsJson) return;

            try {
                const events = JSON.parse(eventsJson);
                let message = "Detail Kehadiran " + dateStr + ":\n";
                events.forEach(e => {
                    message += "- " + e.status + " pada jam " + e.jam + "\n";
                });
                alert(message);
            } catch (e) {
                console.error("Error parsing events", e);
            }
        }
    </script>
</body>

</html>
