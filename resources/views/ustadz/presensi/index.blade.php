<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Presensi Radius &amp; Peta - TPQ Daarul Gusmik</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#ffffff",
                        "background-light": "#3b82f6",
                        "background-dark": "#0f172a",
                        "card-blue": "rgba(255, 255, 255, 0.15)",
                    },
                    fontFamily: {
                        display: ["Plus Jakarta Sans", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "24px",
                    },
                    keyframes: {
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        },
                        'fade-in-up': {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        'pulse-slow': {
                            '0%, 100%': {
                                opacity: '1'
                            },
                            '50%': {
                                opacity: '0.8'
                            },
                        }
                    },
                    animation: {
                        'gradient-x': 'gradient-x 15s ease infinite',
                        'fade-in-up': 'fade-in-up 0.5s ease-out',
                        'pulse-slow': 'pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    }
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-tap-highlight-color: transparent;
            min-height: max(884px, 100dvh);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
        }
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        }
        /* Custom Scrollbar for Riwayat */
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-blue-600 dark:bg-[#0f172a] min-h-screen text-white">
    <div class="max-w-md mx-auto min-h-screen flex flex-col p-6 relative overflow-hidden">
        <header class="flex items-center justify-between mt-4 mb-6">
            <div class="flex items-center space-x-3">
                <a href="{{ route('ustadz.dashboard') }}"
                    class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center shadow-lg active:scale-95 transition-transform">
                    <span class="material-icons-round text-white text-xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-lg font-bold leading-tight">Presensi Kehadiran</h1>
                    <p class="text-white/70 text-[10px]">Ustadz &amp; Pengajar</p>
                </div>
            </div>

        </header>



        <div
            class="bg-white rounded-[32px] p-6 mb-8 text-center flex flex-col items-center animate-fade-in-up shadow-xl">
            <div class="mb-4">
                <p class="text-3xl font-bold text-gray-900" id="current-time">--:--</p>
                <p class="text-gray-500 text-xs mt-1" id="current-date">--</p>
            </div>

            <!-- Status Hari Ini (Card Style like Dashboard) -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                <!-- Masuk Card -->
                <!-- Masuk Card -->
                <div class="bg-gray-50 border border-gray-100 p-3 rounded-2xl flex items-center space-x-3 shadow-sm">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-100 text-blue-600">
                        <span class="material-icons-round">login</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-medium">Masuk</p>
                        <p class="text-sm font-bold text-gray-900 tracking-wide">{{ $jamMasuk ?
                            \Carbon\Carbon::parse($jamMasuk->jam)->format('H:i') : '--:--' }}</p>
                    </div>
                </div>

                <!-- Pulang Card -->
                <!-- Pulang Card -->
                <div class="bg-gray-50 border border-gray-100 p-3 rounded-2xl flex items-center space-x-3 shadow-sm">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-orange-100 text-orange-600">
                        <span class="material-icons-round">logout</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-500 font-medium">Pulang</p>
                        <p class="text-sm font-bold text-gray-900 tracking-wide">{{ $jamPulang ?
                            \Carbon\Carbon::parse($jamPulang->jam)->format('H:i') : '--:--' }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full h-40 bg-gray-100 rounded-2xl mb-6 relative overflow-hidden border border-gray-200 group">
                <div id="map" class="w-full h-full z-0"></div>

                <!-- Map Controls (Right Side) -->
                <div class="absolute bottom-4 right-4 flex flex-col space-y-1.5 z-[400]">
                    <button onclick="map.zoomIn()"
                        class="w-6 h-6 bg-white/90 backdrop-blur text-gray-700 rounded-lg shadow-lg flex items-center justify-center hover:bg-white active:scale-95 border border-gray-200/50">
                        <span class="material-icons-round text-[14px]">add</span>
                    </button>
                    <button onclick="resetMap()"
                        class="w-6 h-6 bg-white/90 backdrop-blur text-blue-600 rounded-lg shadow-lg flex items-center justify-center hover:bg-white active:scale-95 border border-blue-200/50">
                        <span class="material-icons-round text-[14px]">restart_alt</span>
                    </button>
                    <button onclick="map.zoomOut()"
                        class="w-6 h-6 bg-white/90 backdrop-blur text-gray-700 rounded-lg shadow-lg flex items-center justify-center hover:bg-white active:scale-95 border border-gray-200/50">
                        <span class="material-icons-round text-[14px]">remove</span>
                    </button>
                </div>

                <!-- Small Status Indicator on Map -->
                <div id="mapStatusBadge"
                    class="absolute top-2 left-2 z-[400] flex items-center space-x-1 transition-all transform opacity-0">
                    <div id="mapStatusIcon" class="w-1.5 h-1.5 rounded-full bg-gray-400 animate-pulse"></div>
                    <span id="mapStatusText"
                        class="text-[8px] font-bold text-gray-700 drop-shadow-md shadow-white">Mencari...</span>
                </div>





            </div>

            <div class="grid grid-cols-2 gap-4 w-full mb-6">
                <!-- Fingerprint / Geo Button (Masuk) -->
                <button onclick="checkBiometricAndSubmit('masuk')"
                    class="relative flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-xl text-blue-600 active:scale-95 transition-transform overflow-hidden group {{ !$jamMasuk ? 'animate-pulse-slow ring-4 ring-white/20' : '' }}">
                    <div class="absolute top-0 right-0 p-1 bg-green-500 text-white rounded-bl-lg">
                        <span class="material-icons-round text-sm">login</span>
                    </div>
                    <span class="material-symbols-outlined text-4xl mb-2 text-blue-600">fingerprint</span>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Presensi Masuk</span>
                    <div class="mt-2 flex items-center text-[8px] text-blue-500 font-medium">
                        <span class="material-icons-round text-[10px] mr-0.5">verified_user</span>
                        Sidik Jari Check
                    </div>
                </button>

                <!-- Selfie Button (Pulang) -->
                <button onclick="checkBiometricAndSubmit('pulang')"
                    class="relative flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-xl text-orange-600 active:scale-95 transition-transform overflow-hidden group">
                    <span class="material-symbols-outlined text-4xl mb-2 text-orange-600">logout</span>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Presensi Pulang</span>
                    <div class="mt-2 flex items-center text-[8px] text-orange-500 font-medium">
                        <span class="material-icons-round text-[10px] mr-0.5">photo_camera</span>
                        Selfie Check
                    </div>
                </button>
            </div>


        </div>

        <!-- Rekapitulasi Form -->
        <div class="bg-white rounded-2xl p-5 mb-8 animate-fade-in-up shadow-lg" style="animation-delay: 0.1s;">
            <div class="flex items-center space-x-2 mb-4">
                <span class="material-symbols-outlined text-yellow-400">calendar_month</span>
                <h3 class="font-bold text-sm text-gray-900">Rekapitulasi Presensi</h3>
            </div>
            <form action="{{ route('ustadz.presensi') }}" method="GET">
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-500 font-medium ml-1">Tanggal Awal</label>
                        <div class="relative">
                            <input type="date" name="start_date"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-xs text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all"
                                value="{{ $filterStart ?? date('Y-m-01') }}">
                            <span
                                class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400"
                                style="font-size: 16px;">calendar_month</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] text-gray-500 font-medium ml-1">Tanggal Akhir</label>
                        <div class="relative">
                            <input type="date" name="end_date"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-xs text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all"
                                value="{{ $filterEnd ?? date('Y-m-d') }}">
                            <span
                                class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400"
                                style="font-size: 16px;">calendar_month</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-bold text-xs shadow-lg shadow-blue-500/20 active:scale-95 transition-all flex items-center justify-center space-x-2">
                        <span class="material-icons-round text-sm">print</span>
                        <span>Tampilkan</span>
                    </button>
                    <div
                        class="bg-gray-100 border border-gray-200 rounded-xl px-3 py-2.5 flex flex-col items-center justify-center min-w-[70px]">
                        <span class="text-[8px] text-gray-500 uppercase tracking-wider">Total Hadir</span>
                        <span class="text-xs font-bold text-gray-900 leading-none">
                            {{ $totalHadir ?? 0 }}
                        </span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Riwayat Pekan Ini -->
        <div class="flex-1 pb-24">
            <div class="flex items-center justify-between mb-4 px-2">
                <h3 class="font-bold text-lg">Riwayat Pekan Ini</h3>
                <a href="{{ route('ustadz.laporan.index') }}"
                    class="text-xs text-white/70 font-medium hover:text-white transition-colors">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($riwayat as $item)
                <div
                    class="bg-white rounded-2xl p-4 flex items-center justify-between shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 {{ $item->tipe == 'masuk' ? 'bg-green-500/20 text-green-600' : 'bg-orange-500/20 text-orange-600' }} rounded-xl flex items-center justify-center">
                            <span class="material-icons-round">{{ $item->tipe == 'masuk' ? 'login' : 'logout'
                                }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900">{{ $item->tipe == 'masuk' ? 'Masuk Kelas' :
                                'Pulang / Selesai' }}</p>
                            <p class="text-[11px] text-gray-500">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d M') }},
                                {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-[10px] {{ $item->tipe == 'masuk' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }} px-2 py-1 rounded-lg">
                            {{ $item->tipe == 'masuk' ? 'Verified Radius' : 'Selfie Check' }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-white/50 text-xs">
                    Belum ada riwayat presensi pekan ini.
                </div>
                @endforelse
            </div>
        </div>

        <footer class="mt-8 text-center text-[10px] text-white/40 pb-24">
            <p>&copy; {{ date('Y') }} TPQ Daarul Gusmik Al-Hufadz • Versi 2.1.0</p>
        </footer>



        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function updateClock() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const timeEl = document.getElementById('current-time');
                if (timeEl) timeEl.textContent = `${hours}:${minutes}`;
                const dateEl = document.getElementById('current-date');
                if (dateEl) {
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    dateEl.textContent = now.toLocaleDateString('id-ID', options);
                }
            }
            setInterval(updateClock, 1000);
            updateClock();

            // --- MAP & GEOLOCATION LOGIC ---
            // Unit Pusat Coords (Example: Replace with actual configs or DB values)
            // Adjust these to your actual center point
            // Example: -6.200000, 106.816666 (Jakarta) - Replace with TPQ coords
            const SENTRA_LAT = -6.551824;
            const SENTRA_LNG = 106.816065;
            const RADIUS_METER = 50;

            // Data Biometrik User
            // Data Biometrik User
            const biometricId = @json(session('user.biometric_credential'));
            const hasBiometric = biometricId ? true : false;

            let map, userMarker, circle;
            let currentLat = null;
            let currentLng = null;
            let isWithinRadius = false;

            function initMap() {
                // Initialize map with a default view roughly around Indonesia or expected area
                map = L.map('map', {
                    zoomControl: false,
                    attributionControl: false,
                    zoomAnimation: true,
                    markerZoomAnimation: true
                }).setView([SENTRA_LAT, SENTRA_LNG], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                // Red Icon for TPQ
                var smallIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                    iconSize: [25 * 0.7, 41 * 0.7],
                    iconAnchor: [12 * 0.7, 41 * 0.7],
                    popupAnchor: [1, -34 * 0.7],
                    shadowSize: [41 * 0.7, 41 * 0.7]
                });

                // Add Destination Marker (Sentra TPQ)
                L.marker([SENTRA_LAT, SENTRA_LNG], {
                    icon: smallIcon
                }).addTo(map);

                // Draw Radius Circle
                circle = L.circle([SENTRA_LAT, SENTRA_LNG], {
                    color: '#ef4444',
                    fillColor: '#ef4444',
                    fillOpacity: 0.2,
                    radius: RADIUS_METER
                }).addTo(map);

                getLocation();
            }

            function resetMap() {
                if (currentLat && currentLng) {
                    map.setView([currentLat, currentLng], 18);
                } else {
                    map.setView([SENTRA_LAT, SENTRA_LNG], 16);
                }
            }

            function getLocation() {
                const statusText = document.getElementById('statusText');

                if (navigator.geolocation) {
                    const locationTimeout = setTimeout(() => {
                        statusText.textContent = "GPS lambat. Mencoba mode hemat...";
                        tryLowAccuracyGPS();
                    }, 15000);

                    navigator.geolocation.watchPosition(
                        (position) => {
                            clearTimeout(locationTimeout);
                            showPosition(position);
                        },
                        (error) => {
                            clearTimeout(locationTimeout);
                            showError(error);
                            tryLowAccuracyGPS();
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 20000,
                            maximumAge: 30000
                        }
                    );
                } else {
                    statusText.textContent = "Geolocation tidak didukung browser ini.";
                }
            }

            function tryLowAccuracyGPS() {
                navigator.geolocation.getCurrentPosition(
                    (position) => showPosition(position),
                    (error) => showError(error),
                    { enableHighAccuracy: false, timeout: 10000, maximumAge: 60000 }
                );
            }

            let accuracyCircle;

            function showPosition(position) {
                currentLat = position.coords.latitude;
                currentLng = position.coords.longitude;
                const accuracy = position.coords.accuracy;

                // Update Map
                if (userMarker) {
                    userMarker.setLatLng([currentLat, currentLng]);
                    if (accuracyCircle) {
                        accuracyCircle.setLatLng([currentLat, currentLng]);
                        accuracyCircle.setRadius(accuracy);
                    }
                } else {
                    userMarker = L.circleMarker([currentLat, currentLng], {
                        radius: 6, fillColor: '#3b82f6', color: '#ffffff', weight: 2, opacity: 1, fillOpacity: 0.9
                    }).addTo(map);

                    accuracyCircle = L.circle([currentLat, currentLng], {
                        radius: accuracy, color: '#3b82f6', fillColor: '#3b82f6', fillOpacity: 0.15, weight: 0
                    }).addTo(map);

                    map.flyTo([currentLat, currentLng], 17);
                }

                // Calculate Distance
                const distance = map.distance([currentLat, currentLng], [SENTRA_LAT, SENTRA_LNG]);

                // Update Map Badge
                const badge = document.getElementById('mapStatusBadge');
                const badgeIcon = document.getElementById('mapStatusIcon');
                const badgeText = document.getElementById('mapStatusText');

                if (badge) {
                    badge.classList.remove('scale-95', 'opacity-0');
                    if (distance <= RADIUS_METER) {
                        isWithinRadius = true;
                        badgeIcon.className = 'w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_4px_rgba(34,197,94,0.6)]';
                        badgeText.textContent = `Dalam Radius (${Math.round(distance)}m)`;
                        badgeText.className = 'text-[8px] font-bold text-green-600 drop-shadow-sm bg-white/50 px-1 rounded';
                        if (circle) circle.setStyle({ color: '#22c55e', fillColor: '#22c55e' });
                    } else {
                        isWithinRadius = false;
                        badgeIcon.className = 'w-1.5 h-1.5 rounded-full bg-red-500 shadow-[0_0_4px_rgba(239,68,68,0.6)]';
                        badgeText.textContent = `Luar Radius (${Math.round(distance)}m)`;
                        badgeText.className = 'text-[8px] font-bold text-red-600 drop-shadow-sm bg-white/50 px-1 rounded';
                        if (circle) circle.setStyle({ color: '#ef4444', fillColor: '#ef4444' });
                    }
                }
            }

            function showError(error) {
                let msg = "Terjadi kesalahan.";
                switch (error.code) {
                    case error.PERMISSION_DENIED: msg = "Izin lokasi ditolak."; break;
                    case error.POSITION_UNAVAILABLE: msg = "Informasi lokasi tidak tersedia."; break;
                    case error.TIMEOUT: msg = "Waktu permintaan habis."; break;
                }
                const statusText = document.getElementById('statusText');
                if (statusText) statusText.textContent = msg;
            }

            // --- SUBMIT LOGIC ---
            async function checkBiometricAndSubmit(tipe) {
                // 1. Cek Lokasi / Radius
                if (!currentLat || !currentLng) {
                    Swal.fire('Lokasi', 'Tunggu GPS mengunci lokasi Anda.', 'warning');
                    return;
                }

                if (!isWithinRadius) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Di Luar Jangkauan',
                        text: 'Anda berada di luar radius lokasi TPQ.',
                    });
                    return;
                }

                // 2. Cek Registrasi Biometrik
                if (!hasBiometric) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sidik Jari Belum Didaftarkan',
                        text: 'Untuk keamanan, harap daftarkan sidik jari Anda terlebih dahulu di menu Profil/Pengaturan.',
                        showCancelButton: true,
                        confirmButtonText: 'Daftar Sekarang',
                        cancelButtonText: 'Batal'
                    }).then((res) => {
                        if (res.isConfirmed) {
                            window.location.href = "{{ route('ustadz.biometric.index') }}";
                        }
                    });
                    return;
                }

                // 3. Verifikasi Biometrik (Client Side Challenge for MVP)
                if (window.PublicKeyCredential) {
                    try {
                        Swal.fire({
                            title: 'Verifikasi Sidik Jari',
                            text: 'Tempelkan jari pada sensor...',
                            didOpen: () => { Swal.showLoading() },
                            allowOutsideClick: false
                        });

                        // Verifikasi Biometrik (Client Side Challenge)
                        const challenge = new Uint8Array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]);

                        const publicKey = {
                            challenge: challenge,
                            rpId: window.location.hostname,
                            timeout: 60000,
                            userVerification: "required",
                        };

                        // Spesifikasikan ID yang boleh login (PENTING untuk menghindari NotAllowedError)
                        if (biometricId) {
                            try {
                                // Decode Base64 ke Uint8Array
                                const binaryString = window.atob(biometricId);
                                const len = binaryString.length;
                                const bytes = new Uint8Array(len);
                                for (let i = 0; i < len; i++) {
                                    bytes[i] = binaryString.charCodeAt(i);
                                }

                                publicKey.allowCredentials = [{
                                    type: "public-key",
                                    id: bytes,
                                    transports: ["internal", "hybrid"]
                                }];
                            } catch (e) {
                                console.warn("Gagal decode credential ID", e);
                            }
                        }

                        await navigator.credentials.get({ publicKey });
                        Swal.close();

                    } catch (err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Verifikasi',
                            text: 'Sidik jari tidak cocok atau dibatalkan (' + err.name + ').'
                        });
                        return;
                    }
                } else {
                    Swal.fire('Error', 'Perangkat tidak mendukung biometrik.', 'error');
                    return;
                }

                // 4. Lanjut Ambil Foto & Submit (Sama seperti sebelumnya)
                submitPresensi(tipe);
            }

            function submitPresensi(tipe) {
                Swal.fire({
                    title: 'Ambil Foto Presensi',
                    html: 'Pastikan wajah terlihat jelas',
                    showCancelButton: true,
                    confirmButtonText: 'Buka Kamera',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const input = document.createElement('input');
                        input.type = 'file';
                        input.accept = 'image/*';
                        input.capture = 'user';

                        input.onchange = e => {
                            const file = e.target.files[0];
                            const reader = new FileReader();
                            reader.onload = function (event) {
                                sendData(tipe, event.target.result);
                            }
                            reader.readAsDataURL(file);
                        }
                        input.click();
                    }
                });
            }

            function sendData(tipe, fotoBase64) {
                Swal.fire({
                    title: 'Mengirim Data...',
                    didOpen: () => { Swal.showLoading() },
                    allowOutsideClick: false
                });

                const url = tipe === 'masuk' ? '{{ route("presensi.masuk") }}' : '{{ route("presensi.pulang") }}';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        latitude: currentLat,
                        longitude: currentLng,
                        foto: fotoBase64
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => window.location.reload());
                        } else {
                            Swal.fire('Gagal', data.message || 'Error', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Koneksi gagal.', 'error');
                    });
            }

            document.addEventListener("DOMContentLoaded", function () {
                initMap();
            });
        </script>
</body>

</html>
