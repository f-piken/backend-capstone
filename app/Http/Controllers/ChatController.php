<?php

namespace App\Http\Controllers;

use App\Models\BuatChat;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function approveChat($id)
    {
        $chat = BuatChat::find($id);

        if (!$chat) {
            return response()->json([
                'message' => 'Chat tidak ditemukan.'
            ], 404);
        }

        $adminId = Auth::id();

        $chat->status = 'berlangsung';
        $chat->id_admin = $adminId;
        $chat->save();

        return response()->json([
            'message' => 'Chat berhasil disetujui oleh admin.',
            'chat' => $chat
        ], 200);
    }
    public function endChat($id)
    {
        // Cari chat berdasarkan ID
        $chat = BuatChat::find($id);

        if (!$chat) {
            return response()->json([
                'message' => 'Chat tidak ditemukan.'
            ], 404);
        }

        $adminId = Auth::id();

        $chat->status = 'berakhir';
        $chat->id_admin = $adminId;
        $chat->save();

        return response()->json([
            'message' => 'Chat berhasil disetujui oleh admin.',
            'chat' => $chat
        ], 200);
    }

    public function getChatsByStatus(Request $request)
    {
        $status = $request->query('status', 'menunggu');

        $chats = BuatChat::where('status', $status)->get();

        return response()->json($chats);
    }

    public function mulaiChat(Request $request)
    {
        $request->validate([
            'pengirim' => 'required|string',
        ]);

        $chat = BuatChat::create([
            'pengirim' => $request->pengirim,
            'status' => "menunggu",
        ]);
        
        return response()->json([
            'message' => 'Message sent successfully.',
            'chat' => $chat,
        ], 201);
    }
    public function messageUser(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'id_chat' => 'required',
        ]);

        $acc = BuatChat::where('pengirim', $request->id_chat)->first();
        if (!$acc) {
            return response()->json([
                'message' => 'Data buat_chat tidak ditemukan untuk pengirim tersebut.',
            ], 404);
        }
        // Simpan pesan ke database Chat
        $chat = Chat::create([
            'message' => $request->message,
            'id_chat' => $acc->id,
            'pengirim' => 'user',
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
            'id_chat' => 'required',
        ]);
        $acc = BuatChat::where('pengirim', $request->id_chat)->first();
        if (!$acc) {
            return response()->json([
                'message' => 'Data buat_chat tidak ditemukan untuk pengirim tersebut.',
            ], 404);
        }
        $sender = "admin";

        $chat = Chat::create([
            'message' => $request->message,
            'id_chat' => $acc->id,
            'pengirim' => $sender,
        ]);
    
        return response()->json([
            'message' => 'Message sent successfully.',
            'chat' => $chat,
        ], 201);
    }

    public function getMessages($pengirim)
    {

        $buatChat = BuatChat::where('pengirim', $pengirim)
                       ->first();

        if (!$buatChat) {
            return response()->json([], 200);
        }

        $chats = Chat::where('id_chat', $buatChat->id)
                     ->latest()
                     ->take(10)
                     ->get();

        if ($chats->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($chats, 200);
    }
}
