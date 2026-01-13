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
    </style>
</head>

<body class="bg-black min-h-screen overflow-hidden m-0 p-0">

    <!-- Scanner Container (Full Screen) -->
    <div id="reader" class="w-full h-full absolute inset-0 bg-black"></div>

    <!-- UI Overlay -->
    <div class="absolute inset-0 z-10 pointer-events-none flex flex-col items-center justify-center">



        <!-- Scanner Title/Instruction -->
        <div class="absolute top-8 left-0 right-0 text-center pointer-events-none z-40">
            <h2 class="text-white font-bold text-lg drop-shadow-md">Scan Absen Santri</h2>
            <p class="text-white/80 text-xs drop-shadow-md">Arahkan kamera ke QR Code</p>
        </div>



        <!-- Bottom Status -->
        <div class="absolute bottom-12 text-center w-full px-6 z-40">
            <div class="bg-black/40 backdrop-blur-md px-6 py-3 rounded-full inline-block border border-white/10">
                <p class="text-white text-xs font-mono" id="statusText">Mendeteksi Kamera...</p>
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

            // Config: Full FPS for smoothness, auto-select environment camera
            const config = {
                fps: 15,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
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
