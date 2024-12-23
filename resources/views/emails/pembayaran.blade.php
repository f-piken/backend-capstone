<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Berhasil</title>
</head>
<body>
    <h1>Halo {{ $data['name'] }}</h1>
    <p>Terima kasih telah melakukan pembayaran.</p>
    <p>Detail pembayaran Anda:</p>
    <ul>
        <li>Nomor Transaksi: {{ $data['transaction_id'] }}</li>
        <li>Jumlah: Rp {{ number_format($data['amount'], 0, ',', '.') }}</li>
        <li>Tanggal: {{ $data['date'] }}</li>
    </ul>
    <p>Salam,<br>Tim {{ config('app.name') }}</p>
</body>
</html>
