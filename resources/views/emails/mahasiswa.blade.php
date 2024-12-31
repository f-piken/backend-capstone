<!DOCTYPE html>
<html>
<head>
    <title>Informasi Akun Mahasiswa</title>
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
    </style>
</head>
<body>
    <h1>Halo {{ $data['name'] }}!</h1>
    <p>Terima kasih telah menyelesaikan pembayaran Anda. Kami dengan senang hati memberikan informasi akun mahasiswa yang dapat Anda gunakan untuk mengakses layanan kami.</p>
    
    <h3>Detail Akun Mahasiswa Anda:</h3>
    <ul>
        <li><strong>Nama:</strong> {{ $data['name'] }}</li>
        <li><strong>Username:</strong> {{ $data['username'] }}</li>
        <li><strong>Password:</strong> {{ $data['password'] }}</li>
    </ul>

    <p>Untuk login, silakan klik tautan di bawah ini atau salin URL ke browser Anda:</p>
    <p><a href="http://localhost:3000/login">http://localhost:3000/login</a></p>
    
    <h3>Petunjuk Awal:</h3>
    <p>Setelah login, Anda dapat melakukan beberapa hal berikut:</p>
    <ul>
        <li>Memperbarui profil Anda.</li>
        <li>Mengakses layanan akademik.</li>
        <li>Melihat riwayat pembayaran dan status.</li>
    </ul>

    <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami melalui email atau layanan pelanggan di sistem kami.</p>
    
    <p>Salam hangat,<br>Tim {{ config('app.name') }}</p>
    
    <div class="footer">
        <p>Email ini dibuat otomatis, harap tidak membalas langsung. Untuk bantuan, kunjungi pusat bantuan kami.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua Hak Dilindungi.</p>
    </div>
</body>
</html>
