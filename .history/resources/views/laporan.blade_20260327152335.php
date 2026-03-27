<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laporan Keuntungan - Bazar App</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4361ee; --secondary: #3f37c9; --bg: #f8fafc; --text: #1e293b; }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            margin: 0; 
            padding-bottom: 40px; 
            color: var(--text); 
        }

        /* Navigasi Sama dengan Dashboard */
        nav { 
            background: white; 
            padding: 15px 20px; 
            display: flex; 
            justify-content: space-around; 
            align-items: center; 
            box-shadow: 0 2px 15px rgba(0,0,0,0.05); 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
            border-bottom: 1px solid #f1f5f9; 
            margin-bottom: 20px;
        }

        .nav-link { 
            text-decoration: none; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            gap: 4px; 
        }

        .container { max-width: 500px; margin: auto; padding: 0 20px; }

        .card { 
            background: white; 
            padding: 20px; 
            border-radius: 25px; 
            margin-bottom: 15px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
            border: 1px solid #edf2f7;
        }

        .laba-title { font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 5px; }
        .laba-amount { color: #166534; font-size: 28px; font-weight: 800; margin-bottom: 15px; }

        .summary-box { 
            display: flex; 
            justify-content: space-between; 
            font-size: 13px; 
            padding-top: 15px; 
            border-top: 1px dashed #e2e8f0; 
        }

        .btn-pdf { 
            background: #e11d48; 
            color: white; 
            border: none; 
            padding: 16px; 
            border-radius: 15px; 
            font-weight: 700; 
            width: 100%; 
            cursor: pointer; 
            text-decoration: none; 
            display: block; 
            text-align: center; 
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.2);
            transition: 0.3s;
        }
        .btn-pdf:active { transform: scale(0.96); }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; font-size: 11px; color: #94a3b8; text-transform: uppercase; padding: 10px 5px; }
        td { padding: 12px 5px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        
        .txt-laba { color: #166534; font-weight: 700; }
        .txt-small { font-size: 11px; color: #94a3b8; display: block; }
    </style>
</head>
<body>

    <nav>
        <a href="/" class="nav-link" style="opacity: 0.5;">
            <span style="font-size: 20px;">🏠</span>
            <span style="font-size: 10px; font-weight: 700; color: var(--text);">KASIR</span>
        </a>
        <a href="/laporan-keuntungan" class="nav-link">
            <span style="font-size: 20px;">📊</span>
            <span style="font-size: 10px; font-weight: 800; color: var(--primary);">LABA</span>
        </a>
    </nav>

    <div class="container">
        
        <div class="card">
            <div class="laba-title">Estimasi Keuntungan Bersih</div>
            <div class="laba-amount">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
            
            <div class="summary-box">
                <div>
                    <span class="txt-small">OMZET</span>
                    <span style="font-weight: 700;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </div>
                <div style="text-align: right;">
                    <span class="txt-small">TOTAL MODAL</span>
                    <span style="font-weight: 700; color: #e11d48;">Rp {{ number_format($totalModal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <a href="/download-pdf" class="btn-pdf">📥 Download Laporan PDF</a>

        <div class="card">
            <h3 style="margin: 0 0 10px 0; font-size: 16px;">Rincian Transaksi</h3>
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Jual</th>
                        <th>Laba</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>
                            <span style="font-weight: 600;">{{ $d->created_at->format('H:i') }}</span>
                            <span class="txt-small">{{ strtoupper($d->metode) }}</span>
                        </td>
                        <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                        <td class="txt-laba">+{{ number_format($d->harga - $d->modal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>