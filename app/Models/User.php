<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
}