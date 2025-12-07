<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Penjual Diterima</title>
</head>
<body>
    <p>Assalamualaikum, {{ $seller->picName }}.</p>

    <p>
        Pendaftaran akun penjual Anda di <strong>EasyMart</strong>
        telah <strong>DITERIMA</strong>.
    </p>

    <p>
        Anda sekarang dapat login ke EasyMart menggunakan email:
        <strong>{{ $seller->user->email }}</strong> dan mulai mengelola toko
        <strong>{{ $seller->storeName }}</strong>.
    </p>

    <p>Terima kasih telah bergabung dengan EasyMart.</p>

    <p>Salam,<br>Tim EasyMart</p>
</body>
</html>
