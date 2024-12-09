<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat'; // Nama tabel
    protected $fillable = [
        'message',
        'pengirim',
        'created_at',
        'updated_at',
    ];

}