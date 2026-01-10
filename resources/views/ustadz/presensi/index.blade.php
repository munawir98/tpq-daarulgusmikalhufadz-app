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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 48;
        }
        .map-mesh {
            background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body
    class="bg-gradient-to-b from-[#4a90e2] to-[#2c5282] dark:from-[#1e293b] dark:to-[#0f172a] min-h-screen text-white">
    <div class="max-w-md mx-auto min-h-screen flex flex-col p-6 relative overflow-hidden">
        <header class="flex items-center justify-between mt-4 mb-6">
            <div class="flex items-center space-x-3">
                <a href="{{ route('ustadz.dashboard') }}"
                    class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center shadow-lg active:scale-95 transition-transform">
                    <span class="material-icons-round text-white text-2xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-xl font-bold leading-tight">Presensi Kehadiran</h1>
                    <p class="text-white/70 text-xs">Ustadz &amp; Pengajar</p>
                </div>
            </div>
            <a href="{{ route('notifications.index') }}"
                class="w-10 h-10 glass-card rounded-full flex items-center justify-center">
                <span class="material-icons-round text-white">notifications</span>
            </a>
        </header>

        <div class="glass-card rounded-3xl p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    @if(session('user.foto'))
                    <img alt="Profile" class="w-12 h-12 rounded-2xl border-2 border-white/30 object-cover"
                        src="{{ asset('storage/' . session('user.foto')) }}" />
                    @else
                    <div
                        class="w-12 h-12 rounded-2xl border-2 border-white/30 bg-white/20 flex items-center justify-center text-xl font-bold">
                        {{ substr(session('user.name'), 0, 1) }}
                    </div>
                    @endif
                    <div
                        class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-[#4a90e2] rounded-full">
                    </div>
                </div>
                <div>
                    <p class="text-xs text-white/70">Assalamu'alaikum,</p>
                    <h2 class="text-md font-bold leading-tight">
                        @if(session('user.jenis_kelamin') == 'P') Ustadzah @else Ust. @endif
                        {{ explode(' ', session('user.name'))[0] }}
                    </h2>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[10px] bg-white/20 px-2 py-0.5 rounded-full inline-block">ID: {{ session('user.username')
                    ?? '---' }}</p>
            </div>
        </div>

        <div class="glass-card rounded-[32px] p-6 mb-8 text-center flex flex-col items-center">
            <div class="mb-4">
                <p class="text-3xl font-bold" id="current-time">--:--</p>
                <p class="text-white/70 text-xs mt-1" id="current-date">--</p>
            </div>

            <!-- MAP CONTAINER -->
            <div class="w-full h-40 bg-white/5 rounded-2xl mb-6 relative overflow-hidden border border-white/10 group">
                <div id="map" class="w-full h-full z-0"></div>

                <!-- Map Controls (Zoom/Reset) -->
                <div class="absolute bottom-2 right-2 flex flex-col space-y-1 z-[400]">
                    <button onclick="map.zoomIn()"
                        class="w-7 h-7 bg-white/90 backdrop-blur text-gray-600 rounded-lg shadow-sm flex items-center justify-center hover:bg-white active:scale-95">
                        <span class="material-icons-round text-sm">add</span>
                    </button>
                    <button onclick="map.zoomOut()"
                        class="w-7 h-7 bg-white/90 backdrop-blur text-gray-600 rounded-lg shadow-sm flex items-center justify-center hover:bg-white active:scale-95">
                        <span class="material-icons-round text-sm">remove</span>
                    </button>
                    <button onclick="resetMap()"
                        class="w-7 h-7 bg-blue-500/90 backdrop-blur text-white rounded-lg shadow-sm flex items-center justify-center hover:bg-blue-600 active:scale-95">
                        <span class="material-icons-round text-sm">restart_alt</span>
                    </button>
                </div>

                <!-- Status Overlay (Visual Only, real logic in JS) -->
                <div class="absolute top-2 right-2 flex items-center space-x-1 bg-green-500/90 text-white px-3 py-1 rounded-full shadow-lg z-[400]"
                    id="radiusStatusBadge" style="display: none;">
                    <span class="material-icons-round text-[14px]">verified</span>
                    <span class="text-[10px] font-bold">Dalam Radius</span>
                </div>

                <div class="absolute top-2 right-2 flex items-center space-x-1 bg-red-500/90 text-white px-3 py-1 rounded-full shadow-lg z-[400]"
                    id="radiusStatusBadgeError" style="display: none;">
                    <span class="material-icons-round text-[14px]">error</span>
                    <span class="text-[10px] font-bold">Luar Radius</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 w-full mb-6">
                <!-- Fingerprint / Geo Button (Masuk) -->
                <button onclick="checkBiometricAndSubmit('masuk')"
                    class="relative flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-xl text-blue-600 active:scale-95 transition-transform overflow-hidden group">
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
                    class="relative flex flex-col items-center justify-center p-5 bg-white/10 border border-white/20 rounded-2xl text-white active:scale-95 transition-transform hover:bg-white/20">
                    <span class="material-symbols-outlined text-4xl mb-2">logout</span>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Presensi Pulang</span>
                    <div class="mt-2 flex items-center text-[8px] text-white/50 font-medium">
                        <span class="material-icons-round text-[10px] mr-0.5">photo_camera</span>
                        Selfie Check
                    </div>
                </button>
            </div>

            <button onclick="window.location.reload()"
                class="w-full py-4 bg-white/20 hover:bg-white/30 border border-white/30 rounded-2xl font-bold text-sm tracking-[0.2em] uppercase transition-all mb-4">
                Refresh Lokasi
            </button> <!-- ... rest of the file ... -->

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
                const hasBiometric = @json(session('user.biometric_credential') ? true : false);

                let map, userMarker, circle;
                let currentLat = null;
                let currentLng = null;
                let isWithinRadius = false;

                function initMap() {
                    // Initialize map with a default view roughly around Indonesia or expected area
                    map = L.map('map', {
                        zoomControl: false,
                        attributionControl: false
                    }).setView([SENTRA_LAT, SENTRA_LNG], 16);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19
                    }).addTo(map);

                    // Draw Radius Circle
                    circle = L.circle([SENTRA_LAT, SENTRA_LNG], {
                        color: 'green',
                        fillColor: '#4ade80',
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
                    if (navigator.geolocation) {
                        navigator.geolocation.watchPosition(showPosition, showError, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        });
                    } else {
                        document.getElementById('statusText').textContent = "Geolocation tidak didukung browser ini.";
                    }
                }

                function showPosition(position) {
                    currentLat = position.coords.latitude;
                    currentLng = position.coords.longitude;

                    // Update Map
                    if (userMarker) {
                        userMarker.setLatLng([currentLat, currentLng]);
                        // Smooth Pan if far
                    } else {
                        const customIcon = L.divIcon({
                            className: 'custom-div-icon',
                            html: "<div style='background-color:blue; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5);'></div>",
                            iconSize: [12, 12],
                            iconAnchor: [6, 6]
                        });
                        userMarker = L.marker([currentLat, currentLng], { icon: customIcon }).addTo(map);
                        map.setView([currentLat, currentLng], 18);
                    }

                    // Calculate Distance
                    const distance = map.distance([currentLat, currentLng], [SENTRA_LAT, SENTRA_LNG]);
                    const locationNameEl = document.getElementById('locationName');
                    const statusTextEl = document.getElementById('statusText');
                    const statusIconEl = document.getElementById('statusIcon');
                    const badgeOk = document.getElementById('radiusStatusBadge');
                    const badgeErr = document.getElementById('radiusStatusBadgeError');

                    if (distance <= RADIUS_METER) {
                        isWithinRadius = true;
                        locationNameEl.textContent = "Dalam Area TPQ";
                        statusTextEl.textContent = `Akurat (${Math.round(distance)}m)`;
                        statusIconEl.textContent = 'check_circle';
                        statusIconEl.classList.remove('text-red-400');
                        statusIconEl.classList.add('text-green-400');
                        badgeOk.style.display = 'flex';
                        badgeErr.style.display = 'none';
                    } else {
                        isWithinRadius = false;
                        locationNameEl.textContent = "Luar Area TPQ";
                        statusTextEl.textContent = `Jarak: ${Math.round(distance)}m`;
                        statusIconEl.textContent = 'warning';
                        statusIconEl.classList.add('text-red-400');
                        statusIconEl.classList.remove('text-green-400');
                        badgeOk.style.display = 'none';
                        badgeErr.style.display = 'flex';
                    }
                }

                function showError(error) {
                    // ... (keep existing error handling)
                    let msg = "Terjadi kesalahan.";
                    switch (error.code) {
                        case error.PERMISSION_DENIED: msg = "Izin lokasi ditolak."; break;
                        case error.POSITION_UNAVAILABLE: msg = "Informasi lokasi tidak tersedia."; break;
                        case error.TIMEOUT: msg = "Waktu permintaan habis."; break;
                    }
                    document.getElementById('statusText').textContent = msg;
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
                                window.location.href = "{{ route('biometric.index') }}";
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

                            // Dummy Get Credential just to trigger sensor
                            const publicKey = {
                                challenge: new Uint8Array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]),
                                rpId: window.location.hostname,
                                timeout: 60000,
                                userVerification: "required"
                            };

                            await navigator.credentials.get({ publicKey });
                            Swal.close();

                        } catch (err) {
                            Swal.fire('Gagal Verifikasi', 'Sidik jari tidak dikenali atau dibatalkan.', 'error');
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
