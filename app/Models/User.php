<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name', 'username', 'password', 'role',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey(); // ID user sebagai identifier
    }

    public function getJWTCustomClaims()
    {
        return []; // Custom claims bisa diatur di sini jika diperlukan
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }
}