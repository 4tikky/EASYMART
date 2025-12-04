<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pendaftaran Penjual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #10b981;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .store-info {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #10b981;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            background-color: #fbbf24;
            color: #78350f;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EasyMart</h1>
        <p>Platform Marketplace Terpercaya</p>
    </div>
    
    <div class="content">
        <p>Halo, <strong>{{ $seller->picName }}</strong>!</p>

        <p>
            Terima kasih telah mendaftar sebagai penjual di <strong>EasyMart</strong>. 
            Kami telah menerima data pendaftaran toko Anda.
        </p>

        <div class="store-info">
            <h3 style="margin-top: 0; color: #10b981;">📦 Informasi Toko</h3>
            <table style="width: 100%;">
                <tr>
                    <td><strong>Nama Toko</strong></td>
                    <td>: {{ $seller->storeName }}</td>
                </tr>
                <tr>
                    <td><strong>Penanggung Jawab</strong></td>
                    <td>: {{ $seller->picName }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>: {{ $seller->picEmail }}</td>
                </tr>
                <tr>
                    <td><strong>No. HP</strong></td>
                    <td>: {{ $seller->picPhone }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>: <span class="status-badge">MENUNGGU PERSETUJUAN</span></td>
                </tr>
            </table>
        </div>

        <p>
            <strong>⏳ Proses Selanjutnya:</strong>
        </p>
        <ol>
            <li>Tim kami akan melakukan <strong>verifikasi data</strong> Anda</li>
            <li>Proses verifikasi membutuhkan waktu <strong>1-3 hari kerja</strong></li>
            <li>Anda akan menerima <strong>email notifikasi</strong> hasil verifikasi</li>
            <li>Setelah disetujui, Anda dapat langsung <strong>mengelola toko</strong> Anda</li>
        </ol>

        <p>
            Jika ada pertanyaan, silakan hubungi tim support kami.
        </p>

        <p style="margin-top: 30px;">
            Salam hangat,<br>
            <strong>Tim EasyMart</strong>
        </p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} EasyMart. All rights reserved.</p>
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>
