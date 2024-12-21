<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'tb_pembayaran'; // Nama tabel
    public $timestamps = false;
    protected $fillable = [
        'nim',
        'nama',
        'nominal',
        'metode_pembayaran',
        'status_pembayaran',
    ];
}
