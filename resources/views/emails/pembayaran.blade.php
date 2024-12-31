<!DOCTYPE html>
<html>
<head>
    <title>Instruksi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
        }
        p {
            margin: 10px 0;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #ecf0f1;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #7f8c8d;
        }
        .qris {
            text-align: center;
            margin: 20px 0;
        }
        .qris img {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Halo {{ $data['name'] }}!</h1>
    <p>Terima kasih telah memilih layanan kami. Berikut adalah detail pembayaran Anda:</p>
    
    <h3>Detail Pembayaran:</h3>
    <ul>
        <li><strong>Nomor Transaksi:</strong> {{ $data['transaction_id'] }}</li>
        <li><strong>Jumlah:</strong> Rp {{ number_format($data['amount'], 0, ',', '.') }}</li>
        <li><strong>Tanggal:</strong> {{ $data['date'] }}</li>
    </ul>

    <h3>Panduan Pembayaran:</h3>
    <p>Silakan gunakan QRIS di bawah ini untuk melakukan pembayaran:</p>
    <div class="qris">
        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($data['payment_url']) }}&size=200x200" 
             alt="QRIS">
    </div>

    <p>Jika Anda tidak dapat menggunakan QRIS, klik tautan berikut untuk melanjutkan pembayaran:</p>
    <p><a href="{{ $data['payment_url'] }}">{{ $data['payment_url'] }}</a></p>

    <h3>Petunjuk Pembayaran:</h3>
    <ol>
        <li>Buka aplikasi e-wallet atau perbankan yang mendukung QRIS.</li>
        <li>Pindai kode QR di atas menggunakan aplikasi tersebut.</li>
        <li>Konfirmasi jumlah yang ditampilkan di aplikasi.</li>
        <li>Selesaikan pembayaran dan simpan bukti pembayaran Anda.</li>
    </ol>

    <p>Jika Anda memiliki pertanyaan atau mengalami kesulitan, silakan hubungi tim dukungan kami melalui email atau pusat bantuan.</p>
    
    <p>Salam hangat,<br>Tim {{ config('app.name') }}</p>
    
    <div class="footer">
        <p>Email ini dibuat secara otomatis, harap tidak membalas langsung. Jika membutuhkan bantuan, kunjungi pusat bantuan kami.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua Hak Dilindungi.</p>
    </div>
</body>
</html>
