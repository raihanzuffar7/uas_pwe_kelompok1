<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

//panggil model BukuModel
use App\Models\AnggotaModel;

class AnggotaController extends Controller
{
    //method untuk tampil data anggota
    public function anggotatampil()
    {
        // $dataanggota = AnggotaModel::orderby('id_anggota', 'ASC')
        // ->paginate(5);

        // return view('halaman/view_anggota',['anggota'=>$dataanggota]);

        if (Auth::user()->role === 'admin') {
            // Admin melihat semua data buku
            $dataanggota = AnggotaModel::orderby('nim', 'ASC')->paginate(5);
        } else {
            // User hanya melihat data buku miliknya
            $dataanggota = AnggotaModel::where('user_id', Auth::id())
                ->orderby('nim', 'ASC')
                ->paginate(5);
        }
        return view('halaman/view_anggota',['anggota'=>$dataanggota]);
    }

    //method untuk tambah data anggota
    public function anggotatambah(Request $request)
    {
        $this->validate($request, [
            'nim' => 'required',
            'nama_anggota' => 'required',
            'prodi' => 'required',
            'hp' => 'required'
        ]);

        AnggotaModel::create([
            'nim' => $request->nim,
            'nama_anggota' => $request->nama_anggota,
            'prodi' => $request->prodi,
            'hp' => $request->hp,
            'user_id' => Auth::user()->id
        ]);

        // return redirect('/anggota');
        return redirect('/' . Auth::user()->role .'/anggota')->with('success', 'Data anggota berhasil ditambahkan!');
    }

     //method untuk hapus data anggota
     public function anggotahapus($id_anggota)
     {
         $dataanggota=AnggotaModel::find($id_anggota);
         $dataanggota->delete();

         return redirect()->back();
     }

     //method untuk edit data anggota
    public function anggotaedit($id_anggota, Request $request)
    {
        $this->validate($request, [
            'nim' => 'required',
            'nama_anggota' => 'required',
            'prodi' => 'required',
            'hp' => 'required'
        ]);

        // $id_anggota = AnggotaModel::find($id_anggota);
        // $id_anggota->nim   = $request->nim;
        // $id_anggota->nama_anggota      = $request->nama_anggota;
        // $id_anggota->prodi  = $request->prodi;
        // $id_anggota->hp   = $request->hp;

        // $id_anggota->save();

        // return redirect()->back();

        // Cari data anggota berdasarkan ID
        $anggota = AnggotaModel::find($id_anggota);

        // Periksa apakah data ditemukan
        if (!$anggota) {
            return redirect()->back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Update data buku
        $anggota->nim = $request->nim;
        $anggota->nama_anggota = $request->nama_anggota;
        $anggota->prodi = $request->prodi;
        $anggota->hp = $request->hp;
        $anggota->save();

        // Redirect dengan pesan sukses
        // return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
        return redirect('/' . Auth::user()->role .'/anggota')->with('success', 'Data anggota berhasil diperbarui.');

    }
}
