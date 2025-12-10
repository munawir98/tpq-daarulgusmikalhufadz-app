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
    </style>
</head>

<body>

    <h2>TPQ Daarul Gusmik Al-Hufadz</h2>
    <h3>Laporan Absensi Santri</h3>

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

</body>

</html>
