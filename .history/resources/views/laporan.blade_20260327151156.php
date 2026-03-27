<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuntungan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; padding: 20px; }
        .card { background: white; padding: 20px; border-radius: 20px; margin-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .laba { color: #166534; font-size: 24px; font-weight: 800; }
        .btn-pdf { background: #e11d48; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; width: 100%; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 12px; }
        th, td { border-bottom: 1px solid #eee; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <a href="/" style="text-decoration: none; color: #4361ee; font-weight: 700;">← Kembali ke Kasir</a>
    
    <div class="card" style="margin-top: 20px;">
        <small>Total Keuntungan Bersih (Laba)</small>
        <div class="laba">Rp {{ number_format($totalLaba, 0, ',', '.') }}</div>
        <hr>
        <div style="display: flex; justify-content: space-between; font-size: 13px;">
            <span>Omzet: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            <span>Total Modal: Rp {{ number_format($totalModal, 0, ',', '.') }}</span>
        </div>
    </div>

    <a href="/download-pdf" class="btn-pdf">📥 Download Laporan PDF</a>

    <div class="card">
        <h3>Detail Per Transaksi</h3>
        <table>
            <tr>
                <th>Jam</th>
                <th>Jual</th>
                <th>Modal</th>
                <th>Laba</th>
            </tr>
            @foreach($data as $d)
            <tr>
                <td>{{ $d->created_at->format('H:i') }}</td>
                <td>{{ number_format($d->harga) }}</td>
                <td>{{ number_format($d->modal) }}</td>
                <td style="color: green; font-weight: 700;">{{ number_format($d->harga - $d->modal) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>
</html>