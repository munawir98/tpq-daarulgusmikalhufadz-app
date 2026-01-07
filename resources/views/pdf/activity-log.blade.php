<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Activity Log</title>

    <style>
        @page {
            margin: 130px 45px 90px 45px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        header {
            position: fixed;
            top: -110px;
            left: 0;
            right: 0;
            height: 110px;
            text-align: center;
            border-bottom: 2px solid #333;
        }

        header img {
            height: 60px;
            margin-top: 5px;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 60px;
            border-top: 1px solid #333;
            font-size: 10px;
        }

        .watermark {
            position: fixed;
            top: 35%;
            left: 18%;
            opacity: 0.05;
            font-size: 55px;
            transform: rotate(-30deg);
            z-index: -1000;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .small {
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="watermark">TPQ DAARUL GUSMIK</div>

    <header>
        <img src="{{ public_path('logo.png') }}">
        <div style="font-size:16px;font-weight:bold">LAPORAN ACTIVITY LOG</div>
        <div style="font-size:11px">TPQ Daarul Gusmik Al-Hufadz</div>
    </header>

    <footer>
        <div style="float:left">Dicetak: {{ $date }}</div>
        <div style="float:right">Halaman {PAGE_NUM} / {PAGE_COUNT}</div>
    </footer>

    <!-- ===== COVER ===== -->
    <h3 class="center">RINGKASAN LAPORAN</h3>

    <table>
        <tr>
            <td width="30%">Dicetak oleh</td>
            <td>{{ $user }}</td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>{{ $from ?? '-' }} s/d {{ $to ?? '-' }}</td>
        </tr>
        <tr>
            <td>Audit Hash</td>
            <td class="small">{{ $hash }}</td>
        </tr>
    </table>

    <br>

    <div class="center">
        <img src="data:image/png;base64,{{ $qr }}">
        <div class="small">QR Validasi Laporan</div>
    </div>

    <div class="page-break"></div>

    <!-- ===== DATA ===== -->
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Tanggal</th>
                <th width="15%">User</th>
                <th width="10%">Event</th>
                <th width="15%">Modul</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $i => $log)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $log['tanggal'] }}</td>
                <td>{{ $log['user'] }}</td>
                <td class="center">{{ $log['event'] }}</td>
                <td>{{ $log['module'] }}</td>
                <td>{{ $log['desc'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ===== SIGNATURE ===== -->
    <table style="margin-top:50px">
        <tr>
            <td class="center">
                Mengetahui,<br>Kepala TPQ<br><br><br>
                <strong>____________________</strong>
            </td>
            <td class="center">
                Dicetak oleh,<br>Admin Sistem<br><br><br>
                <strong>{{ $user }}</strong>
            </td>
        </tr>
    </table>

</body>

</html>
