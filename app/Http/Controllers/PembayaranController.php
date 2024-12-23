<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PembayaranBerhasil;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function kirimEmailPembayaran($user, $paymentDetails)
{
    $data = [
        'name' => $user->name,
        'transaction_id' => $paymentDetails->id,
        'amount' => $paymentDetails->amount,
        'date' => $paymentDetails->created_at->format('d M Y H:i'),
    ];

    Mail::to($user->email)->send(new PembayaranBerhasil($data));

    return response()->json(['message' => 'Email pembayaran berhasil dikirim!']);
}
}
