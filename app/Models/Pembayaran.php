<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran'; // Nama tabel
    public $timestamps = false;
    protected $fillable = [
        'mhs_id',
        'nama',
        'nominal',
        'metode_pembayaran',
        'status_pembayaran',
    ];
}
