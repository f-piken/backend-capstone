<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran'; // Nama tabel
    protected $fillable = [
        'mhs_id',
        'nama',
        'id_transaksi',
        'nominal',
        'metode_pembayaran',
        'status_pembayaran',
        'created_at',
        'updated_at',
    ];
}
