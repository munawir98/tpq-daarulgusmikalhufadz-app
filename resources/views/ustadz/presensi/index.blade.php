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



        <div class="glass-card rounded-[32px] p-6 mb-8 text-center flex flex-col items-center">
            <div class="mb-4">
                <p class="text-3xl font-bold" id="current-time">--:--</p>
                <p class="text-white/70 text-xs mt-1" id="current-date">--</p>
            </div>

            <!-- Status Hari Ini (Card Style like Dashboard) -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                <!-- Masuk Card -->
                <div
                    class="glass-card p-3 rounded-2xl flex items-center space-x-3 {{ $jamMasuk ? 'bg-green-500/10 border-green-500/30' : '' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ $jamMasuk ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'bg-white/10 text-white/50' }}">
                        <span class="material-icons-round">login</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/60 font-medium">Jam Masuk</p>
                        <p class="text-sm font-bold text-white tracking-wide">{{ $jamMasuk ?
                            \Carbon\Carbon::parse($jamMasuk->jam)->format('H:i') : '--:--' }}</p>
                    </div>
                </div>

                <!-- Pulang Card -->
                <div
                    class="glass-card p-3 rounded-2xl flex items-center space-x-3 {{ $jamPulang ? 'bg-orange-500/10 border-orange-500/30' : '' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ $jamPulang ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/30' : 'bg-white/10 text-white/50' }}">
                        <span class="material-icons-round">logout</span>
                    </div>
                    <div>
                        <p class="text-[10px] text-white/60 font-medium">Jam Pulang</p>
                        <p class="text-sm font-bold text-white tracking-wide">{{ $jamPulang ?
                            \Carbon\Carbon::parse($jamPulang->jam)->format('H:i') : '--:--' }}</p>
                    </div>
                </div>
            </div>
            <div class="w-full h-40 bg-white/5 rounded-2xl mb-6 relative overflow-hidden border border-white/10 group">
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

                <button id="locationStatusBtn" onclick="window.location.reload()"
                    class="w-full py-4 bg-white/20 hover:bg-white/30 border border-white/30 rounded-2xl font-bold text-sm tracking-[0.2em] uppercase transition-all mb-8">
                    Mendeteksi Lokasi...
                </button>
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
                    <div class="glass-card rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div
                                class="w-10 h-10 {{ $item->tipe == 'masuk' ? 'bg-green-500/20 text-green-400' : 'bg-orange-500/20 text-orange-400' }} rounded-xl flex items-center justify-center">
                                <span class="material-icons-round">{{ $item->tipe == 'masuk' ? 'login' : 'logout'
                                    }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-white">{{ $item->tipe == 'masuk' ? 'Masuk Kelas' :
                                    'Pulang / Selesai' }}</p>
                                <p class="text-[11px] text-white/50">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d M') }},
                                    {{ \Carbon\Carbon::parse($item->jam)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span
                                class="text-[10px] {{ $item->tipe == 'masuk' ? 'bg-green-500/20 text-green-400' : 'bg-white/10 text-white/70' }} px-2 py-1 rounded-lg">
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
                    const statusBtn = document.getElementById('locationStatusBtn');

                    if (distance <= RADIUS_METER) {
                        isWithinRadius = true;
                        if (statusBtn) {
                            statusBtn.textContent = `Dalam Radius ${Math.round(distance)} Meter`;
                            statusBtn.classList.remove('bg-red-500/20', 'border-red-500/30', 'text-red-200');
                            statusBtn.classList.add('bg-green-500/20', 'border-green-500/30', 'text-white');
                        }
                        if (circle) circle.setStyle({ color: '#22c55e', fillColor: '#22c55e' });

                    } else {
                        isWithinRadius = false;
                        if (statusBtn) {
                            statusBtn.textContent = `Luar Radius ${Math.round(distance)} Meter`;
                            statusBtn.classList.remove('bg-green-500/20', 'border-green-500/30', 'text-white');
                            statusBtn.classList.add('bg-red-500/20', 'border-red-500/30', 'text-white');
                        }
                        if (circle) circle.setStyle({ color: '#ef4444', fillColor: '#ef4444' });
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
