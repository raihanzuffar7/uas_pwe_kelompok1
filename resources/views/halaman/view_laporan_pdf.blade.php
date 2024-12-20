<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Peminjaman</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h3>Laporan Data Peminjaman</h3>
    <h4>Perpustakaan Universitas Mercu Buana</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pinjam</th>
                <th>Nama Petugas</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datapinjam as $index=>$p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->id_pinjam }}</td>
                    <td>{{ $p->petugas->nama_petugas }}</td>
                    <td>{{ $p->anggota->nama_anggota }}</td>
                    <td>{{ $p->buku->judul }}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
