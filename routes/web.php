<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', [HomeController::class, 'index']);


Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth', 'user-access:user'])->prefix('user')->group(function () {
    //Route untuk Data Buku
    // Route::get('/buku', 'BukuController@bukutampil');
    // Route::post('/buku/tambah','BukuController@bukutambah');
    // Route::get('/buku/hapus/{id_buku}','BukuController@bukuhapus');
    // Route::put('/buku/edit/{id_buku}', 'BukuController@bukuedit');

    Route::get('/buku', [BukuController::class, 'bukutampil'])->name('buku.index');
    Route::post('/buku/tambah', [BukuController::class, 'bukutambah'])->name('buku.tambah');
    Route::put('/buku/edit/{id_buku}', [BukuController::class, 'bukuedit'])->name('buku.edit');

    //Route untuk Data Buku
    Route::get('/home', function () {
        return view('view_home');
    });

    //Route untuk Data Anggota
    // Route::get('/anggota', 'AnggotaController@anggotatampil');
    // Route::post('/anggota/tambah', 'AnggotaController@anggotatambah');
    // Route::get('/anggota/hapus/{id_anggota}', 'AnggotaController@anggotahapus');
    // Route::put('/anggota/edit/{id_anggota}', 'AnggotaController@anggotaedit');

    Route::get('/anggota', [AnggotaController::class, 'anggotatampil'])->name('anggota.index');
    Route::post('/anggota/tambah', [AnggotaController::class, 'anggotatambah'])->name('anggota.tambah');
    Route::put('/anggota/edit/{id_anggota}', [AnggotaController::class, 'anggotaedit'])->name('anggota.edit');

    //Route untuk Data Petugas
    // Route::get('/petugas', 'PetugasController@petugastampil');
    // Route::post('/petugas/tambah', 'PetugasController@petugastambah');
    // Route::get('/petugas/hapus/{id_petugas}', 'PetugasController@petugashapus');
    // Route::put('/petugas/edit/{id_petugas}', 'PetugasController@petugasedit');

    Route::get('/petugas', [PetugasController::class, 'petugastampil'])->name('petugas.index');
    Route::post('/petugas/tambah', [PetugasController::class, 'petugastambah'])->name('petugas.tambah');
    Route::put('/petugas/edit/{id_petugas}', [PetugasController::class, 'petugasedit'])->name('petugas.edit');

    //Route untuk Data Peminjaman
    // Route::get('/pinjam', 'PinjamController@pinjamtampil');
    // Route::post('/pinjam/tambah','PinjamController@pinjamtambah');
    // Route::get('/pinjam/hapus/{id_pinjam}','PinjamController@pinjamhapus');
    // Route::put('/pinjam/edit/{id_pinjam}', 'PinjamController@pinjamedit');

    Route::get('/pinjam', [PinjamController::class, 'pinjamtampil'])->name('pinjam.index');
    Route::post('/pinjam/tambah', [PinjamController::class, 'pinjamtambah'])->name('pinjam.tambah');
    Route::put('/pinjam/edit/{id_pinjam}', [PinjamController::class, 'pinjamedit'])->name('pinjam.edit');

    // Route untuk halaman laporan
    Route::get('/laporanpeminjaman', [PinjamController::class, 'laporanPinjam'])->name('laporan.pinjam');

    // Route untuk mengunduh laporan dalam format PDF
    Route::get('/laporan/pinjaman/pdf', [PinjamController::class, 'laporanPinjamPDF'])->name('laporan.pinjam.pdf');

    Route::get('/home', [HomeController::class, 'index']);
});

Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
    //Route untuk Data Buku
    // Route::get('/buku', 'BukuController@bukutampil');
    // Route::post('/buku/tambah','BukuController@bukutambah');
    // Route::get('/buku/hapus/{id_buku}','BukuController@bukuhapus');
    // Route::put('/buku/edit/{id_buku}', 'BukuController@bukuedit');
    Route::get('/buku', [BukuController::class, 'bukutampil'])->name('buku.index');
    Route::post('/buku/tambah', [BukuController::class, 'bukutambah'])->name('buku.tambah');
    Route::delete('/buku/hapus/{id_buku}', [BukuController::class, 'bukuhapus'])->name('buku.hapus');
    Route::put('/buku/edit/{id_buku}', [BukuController::class, 'bukuedit'])->name('buku.edit');

    //Route untuk Data Buku
    Route::get('/home', function () {
        return view('view_home');
    });

    //Route untuk Data Anggota
    // Route::get('/anggota', 'AnggotaController@anggotatampil');
    // Route::post('/anggota/tambah', 'AnggotaController@anggotatambah');
    // Route::get('/anggota/hapus/{id_anggota}', 'AnggotaController@anggotahapus');
    // Route::put('/anggota/edit/{id_anggota}', 'AnggotaController@anggotaedit');

    Route::get('/anggota', [AnggotaController::class, 'anggotatampil'])->name('anggota.index');
    Route::post('/anggota/tambah', [AnggotaController::class, 'anggotatambah'])->name('anggota.tambah');
    Route::delete('/anggota/hapus/{id_anggota}', [AnggotaController::class, 'anggotahapus'])->name('anggota.hapus');
    Route::put('/anggota/edit/{id_anggota}', [AnggotaController::class, 'anggotaedit'])->name('anggota.edit');

    //Route untuk Data Petugas
    // Route::get('/petugas', 'PetugasController@petugastampil');
    // Route::post('/petugas/tambah', 'PetugasController@petugastambah');
    // Route::get('/petugas/hapus/{id_petugas}', 'PetugasController@petugashapus');
    // Route::put('/petugas/edit/{id_petugas}', 'PetugasController@petugasedit');

    Route::get('/petugas', [PetugasController::class, 'petugastampil'])->name('petugas.index');
    Route::post('/petugas/tambah', [PetugasController::class, 'petugastambah'])->name('petugas.tambah');
    Route::delete('/petugas/hapus/{id_petugas}', [PetugasController::class, 'petugashapus'])->name('petugas.hapus');
    Route::put('/petugas/edit/{id_petugas}', [PetugasController::class, 'petugasedit'])->name('petugas.edit');

    //Route untuk Data Peminjaman
    // Route::get('/pinjam', 'PinjamController@pinjamtampil');
    // Route::post('/pinjam/tambah','PinjamController@pinjamtambah');
    // Route::get('/pinjam/hapus/{id_pinjam}','PinjamController@pinjamhapus');
    // Route::put('/pinjam/edit/{id_pinjam}', 'PinjamController@pinjamedit');

    Route::get('/pinjam', [PinjamController::class, 'pinjamtampil'])->name('pinjam.index');
    Route::post('/pinjam/tambah', [PinjamController::class, 'pinjamtambah'])->name('pinjam.tambah');
    Route::delete('/pinjam/hapus/{id_pinjam}', [PinjamController::class, 'pinjamhapus'])->name('pinjam.hapus');
    Route::put('/pinjam/edit/{id_pinjam}', [PinjamController::class, 'pinjamedit'])->name('pinjam.edit');

    // Route untuk halaman laporan
    // Route::put('/laporan', 'PinjamController@ViewLaporan');

    Route::get('/laporanpeminjaman', [PinjamController::class, 'laporanPinjam'])->name('laporan.pinjam');

    // Route untuk mengunduh laporan dalam format PDF
    Route::get('/laporan/pinjaman/pdf', [PinjamController::class, 'laporanPinjamPDF'])->name('laporan.pinjam.pdf');

    //Route untuk upload buku
    Route::get('/buku', [BukuController::class, 'bukutampil'])->name('buku.tampil');
    Route::post('/buku/tambah', [BukuController::class, 'bukutambah']);
    Route::put('/buku/edit/{id}', [BukuController::class, 'bukuedit']);
    Route::get('/buku/hapus/{id}', [BukuController::class, 'bukuhapus']);

    Route::get('/home', [HomeController::class, 'index']);
    
});
