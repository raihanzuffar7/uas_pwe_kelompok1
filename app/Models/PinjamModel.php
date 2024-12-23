<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamModel extends Model
{
    use HasFactory;
    protected $table        = "peminjaman";
    protected $primaryKey   = "id_pinjam";

    public $incrementing = true; // Menentukan bahwa primary key auto increment
    protected $keyType = 'int'; // Jenis data primary key

    // protected $fillable     = ['id_pinjam','id_petugas','id_anggota','id_buku'];

    protected $fillable     = ['id_petugas','id_anggota','id_buku','user_id','judul_buku'];

    //relasi ke petugas
    public function petugas()
    {
        return $this->belongsTo('App\Models\PetugasModel', 'id_petugas');
    }

    //relasi ke siswa
    public function anggota()
    {
        return $this->belongsTo('App\Models\AnggotaModel', 'id_anggota');
    }

    //relasi ke buku
    public function buku()
    {
        return $this->belongsTo('App\Models\BukuModel', 'id_buku');
    }
}
