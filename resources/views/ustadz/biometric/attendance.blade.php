<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Scanner QR Absen Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;family=JetBrains+Mono&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec37",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102213",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"],
                        "mono": ["JetBrains Mono"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "1rem",
                        "xl": "1.5rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .camera-overlay {
            background: rgba(0, 0, 0, 0.6);
            mask: radial-gradient(circle, transparent 150px, black 151px);
            -webkit-mask: radial-gradient(circle, transparent 150px, black 151px);
        }

        /* Custom mask for square cutout with rounded corners */
        .scanner-mask {
            mask-image: linear-gradient(to bottom, black, black), linear-gradient(to bottom, black, black);
            mask-clip: content-box, padding-box;
            mask-composite: exclude;
            -webkit-mask-composite: destination-out;
        }

        @keyframes scan {
            0% {
                top: 0%;
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                top: 100%;
                opacity: 0;
            }
        }

        .laser-line {
            animation: scan 2s linear infinite;
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }

        /* Essential for Camera Visibility */
        #reader video {
            object-fit: cover;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
        }

        #reader canvas {
            opacity: 0;
            position: absolute;
            pointer-events: none;
        }
    </style>
</head>

<body
    class="font-display bg-background-light dark:bg-background-dark min-h-screen overflow-hidden text-white selection:bg-primary/30">
    <!-- Camera Background (Replacing Image with #reader) -->
    <div id="reader" class="fixed inset-0 z-0 bg-transparent"></div>

    <!-- UI Layer -->
    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- TopAppBar -->
        <div class="flex items-center bg-transparent p-4 pb-2 justify-between">
            <a href="{{ route('ustadz.dashboard') }}"
                class="text-white flex size-12 shrink-0 items-center justify-center cursor-pointer hover:bg-white/10 rounded-full transition-colors">
                <span class="material-symbols-outlined">arrow_back_ios_new</span>
            </a>
            <div class="flex-1 text-center">
                <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">Scan Absen Santri</h2>
                <p class="text-white/60 text-xs font-medium uppercase tracking-widest">TPQ Daarul Gusmik</p>
            </div>
            <div class="flex w-12 items-center justify-end">
                <!-- Optional Flash Button -->
                <!-- <button class="flex size-12 cursor-pointer items-center justify-center overflow-hidden rounded-full hover:bg-white/10 text-white transition-colors">
                    <span class="material-symbols-outlined">flashlight_on</span>
                </button> -->
            </div>
        </div>

        <!-- Headline & Body Text -->
        <div class="flex flex-col items-center pt-8 px-6 text-center">
            <h3 class="text-white tracking-light text-2xl font-bold leading-tight">Arahkan kamera ke QR Code</h3>
            <p class="text-white/70 text-base font-normal leading-normal mt-2">Pastikan QR Code berada di dalam kotak
                pemindaian</p>
        </div>

        <!-- Scanner Viewport Container -->
        <div class="flex-1 relative flex items-center justify-center py-10 pointer-events-none">

            <!-- 4-Div Physical Overlay (Robust Transparency) -->
            <!-- Top -->
            <div class="absolute top-0 left-0 right-0 h-[calc(50%-8rem)] sm:h-[calc(50%-10rem)] bg-[#102213]/90 z-20">
            </div>
            <!-- Bottom -->
            <div
                class="absolute bottom-0 left-0 right-0 h-[calc(50%-8rem)] sm:h-[calc(50%-10rem)] bg-[#102213]/90 z-20">
            </div>
            <!-- Left -->
            <div
                class="absolute top-[calc(50%-8rem)] sm:top-[calc(50%-10rem)] bottom-[calc(50%-8rem)] sm:bottom-[calc(50%-10rem)] left-0 w-[calc(50%-8rem)] sm:w-[calc(50%-10rem)] bg-[#102213]/90 z-20">
            </div>
            <!-- Right -->
            <div
                class="absolute top-[calc(50%-8rem)] sm:top-[calc(50%-10rem)] bottom-[calc(50%-8rem)] sm:bottom-[calc(50%-10rem)] right-0 w-[calc(50%-8rem)] sm:w-[calc(50%-10rem)] bg-[#102213]/90 z-20">
            </div>

            <!-- Scanner Square Container (Visuals Only - NO SHADOW OR BG) -->
            <div class="relative w-64 h-64 sm:w-80 sm:h-80 bg-transparent rounded-xl z-30">

                <!-- Corner Brackets (WhatsApp Style) -->
                <!-- Top Left -->
                <div
                    class="absolute -top-1 -left-1 size-10 border-t-4 border-l-4 border-primary rounded-tl-lg shadow-sm">
                </div>
                <!-- Top Right -->
                <div
                    class="absolute -top-1 -right-1 size-10 border-t-4 border-r-4 border-primary rounded-tr-lg shadow-sm">
                </div>
                <!-- Bottom Left -->
                <div
                    class="absolute -bottom-1 -left-1 size-10 border-b-4 border-l-4 border-primary rounded-bl-lg shadow-sm">
                </div>
                <!-- Bottom Right -->
                <div
                    class="absolute -bottom-1 -right-1 size-10 border-b-4 border-r-4 border-primary rounded-br-lg shadow-sm">
                </div>
                <!-- Laser Line Animation -->
                <div
                    class="laser-line absolute left-0 right-0 h-0.5 bg-primary shadow-[0_0_15px_rgba(19,236,55,0.8)] z-20">
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Right -->
    <div class="absolute -bottom-1 -right-1 size-10 border-b-4 border-r-4 border-primary rounded-br-lg z-30">
    </div>
    <!-- Laser Line Animation -->
    <div class="laser-line absolute left-0 right-0 h-0.5 bg-primary shadow-[0_0_15px_rgba(19,236,55,0.8)] z-20">
    </div>
    </div>
    </div>

    <!-- Bottom Controls & Stats -->
    <div class="px-6 pb-12 flex flex-col items-center gap-6 z-30">
        <!-- Status Stats -->
        <div class="w-full max-w-sm">
            <div
                class="flex flex-col gap-2 rounded-xl p-4 bg-background-dark/80 backdrop-blur-md border border-white/10">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-white/50 text-xs font-bold uppercase tracking-widest">Scanner Status</span>
                    <div class="size-2 bg-primary rounded-full animate-pulse shadow-[0_0_8px_rgba(19,236,55,1)]">
                    </div>
                </div>
                <!-- Status Text ID Mapped -->
                <p class="text-primary font-mono text-xl font-bold leading-tight text-center py-2" id="statusText">
                    Mendeteksi Kamera...</p>
            </div>
        </div>

        <!-- CameraControl (Decorative for now, could act as manual trigger or flash) -->
        <!-- <div class="flex items-center justify-center gap-8 w-full">
                <button
                    class="flex shrink-0 items-center justify-center rounded-full size-12 bg-white/10 backdrop-blur-md text-white border border-white/5 hover:bg-white/20 transition-all">
                    <span class="material-symbols-outlined">image</span>
                </button>
                <button
                    class="flex shrink-0 items-center justify-center rounded-full size-20 bg-primary text-background-dark shadow-[0_0_30px_rgba(19,236,55,0.3)] hover:scale-105 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-4xl"
                        style="font-variation-settings: 'FILL' 1">qr_code_scanner</span>
                </button>
                <button
                    class="flex shrink-0 items-center justify-center rounded-full size-12 bg-white/10 backdrop-blur-md text-white border border-white/5 hover:bg-white/20 transition-all">
                    <span class="material-symbols-outlined">sync</span>
                </button>
            </div> -->

        <!-- Institution Footer -->
        <div class="mt-2">
            <p class="text-white/40 text-xs font-medium tracking-tight">Daarul Gusmik Al-Hufadz © 2024</p>
        </div>
    </div>
    </div>

    <!-- HTML5-QRcode Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let html5QrCode;

        document.addEventListener('DOMContentLoaded', () => {
            startScanner();
        });

        function startScanner() {
            const statusEl = document.getElementById('statusText');

            html5QrCode = new Html5Qrcode("reader");

            const config = {
                fps: 15, // Higher FPS for smoother scanning
                showTorchButtonIfSupported: true,
                // qrbox is typically handled by visual overlay, keeping it undefined allows full frame scanning logic
                // but library might need it to focus scan area.
                // Since we rely on center visual, let's scan full frame but guide user to center.
            };

            html5QrCode.start({
                facingMode: "environment"
            },
                config,
                onScanSuccess,
                onScanFailure
            ).then(() => {
                statusEl.innerText = "Kamera Aktif";
                statusEl.classList.add("text-primary"); // User's green
            }).catch(err => {
                console.error(err);
                statusEl.innerText = "Gagal Akses: " + err;
                statusEl.classList.add("text-red-500");
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

            if (html5QrCode) html5QrCode.pause();

            const statusEl = document.getElementById('statusText');
            statusEl.innerText = "Memproses: " + decodedText;

            submitAttendance(decodedText);
        }

        function onScanFailure(error) {
            // console.warn(`Code scan error = ${error}`);
        }


        async function submitAttendance(santriId) {
            try {
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
                        background: '#102213', // Match user theme
                        color: '#fff',
                        confirmButtonColor: '#13ec37',
                        showCancelButton: true,
                        confirmButtonText: 'Input Hafalan',
                        cancelButtonText: 'Scan Lagi',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('ustadz.hafalan.input') }}?santri_id=" + data
                                .santri_user_id;
                        } else {
                            if (html5QrCode) html5QrCode.resume();
                            document.getElementById('statusText').innerText = "Siap Scan...";
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal',
                        text: data.message,
                        icon: 'error',
                        background: '#102213',
                        color: '#fff',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Coba Lagi'
                    }).then(() => {
                        if (html5QrCode) html5QrCode.resume();
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    title: 'Error Sistem',
                    text: 'Terjadi kesalahan jaringan.',
                    icon: 'error',
                    background: '#102213',
                    color: '#fff'
                }).then(() => {
                    if (html5QrCode) html5QrCode.resume();
                });
            }
        }
    </script>
</body>

</html>
