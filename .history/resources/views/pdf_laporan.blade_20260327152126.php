<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bazar Salad</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 20px; text-align: right; }
        .total { font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PENJUALAN BAZAR</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Produk</th>
                <th>Modal</th>
                <th>Harga Jual</th>
                <th>Laba</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotalJual = 0; 
                $grandTotalModal = 0;
            @endphp
            @foreach($data as $index => $d)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $d->created_at->format('H:i') }}</td>
                <td>{{ $d->produk }}</td>
                <td>Rp {{ number_format($d->modal) }}</td>
                <td>Rp {{ number_format($d->harga) }}</td>
                <td>Rp {{ number_format($d->harga - $d->modal) }}</td>
                <td>{{ strtoupper($d->metode) }}</td>
            </tr>
            @php 
                $grandTotalJual += $d->harga;
                $grandTotalModal += $d->modal;
            @endphp
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Total Omzet: <strong>Rp {{ number_format($grandTotalJual) }}</strong></p>
        <p>Total Modal: <strong>Rp {{ number_format($grandTotalModal) }}</strong></p>
        <p class="total">Total Keuntungan Bersih: Rp {{ number_format($grandTotalJual - $grandTotalModal) }}</p>
    </div>
</body>
</html>