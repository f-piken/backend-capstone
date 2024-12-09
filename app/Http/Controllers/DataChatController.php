<?php

namespace App\Http\Controllers;

use App\Models\Acc;
use Illuminate\Http\Request;

class DataChatController extends Controller
{
    public function mulaiChat(Request $request)
    {
        $request->validate([
            'pengirim' => 'required|string', // Pastikan sender ada
        ]);

        $chat = Acc::create([
            'pengirim' => 'coba', // Gunakan data sender dari request
            'status' => 'menunggu', // Gunakan data sender dari request
        ]);
    }
}
