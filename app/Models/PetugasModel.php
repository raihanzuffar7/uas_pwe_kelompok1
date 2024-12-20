<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasModel extends Model
{
    use HasFactory;
    protected $table        = "petugas";
    protected $primaryKey   = "id_petugas";

    public $incrementing = true; // Menentukan bahwa primary key auto increment
    protected $keyType = 'int'; // Jenis data primary key

    protected $fillable     = ['nama_petugas','hp','user_id'];
}
