<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatDetail extends Model
{
    use HasFactory;

    protected $table = 'chat_detail'; // Nama tabel
    protected $fillable = [
        'message',
        'pengirim',
        'id_chat',
        'created_at',
        'updated_at',
    ];
    public function acc()
    {
        return $this->belongsTo(Chat::class, 'id_chat');
    }
}
