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
                <div class="w-12 h-12 bg-white rounded-full p-2 shadow-lg flex items-center justify-center">
                    <img alt="Logo TPQ Daarul Gusmik" class="w-full h-full object-contain"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD30kh2QMnbSq5XtYE8dK4qwOuiYFIhXZ774jdaBuQ0xDAO338hQda3Xy4m6nFQVtjZw09qVxBzmnwD9IkdcW2v1yAo5JFMi6YKSeovQXCJ880WNr0OPIMG96tlmRedcF3wUV1QRqar0b7wU4tLFtHCpWlEiwZ8GruJzUjyt2Knz-qadQHgyMGU4wTv0va5ce0hjKhZr9WTTv-JmdMaiveUDxZLoUKXjeMNkbNTTMpNPFpEgelzpjjAz75Wuh0WIzOjdCS9BWkP2DFb" />
                </div>
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
            <div class="w-full h-40 bg-white/5 rounded-2xl mb-6 relative overflow-hidden border border-white/10">
                <div id="map" class="w-full h-full z-0"></div>
                <!-- Overlays will be handled by Leaflet or absolute positioning on top if needed,
                     but better to use Leaflet markers/circles for accuracy -->

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
                <button onclick="submitPresensi('masuk')"
                    class="relative flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-xl text-blue-600 active:scale-95 transition-transform overflow-hidden group">
                    <div class="absolute top-0 right-0 p-1 bg-green-500 text-white rounded-bl-lg">
                        <span class="material-icons-round text-sm">login</span>
                    </div>
                    <span class="material-symbols-outlined text-4xl mb-2 text-blue-600">fingerprint</span>
                    <span class="text-[10px] font-bold uppercase tracking-wide">Presensi Masuk</span>
                    <div class="mt-2 flex items-center text-[8px] text-blue-500 font-medium">
                        <span class="material-icons-round text-[10px] mr-0.5">map</span>
                        Geo Verified
                    </div>
                </button>

                <!-- Selfie Button (Pulang) - Logic can be swapped or generic -->
                <button onclick="submitPresensi('pulang')"
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
            </button>

            <div
                class="flex items-center justify-center space-x-2 w-full py-3 bg-green-500/10 border border-green-500/20 rounded-xl">
                <div class="flex flex-col items-center">
                    <div class="flex items-center space-x-2">
                        <span class="material-icons-round text-green-400 text-sm">location_on</span>
                        <span class="text-[11px] font-semibold text-white" id="locationName">Mendeteksi Lokasi...</span>
                    </div>
                    <div class="flex items-center mt-0.5 space-x-1">
                        <span class="material-icons-round text-[10px] text-green-400" id="statusIcon">sync</span>
                        <span class="text-[10px] text-green-400 font-medium" id="statusText">Menunggu koordinat
                            GPS...</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 pb-24">
            <div class="flex items-center justify-between mb-4 px-2">
                <h3 class="font-bold text-lg">Riwayat Pekan Ini</h3>
                <a href="{{ route('ustadz.laporan.index') }}" class="text-xs text-white/70 font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($riwayat as $log)
                <div class="glass-card rounded-2xl p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-10 h-10 {{ $log->tipe == 'masuk' ? 'bg-green-500/20 text-green-400' : 'bg-orange-500/20 text-orange-400' }} rounded-xl flex items-center justify-center">
                            <span class="material-icons-round">{{ $log->tipe == 'masuk' ? 'login' : 'logout' }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-white">{{ $log->tipe == 'masuk' ? 'Masuk' : 'Pulang' }}
                            </p>
                            <p class="text-[11px] text-white/50">{{
                                \Carbon\Carbon::parse($log->tanggal)->translatedFormat('l, d M') }}, {{ $log->jam }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($log->status_presensi == 'HADIR')
                        <span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-1 rounded-lg">Hadir</span>
                        @else
                        <span class="text-[10px] bg-red-500/20 text-red-400 px-2 py-1 rounded-lg">{{
                            $log->status_presensi }}</span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-white/50 text-xs py-4">Belum ada riwayat presensi pekan ini.</p>
                @endforelse
            </div>
        </div>

        <footer class="mt-8 text-center text-[10px] text-white/40 pb-24">
            <p>© {{ date('Y') }} TPQ Daarul Gusmik Al-Hufadz • Versi 2.1.0</p>
        </footer>

        <!-- Bottom Nav -->
        <nav
            class="fixed bottom-6 left-6 right-6 h-16 glass-card rounded-2xl shadow-2xl flex items-center justify-around px-2 z-50">
            <a href="{{ route('ustadz.dashboard') }}"
                class="flex flex-col items-center justify-center text-white/50 hover:text-primary transition-colors">
                <span class="material-icons-round">home</span>
                <span class="text-[10px] mt-0.5">Beranda</span>
            </a>
            <a href="{{ route('ustadz.presensi') }}" class="flex flex-col items-center justify-center text-primary">
                <span class="material-icons-round">fingerprint</span>
                <span class="text-[10px] mt-0.5">Absen</span>
            </a>
            <a href="{{ route('ustadz.laporan.index') }}"
                class="flex flex-col items-center justify-center text-white/50 hover:text-primary transition-colors">
                <span class="material-icons-round">assignment</span>
                <span class="text-[10px] mt-0.5">Laporan</span>
            </a>
            <a href="{{ route('ustadz.settings') }}"
                class="flex flex-col items-center justify-center text-white/50 hover:text-primary transition-colors">
                <span class="material-icons-round">person</span>
                <span class="text-[10px] mt-0.5">Profil</span>
            </a>
        </nav>
    </div>

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
        const SENTRA_LAT = -6.597629; // Placeholder
        const SENTRA_LNG = 106.799568; // Placeholder
        const RADIUS_METER = 50;

        let map, userMarker, circle;
        let currentLat = null;
        let currentLng = null;

        function initMap() {
            // Initialize map with a default view roughly around Indonesia or expected area
            map = L.map('map', {
                zoomControl: false,
                attributionControl: false
            }).setView([SENTRA_LAT, SENTRA_LNG], 15);

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
            } else {
                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: "<div style='background-color:blue; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5);'></div>",
                    iconSize: [12, 12],
                    iconAnchor: [6, 6]
                });
                userMarker = L.marker([currentLat, currentLng], { icon: customIcon }).addTo(map);
            }

            map.setView([currentLat, currentLng], 18);

            // Calculate Distance
            const distance = map.distance([currentLat, currentLng], [SENTRA_LAT, SENTRA_LNG]);
            const locationNameEl = document.getElementById('locationName');
            const statusTextEl = document.getElementById('statusText');
            const statusIconEl = document.getElementById('statusIcon');
            const badgeOk = document.getElementById('radiusStatusBadge');
            const badgeErr = document.getElementById('radiusStatusBadgeError');

            if (distance <= RADIUS_METER) {
                locationNameEl.textContent = "Dalam Area TPQ";
                statusTextEl.textContent = `Akurat (${Math.round(distance)}m)`;
                statusIconEl.textContent = 'check_circle';
                statusIconEl.classList.remove('text-red-400');
                statusIconEl.classList.add('text-green-400');
                badgeOk.style.display = 'flex';
                badgeErr.style.display = 'none';
            } else {
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
            let msg = "";
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    msg = "Izin lokasi ditolak.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    msg = "Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    msg = "Waktu permintaan habis.";
                    break;
                case error.UNKNOWN_ERROR:
                    msg = "Terjadi kesalahan tidak diketahui.";
                    break;
            }
            document.getElementById('statusText').textContent = msg;
            document.getElementById('statusIcon').textContent = 'error';
            document.getElementById('statusIcon').classList.add('text-red-400');
        }

        // --- SUBMIT LOGIC ---
        function submitPresensi(tipe) {
            if (!currentLat || !currentLng) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lokasi Belum Ditemukan',
                    text: 'Tunggu sebentar sampai GPS mengunci lokasi anda.',
                    timer: 2000
                });
                return;
            }

            // For simplicity, using a dummy base64 image or implementing camera later if requested specifically again (previous turn had simple camera).
            // The user requested "Refining Camera Capture Flow" previously but here is a fresh UI.
            // I will assume for now we might need a real camera input, but to keep this artifact "Safe" I will prompt or use a placeholder if camera not active.
            // HOWEVER, the BUTTON says "Selfie Cam".
            // Let's implement a simple Swal Queue for Photo if "Selfie" logic needed, OR just submit for now as MVP.

            // NOTE: The previous controller requires 'foto' (base64).
            // So we MUST capture photo.
            Swal.fire({
                title: 'Ambil Foto Presensi',
                html: 'Pastikan wajah terlihat jelas',
                showCancelButton: true,
                confirmButtonText: 'Buka Kamera',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Open Camera Input (Hidden)
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*';
                    input.capture = 'user';

                    input.onchange = e => {
                        const file = e.target.files[0];
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            const base64 = event.target.result;
                            sendData(tipe, base64);
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            timer: 2000
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Terjadi kesalahan saat presensi.'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan jaringan atau server.'
                    });
                    console.error(error);
                });
        }

        document.addEventListener("DOMContentLoaded", function () {
            initMap();
        });
    </script>
</body>

</html>
