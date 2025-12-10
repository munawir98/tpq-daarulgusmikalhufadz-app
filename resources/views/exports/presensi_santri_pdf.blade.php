<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Presensi Santri</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #f0f0f0;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .status-hadir {
            color: green;
            font-weight: bold;
        }

        .status-sakit {
            color: blue;
            font-weight: bold;
        }

        .status-izin {
            color: orange;
            font-weight: bold;
        }

        .status-alpha {
            color: red;
            font-weight: bold;
        }

        .status-terlambat {
            color: purple;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>

<body>

    <h2 class="title">Rekap Presensi Santri</h2>
    <p class="subtitle">{{ $tanggalRange }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            @foreach($data as $p)
            <tr>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $p->jam }}</td>
                <td>{{ ucfirst($p->tipe) }}</td>
                <td class="status-{{ strtolower($p->status_presensi) }}">
                    {{ ucfirst(strtolower($p->status_presensi)) }}
                </td>
                <td>{{ $p->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem TPQ Daarul Gusmik Al-Hufadz — {{ now()->format('d/m/Y H:i') }}
    </div>

</body>

</html>
