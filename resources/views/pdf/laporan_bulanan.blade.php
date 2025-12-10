<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Bulanan</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>LAPORAN PRESENSI BULAN {{ strtoupper($bulan) }}</h2>

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
            @foreach($data as $row)
            <tr>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->jam }}</td>
                <td>{{ ucfirst($row->tipe) }}</td>
                <td>{{ $row->status_presensi }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table style="width: 40%; float:right;">
        <tr>
            <th>Total Hadir</th>
            <td>{{ $data->where('status_presensi','Hadir')->count() }}</td>
        </tr>
        <tr>
            <th>Total Terlambat</th>
            <td>{{ $data->where('status_presensi','Terlambat')->count() }}</td>
        </tr>
        <tr>
            <th>Total Izin</th>
            <td>{{ $data->where('status_presensi','Izin')->count() }}</td>
        </tr>
        <tr>
            <th>Total Alfa</th>
            <td>{{ $data->where('status_presensi','Alfa')->count() }}</td>
        </tr>
    </table>

</body>

</html>
