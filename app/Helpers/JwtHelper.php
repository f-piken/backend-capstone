<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function createToken($payload)
    {
        // Ambil kunci dari file .env
        $key = env('JWT_SECRET');

        // Pastikan kunci adalah string
        if (!is_string($key)) {
            throw new \Exception('Key must be a string.');
        }

        // Tambahkan waktu kadaluarsa
        $payload['exp'] = time() + env('JWT_EXPIRATION', 3600); // Default: 1 jam

        // Encode token
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function verifyToken($token)
    {
        try {
            $key = env('JWT_SECRET');
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return null; // Invalid token
        }
    }
}
