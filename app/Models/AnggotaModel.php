<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaModel extends Model
{
    use HasFactory;
    protected $table        = "anggota";
    protected $primaryKey   = "id_anggota";

    public $incrementing = true; // Menentukan bahwa primary key auto increment
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable     = ['nim','nama_anggota','prodi','hp', 'user_id'];
}
