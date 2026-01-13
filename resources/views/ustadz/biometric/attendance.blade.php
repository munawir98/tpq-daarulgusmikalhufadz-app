<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Absen Santri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 (Optional for better search) -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .select2-container .select2-selection--single {
            height: 50px;
            border-radius: 0.75rem;
            /* rounded-xl */
            border-color: #e5e7eb;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 12px;
            right: 12px;
        }

        /* Minimal override to ensure video fills container */
        #reader video {
            object-fit: cover !important;
            width: 100% !important;
            height: 100dvh !important;
            /* Force Dynamic Viewport Height */
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            z-index: 0 !important;
            border-radius: 0 !important;
            display: block !important;
        }

        /* Force library wrapper to match screen size */
        #reader div {
            width: 100% !important;
            height: 100dvh !important;
            /* Force Dynamic Viewport Height */
            overflow: hidden !important;
        }

        /* Hide Canvas visually (it often overlays the video with black) */
        #reader canvas {
            opacity: 0 !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            pointer-events: none !important;
        }
    </style>
</head>

<body class="bg-gray-900 min-h-screen overflow-hidden m-0 p-0">

    <!-- Scanner Container (Full Screen) -->
    <div id="reader" class="w-full h-full absolute inset-0 bg-transparent z-0"></div>

    <!-- UI Overlay -->
    <div class="absolute inset-0 z-50 pointer-events-none flex flex-col items-center justify-center">



        <!-- Scanner Title/Instruction -->
        <div class="absolute top-8 left-0 right-0 text-center pointer-events-none z-50">
            <h2 class="text-white font-bold text-lg drop-shadow-md">Scan Absen Santri</h2>
            <p class="text-white/80 text-xs drop-shadow-md">Arahkan kamera ke QR Code</p>
        </div>




        <!-- 4-Div Physical Overlay -->
        <!-- Top -->
        <div
            class="absolute top-0 left-0 right-0 h-[calc(50%-140px)] sm:h-[calc(50%-160px)] bg-black/80 pointer-events-none z-40">
        </div>
        <!-- Bottom -->
        <div class="absolute bottom-0 left-0 right-0 h-[calc(50%-140px)] sm:h-[calc(50%-160px)] bg-black/80 pointer-events-none z-40"
            style="background-color: rgba(0, 0, 0, 0.8) !important;">
        </div>
        <!-- Left -->
        <div
            class="absolute top-[calc(50%-140px)] sm:top-[calc(50%-160px)] left-0 w-[calc(50vw-140px)] sm:w-[calc(50vw-160px)] h-[280px] sm:h-[320px] bg-black/80 pointer-events-none z-40">
        </div>
        <!-- Right -->
        <div
            class="absolute top-[calc(50%-140px)] sm:top-[calc(50%-160px)] right-0 w-[calc(50vw-140px)] sm:w-[calc(50vw-160px)] h-[280px] sm:h-[320px] bg-black/80 pointer-events-none z-40">
        </div>

        <!-- Scan Frame (The "Visuals") -->
        <div class="relative w-[280px] h-[280px] sm:w-[320px] sm:h-[320px] box-content z-30">

            <!-- Rounded Corner Masks (To make the hole look rounded) -->
            <!-- Top Left -->
            <div
                class="absolute top-0 left-0 w-6 h-6 z-40 bg-[radial-gradient(circle_at_100%_100%,transparent_10px,rgba(0,0,0,0.8)_11px)]">
            </div>
            <!-- Top Right -->
            <div
                class="absolute top-0 right-0 w-6 h-6 z-40 bg-[radial-gradient(circle_at_0%_100%,transparent_10px,rgba(0,0,0,0.8)_11px)]">
            </div>
            <!-- Bottom Left -->
            <div
                class="absolute bottom-0 left-0 w-6 h-6 z-40 bg-[radial-gradient(circle_at_100%_0%,transparent_10px,rgba(0,0,0,0.8)_11px)]">
            </div>
            <!-- Bottom Right -->
            <div
                class="absolute bottom-0 right-0 w-6 h-6 z-40 bg-[radial-gradient(circle_at_0%_0%,transparent_10px,rgba(0,0,0,0.8)_11px)]">
            </div>

            <!-- Corner Indicators (WA Style) -->
            <!-- Top Left -->
            <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-white rounded-tl-lg drop-shadow-sm">
            </div>
            <!-- Top Right -->
            <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-white rounded-tr-lg drop-shadow-sm">
            </div>
            <!-- Bottom Left -->
            <div
                class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-white rounded-bl-lg drop-shadow-sm">
            </div>
            <!-- Bottom Right -->
            <div
                class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-white rounded-br-lg drop-shadow-sm">
            </div>

            <!-- Animated Red Laser -->
            <div
                class="absolute top-0 left-4 right-4 h-0.5 bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)] animate-scan-laser">
            </div>
        </div>

        <!-- CLI Style -->
        <style>
            @keyframes scan-laser {
                0% {
                    top: 10px;
                    opacity: 0;
                }

                10% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.8;
                }

                90% {
                    opacity: 1;
                }

                100% {
                    top: calc(100% - 10px);
                    opacity: 0;
                }
            }

            .animate-scan-laser {
                animation: scan-laser 2s ease-in-out infinite;
            }
        </style>

        <!-- Bottom Status -->
        <div class="absolute bottom-12 text-center w-full px-6 z-40">
            <div class="bg-black/40 backdrop-blur-md px-6 py-3 rounded-full inline-block border border-white/10">
                <p class="text-white text-xs font-mono" id="statusText">Mendeteksi Kamera... (v2.3)</p>
            </div>
        </div>

    </div>



    <!-- HTML5-QRcode Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <!-- AGGRESSIVE VIDEO ENFORCER SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Check every 500ms and FORCE the video to be proper size
            setInterval(() => {
                const videoElement = document.querySelector('#reader video');
                if (videoElement) {
                    // Force CSS styles directly on the element to override library inline styles
                    videoElement.style.width = '100%';
                    videoElement.style.height = '100dvh'; // Use dynamic viewport height
                    videoElement.style.objectFit = 'cover';
                    videoElement.style.position = 'absolute';
                    videoElement.style.top = '0';
                    videoElement.style.left = '0';
                    videoElement.style.zIndex = '0';
                }
            }, 500);
        });
    </script>

    <script>
        let html5QrCode;

        document.addEventListener('DOMContentLoaded', () => {
            startScanner();
        });

        function startScanner() {
            const statusEl = document.getElementById('statusText');

            html5QrCode = new Html5Qrcode("reader");

            // Config: Full FPS for smoothness, auto-select environment camera
            const config = {
                fps: 15,
                // qrbox: { width: 250, height: 250 }, // Removed to prevent double overlay
                // aspectRatio: 1.0, // Removed to allow full screen
                showTorchButtonIfSupported: true
            };

            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanFailure
            ).then(() => {
                statusEl.innerText = "Kamera Aktif";
                statusEl.classList.add("text-green-400");
            }).catch(err => {
                console.error(err);
                statusEl.innerText = "Gagal Akses Kamera: " + err;
                statusEl.classList.add("text-red-400");
                Swal.fire({
                    icon: 'error',
                    title: 'Error Kamera',
                    text: 'Pastikan izin kamera diberikan.',
                    confirmButtonText: 'Kembali',
                }).then(() => {
                    window.location.href = "{{ route('ustadz.dashboard') }}";
                });
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);

            // Play Beep Sound (Optional)
            // const audio = new Audio('/sounds/beep.mp3'); audio.play().catch(e=>{});

            // Pause Scanner
            if (html5QrCode) html5QrCode.pause();

            const statusEl = document.getElementById('statusText');
            statusEl.innerText = "Memproses: " + decodedText;

            submitAttendance(decodedText);
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // console.warn(`Code scan error = ${error}`);
        }


        async function submitAttendance(santriId) {
            try {
                // Show floating/sweetalert loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'NIS: ' + santriId,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch("{{ route('ustadz.biometric.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        santri_id: santriId,
                        latitude: null, // Optional
                        longitude: null,
                        type: 'masuk',
                        credential_id: 'QR-SCAN'
                    })
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Input Hafalan',
                        cancelButtonText: 'Scan Lagi',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('ustadz.hafalan.input') }}?santri_id=" + data.santri_user_id;
                        } else {
                            // Resume Scanner
                            if (html5QrCode) html5QrCode.resume();
                            document.getElementById('statusText').innerText = "Siap Scan...";
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Coba Lagi'
                    }).then(() => {
                        if (html5QrCode) html5QrCode.resume();
                    });
                }
            }
            catch (err) {
                console.error(err);
                Swal.fire('Error Sistem', 'Terjadi kesalahan jaringan.', 'error').then(() => {
                    if (html5QrCode) html5QrCode.resume();
                });
            }
        }
    </script>
</body>

</html>
