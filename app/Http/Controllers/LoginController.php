<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        // Cek kredensial untuk otentikasi
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Coba login dengan menggunakan API guard
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Ambil user yang berhasil login
        $user = auth('api')->user();

        // Kembalikan response dengan token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60, // TTL dalam detik
            'role' => $user->role,
        ]);
    }

    public function me()
    {
        // Mengembalikan data user yang sedang login
        return response()->json(auth()->user());
    }
}
