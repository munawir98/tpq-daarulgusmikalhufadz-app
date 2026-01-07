<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Dokumen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .badge-valid {
            display: inline-block;
            background: #28a745;
            color: #ffffff;
            padding: 10px 14px;
            border-radius: 6px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 12px;
            font-size: 14px;
        }

        .label {
            display: inline-block;
            width: 170px;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
            font-size: 12px;
            color: #666;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .label {
                width: 100%;
                display: block;
                margin-bottom: 4px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        {{-- BADGE STATUS --}}
        <div class="badge-valid">
            ✅ DOKUMEN ASLI & TERDAFTAR
        </div>

        {{-- INFORMASI DOKUMEN --}}
        <div class="row">
            <span class="label">Nomor Dokumen</span>
            : {{ $verification->document_number }}
        </div>

        <div class="row">
            <span class="label">Nama File</span>
            : {{ $verification->file_name }}
        </div>

        <div class="row">
            <span class="label">Tanggal Dibuat</span>
            : {{ $verification->generated_at->format('d-m-Y H:i') }}
        </div>

        {{-- JUMLAH SCAN (WAJIB) --}}
        <div class="row">
            <span class="label">Jumlah Scan</span>
            : {{ $scanCount }} kali
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            Dokumen ini diterbitkan secara resmi oleh
            <strong>TPQ Daarul Gusmik Al-Hufadz</strong>.<br>
            Verifikasi dilakukan melalui sistem digital dengan QR Code.<br>
            Jika terdapat keraguan, silakan hubungi pihak TPQ.
        </div>

    </div>

</body>

</html>
