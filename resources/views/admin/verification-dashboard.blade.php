@extends('layouts.admin')

@section('content')
<h3>Dashboard Verifikasi Dokumen</h3>

<ul>
    <li><strong>Total Dokumen:</strong> {{ $totalDocuments }}</li>
    <li><strong>Total Scan:</strong> {{ $totalScans }}</li>
    <li><strong>Scan Hari Ini:</strong> {{ $scansToday }}</li>
</ul>

<h4>Scan Terakhir</h4>
<table border="1" width="100%" cellpadding="6">
    <tr>
        <th>No</th>
        <th>Nomor Dokumen</th>
        <th>IP</th>
        <th>Waktu</th>
    </tr>
    @foreach($latestScans as $i => $scan)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $scan->verification->document_number }}</td>
        <td>{{ $scan->ip_address }}</td>
        <td>{{ $scan->scanned_at }}</td>
    </tr>
    @endforeach
</table>
@endsection
