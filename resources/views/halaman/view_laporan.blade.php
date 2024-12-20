@extends('index')
@section('title', 'Laporan Peminjaman')

@section('isihalaman')
    <h3><center>Laporan Data Peminjaman</center></h3>
    <h3><center>Perpustakaan Universitas Mercu Buana</center></h3>

    <a class="btn btn-danger" href="{{ url(Auth::user()->role.'/laporan/pinjaman/pdf') }}">Export PDF</a>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <td>No</td>
                <td>ID Pinjam</td>
                <td>Nama Petugas</td>
                <td>Nama Anggota</td>
                <td>Judul Buku</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($datapinjam as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->id_pinjam }}</td>
                    <td>{{ $p->petugas?->nama_petugas ?? 'Tidak tersedia' }}</td>
                    <td>{{ $p->anggota?->nama_anggota ?? 'Tidak tersedia' }}</td>
                    <td>{{ $p->buku?->judul ?? 'Tidak tersedia' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection