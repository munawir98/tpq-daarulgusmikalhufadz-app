<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Santri - {{ $santri->nama_lengkap }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                background: white;
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="space-y-6">
        <!-- Card Container -->
        <div class="relative w-[350px] h-[550px] bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">

            <!-- Header Pattern -->
            <div class="absolute top-0 w-full h-32 bg-gradient-to-br from-green-600 to-emerald-500">
                <div class="absolute inset-0 opacity-10"
                    style="background-image: radial-gradient(circle, white 2px, transparent 2.5px); background-size: 12px 12px;">
                </div>
            </div>

            <!-- Profile Content -->
            <div class="relative pt-16 px-6 text-center flex flex-col h-full">

                <!-- Photo Placeholder -->
                <div class="mx-auto w-28 h-28 bg-white p-1 rounded-full shadow-lg mb-4">
                    <div
                        class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center overflow-hidden border-2 border-green-500">
                        @if($santri->foto)
                        <img src="{{ Str::startsWith($santri->foto, 'data:') ? $santri->foto : asset('storage/'.$santri->foto) }}"
                            class="w-full h-full object-cover">
                        @else
                        <span class="text-3xl">👤</span>
                        @endif
                    </div>
                </div>

                <!-- Identity -->
                <h1 class="text-xl font-bold text-gray-800 leading-tight mb-1">{{ $santri->nama_lengkap }}</h1>
                <p class="text-sm text-gray-500 font-medium mb-1">Santri TPQ Daarul Gusmik</p>
                <div class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold mb-6">
                    {{ $santri->nis }}
                </div>

                <!-- QR Code Section -->
                <div class="flex-grow flex flex-col items-center justify-center space-y-2">
                    <div class="bg-white p-2 rounded-xl border-2 border-dashed border-gray-300">
                        <!-- Generate QR Code using SimpleSoftwareIO -->
                        {!! QrCode::size(160)->generate($code) !!}
                    </div>
                    <p class="text-[10px] text-gray-400">Scan untuk Presensi</p>
                </div>

                <!-- Footer -->
                <div class="w-full py-6 mt-auto">
                    <div class="h-1 w-20 bg-gray-200 mx-auto rounded-full"></div>
                </div>

            </div>
        </div>

        <!-- Print Button -->
        <div class="text-center no-print">
            <button onclick="window.print()"
                class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition flex items-center gap-2 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Cetak Kartu
            </button>
        </div>
    </div>

</body>

</html>
