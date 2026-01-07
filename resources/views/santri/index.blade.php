@extends('layouts.app')

@section('title', 'Data Santri')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data Santri</h4>

        <div>
            {{-- Download Template --}}
            <a href="{{ url('/santri/template') }}" class="btn btn-success">
                Download Template Excel
            </a>

            {{-- Import Excel (opsional, kalau nanti ditambahkan) --}}
            {{--
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                Import Excel
            </button>
            --}}
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- ALERT ERROR --}}
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    {{-- TABLE SANTRI --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Kelas</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($santris as $santri)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $santri->nis }}</td>
                        <td>{{ $santri->nama_lengkap }}</td>
                        <td>{{ $santri->jenis_kelamin }}</td>
                        <td>{{ $santri->tanggal_lahir }}</td>
                        <td>{{ $santri->kelas->nama ?? '-' }}</td>
                        <td>{{ $santri->tanggal_masuk }}</td>
                        <td>
                            <a href="{{ url('/santri/'.$santri->id.'/edit') }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ url('/santri/'.$santri->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus santri ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Data santri belum tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
