@extends('index')
@section('title', 'Buku')

@section('isihalaman')
    <h3><center>Daftar Buku Perpustakaan Universitas Mercu Buana</center></h3>
    
    @if (Auth::user()->role === 'admin')
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalBukuTambah">
            Tambah Data Buku
        </button>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td align="center">No</td>
                <td align="center">ID Buku</td>
                <td align="center">Kode Buku</td>
                <td align="center">Judul Buku</td>
                <td align="center">Pengarang</td>
                <td align="center">Kategori</td>
                <td align="center">Gambar</td>
                <td align="center">Status</td>
                @if (Auth::user()->role === 'admin')
                    <td align="center">Aksi</td>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $index => $bk)
                <tr>
                    <td align="center" scope="row">{{ $index + $buku->firstItem() }}</td>
                    <td>{{ $bk->id_buku }}</td>
                    <td>{{ $bk->kode_buku }}</td>
                    <td>{{ $bk->judul }}</td>
                    <td>{{ $bk->pengarang }}</td>
                    <td>{{ $bk->kategori }}</td>
                    <td align="center">
                        @if($bk->gambar)
                            <img src="{{ asset('storage/' . $bk->gambar) }}" width="50" alt="Gambar Buku">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td align="center">{{ $bk->status }}</td>
                    @if (Auth::user()->role === 'admin')
                        <td align="center">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalBukuEdit{{ $bk->id_buku }}">
                                Edit
                            </button>

                            <!-- Modal Edit Data Buku -->
                            <div class="modal fade" id="modalBukuEdit{{ $bk->id_buku }}" tabindex="-1" role="dialog" aria-labelledby="modalBukuEditLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalBukuEditLabel">Form Edit Data Buku</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form name="formbukuedit" id="formbukuedit" action="/{{ Auth::user()->role }}/buku/edit/{{ $bk->id_buku }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                {{ method_field('PUT') }}
                                                <div class="form-group row">
                                                    <label for="kode_buku" class="col-sm-4 col-form-label">Kode Buku</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="kode_buku" name="kode_buku" value="{{ $bk->kode_buku }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="judul" class="col-sm-4 col-form-label">Judul Buku</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="judul" name="judul" value="{{ $bk->judul }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="pengarang" class="col-sm-4 col-form-label">Nama Pengarang</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ $bk->pengarang }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="kategori" name="kategori" value="{{ $bk->kategori }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="file" class="col-sm-4 col-form-label">Pilih File Gambar</label>
                                                    <div class="col-sm-8">
                                                        <input type="file" class="form-control" id="file" name="gambar" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="Tersedia" {{ $bk->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                                            <option value="Tidak Tersedia" {{ $bk->status == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" name="tutup" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" name="bukutambah" class="btn btn-success">Edit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Akhir Modal Edit Data Buku -->

                                                        <!-- Hapus Data Buku -->
                                                        <form action="{{ route('buku.hapus', $bk->id_buku) }}" method="POST" onsubmit="return confirm('Yakin mau dihapus?')" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">Delete</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            
                                <!-- Pagination -->
                                <div>
                                    Halaman : {{ $buku->currentPage() }} <br />
                                    Jumlah Data : {{ $buku->total() }} <br />
                                    Data Per Halaman : {{ $buku->perPage() }} <br />
                                    {{ $buku->links() }}
                                </div>
                            
                                <!-- Modal Tambah Data Buku -->
                                <div class="modal fade" id="modalBukuTambah" tabindex="-1" role="dialog" aria-labelledby="modalBukuTambahLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalBukuTambahLabel">Form Input Data Buku</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form name="formbukutambah" id="formbukutambah" action="/{{ Auth::user()->role }}/buku/tambah" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="kode_buku" class="col-sm-4 col-form-label">Kode Buku</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="kode_buku" name="kode_buku" placeholder="Masukkan Kode Buku">
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-group row">
                                                        <label for="judul" class="col-sm-4 col-form-label">Judul Buku</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan Judul Buku">
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-group row">
                                                        <label for="pengarang" class="col-sm-4 col-form-label">Nama Pengarang</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan Nama Pengarang">
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-group row">
                                                        <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan Kategori">
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-group row">
                                                        <label for="file" class="col-sm-4 col-form-label">Pilih File Gambar</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" class="form-control" id="file" name="gambar" />
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-group row">
                                                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="status" name="status">
                                                                <option value="Tersedia">Tersedia</option>
                                                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" name="tutup" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <button type="submit" name="bukutambah" class="btn btn-success">Tambah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Tambah Data Buku -->
                            @endsection