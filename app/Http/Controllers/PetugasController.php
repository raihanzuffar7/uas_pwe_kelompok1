<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

//panggil model Petugas
use App\Models\PetugasModel;

class PetugasController extends Controller
{
    //method untuk tampil data Petugas
    public function petugastampil()
    {
        // $datapetugas = PetugasModel::orderby('id_petugas', 'ASC')
        // ->paginate(5);

        // return view('halaman/view_petugas',['petugas'=>$datapetugas]);

        if (Auth::user()->role === 'admin') {
            // Admin melihat semua data buku
            $datapetugas = PetugasModel::orderby('nama_petugas', 'ASC')->paginate(5);
        } else {
            // User hanya melihat data buku miliknya
            $datapetugas = PetugasModel::where('user_id', Auth::id())
                ->orderby('nama_petugas', 'ASC')
                ->paginate(5);
        }
        return view('halaman/view_petugas',['petugas'=>$datapetugas]);
    }

    //method untuk tambah data petugas
    public function petugastambah(Request $request)
    {
        $this->validate($request, [
            'nama_petugas' => 'required',
            'hp' => 'required'
        ]);

        PetugasModel::create([
            'nama_petugas' => $request->nama_petugas,
            'hp' => $request->hp,
            'user_id' => Auth::user()->id
        ]);

        // return redirect('/petugas');

        return redirect('/' . Auth::user()->role .'/petugas')->with('success', 'Data petugas berhasil ditambahkan!');
    }

     //method untuk hapus data petugas
     public function petugashapus($id_petugas)
     {
         $datapetugas=PetugasModel::find($id_petugas);
         $datapetugas->delete();

         return redirect()->back();
     }

     //method untuk edit data petugas
    public function petugasedit($id_petugas, Request $request)
    {
        $this->validate($request, [
            'nama_petugas' => 'required',
            'hp' => 'required'
        ]);

        $id_petugas = PetugasModel::find($id_petugas);
        $id_petugas->nama_petugas      = $request->nama_petugas;
        $id_petugas->hp   = $request->hp;

        $id_petugas->save();

        return redirect()->back();

        // Cari data anggota berdasarkan ID
        $id_petugas = PetugasModel::find($id_petugas);

        // Periksa apakah data ditemukan
        if (!$petugas) {
            return redirect()->back()->with('error', 'Data petugas tidak ditemukan.');
        }

        // Update data petugas
        $petugas->nama_petugas = $request->nama_petugas;
        $petugas->hp = $request->hp;
        $petugas->save();

        // Redirect dengan pesan sukses
        // return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
        return redirect('/' . Auth::user()->role .'/petugas')->with('success', 'Data petugas berhasil diperbarui.');

    }
}
