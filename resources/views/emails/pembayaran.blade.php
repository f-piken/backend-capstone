<!DOCTYPE html>
<html>
<head>
    <title>Instruksi Pembayaran</title>
</head>
<body>
    <h1>Halo {{ $data['name'] }}</h1>
    <p>Berikut adalah detail pembayaran Anda:</p>
    <ul>
        <li>Nomor Transaksi: {{ $data['transaction_id'] }}</li>
        <li>Jumlah: Rp {{ number_format($data['amount'], 0, ',', '.') }}</li>
        <li>Tanggal: {{ $data['date'] }}</li>
    </ul>
    <p>Silakan gunakan QRIS di bawah ini untuk pembayaran:</p>
    <div style="text-align: center;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $data['payment_url'] }}&size=200x200" 
             alt="QRIS" 
             style="border: 1px solid #ccc; padding: 10px;">
    </div>
    <p>Atau klik tautan ini untuk melanjutkan pembayaran:</p>
    <a href="{{ $data['payment_url'] }}">{{ $data['payment_url'] }}</a>
    <p>Salam,<br>Tim {{ config('app.name') }}</p>
</body>
</html>

