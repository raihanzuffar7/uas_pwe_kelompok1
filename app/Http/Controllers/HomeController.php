<?php

namespace App\Http\Controllers;

use App\Models\PinjamModel;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil data jumlah peminjaman per bulan
        $dataPeminjaman = PinjamModel::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Labels dan Values untuk Chart.js
        $labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $values = array_fill(0, 12, 0);

        // Memasukkan data peminjaman per bulan ke dalam array sesuai index bulan
        foreach ($dataPeminjaman as $bulan => $total) {
            $values[$bulan - 1] = $total;
        }

        // Debugging: pastikan data yang dikirim ke view benar
        // dd($dataPeminjaman, $labels, $values); // hapus ini jika sudah tidak diperlukan

        return view('view_home', compact('labels', 'values'));
    }
}