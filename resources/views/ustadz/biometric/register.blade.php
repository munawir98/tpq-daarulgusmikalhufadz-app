<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sidik Jari Santri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 -->
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
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-purple-500 to-indigo-500"></div>

        <!-- Back Button -->
        <a href="{{ route('ustadz.dashboard') }}" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600">
            <span class="material-icons-round">arrow_back</span>
        </a>

        <!-- Icon -->
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 mt-6">
            <span class="material-icons-round text-purple-500 text-3xl">fingerprint</span>
        </div>

        <h2 class="text-xl font-bold text-gray-800 mb-1">Daftar Sidik Jari</h2>
        <p class="text-gray-500 text-xs mb-6">Hubungkan data biometrik ke Santri</p>

        <!-- Form  -->
        <div class="w-full text-left space-y-4">

            <!-- Select Santri -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 ml-1">Pilih Santri</label>
                <select id="santriSelect" class="w-full">
                    <option value="" selected disabled>Cari nama santri...</option>
                    @foreach($santris as $santri)
                    <option value="{{ $santri->id }}">{{ $santri->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Jari -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 ml-1">Nama Jari / Perangkat (Opsional)</label>
                <input type="text" id="credentialName" placeholder="Contoh: Jari Telunjuk (Otomatis jika kosong)"
                    class="w-full h-12 rounded-xl border-gray-200 text-sm focus:ring-purple-500 focus:border-purple-500">
            </div>

        </div>

        <!-- Action Button -->
        <button id="btnRegister" onclick="registerProcess()" disabled
            class="mt-8 w-full py-4 bg-gray-200 text-gray-400 rounded-xl font-bold shadow-none transition-all duration-300 flex items-center justify-center gap-2">
            <span class="material-icons-round">fingerprint</span>
            Daftarkan
        </button>

    </div>

    <!-- Debugging Area Removed -->


    <script>
        function logDebug(msg) {
            // Debug console removed
            console.log(msg);
        }

        $(document).ready(function () {
            logDebug("Page Loaded. jQuery Ready.");

            // Init Select2 with AJAX
            $('#santriSelect').select2({
                placeholder: "Cari nama santri...",
                width: '100%',
                ajax: {
                    // Use relative URL to avoid Mixed Content (HTTP vs HTTPS) issues
                    url: "search",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data) {
                        if (data.debug_meta) {
                            logDebug("Server Debug: DB Total=" + data.debug_meta.total_santri_db +
                                " | Term='" + data.debug_meta.term_received + "'" +
                                " | First='" + data.debug_meta.first_santri + "'");
                        }
                        logDebug("Data received: " + data.results.length + " items");
                        return {
                            results: data.results
                        };
                    },
                    cache: true,
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (textStatus === 'abort') return;
                        logDebug("ERROR: " + textStatus + " | Status: " + jqXHR.status + " | " + errorThrown);
                        alert('Error: ' + jqXHR.status + ' ' + errorThrown);
                    }
                },
                minimumInputLength: 0, // Allow showing all on click if supported
                language: {
                    noResults: function () {
                        return "Santri tidak ditemukan or error";
                    },
                    searching: function () {
                        return "Mencari...";
                    }
                }
            });

            // Auto open for UX
            setTimeout(() => $('#santriSelect').select2('open'), 500);

            // Bind to both change AND select2:select for reliability
            $('#santriSelect').on('change select2:select', checkForm);
        });

        // checkForm defined globally so it can be called from registerProcess()
        function checkForm() {
            const santri = $('#santriSelect').val();
            const btn = document.getElementById('btnRegister');

            if (santri) {
                btn.disabled = false;
                btn.className = 'mt-8 w-full py-4 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold shadow-lg transition-transform active:scale-95 flex items-center justify-center gap-2 cursor-pointer';
            } else {
                btn.disabled = true;
                btn.className = 'mt-8 w-full py-4 bg-gray-200 text-gray-400 rounded-xl font-bold shadow-none flex items-center justify-center gap-2';
            }
        }

        async function registerProcess() {
            const santriId = $('#santriSelect').val();
            const name = $('#credentialName').val();

            if (!santriId) return; // Name can be empty

            const btn = document.getElementById('btnRegister');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<span class="animate-spin material-icons-round">sync</span> Memproses...';
            btn.disabled = true;

            try {
                // Check if device supports WebAuthn
                if (!window.PublicKeyCredential) {
                    throw new Error("Perangkat tidak mendukung biometrik.");
                }

                // 1. Create Challenge (Dummy for now, strict would fetch from server)
                const publicKey = {
                    challenge: new Uint8Array([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]),
                    rp: { name: "TPQ Daarul Gusmik", id: window.location.hostname },
                    user: {
                        id: Uint8Array.from(santriId, c => c.charCodeAt(0)),
                        name: "santri-" + santriId,
                        displayName: $("#santriSelect option:selected").text()
                    },
                    pubKeyCredParams: [{ alg: -7, type: "public-key" }, { alg: -257, type: "public-key" }],
                    authenticatorSelection: {
                        authenticatorAttachment: "platform", // Use internal sensor (optional, but good for phone)
                        userVerification: "required",
                        residentKey: "required", // Force Passkey / Discoverable Credential
                        requireResidentKey: true
                    },
                    timeout: 60000,
                    attestation: "none"
                };

                // 2. Trigger Device Prompt
                const credential = await navigator.credentials.create({ publicKey });

                // 3. Serialize Credential ID
                const credentialId = btoa(String.fromCharCode(...new Uint8Array(credential.rawId)));

                // 4. Send to Server
                const response = await fetch("{{ route('ustadz.biometric.register.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        santri_id: santriId,
                        credential_id: credentialId,
                        name: name
                    })
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Sidik jari berhasil didaftarkan untuk ' + name,
                    });
                    // Reset name
                    $('#credentialName').val('');
                    checkForm(); // Disable button
                } else {
                    throw new Error(result.message);
                }

            } catch (error) {
                console.error(error);
                Swal.fire('Gagal', error.message || 'Terjadi kesalahan.', 'error');
            } finally {
                btn.innerHTML = originalContent;
                checkForm(); // Re-evaluate button state correctly
            }
        }
    </script>
</body>

</html>
