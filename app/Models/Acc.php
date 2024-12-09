<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acc extends Model
{
    use HasFactory;
    protected $table = 'buat_chat'; // Nama tabel
    public $timestamps = false;

    protected $fillable = [
        'pengirim',
        'status',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_acc');
    }
    
}
