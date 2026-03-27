<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Bazar Salad">
    
    <title>Bazar Salad - POS System</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --bg: #f8fafc;
            --text: #1e293b;
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            margin: 0;
            color: var(--text);
            overflow-x: hidden;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }

        /* --- SPLASH SCREEN --- */
        #splash-screen {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            color: white;
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .splash-logo {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* --- MAIN LAYOUT --- */
        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            padding-top: env(safe-area-inset-top); /* Untuk iPhone modern */
        }

        .header-app {
            background: linear-gradient(135deg, #6366f1 0%, #4361ee 100%);
            margin: -20px -20px 30px -20px;
            padding: 40px 25px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            color: white;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
        }

        .total-label { font-size: 14px; opacity: 0.9; }
        .total-amount { font-size: 32px; font-weight: 800; display: block; margin-top: 5px; }

        .card {
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            margin-bottom: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        h2 { font-size: 18px; margin-top: 0; display: flex; align-items: center; gap: 10px; }

        label { display: block; margin-top: 15px; font-size: 13px; font-weight: 600; color: #64748b; }

        input, select {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: #f1f5f9;
            font-size: 16px;
            font-family: inherit;
            transition: all 0.3s;
            -webkit-user-select: text;
        }

        input:focus { outline: none; border-color: var(--primary); background: white; box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1); }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 16px;
            width: 100%;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 25px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .btn-submit:active { transform: scale(0.96); opacity: 0.9; }

        /* --- TABLE & LIST --- */
        .table-container { margin-top: 10px; }
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .history-item:last-child { border: none; }
        .item-info span { display: block; }
        .item-name { font-weight: 600; font-size: 15px; }
        .item-date { font-size: 11px; color: #94a3b8; }
        .item-price { font-weight: 700; color: var(--text); }
        .badge {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 800;
        }
        .qris { background: #dcfce7; color: #166534; }
        .cash { background: #f1f5f9; color: #475569; }

        /* --- MODAL QRIS --- */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999;
        }
        .modal-card {
            background: white;
            width: 85%;
            max-width: 350px;
            border-radius: 30px;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        .qris-frame {
            background: white;
            padding: 10px;
            border: 2px solid #f1f5f9;
            border-radius: 20px;
            margin: 20px 0;
        }
        .qris-img { width: 100%; border-radius: 10px; }
    </style>
</head>
<body>

<div id="splash-screen">
    <div class="splash-logo">🥗</div>
    <h1 style="margin: 0; letter-spacing: 2px;">SALAD POS</h1>
    <p style="opacity: 0.7; font-weight: 400;">Bazar Edition v1.0</p>
</div>

<div class="container">
    
    <div class="header-app">
        <span class="total-label">Total Pendapatan Hari Ini</span>
        <span class="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
    </div>

    <div class="card">
        <h2><span>📝</span> Entry Transaksi</h2>
        <form action="/tambah" method="POST">
            @csrf
            <label>NAMA PRODUK</label>
            <input type="text" name="produk" value="Salad Buah" readonly>

            <label>NOMINAL HARGA (RP)</label>
            <input type="number" name="harga" placeholder="0" required autofocus>

            <label>METODE PEMBAYARAN</label>
            <select name="metode">
                <option value="cash">💵 CASH / TUNAI</option>
                <option value="qris">📱 QRIS / E-WALLET</option>
            </select>

            <button type="submit" class="btn-submit">SIMPAN TRANSAKSI</button>
        </form>
    </div>

    <div class="card">
        <h2><span>🕒</span> Riwayat Terakhir</h2>
        <div class="table-container">
            @foreach($data as $d)
            <div class="history-item">
                <div class="item-info">
                    <span class="item-name">{{ $d->produk }}</span>
                    <span class="item-date">{{ $d->created_at->format('H:i') }} WIB</span>
                </div>
                <div style="text-align: right;">
                    <span class="item-price">Rp {{ number_format($d->harga, 0, ',', '.') }}</span>
                    <span class="badge {{ $d->metode == 'qris' ? 'qris' : 'cash' }}">{{ strtoupper($d->metode) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@if(session('show_qris'))
<div class="modal-overlay" id="qrisModal">
    <div class="modal-card">
        <h3 style="margin: 0;">Scan QRIS</h3>
        <p style="font-size: 14px; color: #64748b;">Total: <b>Rp {{ number_format(session('harga'), 0, ',', '.') }}</b></p>
        
        <div class="qris-frame">
            <img src="{{ asset('img/qris-gopay.jpg') }}" alt="QRIS" class="qris-img">
        </div>
        
        <button onclick="document.getElementById('qrisModal').style.display='none'" 
                style="background: #1e293b; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; width: 100%;">
            Tutup & Selesai
        </button>
    </div>
</div>
@endif

<script>
    // Logic Splash Screen
    window.addEventListener('load', () => {
        setTimeout(() => {
            const splash = document.getElementById('splash-screen');
            splash.style.opacity = '0';
            setTimeout(() => {
                splash.style.display = 'none';
            }, 800);
        }, 2000); // Tampil selama 2 detik
    });
</script>

</body>
</html>