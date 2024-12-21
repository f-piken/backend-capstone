<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'tb_mahasiswa'; // Nama tabel
    public $timestamps = false;
    protected $fillable = [
        'nim',
        'nama',
        'alamat',
        'tempat', 
        'tgl_lahir',
        'email',
        'status_pembayaran',
    ];
}
