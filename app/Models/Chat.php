<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat'; // Nama tabel

    protected $fillable = [
        'pengirim',
        'id_admin',
        'status',
        'created_at',
        'updated_at',
    ];

    public function chats()
    {
        return $this->hasMany(ChatDetail::class, 'id_chat');
    }
    
}
