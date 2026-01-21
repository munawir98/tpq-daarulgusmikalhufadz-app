<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kehadiran Santri</title>
    <style>
        body {
            font-family: sans-serif;
            color: #1C1C1E;
            font-size: 10px;
        }

        .header {
            border-bottom: 2px solid #1f2937;
            /* gray-800 */
            padding-bottom: 16px;
            margin-bottom: 24px;
            position: relative;
        }

        .header-content {
            width: 70%;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 4px 0;
            letter-spacing: -0.025em;
        }

        .header p.tpq-name {
            font-size: 12px;
            font-weight: 500;
            color: #4b5563;
            /* gray-600 */
            margin: 0;
        }

        .header p.periode {
            font-size: 10px;
            color: #6b7280;
            /* gray-500 */
            margin: 0;
        }

        .header-icon {
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 40px;
            background-color: #e5e7eb;
            /* gray-200 */
            border-radius: 6px;
            text-align: center;
            line-height: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        th {
            background-color: #ffffff;
            /* white */
            border-top: 1px solid #1f2937;
            /* gray-800 */
            border-bottom: 1px solid #1f2937;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            color: #4b5563;
            /* gray-600 */
            font-size: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        td {
            padding: 8px 4px;
            border-bottom: 1px solid #e5e7eb;
            /* gray-200 */
        }

        .border-r {
            border-right: 1px solid #d1d5db;
        }

        .text-green {
            color: #059669;
            font-weight: bold;
        }

        .text-orange {
            color: #d97706;
            font-weight: bold;
        }

        .text-red {
            color: #dc2626;
            font-weight: bold;
        }

        /* Summary Section */
        .summary-container {
            margin-top: 32px;
            width: 100%;
        }

        .summary-box {
            width: 48%;
            float: left;
            background-color: #ffffff;
            /* white */
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 12px;
            box-sizing: border-box;
        }

        .signature-box {
            width: 48%;
            float: right;
            border: 1px dashed #d1d5db;
            border-radius: 4px;
            padding: 12px;
            text-align: center;
            height: 80px;
            /* approximiate height match */
        }

        .summary-title {
            font-size: 9px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .summary-row {
            display: block;
            margin-bottom: 4px;
            font-size: 10px;
        }

        .clear {
            clear: both;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #f3f4f6;
            padding-top: 8px;
            color: #9ca3af;
            /* gray-400 */
            font-size: 8px;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <h1>LAPORAN REKAP KEHADIRAN SANTRI</h1>
            <p class="tpq-name">TPQ Daarul Gusmikal Hufadz</p>
            <p class="periode">Periode: {{ $monthName }} | Kelas: {{ $kelasNama ?? 'Semua Kelas' }}</p>
        </div>
        <!-- Logo TPQ -->
        <img src="{{ public_path('logo-tpq.png') }}" class="header-icon"
            style="object-fit: contain; background: transparent;">
    </div>

    <table>
        <thead>
            <tr>
                <th class="border-r text-center" width="5%">No</th>
                <th class="border-r" width="35%">Nama Santri</th>
                <th class="border-r text-center" width="10%">Hadir</th>
                <th class="border-r text-center" width="10%">Izin</th>
                <th class="border-r text-center" width="10%">Sakit</th>
                <th class="border-r text-center" width="10%">Alpa</th>
                <th class="text-center" width="20%">%</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="text-center border-r">{{ $index + 1 }}</td>
                <td class="border-r"><strong>{{ $item['nama'] }}</strong></td>
                <td class="text-center border-r">{{ $item['hadir'] }}</td>
                <td class="text-center border-r">{{ $item['izin'] }}</td>
                <td class="text-center border-r">{{ $item['sakit'] }}</td>
                <td class="text-center border-r">{{ $item['alpa'] }}</td>
                <td class="text-center">
                    @php
                    $colorClass = 'text-red';
                    if($item['persentase'] >= 90) $colorClass = 'text-green';
                    elseif($item['persentase'] >= 75) $colorClass = 'text-orange';
                    @endphp
                    <span class="{{ $colorClass }}">{{ $item['persentase'] }}%</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data kehadiran untuk periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-container">
        <div class="summary-box">
            <span class="summary-title">Ringkasan Kehadiran</span>
            @php
            $totalSantri = count($data) > 0 ? count($data) : 1;
            $avgHadir = collect($data)->avg('persentase');
            $mostDiligent = collect($data)->sortByDesc('persentase')->first();
            @endphp
            <div class="summary-row">
                <span>Rata-rata Kehadiran:</span>
                <strong style="float:right">{{ round($avgHadir, 1) }}%</strong>
            </div>
            <div class="summary-row">
                <span>Santri Paling Rajin:</span>
                <strong style="float:right">{{ $mostDiligent['nama'] ?? '-' }}</strong>
            </div>
        </div>

        <div class="signature-box">
            <p style="font-size:8px; color:#9ca3af; margin-bottom:40px; margin-top:0;">Tanda Tangan Pengurus</p>
            <div style="border-bottom:1px solid #9ca3af; width:80%; margin:0 auto;"></div>
            <p style="font-size:8px; font-weight:bold; margin-top:4px;">Kepala TPQ Daarul Gusmikal Hufadz</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="footer">
        <span class="footer-left">Dicetak pada: {{ now()->translatedFormat('d M Y H:i') }}</span>
        <span class="footer-right">Oleh: {{ $printedBy }}</span>
    </div>
</body>

</html>
