<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Mail\Pembayaran;
use App\Models\Pembayaran as ModelsPembayaran;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function kirimEmailPembayaran(Request $request)
    {
        $request->validate([
            'user' => 'required|array',
            'paymentDetails' => 'nullable|array',
        ]);

        $bayar = ModelsPembayaran::where('nama', $request->input('user')['nama'])->first();
    
        $user = (object) $request->input('user');
    
        $qrisUrl = $this->generateQris($request)->getData()->payment_url;

        $emailData = [
            'name' => $user->nama,
            'pembayaran_id' => $bayar->id,
            'transaction_id' => "P" . time(),
            'amount' => $bayar->nominal,
            'payment_url' => $qrisUrl,
            'date' => now()->format('d M Y H:i'),
        ];

        Mail::to($user->email)->send(new Pembayaran($emailData));

        return response()->json(['message' => 'Email pembayaran berhasil dikirim!']);
    }

    public function generateQris(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $bayar = ModelsPembayaran::where('nama', $request->input('user')['nama'])->first();
        $mhs = Mahasiswa::where('nama', $request->input('user')['nama'])->first();

    
        // Data transaksi
        $transactionDetails = [
            'order_id' => 'order-' . time(),
            'gross_amount' => $bayar->nominal,
        ];
    
        $customerDetails = [
            'first_name' => $mhs->nama,
            'email' => $mhs->email,
            'phone' => $mhs->no_tlp,
        ];
    
        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];
    
        $snapToken = Snap::getSnapToken($params);
        $paymentUrl = Snap::createTransaction($params)->redirect_url;
    
        return response()->json([
            'message' => 'QRIS berhasil dibuat!',
            'snap_token' => $snapToken,
            'payment_url' => $paymentUrl,
        ]);
    }
}
