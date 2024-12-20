<?php

namespace App\Http\Controllers;

// use App\Models\BukuModel;
// use App\Models\PetugasModel;
use Illuminate\Http\Request;

//memanggil model PinjamModel
use App\Models\PinjamModel;

//memanggil model PetugasModel
use App\Models\PetugasModel;

//memanggil model AnggotaModel
use App\Models\AnggotaModel;

//memanggil model BukuModel
use App\Models\BukuModel;

use Illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\PDF;

class PinjamController extends Controller
{
    //method untuk tampil data peminjaman
    public function pinjamtampil()
    {
        // $datapinjam = PinjamModel::orderby('id_pinjam', 'ASC')
        // ->paginate(5);

        if (Auth::user()->role === 'admin') {
            // Admin melihat semua data buku
            $datapinjam = PinjamModel::orderby('id_pinjam', 'ASC')->paginate(5);
        } else {
            // User hanya melihat data buku miliknya
            $datapinjam = PinjamModel::where('user_id', Auth::id())
                ->orderby('id_pinjam', 'ASC')
                ->paginate(5);
        }

        $datapetugas    = PetugasModel::all();
        $dataanggota      = AnggotaModel::all();
        $databuku       = BukuModel::all();

        return view('halaman/view_pinjam',['pinjam'=>$datapinjam,'petugas'=>$datapetugas,'anggota'=>$dataanggota,'buku'=>$databuku]);
    }

    //method untuk tambah data peminjaman
    public function pinjamtambah(Request $request)
    {
        $this->validate($request, [
            'id_petugas' => 'required',
            'id_anggota' => 'required',
            'id_buku' => 'required'
        ]);

        PinjamModel::create([
            'id_petugas' => $request->id_petugas,
            'id_anggota' => $request->id_anggota,
            'id_buku' => $request->id_buku,
            'user_id' => Auth::user()->id
        ]);

        // return redirect('/pinjam');
        return redirect('/' . Auth::user()->role .'/pinjam')->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    //method untuk hapus data peminjaman
    public function pinjamhapus($id_pinjam)
    {
        $datapinjam=PinjamModel::find($id_pinjam);
        $datapinjam->delete();

        // $id_pinjam->save();

        return redirect()->back();
    }

    //method untuk edit data peminjaman
    public function pinjamedit($id_pinjam, Request $request)
    {
        $this->validate($request, [
            'id_petugas' => 'required',
            'id_anggota' => 'required',
            'id_buku' => 'required'
        ]);

        $id_pinjam = PinjamModel::find($id_pinjam);
        $id_pinjam->id_petugas    = $request->id_petugas;
        $id_pinjam->id_anggota      = $request->id_anggota;
        $id_pinjam->id_buku      = $request->id_buku;

        $id_pinjam->save();

        return redirect()->back();

        // Cari data anggota berdasarkan ID
        $id_pinjam = pinjamModel::find($id_pinjam);

        // Periksa apakah data ditemukan
        if (!$pinjam) {
            return redirect()->back()->with('error', 'Data pinjam tidak ditemukan.');
        }

        // Update data pinjam
        $pinjam->nama_pinjam = $request->nama_pinjam;
        $pinjam->hp = $request->hp;
        $pinjam->save();

        // Redirect dengan pesan sukses
        // return redirect()->route('pinjam.index')->with('success', 'Data pinjam berhasil diperbarui.');
        return redirect('/' . Auth::user()->role .'/pinjam')->with('success', 'Data peminjaman berhasil diperbarui.');

    }

    public function laporanPinjam()
    {
        // $datapinjam = PinjamModel::with(['petugas', 'anggota', 'buku'])->orderby('id_pinjam', 'ASC')->get();

        // return view('halaman/view_laporan', compact('datapinjam'));

        if (Auth::user()->role === 'admin') {
            // Admin melihat semua data peminjaman
            $datapinjam = PinjamModel::with(['petugas', 'anggota', 'buku'])
            ->orderby('id_pinjam', 'ASC')
            ->get();
        } else {
            // User hanya melihat data peminjaman miliknya
            $datapinjam = PinjamModel::with(['petugas', 'anggota', 'buku'])
            ->where('user_id', Auth::id())
            ->orderby('id_pinjam', 'ASC')
            ->get();
        }
        return view('halaman/view_laporan', compact('datapinjam'));
    }

    public function laporanPinjamPDF()
    {
        // $datapinjam = PinjamModel::with(['petugas', 'anggota', 'buku'])->orderby('id_pinjam', 'ASC')->get();
        if (Auth::user()->role === 'admin') {
            // Admin melihat semua data peminjaman
            $datapinjam = PinjamModel::with(['petugas', 'anggota', 'buku'])
            ->orderby('id_pinjam', 'ASC')
            ->get();
        } else {
            // User hanya melihat data peminjaman miliknya
            $datapinjam = PinjamModel::with(['petugas', 'anggota', 'buku'])
            ->where('user_id', Auth::id())
            ->orderby('id_pinjam', 'ASC')
            ->get();
        }
        $pdf = PDF::loadView('halaman/view_laporan_pdf', compact('datapinjam'));
        return $pdf->download('laporan_pinjaman.pdf');
    }
}
