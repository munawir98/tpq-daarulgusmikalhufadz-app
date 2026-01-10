<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sidik Jari</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-6 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-purple-500"></div>

        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-icons-round text-blue-500 text-4xl">fingerprint</span>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-2">Aktivasi Biometrik</h2>
        <p class="text-gray-500 text-sm mb-8">Daftarkan sidik jari atau Face ID perangkat Anda untuk mempermudah
            presensi harian.</p>

        <div id="instruction" class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 text-left">
            <h3 class="text-sm font-bold text-blue-800 mb-1">Panduan:</h3>
            <ul class="text-xs text-blue-600 list-disc ml-4 space-y-1">
                <li>Pastikan perangkat memiliki sensor sidik jari / wajah.</li>
                <li>Klik tombol di bawah ini.</li>
                <li>Tempelkan jari pada sensor saat diminta browser.</li>
            </ul>
        </div>

        <button onclick="registerBiometric()" id="btnRegister"
            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg transition-transform active:scale-95 flex items-center justify-center gap-2">
            <span class="material-icons-round">fingerprint</span>
            Jalankan Sensor
        </button>

        <a href="{{ route('ustadz.settings') }}"
            class="block mt-6 text-sm text-gray-400 font-medium hover:text-gray-600">Batal / Kembali</a>
    </div>

    <script>
        async function registerBiometric() {
            if (!window.PublicKeyCredential) {
                Swal.fire('Error', 'Perangkat ini tidak mendukung WebAuthn / Biometrik.', 'error');
                return;
            }

            const btn = document.getElementById('btnRegister');
            btn.disabled = true;
            btn.innerHTML = '<span class="animate-spin material-icons-round">sync</span> Memproses...';

            try {
                // Konfigurasi WebAuthn Sederhana (Hanya untuk mendapatkan Credential ID)
                // Di produksi, challenge harus dari server.
                const publicKey = {
                    challenge: new Uint8Array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]), // Dummy Challenge
                    rp: { name: "TPQ Daarul Gusmik", id: window.location.hostname },
                    user: {
                        id: Uint8Array.from("{{ session('user.id') }}", c => c.charCodeAt(0)),
                        name: "{{ session('user.email') ?? session('user.username') }}",
                        displayName: "{{ session('user.name') }}"
                    },
                    pubKeyCredParams: [{ alg: -7, type: "public-key" }],
                    authenticatorSelection: { userVerification: "preferred" }, // Memaksa verifikasi lokal (sidik jari/PIN)
                    timeout: 60000,
                    attestation: "none"
                };

                const credential = await navigator.credentials.create({ publicKey });

                // Kirim ID ke server
                const credentialId = btoa(String.fromCharCode(...new Uint8Array(credential.rawId)));

                saveToServer(credentialId);

            } catch (error) {
                console.error(error);
                let msg = 'Gagal mengakses sensor.';
                if (error.name === 'NotAllowedError') msg = 'Izin ditolak atau waktu habis.';
                Swal.fire('Gagal', msg, 'error');
                btn.disabled = false;
                btn.innerHTML = '<span class="material-icons-round">fingerprint</span> Coba Lagi';
            }
        }

        function saveToServer(credId) {
            fetch("{{ route('ustadz.biometric.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ credential_id: credId })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Sidik jari berhasil didaftarkan.',
                            confirmButtonText: 'Lanjut Presensi'
                        }).then(() => {
                            window.location.href = "{{ route('ustadz.presensi') }}";
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(err => {
                    Swal.fire('Error', err.message, 'error');
                    const btn = document.getElementById('btnRegister');
                    btn.disabled = false;
                    btn.innerHTML = '<span class="material-icons-round">fingerprint</span> Coba Lagi';
                });
        }
    </script>
</body>

</html>
