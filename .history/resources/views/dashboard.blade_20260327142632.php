<!DOCTYPE html>
<html>
<head>
    <title>Bazar Salad</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: #2c7be5;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background: #2c7be5;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background: #1a5edb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="card">
        <h1>Bazar Salad</h1>
        <p class="total">Total: Rp {{ number_format($total) }}</p>
    </div>

    <div class="card">
        <h2>Tambah Transaksi</h2>

        <form action="/tambah" method="POST">
            @csrf

            <input type="hidden" name="produk" value="Salad Buah">

            <input name="harga" placeholder="Masukkan harga">

            <select name="metode">
                <option value="qris">QRIS</option>
                <option value="cash">Cash</option>
            </select>

            <button type="submit">Simpan</button>
        </form>
    </div>

    <div class="card">
        <h2>Riwayat Transaksi</h2>

        <table>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Metode</th>
            </tr>

            @foreach($data as $d)
            <tr>
                <td>{{ $d->produk }}</td>
                <td>Rp {{ number_format($d->harga) }}</td>
                <td>{{ strtoupper($d->metode) }}</td>
            </tr>
            @endforeach
        </table>
    </div>

</div>

</body>
</html>