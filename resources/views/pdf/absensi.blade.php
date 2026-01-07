<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* WATERMARK */
        .watermark {
            position: fixed;
            top: 35%;
            left: 20%;
            width: 60%;
            opacity: 0.08;
            z-index: -1;
        }

        /* FOOTER QR */
        footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #444;
        }

        .qr-box {
            margin-top: 5px;
        }

        /* TTD */
        .ttd {
            margin-top: 40px;
            text-align: right;
        }

        .doc-number {
            text-align: center;
            margin-top: 6px;
            font-size: 11px;
        }
    </style>
</head>

<body>

    {{-- A. WATERMARK LOGO --}}
    <img src="{{ public_path('images/logo-tpq.png') }}" class="watermark">

    <h2>TPQ Daarul Gusmik Al-Hufadz</h2>
    <h3>Laporan Absensi Santri</h3>

    {{-- B. NOMOR DOKUMEN --}}
    <div class="doc-number">
        <strong>Nomor Dokumen:</strong>
        {{ $verification->document_number }}
    </div>

    <p><strong>Nama Santri:</strong> {{ $santri->nama_lengkap }}</p>
    <p><strong>Bulan:</strong> {{ $bulan }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- C. TANDA TANGAN DIGITAL --}}
    <div class="ttd">
        <img src="{{ public_path('images/ttd-kepala-tpq.png') }}" width="120">
        <p>
            <strong>Kepala TPQ Daarul Gusmik Al-Hufadz</strong>
        </p>
    </div>

    {{-- D. FOOTER QR VERIFIKASI --}}
    <footer>
        <div>
            <strong>Verifikasi Keaslian Dokumen</strong><br>
            Scan QR Code di bawah ini
        </div>

        <div class="qr-box">
            {!! QrCode::size(80)->generate($qrUrl) !!}
        </div>

        <p style="margin-top:4px;">
            {{ $qrUrl }}
        </p>

        {{-- ✅ INFO JUMLAH SCAN (BARU) --}}
        <p style="font-size:10px; margin-top:6px;">
            Dokumen ini telah diverifikasi sebanyak
            <strong>{{ $scanCount }}</strong> kali
        </p>
    </footer>

</body>

</html>
