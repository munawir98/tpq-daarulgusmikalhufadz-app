@extends('layouts.admin')

@section('content')
<div class="container">

    <h3 style="margin-bottom:15px;">
        Riwayat Scan Verifikasi Dokumen
    </h3>

    <table width="100%" border="1" cellpadding="8" cellspacing="0">
        <thead style="background:#f3f3f3;">
            <tr>
                <th>No</th>
                <th>Nomor Dokumen</th>
                <th>Nama File</th>
                <th>IP Address</th>
                <th>User Agent</th>
                <th>Waktu Scan</th>
            </tr>
        </thead>

        <tbody>
            @forelse($scans as $index => $scan)
            <tr>
                <td align="center">
                    {{ $scans->firstItem() + $index }}
                </td>

                {{-- DATA DOKUMEN --}}
                <td>
                    {{ $scan->verification->document_number ?? '-' }}
                </td>

                <td>
                    {{ $scan->verification->file_name ?? '-' }}
                </td>

                {{-- DATA SCAN --}}
                <td>
                    {{ $scan->ip_address }}
                </td>

                <td style="max-width:300px; word-break:break-all;">
                    {{ $scan->user_agent }}
                </td>

                <td>
                    {{ $scan->scanned_at->format('d-m-Y H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" align="center">
                    Belum ada riwayat scan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PAGINATION --}}
    <div style="margin-top:15px;">
        {{ $scans->links() }}
    </div>

</div>
@endsection
