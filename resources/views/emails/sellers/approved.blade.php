<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Penjual Diterima</title>
</head>
<body>
    <p>Assalamualaikum, {{ $user->name }}.</p>

    <p>
        Pendaftaran akun penjual Anda di <strong>EasyMart</strong>
        telah <strong>DITERIMA</strong>.
    </p>

    <p>
        Anda sekarang dapat login ke EasyMart menggunakan email:
        <strong>{{ $user->email }}</strong> dan mulai mengelola toko
        <strong>{{ $user->nama_toko }}</strong>.
    </p>

    <p>Terima kasih telah bergabung dengan EasyMart.</p>

    <p>Salam,<br>Tim EasyMart</p>
</body>
</html>
