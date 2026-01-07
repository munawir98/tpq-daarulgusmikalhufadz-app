@extends('layouts.mobile')

@section('title', 'Presensi')

@section('header')
<header
    class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="flex items-center justify-between px-5 py-4">
        <div class="flex items-center gap-3">
            <a href="{{ url()->previous() }}"
                class="p-2 -ml-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-xl font-bold">Presensi</h2>
        </div>
        <a href="{{ route('santri.presensi.history') }}"
            class="flex items-center gap-1 text-primary text-sm font-semibold hover:underline">
            <span class="material-symbols-outlined" style="font-size: 18px;">history</span>
            Riwayat
        </a>
    </div>
</header>
@endsection

@section('content')

{{-- Status Card --}}
<div class="bg-primary rounded-3xl p-6 shadow-lg shadow-primary/20">
    <div class="flex flex-col items-center text-center">
        <div class="bg-[#102216]/10 p-4 rounded-2xl mb-4">
            <span class="material-symbols-outlined text-[#102216]" style="font-size: 48px;">
                {{ $hasPresensi ? 'check_circle' : 'qr_code_scanner' }}
            </span>
        </div>
        <h3 class="text-2xl font-bold text-[#102216] mb-1">
            {{ $hasPresensi ? 'Sudah Presensi!' : 'Presensi Hari Ini' }}
        </h3>
        <p class="text-[#102216]/80 text-sm">
            @if($hasPresensi)
            Masuk: {{ $presensiTime }} WIB
            @else
            Scan QR atau presensi manual
            @endif
        </p>
    </div>
</div>

{{-- Location Status --}}
{{-- Location Status --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
    <div id="map" class="mb-4"></div>

    <div class="flex items-start gap-4">
        <div id="locationCard" class="shrink-0 p-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-500">
            <span id="statusIcon" class="material-symbols-outlined">location_on</span>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-[#111813] dark:text-white">Status Lokasi</h4>
            <p id="locationText" class="text-sm text-gray-500 mt-1">
                Mencari lokasi...
            </p>
            <div id="debugConsole"
                class="text-[10px] font-mono text-gray-400 mt-2 p-2 bg-gray-50 dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700 hidden">
                Logs:
            </div>
            <p id="distanceText" class="text-xs text-gray-500 mt-2">Jarak: -- m dari TPQ</p>
        </div>
        <button onclick="refreshLocation()"
            class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <span class="material-symbols-outlined">refresh</span>
        </button>
    </div>
</div>

{{-- Action Buttons --}}
@if(!$hasPresensi)
<div class="flex flex-col gap-3">
    <button id="btnScan" onclick="openQRScanner()" disabled
        class="w-full flex items-center justify-center gap-3 bg-primary text-[#102216] font-bold py-4 rounded-2xl shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all active:scale-95 opacity-50 cursor-not-allowed">
        <span class="material-symbols-outlined">qr_code_scanner</span>
        Scan QR Code
    </button>

    <button id="btnManual" onclick="manualPresensi()" disabled
        class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-800 text-[#111813] dark:text-white font-bold py-4 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-primary/50 transition-all active:scale-95 opacity-50 cursor-not-allowed">
        <span class="material-symbols-outlined">touch_app</span>
        Presensi Manual
    </button>
</div>
@endif

{{-- Instructions --}}
<div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-5 border border-dashed border-gray-200 dark:border-gray-700">
    <div class="flex items-center gap-2 mb-3">
        <span class="material-symbols-outlined text-primary" style="font-size: 20px;">info</span>
        <h4 class="font-bold text-[#111813] dark:text-white">Cara Presensi</h4>
    </div>
    <ol class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
        <li class="flex items-start gap-3">
            <span
                class="shrink-0 size-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">1</span>
            <span>Pastikan lokasi GPS aktif di perangkat Anda</span>
        </li>
        <li class="flex items-start gap-3">
            <span
                class="shrink-0 size-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">2</span>
            <span>Berada di area TPQ (radius 100m)</span>
        </li>
        <li class="flex items-start gap-3">
            <span
                class="shrink-0 size-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">3</span>
            <span>Scan kode QR atau tap presensi manual</span>
        </li>
        <li class="flex items-start gap-3">
            <span
                class="shrink-0 size-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center">4</span>
            <span>Tunggu konfirmasi dari sistem</span>
        </li>
    </ol>
</div>

{{-- Simulation Tools Removed for Production --}}

@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: 250px;
        width: 100%;
        border-radius: 1rem;
        z-index: 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Configuration
    // Masjid Albir Brigade Arsy, Jl. P Dan K, Kedung Halang, Bogor
    const TPQ_LAT = -6.551824;
    const TPQ_LNG = 106.816065;
    const RADIUS_METER = 50; // 50 meters

    let map, userMarker, circle;
    let currentLat, currentLng;
    let isWithinRadius = false;

    // Logger Utility
    function log(message, isError = false) {
        console.log(message);
        const debugEl = document.getElementById('debugConsole');
        if (debugEl) {
            debugEl.classList.remove('hidden');
            const time = new Date().toLocaleTimeString();
            const color = isError ? 'text-red-500' : 'text-gray-500';
            debugEl.innerHTML += `<div class="${color}">[${time}] ${message}</div>`;
        }
    }

    // Initialize Map
    function initMap() {
        log("Initializing Map...");

        if (typeof L === 'undefined') {
            log("Error: Leaflet library not loaded!", true);
            alert("Gagal memuat peta. Periksa koneksi internet Anda.");
            return;
        }

        try {
            // Default view centered on TPQ
            map = L.map('map').setView([TPQ_LAT, TPQ_LNG], 17);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            // Add TPQ Radius Circle
            circle = L.circle([TPQ_LAT, TPQ_LNG], {
                color: '#ef4444', // Red
                fillColor: '#ef4444',
                fillOpacity: 0.2,
                radius: RADIUS_METER
            }).addTo(map);

            // Add TPQ Marker
            L.marker([TPQ_LAT, TPQ_LNG]).addTo(map)
                .bindPopup("Lokasi TPQ")
                .openPopup();

            log("Map initialized. Starting Geolocation...");
            getLocation();
        } catch (e) {
            log("Map init error: " + e.message, true);
        }
    }

    function getLocation() {
        if (!navigator.geolocation) {
            log("Geolocation API not supported", true);
            alert("Geolocation is not supported by this browser.");
            document.getElementById('locationText').innerText = "Browser tidak mendukung GPS.";
            return;
        }

        log("Requesting position...");

        // Set timeout for location request
        const locationTimeout = setTimeout(() => {
            log("Timeout triggered after 10s", true);
            showError({ code: 3, message: "Timeout - requesting location took too long." });
        }, 10000);

        navigator.geolocation.watchPosition(
            (position) => {
                clearTimeout(locationTimeout);
                log("Position received: " + position.coords.latitude.toFixed(6));
                showPosition(position);
            },
            (error) => {
                clearTimeout(locationTimeout);
                log("Geolocation error: " + error.code + " - " + error.message, true);
                showError(error);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function showPosition(position) {
        currentLat = position.coords.latitude;
        currentLng = position.coords.longitude;

        // Update User Marker
        if (userMarker) {
            userMarker.setLatLng([currentLat, currentLng]);
        } else {
            userMarker = L.marker([currentLat, currentLng], {
                icon: L.divIcon({
                    className: 'bg-green-500 w-4 h-4 rounded-full border-2 border-white shadow-lg',
                    iconSize: [16, 16]
                })
            }).addTo(map);

            // Center map initially
            map.setView([currentLat, currentLng], 17);
        }

        // Calculate Distance
        const distance = calculateDistance(currentLat, currentLng, TPQ_LAT, TPQ_LNG);
        log("Distance calculated: " + Math.round(distance) + "m");
        updateStatus(distance);
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // Earth radius in meters
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
            Math.cos(φ1) * Math.cos(φ2) *
            Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c; // Distance in meters
    }

    function updateStatus(distance) {
        const statusTextEl = document.getElementById('locationText');
        const distanceEl = document.getElementById('distanceText');
        const btnScan = document.getElementById('btnScan');
        const btnManual = document.getElementById('btnManual');
        const locationCard = document.getElementById('locationCard');

        distanceEl.innerText = `Jarak: ${Math.round(distance)}m dari TPQ`;

        if (distance <= RADIUS_METER) {
            isWithinRadius = true;
            statusTextEl.innerText = "Anda berada di area TPQ";
            statusTextEl.className = "text-sm text-green-600 mt-1 font-bold";

            // Update Card Style
            locationCard.className = "shrink-0 p-3 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600";
            locationCard.innerHTML = '<span class="material-symbols-outlined">check_circle</span>';

            // Enable Buttons
            if (btnScan) {
                btnScan.disabled = false;
                btnScan.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            if (btnManual) {
                btnManual.disabled = false;
                btnManual.classList.remove('opacity-50', 'cursor-not-allowed');
            }

        } else {
            isWithinRadius = false;
            statusTextEl.innerText = "Anda di luar area TPQ (Max 50m)";
            statusTextEl.className = "text-sm text-red-600 mt-1 font-bold";

            // Update Card Style
            locationCard.className = "shrink-0 p-3 rounded-xl bg-red-100 dark:bg-red-900/30 text-red-600";
            locationCard.innerHTML = '<span class="material-symbols-outlined">fmd_bad</span>';

            // Disable Buttons
            if (btnScan) {
                btnScan.disabled = true;
                btnScan.classList.add('opacity-50', 'cursor-not-allowed');
            }
            if (btnManual) {
                btnManual.disabled = true;
                btnManual.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    function showError(error) {
        let msg = "";
        switch (error.code) {
            case error.PERMISSION_DENIED:
                msg = "Akses lokasi ditolak. Mohon izinkan lokasi di pengaturan browser.";
                break;
            case error.POSITION_UNAVAILABLE:
                msg = "Informasi lokasi tidak tersedia. Pastikan GPS aktif.";
                break;
            case error.TIMEOUT:
            case 3: // Custom timeout code
                msg = "Waktu habis. Gagal mendapatkan lokasi. Coba refresh.";
                break;
            default:
                msg = "Terjadi kesalahan tidak diketahui (" + error.message + ").";
                break;
        }
        log("Show Error: " + msg, true);

        // Update UI logic
        document.getElementById('locationText').innerHTML = `<span class="text-red-600 font-bold">${msg}</span>`;
        document.getElementById('distanceText').innerText = "Gagal memuat";

        // Show SSL warning if on http and not localhost (heuristic)
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            log("WARN: Non-secure context detected!", true);
            alert('PERHATIAN: Fitur GPS biasanya tidak berjalan di HTTP. Pastikan browser HP sudah disetting "Insecure origins treated as secure".');
        }
    }

    function refreshLocation() {
        location.reload();
    }

    function openQRScanner() {
        if (!isWithinRadius) {
            alert('Anda berada di luar radius presensi (' + RADIUS_METER + 'm)!');
            return;
        }
        alert('Membuka QR Scanner... (Simulasi)');
        // Implementasi Scanner bisa ditambahkan di sini
    }

    function manualPresensi() {
        if (!isWithinRadius) {
            alert('Anda berada di luar radius presensi (' + RADIUS_METER + 'm)!');
            return;
        }

        if (confirm('Yakin melakukan presensi manual?')) {
            // Include coordinates in request
            fetch('{{ route("santri.presensi.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    type: 'manual',
                    latitude: currentLat,
                    longitude: currentLng
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Presensi berhasil!');
                        location.reload();
                    } else {
                        alert(data.message || 'Gagal melakukan presensi');
                    }
                })
                .catch(error => {
                    log("Fetch Error: " + error.message, true);
                    alert('Terjadi kesalahan network');
                });
        }
    }

    document.addEventListener('DOMContentLoaded', initMap);
</script>
@endpush
