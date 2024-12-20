<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BukuModel;
use Illuminate\Support\Facades\Log;

class BukuController extends Controller
{
    // method untuk tampil data buku
    public function bukutampil()
    {
        $databuku = BukuModel::orderby('kode_buku', 'ASC')->paginate(8);
        // if (Auth::user()->role === 'admin') {
        //     // Admin melihat semua data buku
        //     $databuku = BukuModel::orderby('kode_buku', 'ASC')->paginate(6);
        // } else {
        //     // User hanya melihat data buku miliknya
        //     $databuku = BukuModel::where('user_id', Auth::id())
        //         ->orderby('kode_buku', 'ASC')
        //         ->paginate(6);
        // }
        return view('halaman/view_buku', ['buku' => $databuku]);
    }

    // method untuk tambah data buku
    public function bukutambah(Request $request)
    {
        // Validasi data input
        $this->validate($request, [
            'kode_buku' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'kategori' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'status' => 'required', // Validasi status
        ]);

        // Inisialisasi $gambarPath dengan null
        $gambarPath = null;

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('public/images'); // Menyimpan gambar di folder storage/app/public/images
        }

        // Tambah data buku baru
        BukuModel::create([
            'kode_buku' => $request->kode_buku,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'kategori' => $request->kategori,
            'gambar' => $gambarPath, // Menyimpan path gambar
            'user_id' => Auth::user()->id, // Menyimpan ID user yang sedang login
            'status' => $request->status, // Menyimpan status
        ]);

        // Debug log
        Log::info('Data buku berhasil ditambahkan oleh User ID: ' . Auth::user()->id);

        // Redirect kembali ke halaman buku dengan pesan sukses
        return redirect('/' . Auth::user()->role . '/buku')->with('success', 'Data buku berhasil ditambahkan!');
    }

    // method untuk hapus data buku
    public function bukuhapus($id_buku)
    {
        $databuku = BukuModel::find($id_buku);

        // Hapus gambar jika ada
        if ($databuku->gambar && file_exists(storage_path('app/' . $databuku->gambar))) {
            unlink(storage_path('app/' . $databuku->gambar)); // Menghapus file gambar
        }

        $databuku->delete();

        return redirect()->back();
    }

    // method untuk edit data buku
    public function bukuedit($id_buku, Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'kode_buku' => 'required',
            'judul' => 'required',
            'pengarang' => 'required',
            'kategori' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'status' => 'required', // Validasi status
        ]);

        // Cari data buku berdasarkan ID
        $buku = BukuModel::find($id_buku);

        // Periksa apakah data ditemukan
        if (!$buku) {
            return redirect()->back()->with('error', 'Data buku tidak ditemukan.');
        }

        // Proses upload gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($buku->gambar && file_exists(storage_path('app/' . $buku->gambar))) {
                unlink(storage_path('app/' . $buku->gambar)); // Menghapus file gambar lama
            }

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('public/images');
        } else {
            // Jika tidak ada gambar baru, tetap gunakan gambar lama
            $gambarPath = $buku->gambar;
        }

        // Update data buku
        $buku->kode_buku = $request->kode_buku;
        $buku->judul = $request->judul;
        $buku->pengarang = $request->pengarang;
        $buku->kategori = $request->kategori;
        $buku->gambar = $gambarPath; // Menyimpan path gambar (baru atau lama)
        $buku->status = $request->status; // Menyimpan status
        $buku->save();

        // Redirect dengan pesan sukses
        return redirect('/' . Auth::user()->role . '/buku')->with('success', 'Data buku berhasil diperbarui.');
    }
}
