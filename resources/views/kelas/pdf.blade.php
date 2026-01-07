<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    @include('pdf.style')
</head>

<body>

    {{-- WATERMARK --}}
    <img src="{{ public_path('logo-tpq.png') }}" class="watermark" alt="Watermark">

    {{-- KOP --}}
    @include('pdf.kop', ['judul' => 'Laporan Data Kelas'])

    {{-- TANGGAL CETAK --}}
    <div style="text-align:right;font-size:10px;margin-bottom:12px;">
        Dicetak pada: {{ $tanggalCetak }}
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode</th>
                <th width="35%">Nama Kelas</th>
                <th width="15%">Tingkat</th>
                <th width="30%">Wali Kelas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelas as $i => $item)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $item->kode_kelas }}</td>
                <td>{{ $item->nama_kelas }}</td>
                <td align="center">{{ $item->tingkat }}</td>
                <td>{{ $item->ustadz->nama ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" align="center">Data tidak tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- BLOK TANDA TANGAN (KANAN, CENTER AREA) --}}
    <div style="margin-top:45px;width:100%;">

        <div style="width:45%;margin-left:auto;text-align:center;">

            {{-- JABATAN --}}
            <div style="font-size:11px;margin-bottom:2px;">
                Kepala TPQ
            </div>

            {{-- STEMPEL + TTD --}}
            <div style="position:relative;height:180px;margin-bottom:-12px;">

                {{-- STEMPEL (BELAKANG, PAS DI BAWAH TTD) --}}
                <img src="{{ public_path('stempel.png') }}" alt="Stempel" style="
                        width:190px;
                        position:absolute;
                        left:50%;
                        top:30px;
                        transform:translateX(-50%);
                        opacity:0.35;
                        z-index:1;
                    ">

                {{-- TANDA TANGAN (DEPAN, CENTER) --}}
                <img src="{{ public_path('ttd-kepala.png') }}" alt="Tanda Tangan" style="
                        width:140px;
                        position:absolute;
                        left:50%;
                        top:65px;
                        transform:translateX(-50%);
                        z-index:2;
                    ">
            </div>

            {{-- NAMA --}}
            <div style="font-size:11px;font-weight:bold;margin-top:-6px;">
                ( Ahmad Fauzi, S.Pd.I )
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <footer>
        Sistem Informasi TPQ Daarul Gusmik Al-Hufadz © {{ date('Y') }}

        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(
                    420,
                    820,
                    "Halaman {PAGE_NUM} / {PAGE_COUNT}",
                    null,
                    10
                );
            }
        </script>
    </footer>

</body>

</html>
