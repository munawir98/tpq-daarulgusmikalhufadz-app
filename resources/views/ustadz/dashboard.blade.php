<!DOCTYPE html>
<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport" />
    <title>Ustadz Dashboard</title>

    <!-- PWA / Full Screen Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#4A90B8">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />

    <!-- DNS Prefetch for External Assets -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0"
        rel="stylesheet" />
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Smooth Marker Transitions */
        .leaflet-marker-icon,
        .leaflet-marker-shadow,
        path.leaflet-interactive {
            transition: transform 1s cubic-bezier(0.25, 0.1, 0.25, 1);
        }

        /* Custom Toast Animation */
        .swal2-popup.swal2-toast {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            padding: 0.75rem 1rem !important;
            border-radius: 1rem !important;
        }

        .swal2-title {
            font-size: 0.875rem !important;
            font-weight: 600 !important;
        }
    </style>
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
                        'nav': '0 -10px 40px rgba(0,0,0,0.05)',
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

        /* Allow horizontal swipe on slider even over map */
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

        /* Prevent map from blocking horizontal swipe */
        #map {
            touch-action: pan-y pinch-zoom;
        }

        .material-symbols-rounded {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes moveTexture {
            from {
                background-position: 0 0;
            }

            to {
                background-position: -40px 0;
            }
        }

        /* Gradient Texture Overlay - like reference image */
        /* Separate static highlight */
        .highlight-overlay {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(255, 255, 255, 0.02) 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.02) 75%,
                    rgba(255, 255, 255, 0.08) 100%);
        }

        /* Unified seamless stripe pattern */
        .islamic-pattern {
            background-image:
                linear-gradient(45deg,
                    rgba(255, 255, 255, 0.05) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.05) 50%,
                    rgba(255, 255, 255, 0.05) 75%,
                    transparent 75%,
                    transparent);
            background-size: 40px 40px;
            animation: moveTexture 3s linear infinite;
        }

        .islamic-pattern.pattern-dark {
            background-image:
                linear-gradient(45deg,
                    rgba(30, 64, 175, 0.08) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(30, 64, 175, 0.08) 50%,
                    rgba(30, 64, 175, 0.08) 75%,
                    transparent 75%,
                    transparent);
        }

        /* Marquee Animation */
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .marquee-container {
            overflow: hidden;
            width: 100%;
        }

        .marquee-content {
            display: flex;
            gap: 12px;
            animation: marquee 15s linear infinite;
            width: max-content;
        }

        .marquee-content:hover {
            animation-play-state: paused;
        }

        /* Cards Step Animation */
        .cards-slider {
            overflow: hidden;
            width: 100%;
        }

        .cards-track {
            display: flex;
            gap: 16px;
            transition: transform 0.8s ease-in-out;
            width: max-content;
            padding: 0;
        }

        /* Avatar Gradient Border Animation */
        @keyframes rotate-gradient {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .avatar-ring {
            position: relative;
        }

        .avatar-ring::before {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            background: linear-gradient(45deg, #4A90B8, #6BB8DE, #2E6B8A, #4A90B8);
            background-size: 400% 400%;
            animation: rotate-gradient 3s linear infinite;
            z-index: -1;
        }

        /* Pulse Animation for Button */
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

        /* Glassmorphism Nav */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass-nav {
            background: rgba(30, 30, 30, 0.85);
        }

        /* Fade In Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Confetti Animation */
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            top: -10px;
            z-index: 9999;
            animation: confetti-fall 3s ease-out forwards;
        }

        /* Quote Card */
        .quote-card {
            background: linear-gradient(135deg, rgba(74, 144, 184, 0.1) 0%, rgba(46, 107, 138, 0.05) 100%);
            border-left: 3px solid #4A90B8;
        }

        #debugConsole {
            display: none;
            /* Hidden after debugging */
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background: rgba(0, 0, 0, 0.8);
            color: #0f0;
            font-family: monospace;
            font-size: 10px;
            padding: 10px;
            overflow-y: auto;
            z-index: 99999;
            pointer-events: none;
            /* Allow clicks through */
        }
    </style>
    <style>
        body {
            /* Prevent pull-to-refresh on mobile used as app */
            overscroll-behavior-y: none;
            height: 100dvh;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 font-display flex justify-center items-center min-h-screen p-0 sm:p-4">
    <div
        class="relative w-full max-w-[400px] min-h-[100dvh] sm:min-h-0 sm:h-[850px] bg-background-light dark:bg-background-dark rounded-none sm:rounded-[40px] overflow-hidden shadow-none sm:shadow-2xl flex flex-col">

        <!-- Header Background - Blue Gradient -->
        <div
            class="absolute top-0 left-0 w-full h-[260px] bg-gradient-to-r from-[#1A2980] to-[#26D0CE] z-0 rounded-b-[40px] overflow-hidden">
            <div class="absolute top-[-50px] right-[-50px] w-64 h-64 bg-[#5BA3CC] rounded-full blur-3xl opacity-60">
            </div>
            <div class="absolute bottom-[-20px] left-[-20px] w-48 h-48 bg-[#2A5A78] rounded-full blur-2xl opacity-50">
            </div>
            <div class="absolute top-[100px] left-[50%] w-32 h-32 bg-[#6BB8DE] rounded-full blur-2xl opacity-30">
            </div>
            <div class="absolute inset-0 highlight-overlay"></div>
            <div class="absolute inset-0 islamic-pattern"></div>
        </div>

        <!-- Scrollable Content -->
        <div class="relative z-10 flex-1 overflow-y-auto no-scrollbar flex flex-col">

            <!-- Top Header -->
            <div
                class="px-6 pt-8 pb-2 text-white flex flex-col gap-2 pt-[calc(2rem+env(safe-area-inset-top))] shrink-0">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-4">
                        <div class="relative avatar-ring">
                            @if(session('user.foto'))
                            <img alt="Profile"
                                class="w-14 h-14 rounded-full border-2 border-white shadow-lg object-cover"
                                src="{{ asset('storage/' . session('user.foto')) }}" />
                            @else
                            <div
                                class="w-14 h-14 rounded-full border-2 border-white shadow-lg bg-white/20 flex items-center justify-center text-white text-xl font-bold">
                                {{ substr(session('user.name', 'U'), 0, 1) }}
                            </div>
                            @endif
                            <div
                                class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-400 border-2 border-white rounded-full animate-pulse">
                            </div>
                        </div>
                        <div>
                            <p id="greetingText" class="text-xs font-medium text-white/80 leading-none">
                                Assalamu'alaikum,</p>
                            <h1 class="text-xl font-bold tracking-tight -mt-1">
                                @if(session('user.jenis_kelamin') == 'P')
                                Ustadzah {{ session('user.name', '') }}
                                @else
                                Ustadz {{ session('user.name', '') }}
                                @endif
                            </h1>
                            <p id="liveDate" class="text-[10px] text-white/70 mt-0.5">{{ now()->translatedFormat('l, d F
                                Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('notifications.index') }}"
                        class="relative flex items-center justify-center transition-all hover:opacity-80">
                        <span class="material-symbols-rounded text-white text-[24px]">notifications</span>
                        @php
                        $unreadCount = \App\Models\User::find(session('user.id'))->unreadNotifications()->count();
                        @endphp
                        @if($unreadCount > 0)
                        <span
                            class="absolute -top-1 -right-1 min-w-[16px] h-[16px] bg-red-500 rounded-full flex items-center justify-center text-[9px] font-bold text-white px-1">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                        @endif
                    </a>
                </div>

                <!-- Status Cards with Marquee -->
                <div class="marquee-container mt-4">
                    <div class="marquee-content flex items-center" style="gap: 0;">
                        <!-- Set 1 -->
                        <div
                            class="shrink-0 flex items-center gap-1 px-1.5 py-0.5 bg-white/10 backdrop-blur-md rounded-md border border-white/10 mr-2">
                            <span class="material-symbols-rounded text-white text-[14px]">schedule</span>
                            <div>
                                <p class="text-[7px] text-white/70 leading-tight mb-0.5 font-medium">Waktu</p>
                                <p class="text-[8px] font-bold text-white leading-tight tracking-wide" id="liveClock">
                                    00:00:00</p>
                            </div>
                        </div>
                        <div
                            class="shrink-0 flex items-center gap-1 px-1.5 py-0.5 bg-white/10 backdrop-blur-md rounded-md border border-white/10 mr-2">
                            <span id="weatherIcon1"
                                class="material-symbols-rounded text-yellow-300 text-[14px]">partly_cloudy_day</span>
                            <div>
                                <p class="text-[7px] text-white/70 leading-tight mb-0.5 font-medium">Cuaca</p>
                                <p id="weatherText1" class="text-[8px] font-bold text-white leading-tight">Memuat...</p>
                            </div>
                        </div>
                        <a href="{{ route('chat.index') }}"
                            class="shrink-0 flex items-center gap-1 px-1.5 py-0.5 bg-white/10 backdrop-blur-md rounded-md border border-white/10 mr-2">
                            <span class="material-symbols-rounded text-blue-300 text-[14px]">mark_chat_unread</span>
                            <div>
                                <p class="text-[7px] text-white/70 leading-tight mb-0.5 font-medium">Pesan</p>
                                <p class="text-[8px] font-bold text-white leading-tight">12 Baru</p>
                            </div>
                        </a>
                        <!-- Set 2 (duplicate for seamless loop) -->
                        <div
                            class="shrink-0 flex items-center gap-1 px-1.5 py-0.5 bg-white/10 backdrop-blur-md rounded-md border border-white/10 mr-2">
                            <span class="material-symbols-rounded text-white text-[14px]">schedule</span>
                            <div>
                                <p class="text-[7px] text-white/70 leading-tight mb-0.5 font-medium">Waktu</p>
                                <p class="text-[8px] font-bold text-white leading-tight tracking-wide" id="liveClock2">
                                    00:00:00</p>
                            </div>
                        </div>
                        <div
                            class="shrink-0 flex items-center gap-1 px-1.5 py-0.5 bg-white/10 backdrop-blur-md rounded-md border border-white/10 mr-2">
                            <span id="weatherIcon2"
                                class="material-symbols-rounded text-yellow-300 text-[14px]">partly_cloudy_day</span>
                            <div>
                                <p class="text-[7px] text-white/70 leading-tight mb-0.5 font-medium">Cuaca</p>
                                <p id="weatherText2" class="text-[8px] font-bold text-white leading-tight">Memuat...</p>
                            </div>
                        </div>
                        <a href="{{ route('chat.index') }}"
                            class="shrink-0 flex items-center gap-1 px-1.5 py-0.5 bg-white/10 backdrop-blur-md rounded-md border border-white/10 mr-2">
                            <span class="material-symbols-rounded text-blue-300 text-[14px]">mark_chat_unread</span>
                            <div>
                                <p class="text-[7px] text-white/70 leading-tight mb-0.5 font-medium">Pesan</p>
                                <p class="text-[8px] font-bold text-white leading-tight">12 Baru</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- White Container Wrapper -->
            <div id="whiteContainer"
                class="w-full bg-white dark:bg-surface-dark rounded-t-[30px] shadow-soft pt-5 relative z-20 flex-grow min-h-0 pb-[calc(10px+env(safe-area-inset-bottom))] transition-all duration-300">

                <!-- Main Attendance Card (Expandable) -->
                <div id="mainCard"
                    class="mx-4 bg-gray-50 dark:bg-gray-800/50 rounded-[24px] p-5 relative z-20 mb-6 shadow-sm transition-all duration-300 overflow-hidden">


                    <!-- Swipe Indicator -->
                    <div class="absolute top-2 left-1/2 -translate-x-1/2 z-30 hidden">
                        <div id="swipeIndicator" class="w-10 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                    </div>

                    <!-- Hidden Native Camera Input -->
                    <input type="file" id="cameraInput" accept="image/*" capture="user" class="hidden" />

                    <!-- VIEW 1: Presensi Selfie (Default) -->
                    <div id="presensiView" class="transition-all duration-300">
                        <div class="flex justify-between items-center mb-5 mt-2">
                            <div>
                                <h2
                                    class="text-sm font-bold text-text-main-light dark:text-white flex items-center gap-2">
                                    Presensi Selfie
                                    <span class="material-symbols-rounded text-primary text-[18px]">camera_front</span>
                                </h2>
                                <p class="text-[8px] font-medium text-text-sub-light mt-0.5">Silahkan ambil foto
                                    kehadiran
                                </p>
                            </div>
                            <div id="radiusBadge"
                                class="px-2.5 py-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center gap-1.5 border border-gray-300 dark:border-gray-700 shadow-sm">
                                <span id="radiusDot" class="relative flex h-2 w-2">
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-gray-400"></span>
                                </span>
                                <span id="radiusText"
                                    class="text-[9px] font-bold text-gray-500 dark:text-gray-400">Mendeteksi...</span>

                            </div>
                        </div>





                        <div class="flex gap-4 mb-3">
                            <div id="ambilFotoBtn" onclick="ambilFoto()"
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
                                    <span class="material-symbols-rounded text-white text-2xl">check_circle</span>
                                </div>
                                <!-- In-Button Notification Overlay -->
                                <div id="btnNotification"
                                    class="absolute inset-0 bg-orange-500 rounded-2xl hidden flex-col items-center justify-center p-2 z-40 transition-all">
                                    <span class="material-symbols-rounded text-white text-lg mb-0.5">schedule</span>
                                    <span id="btnNotificationText"
                                        class="text-[7px] font-bold text-white text-center leading-tight"></span>
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col justify-center gap-1.5">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-2 flex justify-between items-center border border-gray-100 dark:border-gray-700 shadow-sm">
                                    <span class="text-[10px] text-gray-500 font-medium">Jam Masuk</span>
                                    <span id="jamMasuk"
                                        class="text-[10px] font-bold text-gray-400 dark:text-gray-500">-- :
                                        --</span>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-2 flex justify-between items-center border border-gray-100 dark:border-gray-700 shadow-sm">
                                    <span class="text-[10px] text-gray-500 font-medium">Jam Keluar</span>
                                    <span id="jamKeluar"
                                        class="text-[10px] font-bold text-gray-400 dark:text-gray-500">-- :
                                        --</span>
                                </div>
                                <div id="presensiStatus"
                                    class="bg-gray-50 dark:bg-gray-800 rounded-lg px-2 py-1 flex justify-between items-center border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <span class="text-[9px] text-gray-500 font-medium">Status</span>
                                    <span id="presensiText"
                                        class="text-[9px] font-bold text-gray-400 dark:text-gray-500">-------</span>
                                </div>
                            </div>
                        </div>

                        <!-- Map/Menu Swipe Slider -->
                        <div id="mapSliderSection" class="mt-6 mb-3">
                            <!-- Swipeable Container -->
                            <div id="slideContainer"
                                class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbar"
                                style="scroll-snap-type: x mandatory; scroll-behavior: smooth;">
                                <!-- Slide 1: Map -->
                                <div class="snap-center snap-always shrink-0 w-full" style="min-width: 100%;">
                                    <div id="mapWrapper"
                                        class="relative w-full h-[150px] rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm transition-shadow duration-300">
                                        <!-- Swipe Handle Overlay (for touch events) -->
                                        <div id="swipeOverlay" class="absolute inset-0 z-[500] pointer-events-none">
                                        </div>
                                        <!-- Leaflet Map Container -->
                                        <div id="map" class="w-full h-full z-0 bg-gray-200 dark:bg-gray-700"></div>

                                        <!-- Map Controls (Center Right) -->
                                        <div
                                            class="absolute top-1/2 -translate-y-1/2 right-2 z-[1000] flex flex-col gap-1.5">
                                            <button onclick="zoomIn()"
                                                class="w-6 h-6 bg-white dark:bg-gray-700 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-600 active:scale-90 transition-all duration-200">
                                                <span
                                                    class="material-symbols-rounded text-gray-600 dark:text-gray-300 text-[14px]">add</span>
                                            </button>
                                            <button onclick="zoomOut()"
                                                class="w-6 h-6 bg-white dark:bg-gray-700 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-600 active:scale-90 transition-all duration-200">
                                                <span
                                                    class="material-symbols-rounded text-gray-600 dark:text-gray-300 text-[14px]">remove</span>
                                            </button>
                                            <button onclick="resetMap()"
                                                class="w-6 h-6 bg-white dark:bg-gray-700 rounded-md shadow-sm border border-gray-200 dark:border-gray-600 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-gray-600 active:scale-90 transition-all duration-200 mt-0.5">
                                                <span
                                                    class="material-symbols-rounded text-primary text-[14px]">restart_alt</span>
                                            </button>
                                        </div>

                                        <!-- Location Info Overlay -->
                                        <div
                                            class="absolute bottom-0 left-0 z-[1000] m-1.5 px-1.5 py-0.5 bg-white/90 dark:bg-gray-800/90 rounded-md shadow-sm">
                                            <div class="flex items-center gap-0.5">
                                                <span
                                                    class="material-symbols-rounded text-primary text-[10px]">location_on</span>
                                                <span
                                                    class="text-[6px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Lokasi</span>
                                            </div>
                                            <p class="text-[8px] font-mono font-bold text-primary truncate tracking-tight"
                                                id="userLocation">Mendeteksi...</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slide 2: Quick Menu -->
                                <div class="snap-center snap-always shrink-0 w-full" style="min-width: 100%;">
                                    <div class="grid grid-cols-4 gap-3 py-1">
                                        <!-- Row 1 -->
                                        <a href="{{ route('ustadz.hafalan.index') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-primary dark:text-blue-400 group-hover:bg-primary group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">menu_book</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Setoran</span>
                                        </a>
                                        <a href="{{ route('ustadz.laporan.index') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">analytics</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Laporan</span>
                                        </a>
                                        <a href="{{ route('chat.index') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">chat</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Pesan</span>
                                        </a>
                                        <a href="{{ route('ustadz.santri.index') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-500 group-hover:bg-cyan-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">group</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Santri</span>
                                        </a>
                                        <!-- Row 2 -->
                                        <a href="{{ route('ustadz.jadwal') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">calendar_month</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Jadwal</span>
                                        </a>
                                        <a href="{{ route('ustadz.presensi') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-500 group-hover:bg-teal-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">how_to_reg</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Presensi</span>
                                        </a>
                                        <a href="{{ route('info') }}" class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">info</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Info</span>
                                        </a>
                                        <a href="{{ route('profile.index') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-500 group-hover:bg-purple-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">person</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Akun</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- Slide 3: More Menu -->
                                <div class="snap-center snap-always shrink-0 w-full" style="min-width: 100%;">
                                    <div class="grid grid-cols-4 gap-3 py-1">
                                        <a href="{{ route('notifications.index') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">notifications</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Notifikasi</span>
                                        </a>
                                        <a href="#" class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center text-pink-500 group-hover:bg-pink-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">event</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Agenda</span>
                                        </a>
                                        <a href="#" class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-lime-100 dark:bg-lime-900/30 flex items-center justify-center text-lime-600 group-hover:bg-lime-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">history</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Riwayat</span>
                                        </a>
                                        <a href="{{ route('ustadz.settings') }}"
                                            class="flex flex-col items-center gap-1 group">
                                            <div
                                                class="w-11 h-11 rounded-2xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 group-hover:bg-gray-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                                <span class="material-symbols-rounded text-xl">settings</span>
                                            </div>
                                            <span
                                                class="text-[9px] font-bold text-gray-600 dark:text-gray-400">Pengaturan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Dot Indicators -->
                            <div class="flex justify-center gap-2 mt-2">
                                <button id="dot0" onclick="goToSlide(0)"
                                    class="w-2 h-2 rounded-full bg-primary transition-all"></button>
                                <button id="dot1" onclick="goToSlide(1)"
                                    class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 transition-all"></button>
                                <button id="dot2" onclick="goToSlide(2)"
                                    class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 transition-all"></button>
                            </div>
                        </div>

                        <!-- Swipe Up Hint -->
                        <div id="swipeUpHint"
                            class="flex justify-center items-center gap-1 mt-6 opacity-50 transition-opacity duration-300">
                            <span
                                class="material-symbols-rounded text-gray-400 text-sm animate-bounce">expand_less</span>
                            <span class="text-[7px] text-gray-400 font-medium">Swipe ke atas untuk menu</span>
                        </div>
                    </div>

                    <!-- VIEW 2: Expanded Menu (Hidden by default) -->
                    <div id="menuView" class="hidden transition-all duration-500 ease-in-out">
                        <div class="flex justify-between items-center mb-4 mt-2">
                            <h2 class="text-sm font-bold text-text-main-light dark:text-white flex items-center gap-2">
                                Menu Utama
                                <span class="material-symbols-rounded text-primary text-[18px]">apps</span>
                            </h2>
                            <button onclick="toggleCardView()"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                <span
                                    class="material-symbols-rounded text-gray-600 dark:text-gray-300 text-lg">close</span>
                            </button>
                        </div>

                        <!-- Full Menu Grid (3 rows) -->
                        <!-- Menu Slider Container -->
                        <!-- Full Menu Grid (All Items consolidated) -->
                        <!-- Full Menu Grid (All Items consolidated) -->
                        <!-- Full Menu Grid (Grouped by Category) -->
                        <div id="menuGrid" class="flex flex-col gap-5 px-1 py-1 overflow-y-auto max-h-[60vh] pb-12">

                            <!-- Full Menu Grid (Consolidated) -->
                            <div class="grid grid-cols-4 gap-4">
                                <!-- 1. Santri -->
                                <a href="{{ route('ustadz.santri.index') }}"
                                    class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 group-hover:bg-cyan-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">group</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Santri</span>
                                </a>

                                <!-- 2. Hafalan -->
                                <a href="{{ route('ustadz.hafalan.index') }}"
                                    class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">menu_book</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Setoran</span>
                                </a>

                                <!-- 3. Presensi -->
                                <a href="{{ route('ustadz.presensi') }}" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 group-hover:bg-teal-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">how_to_reg</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Presensi</span>
                                </a>

                                <!-- 4. Nilai -->
                                <a href="#" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">grade</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Nilai</span>
                                </a>

                                <!-- 5. Jadwal -->
                                <a href="#" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">calendar_month</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Jadwal</span>
                                </a>

                                <!-- 6. Keuangan -->
                                <a href="#" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">payments</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Keuangan</span>
                                </a>

                                <!-- 7. Laporan -->
                                <a href="{{ route('ustadz.laporan.index') }}"
                                    class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 group-hover:bg-orange-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">analytics</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Laporan</span>
                                </a>

                                <!-- 8. Pesan -->
                                <a href="{{ route('chat.index') }}" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 group-hover:bg-green-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">chat</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Pesan</span>
                                </a>

                                <!-- 9. Info -->
                                <a href="{{ route('info') }}" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-lime-100 dark:bg-lime-900/30 flex items-center justify-center text-lime-600 group-hover:bg-lime-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">info</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Info</span>
                                </a>

                                <!-- 10. Notifikasi -->
                                <a href="{{ route('notifications.index') }}"
                                    class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 group-hover:bg-red-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">notifications</span>
                                    </div>
                                    <span
                                        class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Notifikasi</span>
                                </a>

                                <!-- 11. Profil -->
                                <a href="{{ route('profile.index') }}" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 group-hover:bg-purple-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">person</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Profil</span>
                                </a>

                                <!-- 12. Pengaturan -->
                                <a href="{{ route('ustadz.settings') }}" class="flex flex-col items-center gap-2 group">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 group-hover:bg-gray-500 group-hover:text-white transition-all active:scale-95 shadow-sm">
                                        <span class="material-symbols-rounded text-2xl">settings</span>
                                    </div>
                                    <span
                                        class="text-[10px] font-bold text-gray-600 dark:text-gray-400">Pengaturan</span>
                                </a>
                            </div>
                        </div>

                        <!-- Swipe Down Hint -->
                        <div class="flex justify-center items-center gap-1 mt-4 opacity-50 pb-4">
                            <span
                                class="material-symbols-rounded text-gray-400 text-sm animate-bounce">expand_more</span>
                            <span class="text-[7px] text-gray-400 font-medium">Swipe ke bawah untuk kembali</span>
                        </div>

                    </div><!-- End Main Card -->
                </div>

                <!-- Bottom Navigation -->
                @include('layouts.partials.bottom-nav')

                <!-- Scripts -->
                <script src="{{ asset('js/islamic-quotes.js') }}"></script>
                <script>
                    // Live Clock & Date
                    function updateClock() {
                        const now = new Date();
                        const h = String(now.getHours()).padStart(2, '0');
                        const m = String(now.getMinutes()).padStart(2, '0');
                        const s = String(now.getSeconds()).padStart(2, '0');
                        const timeStr = `${h}:${m}:${s}`;
                        document.getElementById('liveClock').textContent = timeStr;
                        const clock2 = document.getElementById('liveClock2');
                        if (clock2) clock2.textContent = timeStr;
                    }
                    setInterval(updateClock, 1000);
                    updateClock();

                    const now = new Date();
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: '2-digit' };
                    document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', options);

                    // Dynamic Greeting
                    const hour = now.getHours();
                    let greeting = 'Assalamu\'alaikum,';
                    if (hour >= 3 && hour < 11) greeting = 'Selamat Pagi 🌅';
                    else if (hour >= 11 && hour < 15) greeting = 'Selamat Siang ☀️';
                    else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore 🌇';
                    else greeting = 'Selamat Malam 🌙';
                    const greetingEl = document.getElementById('greetingText');
                    if (greetingEl) greetingEl.textContent = greeting;

                    // Weather Logic (Optimized with Cache & Timeout)
                    async function getWeather() {
                        const cacheKey = 'weatherData';
                        const cacheTime = 3600000; // 1 hour (60 * 60 * 1000)

                        // 1. Check Cache
                        const cached = localStorage.getItem(cacheKey);
                        if (cached) {
                            try {
                                const { timestamp, data } = JSON.parse(cached);
                                if (Date.now() - timestamp < cacheTime) {
                                    renderWeather(data);
                                    return; // Use cache, don't fetch
                                }
                            } catch (e) { localStorage.removeItem(cacheKey); }
                        }

                        // 2. Fetch New Data
                        try {
                            const controller = new AbortController();
                            const timeoutId = setTimeout(() => controller.abort(), 2000); // 2s Timeout

                            const response = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-6.5520&longitude=106.8160&current_weather=true', {
                                signal: controller.signal
                            });
                            clearTimeout(timeoutId);

                            if (!response.ok) throw new Error('API Error');

                            const data = await response.json();

                            // Save to cache
                            localStorage.setItem(cacheKey, JSON.stringify({
                                timestamp: Date.now(),
                                data: data
                            }));

                            renderWeather(data);

                        } catch (e) {
                            console.error('Weather error:', e);
                            // Fallback to cache if available even if expired, or show Error
                            if (cached) {
                                const { data } = JSON.parse(cached);
                                renderWeather(data);
                            } else {
                                document.getElementById('weatherText1').textContent = 'N/A';
                                if (document.getElementById('weatherText2')) document.getElementById('weatherText2').textContent = 'N/A';
                            }
                        }
                    }

                    function renderWeather(data) {
                        if (!data || !data.current_weather) return;

                        const weatherCode = data.current_weather.weathercode;
                        const temp = Math.round(data.current_weather.temperature);

                        let weatherText = 'Cerah';
                        let icon = 'sunny';
                        let iconColor = 'text-yellow-300';

                        // Simple WMO code mapping
                        if (weatherCode <= 3) { weatherText = 'Cerah/Berawan'; icon = 'partly_cloudy_day'; }
                        else if (weatherCode <= 48) { weatherText = 'Berkabut'; icon = 'foggy'; iconColor = 'text-gray-300'; }
                        else if (weatherCode <= 67) { weatherText = 'Hujan'; icon = 'rainy'; iconColor = 'text-blue-300'; }
                        else if (weatherCode <= 82) { weatherText = 'Hujan Deras'; icon = 'thunderstorm'; iconColor = 'text-purple-300'; }
                        else if (weatherCode <= 99) { weatherText = 'Badai'; icon = 'thunderstorm'; iconColor = 'text-red-300'; }

                        const textEl1 = document.getElementById('weatherText1');
                        const textEl2 = document.getElementById('weatherText2');
                        const iconEl1 = document.getElementById('weatherIcon1');
                        const iconEl2 = document.getElementById('weatherIcon2');

                        if (textEl1) textEl1.textContent = `${weatherText}, ${temp}°C`;
                        if (textEl2) textEl2.textContent = `${weatherText}, ${temp}°C`;

                        if (iconEl1) {
                            iconEl1.textContent = icon;
                            iconEl1.className = `material-symbols-rounded ${iconColor} text-[14px]`;
                        }
                        if (iconEl2) {
                            iconEl2.textContent = icon;
                            iconEl2.className = `material-symbols-rounded ${iconColor} text-[14px]`;
                        }
                    }

                    // getWeather(); // Delayed to prioritize UI render
                    setTimeout(getWeather, 3000);
                    setInterval(getWeather, 900000); // 15 mins

                    // Presensi Logic
                    // Using Blade to check server state
                    const jadwalPresensi = {
                        0: { masukStart: '06:00', masukEnd: '07:00', pulangStart: '08:00', pulangEnd: '08:30', selesaiEnd: '09:00', nama: 'Ahad' },
                        1: { masukStart: '16:00', masukEnd: '17:00', pulangStart: '17:30', pulangEnd: '18:00', selesaiEnd: '18:30', nama: 'Senin' }, // Added default for safety
                        2: { masukStart: '16:00', masukEnd: '17:00', pulangStart: '17:30', pulangEnd: '18:00', selesaiEnd: '18:30', nama: 'Selasa' }, // Added default for safety
                        3: { masukStart: '16:00', masukEnd: '17:00', pulangStart: '17:30', pulangEnd: '18:00', selesaiEnd: '18:30', nama: 'Rabu' },
                        4: { masukStart: '16:00', masukEnd: '17:00', pulangStart: '17:30', pulangEnd: '18:00', selesaiEnd: '18:30', nama: 'Kamis' },
                        5: { masukStart: '14:00', masukEnd: '15:00', pulangStart: '16:00', pulangEnd: '16:30', selesaiEnd: '17:00', nama: 'Jumat' }, // Added default for safety
                        6: { masukStart: '06:00', masukEnd: '07:00', pulangStart: '08:00', pulangEnd: '08:30', selesaiEnd: '09:00', nama: 'Sabtu' }
                    };

                    let sudahMasuk = @json($presensiHariIni && $presensiHariIni -> jam_masuk ? true : false);
                    let sudahPulang = @json($presensiHariIni && $presensiHariIni -> jam_pulang ? true : false);
                    let waktuMasuk = @json($presensiHariIni && $presensiHariIni -> jam_masuk ?\Carbon\Carbon:: parse($presensiHariIni -> jam_masuk) -> format('H:i'). ' WIB' : '');
                    let waktuPulang = @json($presensiHariIni && $presensiHariIni -> jam_pulang ?\Carbon\Carbon:: parse($presensiHariIni -> jam_pulang) -> format('H:i'). ' WIB' : '');

                    // GPS & Map Logic
                    // Masjid Albir Brigade Arsy, Jl. P Dan K, Kedung Halang, Bogor
                    const TPQ_LAT = -6.551824;
                    const TPQ_LNG = 106.816065;
                    const RADIUS_METER = 50; // Radius 50m
                    let dalamRadius = false;
                    let userLat = null, userLng = null;

                    function getCurrentTime() {
                        const now = new Date();
                        return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
                    }

                    function getHariPresensiBerikutnya(currentDay) {
                        for (let i = 0; i < 7; i++) {
                            const nextDay = (currentDay + i + 1) % 7;
                            if (jadwalPresensi[nextDay]) return `${jadwalPresensi[nextDay].nama} - ${jadwalPresensi[nextDay].masukStart}`;
                        }
                        return 'Jadwal Berikutnya';
                    }

                    function cekJadwalPresensi() {
                        const now = new Date();
                        const day = now.getDay();
                        const currentTime = getCurrentTime();

                        if (!jadwalPresensi[day]) {
                            return { valid: false, type: null, jadwal: null, message: `Hari Libur<br/>${getHariPresensiBerikutnya(day)}` };
                        }

                        const jadwal = jadwalPresensi[day];

                        // 1. Logic Masuk (STRICT MODE)
                        if (!sudahMasuk) {
                            // Terlalu Pagi (Belum Masuk Jam Start)
                            if (currentTime < jadwal.masukStart) {
                                return { valid: false, type: 'tunggu_masuk', jadwal: jadwal, message: `Belum Jam Masuk<br/>(${jadwal.masukStart})` };
                            }

                            // On Time (Dalam Range Masuk)
                            if (currentTime >= jadwal.masukStart && currentTime <= jadwal.masukEnd) {
                                return { valid: true, type: 'masuk', jadwal: jadwal };
                            }

                            // Terlambat (Lewat Jam End)
                            return { valid: false, type: 'terlambat_masuk', jadwal: jadwal, message: `Absen Masuk Ditutup<br/>(Max ${jadwal.masukEnd})` };
                        }


                        // Helper to add minutes to "HH:mm"
                        function addMinutes(timeStr, mins) {
                            const [h, m] = timeStr.split(':').map(Number);
                            const date = new Date();
                            date.setHours(h, m + mins, 0, 0);
                            return String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
                        }

                        // 2. Logic Pulang (STRICT MODE + 30 mins grace period for message)
                        if (sudahMasuk && !sudahPulang) {
                            // Belum Waktunya (Sebelum Jam Pulang)
                            if (currentTime < jadwal.pulangStart) {
                                return { valid: false, type: 'tunggu_pulang', jadwal: jadwal, message: `Belum Waktu Pulang<br/>(${jadwal.pulangStart})` };
                            }

                            // On Time (Dalam Range Pulang)
                            if (currentTime >= jadwal.pulangStart && currentTime <= jadwal.pulangEnd) {
                                return { valid: true, type: 'pulang', jadwal: jadwal };
                            }

                            // Terlambat (Lewat Jam Pulang)
                            // "Absen Pulang Ditutup" tampil sampai 30 menit setelah jadwal berakhir
                            const limitTime = addMinutes(jadwal.pulangEnd, 30);

                            // Handle crossing midnight (very rare for school hours but safe handling)
                            // Simple string comparison works if times are in same day.
                            // If limitTime is smaller than pulangEnd (e.g. 23:45 + 30m = 00:15), this logic needs date objects.
                            // But for simplicity given the constraints:
                            if (currentTime <= limitTime) {
                                return { valid: false, type: 'terlambat_pulang', jadwal: jadwal, message: `Absen Pulang Ditutup<br/>(Max ${jadwal.pulangEnd})` };
                            }

                            // Jika lewat 30 menit, jatuh ke bawah (return default "Tunggu Jadwal")
                        }


                        // 3. Logic Selesai
                        if (sudahMasuk && sudahPulang) {
                            return { valid: false, type: 'selesai', jadwal: jadwal, message: 'Presensi Selesai' };
                        }

                        return { valid: false, type: null, jadwal: jadwal, message: `Tunggu Jadwal` };
                    }

                    function hitungJarak(lat1, lon1, lat2, lon2) {
                        if (!lat1 || !lon1) return 99999;
                        const R = 6371000;
                        const dLat = (lat2 - lat1) * Math.PI / 180;
                        const dLon = (lon2 - lon1) * Math.PI / 180;
                        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
                        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    }

                    // ==========================================
                    // NEW: SweetAlert2 Notification Logic
                    // ==========================================
                    function showNotification(message, type = 'info') {
                        console.log('[Notif]', type, message); // Debug log

                        try {
                            // Map 'info', 'success', 'error' to icons
                            const iconMap = {
                                'info': 'info',
                                'success': 'success',
                                'error': 'error',
                                'warning': 'warning'
                            };

                            // Use SweetAlert2 Toast if available
                            if (typeof Swal !== 'undefined' && Swal.fire) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top',
                                    icon: iconMap[type] || 'info',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        popup: '!rounded-xl !shadow-xl !border !border-gray-100 dark:!border-gray-700 dark:!bg-gray-800'
                                    }
                                });
                            } else {
                                // Fallback HTML notification
                                const existing = document.querySelectorAll('.notification-toast');
                                existing.forEach(el => el.remove());

                                const container = document.createElement('div');
                                container.className = 'notification-toast fixed top-4 left-1/2 -translate-x-1/2 z-[9999] bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-4 min-w-[280px] max-w-[90vw] border-l-4 border-blue-500 flex items-center gap-3';
                                container.style.transform = 'translateX(-50%)';
                                container.innerHTML = `
                        <div class="bg-blue-50 dark:bg-blue-900/30 p-2 rounded-full text-blue-500"><span class="material-symbols-rounded">info</span></div>
                        <div><p class="text-sm text-gray-800 dark:text-white">${message}</p></div>
                        `;
                                document.body.appendChild(container);
                                setTimeout(() => {
                                    container.style.opacity = '0';
                                    container.style.transition = 'opacity 0.3s';
                                    setTimeout(() => container.remove(), 300);
                                }, 3000);
                            }
                        } catch (e) {
                            console.error('Notification error:', e);
                            // Ultimate fallback - simple alert
                            // alert(message); // Uncomment if needed for debugging
                        }
                    }

                    function updateButtonDisplay() {
                        const btn = document.getElementById('ambilFotoBtn');
                        const icon = document.getElementById('fotoIcon');
                        const text = document.getElementById('fotoBtnText');

                        if (!btn) return;

                        const cek = cekJadwalPresensi();

                        // 1. Selesai
                        if (sudahMasuk && sudahPulang) {
                            btn.className = 'w-24 h-24 shrink-0 bg-green-50 dark:bg-green-900/30 rounded-2xl border-2 border-green-300 dark:border-green-700 flex flex-col items-center justify-center gap-1 cursor-default opacity-80';
                            if (icon) {
                                icon.textContent = 'check_circle';
                                icon.className = 'material-symbols-rounded text-green-500 text-3xl';
                            }
                            if (text) text.innerHTML = 'Presensi<br/>Selesai';
                            btn.onclick = null;
                            return;
                        }

                        // 2. Valid
                        if (cek.valid) {
                            if (cek.type === 'pulang') {
                                // ORANGE Theme for Pulang
                                btn.className = 'w-24 h-24 shrink-0 bg-orange-50 dark:bg-orange-900/20 rounded-2xl border-2 border-dashed border-orange-300 dark:border-orange-700 flex flex-col items-center justify-center gap-1 cursor-pointer group hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors pulse-btn relative overflow-hidden';
                            } else {
                                // BLUE Theme for Masuk (Default)
                                btn.className = 'w-24 h-24 shrink-0 bg-blue-50 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-blue-200 dark:border-gray-700 flex flex-col items-center justify-center gap-1 cursor-pointer group hover:bg-blue-100 dark:hover:bg-gray-700 transition-colors pulse-btn relative overflow-hidden';
                            }

                            // Check if photo is captured but not sent
                            if (capturedPhotoData) {
                                // REMOVE ICON & TEXT when showing Photo
                                if (icon) icon.style.display = 'none';
                                if (text) text.style.display = 'none';

                                // Ensure preview is visible
                                const preview = document.getElementById('fotoPreview');
                                if (preview) {
                                    preview.src = capturedPhotoData;
                                    preview.classList.remove('hidden');
                                }

                                // Show Overlay for Buttons (OK / Ulang)
                                const overlay = document.getElementById('fotoOverlay');
                                if (overlay) {
                                    overlay.classList.remove('hidden');
                                    overlay.classList.add('flex');
                                    overlay.innerHTML = `
                                        <div class="flex gap-2 w-full px-1 z-50">
                                             <button type="button" onclick="event.stopPropagation(); retakePhoto();" class="flex-1 py-1 rounded-lg bg-white/20 hover:bg-white/30 text-white text-[9px] font-bold backdrop-blur-sm border border-white/30">Ulang</button>
                                             <button type="button" onclick="event.stopPropagation(); confirmPhoto();" class="flex-1 py-1 rounded-lg bg-green-500 hover:bg-green-600 text-white text-[9px] font-bold shadow-lg">OK</button>
                                        </div>
                                    `;
                                }

                                btn.onclick = showZoomModal; // Click photo to Zoom
                                return; // EXIT HERE so we don't reset below
                            }

                            // --- NORMAL STATE (No Photo) ---
                            if (icon) {
                                icon.style.display = 'block';
                                icon.textContent = 'add_a_photo';
                                if (cek.type === 'pulang') {
                                    icon.className = 'material-symbols-rounded text-orange-400 dark:text-orange-500 group-hover:text-orange-500 transition-colors text-3xl';
                                } else {
                                    icon.className = 'material-symbols-rounded text-blue-400 dark:text-gray-500 group-hover:text-primary transition-colors text-3xl';
                                }
                            }

                            if (text) {
                                text.style.display = 'block';
                                if (cek.type === 'masuk') {
                                    text.innerHTML = 'Ambil Foto<br/>Masuk';
                                    text.className = 'text-[8px] font-bold text-blue-400 dark:text-gray-500 group-hover:text-primary transition-colors text-center leading-tight';
                                } else { // Pulang
                                    text.innerHTML = 'Ambil Foto<br/>Pulang';
                                    text.className = 'text-[8px] font-bold text-orange-400 dark:text-orange-500 group-hover:text-orange-500 transition-colors text-center leading-tight';
                                }
                            }

                            // Reset Preview & Overlay (Only if NO photo)
                            const preview = document.getElementById('fotoPreview');
                            if (preview) preview.classList.add('hidden');
                            const overlay = document.getElementById('fotoOverlay');
                            if (overlay) overlay.classList.add('hidden');

                            btn.onclick = ambilFoto; // Set click handler to take photo
                            return;
                        }


                        // 3a. Tunggu (Masuk/Pulang) - Orange
                        if (cek.type === 'tunggu_pulang' || cek.type === 'tunggu_masuk') {
                            btn.className = 'w-24 h-24 shrink-0 bg-orange-50 dark:bg-orange-900/20 rounded-2xl border-2 border-dashed border-orange-300 dark:border-orange-700 flex flex-col items-center justify-center gap-1 cursor-pointer group hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors pulse-btn relative overflow-hidden';
                            if (icon) {
                                icon.textContent = 'schedule'; // Changed from add_a_photo to schedule for waiting
                                icon.className = 'material-symbols-rounded text-orange-400 dark:text-orange-500 group-hover:text-orange-500 transition-colors text-3xl';
                            }
                            if (text) {
                                text.innerHTML = 'Tunggu<br/>Jadwal';
                                text.className = 'text-[8px] font-bold text-orange-400 dark:text-orange-500 group-hover:text-orange-500 transition-colors text-center leading-tight';
                            }
                            btn.onclick = () => {
                                const notifOverlay = document.getElementById('btnNotification');
                                const notifText = document.getElementById('btnNotificationText');
                                if (notifOverlay && notifText) {
                                    notifText.innerHTML = cek.message.replace('<br/>', '\n');
                                    notifOverlay.classList.remove('hidden');
                                    notifOverlay.classList.add('flex');
                                    setTimeout(() => {
                                        notifOverlay.classList.add('hidden');
                                        notifOverlay.classList.remove('flex');
                                    }, 2500);
                                }
                            };
                            return;
                        }

                        // 3b. Di Luar Jadwal - Black/Gray (terlambat masuk, libur, terlambat pulang, etc)
                        btn.className = 'w-24 h-24 shrink-0 bg-gray-100 dark:bg-gray-800/80 rounded-2xl border-2 border-dashed border-gray-400 dark:border-gray-600 flex flex-col items-center justify-center gap-1 cursor-pointer group hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors pulse-btn relative overflow-hidden';
                        if (icon) {
                            icon.textContent = 'block'; // Changed icon for closed state
                            icon.className = 'material-symbols-rounded text-gray-400 dark:text-gray-500 group-hover:text-gray-500 transition-colors text-3xl';
                        }
                        if (text) {
                            text.innerHTML = 'Absen<br/>Tutup';
                            text.className = 'text-[8px] font-bold text-gray-500 dark:text-gray-400 group-hover:text-gray-600 transition-colors text-center leading-tight';
                        }
                        btn.onclick = () => {
                            const notifOverlay = document.getElementById('btnNotification');
                            const notifText = document.getElementById('btnNotificationText');
                            if (notifOverlay && notifText) {
                                // Use dynamic message from logic if available, else default
                                notifText.innerHTML = cek.message ? cek.message.replace('<br/>', '\n') : 'Absen Ditutup\nTunggu Jadwal';

                                notifOverlay.style.backgroundColor = '#374151';
                                notifOverlay.classList.remove('hidden');
                                notifOverlay.classList.add('flex');
                                setTimeout(() => {
                                    notifOverlay.classList.add('hidden');
                                    notifOverlay.classList.remove('flex');
                                    notifOverlay.style.backgroundColor = '';
                                }, 2500);
                            }
                        };
                    }

                    function initUIState() {
                        if (sudahMasuk) {
                            const jamMasukEl = document.getElementById('jamMasuk');
                            if (jamMasukEl) {
                                jamMasukEl.textContent = waktuMasuk;
                                jamMasukEl.classList.remove('text-gray-400', 'dark:text-gray-500');
                                jamMasukEl.classList.add('text-primary');
                            }
                            const presensiText = document.getElementById('presensiText');
                            if (presensiText) {
                                presensiText.textContent = 'Sudah Masuk';
                                presensiText.className = 'text-[9px] font-bold text-blue-500';
                            }
                        }

                        if (sudahPulang) {
                            const jamKeluarEl = document.getElementById('jamKeluar');
                            if (jamKeluarEl) {
                                jamKeluarEl.textContent = waktuPulang;
                                jamKeluarEl.classList.remove('text-gray-400', 'dark:text-gray-500');
                                jamKeluarEl.classList.add('text-green-500');
                            }
                            const presensiText = document.getElementById('presensiText');
                            if (presensiText) {
                                presensiText.textContent = 'Selesai';
                                presensiText.className = 'text-[9px] font-bold text-green-500';
                            }
                        }
                    }

                    // Camera & Modal
                    // Camera & Modal
                    // Camera Preview Modal (Zoom)
                    function showZoomModal() {
                        if (capturedPhotoData && typeof Swal !== 'undefined') {
                            Swal.fire({
                                imageUrl: capturedPhotoData,
                                imageAlt: 'Preview Foto',
                                showConfirmButton: false,
                                showCloseButton: true,
                                background: 'transparent',
                                backdrop: 'rgba(0,0,0,0.9)',
                                customClass: {
                                    popup: 'bg-transparent shadow-none',
                                    image: 'rounded-2xl max-h-[85vh] w-auto object-contain shadow-2xl border-2 border-white/20'
                                }
                            });
                        }
                    }

                    function ambilFoto() {
                        // Strict Radius Validity
                        if (!dalamRadius) {
                            showNotification('Lokasi Anda di luar radius. Mencoba update lokasi...', 'info');
                            // Try one last quick check
                            navigator.geolocation.getCurrentPosition(pos => {
                                userLat = pos.coords.latitude;
                                userLng = pos.coords.longitude;
                                const dist = hitungJarak(userLat, userLng, TPQ_LAT, TPQ_LNG);
                                dalamRadius = dist <= RADIUS_METER;

                                if (dalamRadius) {
                                    openCamera();
                                } else {
                                    showNotification(`Gagal: Lokasi Anda ${Math.round(dist)}m dari titik presensi. Max ${RADIUS_METER}m.`, 'error');
                                }
                            }, err => {
                                showNotification('Gagal mendeteksi lokasi presisi. Pastikan GPS aktif.', 'error');
                            }, { enableHighAccuracy: true, timeout: 5000 });
                            return;
                        }

                        openCamera();
                    }

                    function openCamera() {
                        // Schedule Check
                        const cek = cekJadwalPresensi();
                        if (!cek.valid) {
                            showNotification(cek.message.replace('<br/>', ' '), 'warning');
                            return;
                        }

                        // Trigger Native Input
                        const input = document.getElementById('cameraInput');
                        if (input) input.click();
                    }

                    function closeCameraModal() {
                        // No modal to close in native flow, but keeping function to avoid errors if called elsewhere
                    }

                    let capturedPhotoData = null;
                    // snapPhoto removed (not needed for native)



                    function retakePhoto() {
                        capturedPhotoData = null;
                        document.getElementById('fotoPreview').classList.add('hidden');
                        document.getElementById('fotoOverlay').classList.add('hidden');

                        // Clear input file so onchange triggers even if same file selected
                        const input = document.getElementById('cameraInput');
                        if (input) input.value = '';

                        updateButtonDisplay();
                        ambilFoto(); // Re-open camera native
                    }


                    async function confirmPhoto() {
                        if (!capturedPhotoData) {
                            showNotification('Foto belum diambil!', 'error');
                            return;
                        }

                        const cek = cekJadwalPresensi();
                        const type = (cek.valid && cek.type) ? cek.type : (sudahMasuk ? 'pulang' : 'masuk');
                        const url = type === 'masuk' ? "{{ route('presensi.masuk') }}" : "{{ route('presensi.pulang') }}";

                        // Show Loading on Dashboard Button
                        const icon = document.getElementById('fotoIcon');
                        const text = document.getElementById('fotoBtnText');
                        const btn = document.getElementById('ambilFotoBtn');

                        if (icon) icon.innerHTML = '<span class="material-symbols-rounded animate-spin">sync</span>';
                        if (text) text.innerHTML = 'Proses...';
                        btn.onclick = showZoomModal; // Click photo to Zoom
                        try {
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    foto: capturedPhotoData,
                                    latitude: userLat,
                                    longitude: userLng
                                })
                            });
                            const data = await response.json();
                            if (data.success) {
                                showNotification('Berhasil disimpan!');
                                setTimeout(() => window.location.reload(), 1000);
                            } else {
                                alert('Gagal: ' + (data.message || 'Error'));
                                updateButtonDisplay(); // Reset UI
                            }
                        } catch (e) {
                            console.error(e);
                            alert('Gagal: Terjadi kesalahan jaringan');
                            updateButtonDisplay(); // Reset UI
                        }
                    }


                    // Logger Function
                    function log(msg, isError = false) {
                        console.log(msg);
                        const consoleEl = document.getElementById('debugConsole');
                        if (consoleEl) {
                            // consoleEl.style.display = 'block'; // Hide debug console again
                            const line = document.createElement('div');
                            line.style.color = isError ? '#ff5555' : '#00ff00';
                            line.textContent = `> ${msg}`;
                            consoleEl.appendChild(line);
                            consoleEl.scrollTop = consoleEl.scrollHeight;
                        }
                    }

                    function updateLocation() {
                        const statusText = document.getElementById('radiusText');
                        if (statusText) statusText.textContent = "Mendeteksi...";
                        log("Mulai mendeteksi lokasi...");

                        if (!navigator.geolocation) {
                            log("Geolocation tidak didukung browser ini.", true);
                            if (statusText) {
                                statusText.textContent = "GPS Tidak Didukung";
                                statusText.className = 'text-[9px] font-bold text-red-500';
                            }
                            showNotification('Browser tidak support GPS.');
                            return;
                        }

                        // Directly start geolocation - handle permission errors in callback
                        startGeolocation();

                        function startGeolocation() {
                            // Explicit Timeout for UI feedback
                            const locationTimeout = setTimeout(() => {
                                log("Timeout: Lokasi terlalu lama (15s).", true);
                                const statusText = document.getElementById('radiusText');
                                if (statusText) {
                                    statusText.textContent = "GPS Timeout";
                                    statusText.className = 'text-[9px] font-bold text-orange-500';
                                }
                                showNotification('GPS lambat. Pastikan lokasi aktif dan di luar ruangan.');

                                // Fallback: Try low accuracy GPS
                                log("Mencoba GPS akurasi rendah...");
                                tryLowAccuracyGPS();
                            }, 15000);

                            if (window.watchId) {
                                navigator.geolocation.clearWatch(window.watchId);
                            }

                            // First try: High accuracy GPS
                            window.watchId = navigator.geolocation.watchPosition(handleGPSSuccess, handleGPSError, {
                                enableHighAccuracy: true,
                                timeout: 20000,
                                maximumAge: 30000
                            });

                            function handleGPSSuccess(pos) {
                                clearTimeout(locationTimeout);
                                processPosition(pos);
                            }

                            function handleGPSError(err) {
                                clearTimeout(locationTimeout);
                                console.error('GPS High Accuracy Error:', err);
                                log(`GPS High Error: ${err.code} - ${err.message}`, true);

                                // Try low accuracy as fallback
                                tryLowAccuracyGPS();
                            }

                            function tryLowAccuracyGPS() {
                                navigator.geolocation.getCurrentPosition(
                                    pos => {
                                        log("GPS Low Accuracy berhasil!");
                                        processPosition(pos);
                                    },
                                    err => {
                                        log(`GPS Low Error: ${err.code} - ${err.message}`, true);
                                        const statusText = document.getElementById('radiusText');

                                        let msg = 'Gagal mendapatkan lokasi.';
                                        if (err.code === 1) {
                                            msg = 'Izin GPS Ditolak';
                                            if (statusText) {
                                                statusText.textContent = "GPS Diblokir";
                                                statusText.className = 'text-[9px] font-bold text-red-500';
                                            }
                                        } else if (err.code === 2) {
                                            msg = 'Signal GPS tidak tersedia';
                                            if (statusText) {
                                                statusText.textContent = "No Signal";
                                                statusText.className = 'text-[9px] font-bold text-red-500';
                                            }
                                        } else {
                                            if (statusText) {
                                                statusText.textContent = "GPS Error";
                                                statusText.className = 'text-[9px] font-bold text-red-500';
                                            }
                                        }
                                        showNotification(msg, 'error');
                                    },
                                    { enableHighAccuracy: false, timeout: 10000, maximumAge: 60000 }
                                );
                            }

                            function processPosition(pos) {
                                clearTimeout(locationTimeout);
                                userLat = pos.coords.latitude;
                                userLng = pos.coords.longitude;
                                const accuracy = pos.coords.accuracy; // in meters

                                log(`Lokasi: ${userLat.toFixed(5)}, ${userLng.toFixed(5)} (Akurasi: ${Math.round(accuracy)}m)`);

                                // UPDATE MAP MARKER
                                if (window.dashboardMap) {
                                    if (!window.userMarker) {
                                        // USER REQUEST: BLUE CIRCLE ONLY (Resized)
                                        window.userMarker = L.circleMarker([userLat, userLng], {
                                            radius: 5, // Smaller dot
                                            fillColor: '#3b82f6',
                                            color: '#ffffff',
                                            weight: 2,
                                            opacity: 1,
                                            fillOpacity: 0.9
                                        }).addTo(window.dashboardMap);

                                        window.accuracyCircle = L.circle([userLat, userLng], {
                                            radius: accuracy, color: '#3b82f6', fillColor: '#3b82f6', fillOpacity: 0.15, weight: 0
                                        }).addTo(window.dashboardMap);
                                    } else {
                                        window.userMarker.setLatLng([userLat, userLng]);
                                        if (window.accuracyCircle) {
                                            window.accuracyCircle.setLatLng([userLat, userLng]);
                                            window.accuracyCircle.setRadius(accuracy);
                                        }
                                    }
                                }

                                // Calculate Distance
                                const dist = hitungJarak(userLat, userLng, TPQ_LAT, TPQ_LNG);
                                log(`Jarak: ${Math.round(dist)} meter`);

                                dalamRadius = dist <= RADIUS_METER;
                                const statusText = document.getElementById('radiusText');
                                const dot = document.getElementById('radiusDot');

                                // FORCE UPDATE TEXT - Don't leave it as "Mendeteksi..."
                                if (dalamRadius) {
                                    if (statusText) {
                                        statusText.textContent = `Dalam Radius (${Math.round(dist)}m)`;
                                        statusText.className = 'text-[9px] font-bold text-green-600 dark:text-green-400';
                                    }
                                    if (dot) dot.innerHTML = '<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>';
                                    if (window.radiusCircle) window.radiusCircle.setStyle({ color: '#22c55e', fillColor: '#22c55e' });

                                    // Auto center map ONCE if inside radius
                                    if (!window.hasCentered && window.dashboardMap) {
                                        window.dashboardMap.setView([userLat, userLng], 18);
                                        window.hasCentered = true;
                                    }
                                } else {
                                    if (statusText) {
                                        // Show distance AND accuracy warning if needed
                                        let text = `Luar Radius (${Math.round(dist)}m)`;
                                        if (accuracy > 100) text += ` ±${Math.round(accuracy)}m`;

                                        statusText.textContent = text;
                                        statusText.className = 'text-[9px] font-bold text-red-500';
                                    }
                                    if (dot) dot.innerHTML = '<span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>';
                                    if (window.radiusCircle) window.radiusCircle.setStyle({ color: '#ef4444', fillColor: '#ef4444' });
                                }

                                // Update Coordinates Text
                                const userLocEl = document.getElementById('userLocation');
                                if (userLocEl) userLocEl.textContent = `${userLat.toFixed(5)}, ${userLng.toFixed(5)}`;
                            } // end processPosition
                        } // end startGeolocation
                    } // end updateLocation

                    // Map
                    function initMap() {
                        if (typeof L === 'undefined') {
                            console.error('Leaflet not loaded');
                            return;
                        }

                        const mapContainer = document.getElementById('map');
                        if (!mapContainer) return;

                        // Ensure container has dimension
                        if (mapContainer.clientHeight === 0) {
                            mapContainer.style.height = '150px'; // Force height if 0
                        }

                        // Initialize Map if not already initialized
                        if (window.dashboardMap) {
                            window.dashboardMap.remove(); // Reset if exists
                            window.dashboardMap = null;
                        }

                        // Initialize Map with default center first
                        const map = L.map('map', {
                            zoomControl: false,
                            attributionControl: false,
                            zoomAnimation: true,
                            markerZoomAnimation: true
                        }).setView([TPQ_LAT, TPQ_LNG], 15);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

                        // RED Icon for TPQ (Target)
                        var smallIcon = L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25 * 0.7, 41 * 0.7],
                            iconAnchor: [12 * 0.7, 41 * 0.7],
                            popupAnchor: [1, -34 * 0.7],
                            shadowSize: [41 * 0.7, 41 * 0.7]
                        });

                        L.marker([TPQ_LAT, TPQ_LNG], { icon: smallIcon }).addTo(map).bindPopup('<b>Lokasi TPQ</b><br>Absen di sini');

                        // DRAW RADIUS IMMEDIATELY
                        window.radiusCircle = L.circle([TPQ_LAT, TPQ_LNG], { color: '#ef4444', fillColor: '#ef4444', fillOpacity: 0.2, radius: RADIUS_METER }).addTo(map);

                        window.dashboardMap = map;

                        // CRITICAL: Fix for Map not showing in slider/tabs
                        function fixMapLayout() {
                            if (window.dashboardMap) {
                                window.dashboardMap.invalidateSize();
                                // Only fit bounds if we haven't centered on user yet
                                if (window.radiusCircle && !window.hasCentered) {
                                    window.dashboardMap.fitBounds(window.radiusCircle.getBounds(), { padding: [20, 20], animate: false });
                                }
                            }
                        }

                        // Aggressive Layout Fixes
                        setTimeout(fixMapLayout, 100);
                        setTimeout(fixMapLayout, 500);
                        setTimeout(fixMapLayout, 1000);
                        setTimeout(fixMapLayout, 2000);

                        // Also hook into slider scroll to refresh map when it comes into view
                        const slider = document.getElementById('slideContainer');
                        if (slider) {
                            slider.addEventListener('scroll', () => {
                                clearTimeout(window.mapScrollTimeout);
                                window.mapScrollTimeout = setTimeout(() => {
                                    if (slider.scrollLeft < 50) {
                                        fixMapLayout();
                                    }
                                }, 150);
                            }, { passive: true });
                        }

                        // Re-center logic specific
                        setTimeout(() => {
                            if (map && !window.hasCentered) {
                                map.flyTo([TPQ_LAT, TPQ_LNG], 17, { animate: true, duration: 1.5 });
                            }
                        }, 2500);

                        // FORCE UPDATE ON INIT
                        if (!window.isSecureContext && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
                            showNotification('Peringatan: GPS membutuhkan HTTPS.');
                        }

                        updateLocation();
                    }

                    function zoomIn() {
                        if (window.dashboardMap) window.dashboardMap.zoomIn();
                    }

                    function zoomOut() {
                        if (window.dashboardMap) window.dashboardMap.zoomOut();
                    }

                    function resetMap() {
                        if (window.dashboardMap && window.radiusCircle) {
                            window.dashboardMap.fitBounds(window.radiusCircle.getBounds(), { padding: [20, 20] });
                        }
                    }

                    // Global exposure for debugging
                    window.hitungJarak = hitungJarak;


                    // Carousel & Marquee Logic
                    function initCarousel() {
                        const slider = document.querySelector('.cards-slider');
                        const track = document.querySelector('.cards-track');
                        if (!slider || !track) return;

                        let isDown = false;
                        let startX;
                        let scrollLeft;
                        let velX = 0;
                        let momentumID;

                        slider.addEventListener('mousedown', (e) => {
                            isDown = true;
                            slider.classList.add('active');
                            startX = e.pageX - slider.offsetLeft;
                            scrollLeft = slider.scrollLeft;
                            cancelAnimationFrame(momentumID);
                        });

                        slider.addEventListener('mouseleave', () => {
                            isDown = false;
                            slider.classList.remove('active');
                            beginMomentum();
                        });

                        window.addEventListener('mouseup', () => {
                            if (isDown) {
                                isDown = false;
                                if (slider) slider.classList.remove('active');
                                beginMomentum();
                            }
                        });

                        slider.addEventListener('mousemove', (e) => {
                            if (!isDown) return;
                            e.preventDefault();
                            const x = e.pageX - slider.offsetLeft;
                            const walk = (x - startX) * 2;
                            const newScrollLeft = scrollLeft - walk;

                            velX = newScrollLeft - slider.scrollLeft;
                            slider.scrollLeft = newScrollLeft;
                        });

                        // Touch handling
                        slider.addEventListener('touchstart', (e) => {
                            isDown = true;
                            startX = e.changedTouches[0].pageX - slider.offsetLeft;
                            scrollLeft = slider.scrollLeft;
                            cancelAnimationFrame(momentumID);
                        });

                        slider.addEventListener('touchend', () => {
                            isDown = false;
                            beginMomentum();
                        });

                        slider.addEventListener('touchmove', (e) => {
                            if (!isDown) return;
                            const x = e.changedTouches[0].pageX - slider.offsetLeft;
                            const walk = (x - startX) * 2;
                            const newScrollLeft = scrollLeft - walk;

                            velX = newScrollLeft - slider.scrollLeft;
                            slider.scrollLeft = newScrollLeft;
                        });

                        // Wheel
                        slider.addEventListener('wheel', (e) => {
                            if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) {
                                e.preventDefault();
                                slider.scrollLeft += e.deltaX;
                            }
                        });

                        function beginMomentum() {
                            cancelAnimationFrame(momentumID);
                            function momentumLoop() {
                                slider.scrollLeft += velX;
                                velX *= 0.95;
                                if (Math.abs(velX) > 0.5) {
                                    momentumID = requestAnimationFrame(momentumLoop);
                                }
                            }
                            momentumLoop();
                        }
                    }

                    // Clock Logic
                    function initClock() {
                        function update() {
                            const now = new Date();
                            const hours = String(now.getHours()).padStart(2, '0');
                            const minutes = String(now.getMinutes()).padStart(2, '0');
                            const seconds = String(now.getSeconds()).padStart(2, '0');
                            const timeString = `${hours}:${minutes}:${seconds}`;

                            document.querySelectorAll('#liveClock, #liveClock2').forEach(el => {
                                el.textContent = timeString;
                            });
                        }
                        update();
                        setInterval(update, 1000);
                    }

                    // Weather Logic
                    async function initWeather() {
                        // Default Bogor
                        const lat = -6.595038;
                        const lon = 106.816635;

                        try {
                            const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`);
                            const data = await response.json();

                            if (data.current_weather) {
                                const temp = Math.round(data.current_weather.temperature);
                                const code = data.current_weather.weathercode;
                                const weatherNames = {
                                    0: 'Cerah', 1: 'Cerah Berawan', 2: 'Berawan', 3: 'Mendung',
                                    45: 'Berkabut', 48: 'Berkabut', 51: 'Gerimis', 53: 'Gerimis',
                                    55: 'Gerimis', 61: 'Hujan Ringan', 63: 'Hujan Sedang',
                                    65: 'Hujan Lebat', 80: 'Hujan Ringan', 81: 'Hujan Sedang',
                                    82: 'Hujan Lebat', 95: 'Badai Petir'
                                };
                                const text = `${weatherNames[code] || 'Berawan'}, ${temp}°C`;

                                document.querySelectorAll('#weatherText1, #weatherText2').forEach(el => {
                                    el.textContent = text;
                                });
                            }
                        } catch (e) {
                            console.error('Weather error:', e);
                            document.querySelectorAll('#weatherText1, #weatherText2').forEach(el => {
                                el.textContent = 'Tidak Tersedia';
                            });
                        }
                    }

                    function initMarquees() {
                        const marquees = document.querySelectorAll('.marquee-container');
                        marquees.forEach(container => {
                            const content = container.querySelector('.marquee-content');
                            if (!content) return;

                            // Reset animation
                            content.style.animation = 'none';
                            content.offsetHeight; /* trigger reflow */

                            // Simple cloning for loop: A -> A+A
                            if (content.children.length > 0 && content.scrollWidth < container.offsetWidth * 3) {
                                const originalContent = content.innerHTML;
                                content.innerHTML = originalContent + originalContent;
                            }

                            content.style.display = 'flex';
                            // Apply animation
                            content.style.animation = 'marquee 30s linear infinite';

                            // Pause on hover
                            content.addEventListener('mouseenter', () => {
                                content.style.animationPlayState = 'paused';
                            });
                            content.addEventListener('mouseleave', () => {
                                content.style.animationPlayState = 'running';
                            });
                        });
                    }

                    // CSS Injection for Marquee
                    const style = document.createElement('style');
                    style.innerHTML = `
                @keyframes marquee {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .marquee-content {
                    width: max-content;
                }
                .cards-slider {
                    overflow-x: auto;
                    cursor: grab;
                    scrollbar-width: none; /* Firefox */
                    -ms-overflow-style: none;  /* IE 10+ */
                }
                .cards-slider::-webkit-scrollbar {
                    display: none;  /* Chrome/Safari */
                }
                .cards-slider.active {
                    cursor: grabbing;
                    cursor: -webkit-grabbing;
                }
            `;
                    document.head.appendChild(style);


                    document.addEventListener('DOMContentLoaded', () => {
                        try {
                            initMap();
                            initUIState();
                            updateButtonDisplay();
                            initCarousel();
                            initMarquees();
                            initClock(); // NEW
                            initWeather(); // NEW
                            setInterval(updateButtonDisplay, 30000); // 30s

                            // Camera Input Handler for Native Camera
                            const cameraInput = document.getElementById('cameraInput');
                            if (cameraInput) {
                                cameraInput.addEventListener('change', function (e) {
                                    if (e.target.files && e.target.files[0]) {
                                        const file = e.target.files[0];
                                        const reader = new FileReader();

                                        reader.onload = function (event) {
                                            capturedPhotoData = event.target.result;

                                            // Update preview on dashboard
                                            const preview = document.getElementById('fotoPreview');
                                            if (preview) {
                                                preview.src = capturedPhotoData;
                                                preview.classList.remove('hidden');
                                            }

                                            // Hide icon and text, show overlay with buttons
                                            updateButtonDisplay();
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                });
                            }
                        } catch (e) {
                            console.error('Unified Dashboard Error:', e);
                            // Optional: showNotification('Gagal memuat beberapa fitur dashboard. Silahkan refresh.');
                        }
                    });
                    // Swipe Slider Logic
                    const TOTAL_SLIDES = 3;
                    let currentSlide = 0;
                    let isProgrammaticScroll = false; // Flag to prevent scroll event interference

                    function goToSlide(index) {
                        const container = document.getElementById('slideContainer');
                        if (!container) return;

                        // Wrap around for infinite loop
                        if (index < 0) index = TOTAL_SLIDES - 1;
                        if (index >= TOTAL_SLIDES) index = 0;

                        currentSlide = index;
                        isProgrammaticScroll = true;

                        // Calculate exact scroll position
                        const slideWidth = container.offsetWidth;
                        const targetScroll = index * slideWidth;

                        // Use scrollTo for more reliable navigation
                        container.scrollTo({
                            left: targetScroll,
                            behavior: 'smooth'
                        });

                        updateDots(index);

                        // Reset flag after animation completes
                        setTimeout(() => {
                            isProgrammaticScroll = false;
                        }, 400);
                    }

                    // Navigate to next/previous slide (for infinite loop)
                    function nextSlide() {
                        goToSlide(currentSlide + 1);
                    }

                    function prevSlide() {
                        goToSlide(currentSlide - 1);
                    }

                    function updateDots(activeIndex) {
                        const dots = [document.getElementById('dot0'), document.getElementById('dot1'), document.getElementById('dot2')];
                        dots.forEach((dot, i) => {
                            if (dot) {
                                if (i === activeIndex) {
                                    dot.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                                    dot.classList.add('bg-primary');
                                } else {
                                    dot.classList.remove('bg-primary');
                                    dot.classList.add('bg-gray-300', 'dark:bg-gray-600');
                                }
                            }
                        });

                        // Toggle Swipe Up Hint Visibility
                        const hint = document.getElementById('swipeUpHint');
                        if (hint) {
                            // Show hint ONLY if we are on the Menu slides (index 1 or 2)
                            if (activeIndex > 0) {
                                hint.style.opacity = '1';
                            } else {
                                hint.style.opacity = '0';
                            }
                        }
                    }

                    // Detect scroll position to update dots
                    document.addEventListener('DOMContentLoaded', () => {
                        const container = document.getElementById('slideContainer');
                        if (container) {
                            container.addEventListener('scroll', () => {
                                // Skip if this is a programmatic scroll
                                if (isProgrammaticScroll) return;

                                const scrollPos = container.scrollLeft;
                                const slideWidth = container.offsetWidth;
                                const activeIndex = Math.round(scrollPos / slideWidth);
                                currentSlide = activeIndex; // Sync currentSlide for infinite loop
                                updateDots(activeIndex);
                            });
                        }

                        // Menu Slider Scroll Logic
                        const menuContainer = document.getElementById('menuSlider');
                        if (menuContainer) {
                            menuContainer.addEventListener('scroll', () => {
                                const scrollPos = menuContainer.scrollLeft;
                                const slideWidth = menuContainer.offsetWidth;
                                const activeIndex = Math.round(scrollPos / slideWidth);

                                // Update Menu Dots
                                const dot1 = document.getElementById('menuDot1');
                                const dot2 = document.getElementById('menuDot2');

                                if (activeIndex === 0) {
                                    if (dot1) { dot1.classList.remove('bg-gray-300', 'dark:bg-gray-600'); dot1.classList.add('bg-primary'); }
                                    if (dot2) { dot2.classList.remove('bg-primary'); dot2.classList.add('bg-gray-300', 'dark:bg-gray-600'); }
                                } else {
                                    if (dot1) { dot1.classList.remove('bg-primary'); dot1.classList.add('bg-gray-300', 'dark:bg-gray-600'); }
                                    if (dot2) { dot2.classList.remove('bg-gray-300', 'dark:bg-gray-600'); dot2.classList.add('bg-primary'); }
                                }
                            });
                        }

                        // Setup swipe detection on map wrapper (entire card area)
                        const mapWrapper = document.getElementById('mapWrapper');
                        const mapEl = document.getElementById('map');
                        const swipeOverlay = document.getElementById('swipeOverlay');

                        // Function to setup swipe handlers
                        function setupSwipeHandlers(element) {
                            const container = document.getElementById('slideContainer');
                            if (!element || !container) return;

                            let startX = 0;
                            let startY = 0;
                            let isSwiping = false;
                            let startTime = 0;

                            element.addEventListener('touchstart', (e) => {
                                // Ignore multi-touch (e.g. pinch to zoom)
                                if (e.touches.length > 1) return;

                                startX = e.touches[0].clientX;
                                startY = e.touches[0].clientY;
                                startTime = Date.now();
                                isSwiping = false;
                            }, { passive: true });

                            element.addEventListener('touchmove', (e) => {
                                if (!startX || !startY) return;

                                const currentX = e.touches[0].clientX;
                                const currentY = e.touches[0].clientY;
                                const diffX = currentX - startX;
                                const diffY = Math.abs(currentY - startY);

                                // Strict horizontal check: Horizontal diff must be significant AND dominant
                                // Increased factor to 2.0 to prevent accidental swipes when scrolling vertically
                                if (Math.abs(diffX) > 15 && Math.abs(diffX) > diffY * 2) {
                                    isSwiping = true;

                                    // Disable map dragging immediately if this is the map
                                    if (window.dashboardMap && (element.id === 'map' || element.id === 'mapWrapper')) {
                                        window.dashboardMap.dragging.disable();
                                    }

                                    // Enable swipe overlay to capture events and prevent map interaction
                                    if (swipeOverlay) {
                                        swipeOverlay.style.pointerEvents = 'auto';
                                    }
                                }
                            }, { passive: true });

                            element.addEventListener('touchend', (e) => {
                                if (isSwiping) {
                                    const endX = e.changedTouches[0].clientX;
                                    const diffX = endX - startX;
                                    const elapsed = Date.now() - startTime;

                                    // Calculate velocity for quick flicks
                                    const velocity = Math.abs(diffX) / elapsed;

                                    // Lower threshold for quick swipes (velocity > 0.3), normal threshold for slow swipes
                                    const threshold = velocity > 0.3 ? 20 : 35;

                                    // Determine swipe direction and navigate (infinite loop)
                                    if (diffX < -threshold) {
                                        // Swipe left -> go to next slide
                                        nextSlide();
                                    } else if (diffX > threshold) {
                                        // Swipe right -> go to previous slide
                                        prevSlide();
                                    }
                                }

                                // Re-enable map dragging
                                setTimeout(() => {
                                    if (window.dashboardMap) {
                                        window.dashboardMap.dragging.enable();
                                    }
                                    if (swipeOverlay) {
                                        swipeOverlay.style.pointerEvents = 'none';
                                    }
                                }, 100);

                                startX = 0;
                                startY = 0;
                                isSwiping = false;
                            }, { passive: true });
                        }

                        // Apply swipe handlers ONLY to mapWrapper (to handle map vs swipe conflict)
                        // For other slides (Menus), we rely on native CSS scroll snapping which is smoother
                        setupSwipeHandlers(mapWrapper);

                        // Also apply to map elements specifically
                        const mapObj = document.getElementById('map');
                        if (mapObj) setupSwipeHandlers(mapObj);
                    });

                    // Vertical Swipe for Main Card Logic
                    let isCardExpanded = false;
                    const mainCard = document.getElementById('mainCard');
                    const presensiView = document.getElementById('presensiView');
                    const menuView = document.getElementById('menuView');

                    function toggleCardView(forceState = null) {
                        if (!mainCard || !presensiView || !menuView) return;
                        const whiteContainer = document.getElementById('whiteContainer');

                        const shouldExpand = forceState !== null ? forceState : !isCardExpanded;

                        if (shouldExpand) {
                            isCardExpanded = true;
                            // Expand: Show Menu, Hide Presensi with animation
                            presensiView.style.opacity = '0';

                            // NO Fullscreen expansion for whiteContainer as per request
                            // We keep the card size native/constrained

                            setTimeout(() => {
                                presensiView.classList.add('hidden');
                                menuView.classList.remove('hidden');
                                menuView.classList.remove('mt-2');

                                // ANIMATION UPDATES:
                                requestAnimationFrame(() => {
                                    menuView.style.opacity = '1';
                                });
                            }, 200);
                        } else {
                            // Collapse
                            menuView.style.opacity = '0';

                            // Reset container if it was modified (not anymore)

                            setTimeout(() => {
                                menuView.classList.add('hidden');
                                presensiView.classList.remove('hidden');

                                requestAnimationFrame(() => {
                                    presensiView.style.opacity = '1';
                                });
                            }, 200);
                        }
                    }

                    // --- NATIVE CAMERA IMPLEMENTATION ---
                    function handleCameraCapture(event) {
                        const file = event.target.files[0];
                        if (file) {
                            // Validate file type?
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                capturedPhotoData = e.target.result;

                                // Show Preview immediately
                                const dashboardPreview = document.getElementById('fotoPreview');
                                if (dashboardPreview) {
                                    dashboardPreview.src = capturedPhotoData;
                                    dashboardPreview.classList.remove('hidden');
                                }

                                // Update UI to show Confirm/Retry buttons
                                updateButtonDisplay();
                            };
                            reader.readAsDataURL(file);
                        }
                    }




                    // --- ZOOM PREVIEW IMPLEMENTATION ---
                    function showZoomModal() {
                        if (!capturedPhotoData) return;

                        let zoomModal = document.getElementById('zoomModal');
                        if (!zoomModal) {
                            zoomModal = document.createElement('div');
                            zoomModal.id = 'zoomModal';
                            zoomModal.className = 'fixed inset-0 z-[60] bg-black/95 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity duration-300 opacity-0';
                            zoomModal.onclick = closeZoomModal;
                            zoomModal.innerHTML = `
                                <div class="relative max-w-full max-h-full transition-transform duration-300 scale-90" id="zoomContent">
                                    <img id="zoomImage" src="" class="max-w-[90vw] max-h-[85vh] object-contain rounded-xl shadow-2xl border-2 border-white/20">
                                    <button onclick="closeZoomModal()" class="absolute -top-12 right-0 md:-right-12 text-white/70 hover:text-white p-2">
                                        <span class="material-symbols-rounded text-3xl">close</span>
                                    </button>
                                    <div class="absolute -bottom-16 left-1/2 -translate-x-1/2 flex gap-4 w-full justify-center">
                                         <button onclick="event.stopPropagation(); retakePhoto(); closeZoomModal();" class="px-6 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold backdrop-blur-sm border border-white/30 flex items-center gap-2">
                                            <span class="material-symbols-rounded">refresh</span> Ulangi
                                         </button>
                                         <button onclick="event.stopPropagation(); confirmPhoto(); closeZoomModal();" class="px-6 py-2 rounded-xl bg-green-500 hover:bg-green-600 text-white font-semibold shadow-lg flex items-center gap-2">
                                            <span class="material-symbols-rounded">check</span> Kirim
                                         </button>
                                    </div>
                                </div>
                            `;
                            document.body.appendChild(zoomModal);
                        }

                        const img = document.getElementById('zoomImage');
                        if (img) img.src = capturedPhotoData;

                        zoomModal.classList.remove('hidden');
                        // Animation frame for transition
                        requestAnimationFrame(() => {
                            zoomModal.classList.remove('opacity-0');
                            const content = document.getElementById('zoomContent');
                            if (content) content.classList.remove('scale-90');
                        });
                    }

                    function closeZoomModal() {
                        const zoomModal = document.getElementById('zoomModal');
                        if (zoomModal) {
                            zoomModal.classList.add('opacity-0');
                            const content = document.getElementById('zoomContent');
                            if (content) content.classList.add('scale-90');

                            setTimeout(() => {
                                zoomModal.remove(); // Remove to clean up
                            }, 300);
                        }
                    }

                    // Setup Vertical Swipe on Main Card
                    if (mainCard) {
                        let cardStartY = 0;
                        let cardStartX = 0;

                        mainCard.addEventListener('touchstart', (e) => {
                            cardStartY = e.touches[0].clientY;
                            cardStartX = e.touches[0].clientX;
                        }, { passive: true });

                        mainCard.addEventListener('touchend', (e) => {
                            const endY = e.changedTouches[0].clientY;
                            const endX = e.changedTouches[0].clientX;
                            const diffY = endY - cardStartY;
                            const diffX = endX - cardStartX;

                            // Ensure vertical swipe is dominant (vert > horiz & abs(vert) > 30px)
                            if (Math.abs(diffY) > Math.abs(diffX) && Math.abs(diffY) > 30) {
                                // Swipe Up -> Expand (from any slide)
                                if (diffY < 0 && !isCardExpanded) {
                                    toggleCardView(true);
                                }
                                // Swipe Down -> Collapse (if expanded)
                                else if (diffY > 0 && isCardExpanded) {
                                    toggleCardView(false);
                                }
                            }
                        }, { passive: true });
                    }

                    // Make functions globally available
                    window.toggleCardView = toggleCardView;
                    window.goToSlide = goToSlide;
                </script>
                <div id="debugConsole">DEBUG CONSOLE STARTED...<br></div>
</body>

</html>
