@extends('index')
@section('title', 'Home')

@section('isihalaman')
    <h3>Pengertian perpustakaan menurut para ahli</h3>
    <p>
        <h4>Perpustakaan</h4>
        Perpustakaan Perguruan Tinggi merupakan unit kerja pelaksana teknis (UPT) Perguruan Tinggi yang bersama-sama
        dengan unit lain turut melaksanakan Tri Dharma Perguruan Tinggi, yaitu: pendidikan, penelitian, dan pengabdian
        kepada masyarakat dengan cara memilah, menghimpun, mengolah, merawat, serta menyebarluaskan sumber informasi kepada
        lembaga induknya pada khususnya dan sivitas akademika pada umumnya. Kelima tugas tersebut dilaksanakan dengan
        tata cara administrasi dan organisasi yang berlaku bagi penyelenggaraan sebuah perpustakaan.
    </p>

    <!-- Menampilkan Grafik -->
    <div>
        <canvas id="chartPeminjaman" width="400" height="200"></canvas>
    </div>

    <!-- Tambahkan Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data dari Controller yang di-pass melalui Blade
        const labels = @json($labels);
        const dataValues = @json($values);

        // Konfigurasi Chart.js
        const ctx = document.getElementById('chartPeminjaman').getContext('2d');
        const chartPeminjaman = new Chart(ctx, {
            type: 'bar', // Menggunakan chart batang
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman per Bulan',
                    data: dataValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)', // Warna batang grafik
                    borderColor: 'rgba(54, 162, 235, 1)', // Warna garis pinggir grafik
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Peminjaman'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                }
            }
        });
    </script>
@endsection