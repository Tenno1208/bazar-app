<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Bazar Salad">
        <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Bazar Salad Buah - Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 20px;
            margin: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        h1, h2 {
            margin-top: 0;
            color: #1a5edb;
        }

        .total-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #2c7be5;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-sizing: border-box; /* Biar gak luber */
        }

        button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background: #2c7be5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #1a5edb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #f8f9fa;
            color: #666;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .bg-qris { background: #e3f2fd; color: #0d47a1; }
        .bg-cash { background: #e8f5e9; color: #1b5e20; }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 20px;
            max-width: 350px;
            width: 90%;
            text-align: center;
            animation: slideUp 0.3s ease-out;
        }
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .qris-img {
            width: 100%;
            border: 1px solid #eee;
            border-radius: 10px;
            margin: 15px 0;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="card">
        <h1>🥗 Bazar Salad</h1>
        <div class="total-box">
            <span>Total Pendapatan:</span>
            <span class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="card">
        <h2>Entry Transaksi</h2>
        <form action="/tambah" method="POST">
            @csrf
            <label>Produk</label>
            <input type="text" name="produk" value="Salad Buah" readonly style="background: #f9f9f9;">

            <label>Harga (Rp)</label>
            <input type="number" name="harga" placeholder="Contoh: 15000" required autofocus>

            <label>Metode Pembayaran</label>
            <select name="metode">
                <option value="cash">💵 TUNAI (CASH)</option>
                <option value="qris">📱 QRIS / GOPAY</option>
            </select>

            <button type="submit">Konfirmasi & Simpan</button>
        </form>
    </div>

    <div class="card">
        <h2>Riwayat Terakhir</h2>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->produk }}</td>
                        <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $d->metode == 'qris' ? 'bg-qris' : 'bg-cash' }}">
                                {{ $d->metode }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@if(session('show_qris'))
<div class="modal-overlay" id="qrisModal">
    <div class="modal-content">
        <h2 style="color: #333;">Scan untuk Bayar</h2>
        <p style="margin-bottom: 5px;">Total Tagihan:</p>
        <h1 style="color: #2c7be5; margin-top: 0;">Rp {{ number_format(session('harga'), 0, ',', '.') }}</h1>
        
        <img src="{{ asset('img/qris-gopay.jpg') }}" alt="QRIS GOPAY" class="qris-img">
        
        <p style="font-size: 12px; color: #666;">Silahkan tunjukkan QRIS ini kepada pembeli.</p>
        
        <button onclick="document.getElementById('qrisModal').style.display='none'" style="background: #28a745;">
            Selesai / Sudah Bayar
        </button>
    </div>
</div>
@endif

</body>
</html>