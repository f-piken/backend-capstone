<?php

namespace App\Http\Controllers;

use App\Models\Acc;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil status dari query parameter atau set default ke 'menunggu'
        $status = $request->query('status', 'menunggu');

        // Ambil data berdasarkan status chat
        $chat = Chat::where('status', $status)->get();

        // Kirimkan data ke frontend (React)
        return response()->json($chat);
    }

    public function mulaiChat(Request $request){
        
        try{
            $request->validate([
                'pengirim' => 'required|string', // Pastikan sender ada
            ]);
    
            $chat = Acc::create([
                'pengirim' => $request->pengirim, // Gunakan data sender dari request
                'status' => "menunggu", // Gunakan data sender dari request
            ]);
        }catch(ValidationException $e){
            return response()->json(['msg' => $e->getMessage()], 400);
        }

        return response()->json([
            'message' => 'Message sent successfully.',
            'chat' => $chat,
        ], 201);
    }
    public function messageUser(Request $request)
    {
        // Validasi input pesan
        $request->validate([
            'message' => 'required|string|max:500',
            'sender' => 'required|string', // Pastikan sender ada
        ]);
    
        // Ambil data pengirim dari request
        $sender = $request->sender;
    
        // Simpan pesan ke database
        $chat = Chat::create([
            'message' => $request->message,
            'pengirim' => $sender, // Gunakan data sender dari request
        ]);
    
        return response()->json([
            'message' => 'Message sent successfully.',
            'chat' => $chat,
        ], 201);
    }
    public function messageAdmin(Request $request)
    {
        // Validasi input pesan
        $request->validate([
            'message' => 'required|string|max:500',
        ]);
    
        // Ambil data pengirim dari request
        $sender = "admin";

        // Simpan pesan ke database
        $chat = Chat::create([
            'message' => $request->message,
            'pengirim' => $sender, // Gunakan data sender dari request
            'status' => 'menunggu', // Status pesan yang dikirim
        ]);
    
        return response()->json([
            'message' => 'Message sent successfully.',
            'chat' => $chat,
        ], 201);
    }




    public function getMessages()
    {
        // Ambil 10 pesan terakhir
        $chats = Chat::latest()->take(10)->get(); 
        return response()->json($chats, 200);
    }
}
