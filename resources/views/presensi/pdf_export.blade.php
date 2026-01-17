<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kehadiran Santri</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .bg-green {
            background-color: #10B981;
        }

        .bg-blue {
            background-color: #25c0f4;
        }

        .bg-red {
            background-color: #EF4444;
        }

        .bg-gray {
            background-color: #9CA3AF;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
            color: #999;
            text-align: right;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Kehadiran Santri</h1>
        <p>TPQ Daarul Gusmikal Hufadz</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Periode:</strong></td>
            <td width="35%">{{ $monthName }}</td>
            <td width="15%"><strong>Kelas:</strong></td>
            <td width="35%">{{ $kelasNama ?? 'Semua Kelas' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Cetak:</strong></td>
            <td>{{ now()->translatedFormat('d F Y H:i') }}</td>
            <td><strong>Oleh:</strong></td>
            <td>{{ auth()->user()->name }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="35%">Nama Santri</th>
                <th width="10%" class="text-center">Hadir</th>
                <th width="10%" class="text-center">Izin</th>
                <th width="10%" class="text-center">Sakit</th>
                <th width="10%" class="text-center">Alpa</th>
                <th width="20%" class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $item['nama'] }}</strong>
                </td>
                <td class="text-center">{{ $item['hadir'] }}</td>
                <td class="text-center">{{ $item['izin'] }}</td>
                <td class="text-center">{{ $item['sakit'] }}</td>
                <td class="text-center">{{ $item['alpa'] }}</td>
                <td class="text-center">
                    {{ $item['persentase'] }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak melalui Sistem Informasi TPQ
    </div>
</body>

</html>
