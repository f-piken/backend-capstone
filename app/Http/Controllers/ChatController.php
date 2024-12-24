<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function approveChat($id)
    {
        $chat = Chat::find($id);

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
        $chat = Chat::find($id);

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

        $chats = Chat::where('status', $status)->get();

        return response()->json($chats);
    }

    public function mulaiChat(Request $request)
    {
        $request->validate([
            'pengirim' => 'required|string',
        ]);

        $chat = Chat::create([
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

        $acc = Chat::where('pengirim', $request->id_chat)->first();
        if (!$acc) {
            return response()->json([
                'message' => 'Data chat tidak ditemukan untuk pengirim tersebut.',
            ], 404);
        }
        // Simpan pesan ke database ChatDetail
        $chat = ChatDetail::create([
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
        $acc = Chat::where('pengirim', $request->id_chat)->first();
        if (!$acc) {
            return response()->json([
                'message' => 'Data chat tidak ditemukan untuk pengirim tersebut.',
            ], 404);
        }
        $sender = "admin";

        $chat = ChatDetail::create([
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

        $Chat = Chat::where('pengirim', $pengirim)
                       ->first();

        if (!$Chat) {
            return response()->json([], 200);
        }

        $chats = ChatDetail::where('id_chat', $Chat->id)
                     ->latest()
                     ->take(10)
                     ->get();

        if ($chats->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($chats, 200);
    }
}
