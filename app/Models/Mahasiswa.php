<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $fillable = [
        'user_id',
        'nim',
        'nisn',
        'nama',
        'alamat',
        'tempat', 
        'tgl_lahir',
        'email',
        'no_tlp',
        'created_at',
        'updated_at',
    ];
}
