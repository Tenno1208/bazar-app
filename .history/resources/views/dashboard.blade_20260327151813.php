<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Bazar App">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    <title>Bazar App - POS System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        :root { --primary: #4361ee; --secondary: #3f37c9; --bg: #f8fafc; --text: #1e293b; }
        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            margin: 0; 
            color: var(--text); 
            user-select: none;
            -webkit-touch-callout: none;
        }

        /* Splash Screen */
        #splash { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: linear-gradient(135deg, var(--primary), var(--secondary)); 
            display: flex; flex-direction: column; align-items: center; justify-content: center; 
            z-index: 10000; color: white; transition: 0.8s; 
        }
        .bounce { animation: bounce 2s infinite; font-size: 80px; }
        @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }

        /* Layout */
        .container { max-width: 500px; margin: auto; padding: 20px; }
        .header { 
            background: linear-gradient(135deg, #6366f1, #4361ee); 
            margin: -20px -20px 25px -20px; padding: 40px 25px; 
            border-radius: 0 0 30px 30px; color: white; 
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2); 
        }

        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 15px; border-radius: 20px; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.03); }
        .stat-val { display: block; font-weight: 800; font-size: 18px; color: var(--primary); }
        
        .card { background: white; padding: 20px; border-radius: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px; }
        
        input, select { 
            width: 100%; padding: 14px; margin-top: 8px; border-radius: 12px; 
            border: 1.5px solid #e2e8f0; background: #f1f5f9; font-size: 16px; 
        }
        
        .btn-submit { 
            background: var(--primary); color: white; border: none; padding: 16px; 
            width: 100%; border-radius: 15px; font-weight: 700; margin-top: 20px; 
            cursor: pointer; box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            transition: 0.3s;
        }
        .btn-submit:active { transform: scale(0.96); }
        .btn-submit:disabled { background: #cbd5e1; cursor: not-allowed; box-shadow: none; }

        .history-item { 
            display: flex; justify-content: space-between; align-items: center; 
            padding: 15px 0; border-bottom: 1px solid #f1f5f9; 
        }
        .badge { font-size: 10px; padding: 4px 8px; border-radius: 6px; font-weight: 800; }
        .qris { background: #dcfce7; color: #166534; }
        .cash { background: #f1f5f9; color: #475569; }

        .btn-del { 
            background: #fff1f2; color: #e11d48; border: none; 
            padding: 8px 12px; border-radius: 10px; margin-left: 10px; font-weight: bold;
        }

        /* Modal QRIS */
        .modal { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.85); backdrop-filter: blur(5px); 
            display: flex; align-items: center; justify-content: center; z-index: 9999; 
        }
        .m-card { background: white; width: 85%; max-width: 350px; border-radius: 30px; padding: 25px; text-align: center; }

        /* Inventory Tool */
        details summary { font-size: 12px; font-weight: 700; color: var(--primary); cursor: pointer; padding: 5px; }
    </style>
</head>
<body>

    <nav style="background: white; padding: 15px 20px; display: flex; justify-content: space-around; align-items: center; box-shadow: 0 2px 15px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid #f1f5f9;">
    <a href="/" style="text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 4px;">
        <span style="font-size: 20px;">🏠</span>
        <span style="font-size: 10px; font-weight: 800; color: var(--primary); letter-spacing: 0.5px;">KASIR</span>
    </a>
    <a href="/laporan-keuntungan" style="text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 4px; opacity: 0.5;">
        <span style="font-size: 20px;">📊</span>
        <span style="font-size: 10px; font-weight: 700; color: var(--text); letter-spacing: 0.5px;">LABA</span>
    </a>
</nav>

<div id="splash">
    <div class="bounce">🥗</div>
    <h1 style="margin:0; letter-spacing: 2px;">BAZAR APP</h1>
    <p style="opacity: 0.6">Point of Sale v1.0</p>
</div>

<div class="container">
    <div class="header">
        <small style="opacity: 0.8">Total Pendapatan</small>
        <h1 style="margin:5px 0 0 0; font-size: 32px;">Rp {{ number_format($total, 0, ',', '.') }}</h1>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <small style="color:#64748b; font-size: 10px; text-transform: uppercase;">Sisa Stok</small>
            <span class="stat-val" style="color: {{ $stok <= 5 ? '#e11d48' : '#4361ee' }}">{{ $stok }} Porsi</span>
        </div>
        <div class="stat-card">
            <small style="color:#64748b; font-size: 10px; text-transform: uppercase;">Via QRIS</small>
            <span class="stat-val">{{ $countQris }}</span>
        </div>
    </div>

    <details class="card" style="padding: 10px; margin-bottom: 20px; border: none; background: #f1f5f9;">
        <summary>⚙️ Atur Stok Awal</summary>
        <form action="/update-stok" method="POST" style="display: flex; gap: 10px; margin-top: 10px;">
            @csrf
            <input type="number" name="stok" value="{{ $stok }}" style="padding: 8px; margin: 0;">
            <button type="submit" class="btn-submit" style="margin: 0; width: auto; padding: 0 15px; font-size: 12px;">Update</button>
        </form>
    </details>

    <div class="card">
        <h3 style="margin:0 0 15px 0">📝 Baru</h3>
        <form action="/tambah" method="POST">
            @csrf
            <input type="hidden" name="produk" value="Salad Buah">

            <label style="font-size:12px; font-weight:700; color:#64748b">HARGA MODAL (RP)</label>
        <input type="number" name="modal" placeholder="Contoh: 5000" required>
            
            <label style="font-size:12px; font-weight:700; color:#64748b">HARGA JUAL (RP)</label>
            <input type="number" name="harga" placeholder="0" required autofocus>
            
            <label style="font-size:12px; font-weight:700; display:block; margin-top:15px; color:#64748b">METODE BAYAR</label>
            <select name="metode">
                <option value="cash">💵 TUNAI (CASH)</option>
                <option value="qris">📱 QRIS / GOPAY</option>
            </select>
            
            @if($stok > 0)
                <button type="submit" class="btn-submit">SIMPAN TRANSAKSI</button>
            @else
                <button type="button" class="btn-submit" disabled>STOK HABIS</button>
                <p style="color: #e11d48; font-size: 11px; text-align: center; margin-top: 10px; font-weight: bold;">Isi stok kembali melalui menu pengaturan di atas.</p>
            @endif
        </form>
    </div>

    <div class="card">
        <h3 style="margin:0 0 15px 0">🕒 Riwayat</h3>
        @foreach($data as $d)
        <div class="history-item">
            <div>
                <b style="font-size:14px">{{ $d->produk }}</b>
                <div style="font-size:11px; color:#94a3b8">{{ $d->created_at->format('H:i') }} WIB</div>
            </div>
            <div style="display:flex; align-items:center">
                <div style="text-align:right">
                    <div style="font-weight:800">Rp {{ number_format($d->harga, 0, ',', '.') }}</div>
                    <span class="badge {{ $d->metode }}">{{ strtoupper($d->metode) }}</span>
                </div>
                <form action="/hapus/{{ $d->id }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del">✕</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

@if(session('show_qris'))
<div class="modal" id="qModal">
    <div class="m-card">
        <h3 style="margin:0">Scan QRIS</h3>
        <h2 style="color:var(--primary); margin:10px 0">Rp {{ number_format(session('harga'), 0, ',', '.') }}</h2>
        <img src="{{ asset('img/qris-gopay.jpg') }}" style="width:100%; border-radius:20px; margin-bottom:20px">
        <button onclick="document.getElementById('qModal').style.display='none'" class="btn-submit" style="margin:0">OKE, SUDAH</button>
    </div>
</div>
@endif

<script>
    window.addEventListener('load', () => {
        setTimeout(() => { 
            const s = document.getElementById('splash');
            s.style.opacity = '0';
            setTimeout(() => s.style.display = 'none', 800);
        }, 1500);
    });
</script>

</body>
</html>