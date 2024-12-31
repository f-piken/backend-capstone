<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal'; // Nama tabel
    public $timestamps = false;
    protected $fillable = [
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'mata_kuliah',
        'ruang',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'mahasiswa_id');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
    
}
