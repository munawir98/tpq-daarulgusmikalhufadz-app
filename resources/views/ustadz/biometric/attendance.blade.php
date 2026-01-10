<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Sidik Jari</title>
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

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div
        class="max-w-md w-full bg-white rounded-3xl shadow-xl p-6 text-center relative overflow-hidden flex flex-col items-center">
        <!-- Header Gradient -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-emerald-500"></div>

        <!-- Back Button -->
        <a href="{{ route('ustadz.menu') }}" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600">
            <span class="material-icons-round">arrow_back</span>
        </a>



        <!-- Icon -->
        <div
            class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 mt-6 animate-pulse">
            <span class="material-icons-round text-green-500 text-5xl">fingerprint</span>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-1">Absen Sidik Jari</h2>
        <p class="text-gray-500 text-sm mb-4">Tempelkan jari untuk mendeteksi Santri</p>

        <div class="mb-6 px-4 py-2 bg-gray-50 rounded-lg border border-gray-100 inline-block">
            <p class="text-xs text-gray-400 font-mono">Server Status: {{ $totalCredentials ?? 0 }} Jari Terdaftar</p>
        </div>

        <!-- Main Action Button (Scan First) -->
        <button id="btnScanIdentify" onclick="identifyUser()"
            class="w-full py-5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-2xl font-bold shadow-lg shadow-green-500/30 transition-all transform active:scale-95 flex items-center justify-center gap-3">
            <span class="material-icons-round text-3xl">sensors</span>
            <span class="text-lg">Scan Sidik Jari</span>
        </button>

        <!-- Register Link Button -->
        <a href="{{ route('ustadz.biometric.register') }}"
            class="mt-4 w-full py-3 bg-white border-2 border-green-100 text-green-600 rounded-xl font-bold hover:bg-green-50 transition-colors flex items-center justify-center gap-2">
            <span class="material-icons-round">person_add</span>
            Daftarkan Jari Santri
        </a>

    </div>

    <script>
        function resetBtns() {
            const btn = document.getElementById('btnScanIdentify');
            btn.innerHTML = '<span class="material-icons-round text-3xl">sensors</span> <span class="text-lg">Scan Sidik Jari</span>';
            btn.disabled = false;
        }

        async function identifyUser() {
            // DEBUG: Alert to confirm button click
            // alert("Tombol diklik. Memulai scan...");
            console.log("Starting identification...");

            const btn = document.getElementById('btnScanIdentify');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span class="animate-spin material-icons-round text-2xl">sync</span> Mencari...';
            btn.disabled = true;

            try {
                if (!window.PublicKeyCredential) {
                    throw new Error("Perangkat tidak mendukung biometrik.");
                }

                // Call get() WITHOUT allowCredentials to trigger "Discoverable Credential" flow / Account Chooser
                const credential = await navigator.credentials.get({
                    publicKey: {
                        challenge: new Uint8Array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]),
                        rpId: window.location.hostname,
                        userVerification: "required",
                    }
                });

                // Extract User Handle (Santri ID)
                const userHandleBuffer = credential.response.userHandle;
                if (!userHandleBuffer) {
                    throw new Error("Identitas tidak ditemukan dalam kredensial ini. Pastikan sidik jari sudah didaftarkan ulang.");
                }

                // Decode User Handle back to String ID
                const santriId = new TextDecoder().decode(userHandleBuffer);
                console.log("Identified Santri ID:", santriId);

                // Authenticate & Submit
                submitAttendance(santriId, credential);

            } catch (error) {
                console.error(error);
                let msg = error.message || 'Terjadi kesalahan saat mendeteksi biometrik.';
                if (error.name === 'NotAllowedError') msg = 'Scan dibatalkan atau waktu habis.';

                Swal.fire('Scan Gagal', msg, 'error');
                resetBtns();
            }
        }

        async function submitAttendance(santriId, credential) {
            try {
                const response = await fetch("{{ route('ustadz.biometric.submit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        santri_id: santriId,
                        latitude: null, // Optional for manual override
                        longitude: null,
                        type: 'masuk', // Default to masuk
                        credential_id: credential.id // Send credential ID for verification if needed
                    })
                });

                const data = await response.json();
                resetBtns();

                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message + ' Input setoran hafalan sekarang?',
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Input',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('ustadz.hafalan.input') }}?santri_id=" + santriId;
                        }
                    });
                } else {
                    Swal.fire('Gagal', data.message, 'error');
                }
            }
            catch (err) {
                resetBtns();
                console.error(err);
                Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
            }
        }
    </script>

</body>

</html>
