<?php

namespace App\Http\Controllers;

use App\Mail\AkunMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Mail\Pembayaran;
use App\Models\Pembayaran as ModelsPembayaran;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Veritrans_Exception;
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

        return response()->json(['message' => 'Email transac$transaction berhasil dikirim!']);
    }

    public function generateQris(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil data transac$transaction dan mahasiswa
        $bayar = ModelsPembayaran::where('nama', $request->input('user')['nama'])->first();
        if (!$bayar) {
            return response()->json(['error' => 'Data transac$transaction tidak ditemukan.'], 404);
        }

        $mhs = Mahasiswa::where('nama', $request->input('user')['nama'])->first();
        if (!$mhs) {
            return response()->json(['error' => 'Data mahasiswa tidak ditemukan.'], 404);
        }

        // Data transaksi
        $transactionDetails = [
            'order_id' => 'order-' . time(),
            'gross_amount' => $bayar->nominal,
        ];

        $bayar->id_transaksi = $transactionDetails['order_id'];
        $bayar->save();
        
        $customerDetails = [
            'first_name' => $mhs->nama,
            'email' => $mhs->email,
            'phone' => $mhs->no_tlp,
        ];

        $enabledPayments = [$bayar->metode_pembayaran];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => $enabledPayments,
        ];

        try {
            $transaction = Snap::createTransaction($params);
            $paymentUrl = $transaction->redirect_url;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat transaksi Midtrans: ' . $e->getMessage()], 500);
        }

        return response()->json([
            'message' => 'Metode transac$transaction berhasil dibuat!',
            'payment_url' => $paymentUrl,
        ]);
    }

    public function __construct()
    {
        // Set konfigurasi Midtrans di sini
        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Ganti dengan server key dari Midtrans
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY'); // Ganti dengan server key dari Midtrans
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false); // Sesuaikan dengan environment Anda
    }

    public function webhook(Request $request)
    {
        try {
            $notif = new Notification();
            $status = $notif->transaction_status ?? null;
            $order_id = $notif->order_id ?? null;
        
            if (!$status || !$order_id) {
                return response()->json(['status' => 'failed', 'message' => 'Invalid webhook data'], 400);
            }
        
            $transaction = ModelsPembayaran::where('id_transaksi', $order_id)->first();
            if ($transaction) {
                $mhs = Mahasiswa::where('nama', $transaction->nama)->first();
                $user = null;
            
                switch ($status) {
                    case 'capture':
                    case 'settlement':
                        $transaction->status_pembayaran = 'LUNAS';
                    
                        // Buat data user jika belum ada
                        $existingUser = User::where('username', $order_id)->first();
                        if (!$existingUser) {
                            $nim = $this->generateNim($order_id);
                            $user = User::create([
                                'name' => $transaction->nama,
                                'username' => $nim,
                                'password' => bcrypt($nim),
                                'role' => 'mahasiswa',
                            ]);
                        } else {
                            $user = $existingUser;
                        }
                    
                        if ($mhs) {
                            $mhs->nim = $nim ?? null;
                            $mhs->user_id = $user->id ?? null;
                            $mhs->save();
                        }

                        // Kirim email
                        if ($user) {
                            $emailData = [
                                'name' => $user->name,
                                'username' => $user->username,
                                'password' => $nim,
                                'date' => now()->format('d M Y H:i'),
                            ];
                            Mail::to($mhs->email)->send(new AkunMahasiswa($emailData));
                        }
                        break;
                    
                    case 'pending':
                    case 'deny':
                        $transaction->status_pembayaran = 'BELUM LUNAS';
                        break;
                    
                    case 'expired':
                        $transaction->status_pembayaran = 'EXPIRED';
                        break;
                    
                    default:
                        $transaction->status_pembayaran = 'UNKNOW';
                        break;
                }
            
                $transaction->save();
                return response()->json(['status' => 'success']);
            }
        
            return response()->json(['status' => 'transaction not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 400);
        }
    }


    private function generateNim($order_id)
    {
        $prefix = '2024'; // Contoh prefix untuk tahun
        $uniqueId = substr($order_id, -6); // Ambil 6 karakter terakhir dari order_id
        return $prefix . $uniqueId;
    }

}

// Kartu Kredit/Debit Dummy Midtrans
// Nomor Kartu: 4811 1111 1111 1114
// Tanggal Kedaluwarsa (Expiry Date): Gunakan tanggal kedaluwarsa di masa depan, misalnya 12/29.
// CVV: 123
// Password Dummy untuk 3D Secure: 112233

// ngrok http 8000
