<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Stok - Bazar App</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #4361ee; --bg: #f8fafc; --text: #1e293b; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); margin: 0; padding-bottom: 80px; }
        nav { background: white; padding: 15px 20px; display: flex; justify-content: space-around; box-shadow: 0 2px 15px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; border-bottom: 1px solid #f1f5f9; margin-bottom: 25px; }
        .container { max-width: 500px; margin: auto; padding: 0 20px; }
        .card { background: white; padding: 30px; border-radius: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; }
        input { width: 100%; padding: 15px; border-radius: 15px; border: 2px solid #e2e8f0; font-size: 20px; text-align: center; margin: 20px 0; font-family: inherit; font-weight: 800; color: var(--primary); }
        .btn-save { background: var(--primary); color: white; border: none; padding: 16px; width: 100%; border-radius: 15px; font-weight: 700; font-size: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3); }
    </style>
</head>
<body>
    <nav>
        <a href="/" style="text-decoration: none; opacity: 0.5;">🏠 <span style="font-size: 10px; font-weight: 800; display: block; color: var(--text);">KASIR</span></a>
        <a href="/stok" style="text-decoration: none;">📦 <span style="font-size: 10px; font-weight: 800; display: block; color: var(--primary);">STOK</span></a>
        <a href="/laporan-keuntungan" style="text-decoration: none; opacity: 0.5;">📊 <span style="font-size: 10px; font-weight: 800; display: block; color: var(--text);">LABA</span></a>
    </nav>

    <div class="container">
        <div class="card">
            <span style="font-size: 50px;">📦</span>
            <h2 style="margin: 10px 0;">Update Stok</h2>
            <p style="color: #64748b; font-size: 14px;">Masukkan jumlah porsi salad yang tersedia saat ini.</p>
            <form action="/update-stok" method="POST">
                @csrf
                <input type="number" name="stok" value="{{ $stok }}" autofocus>
                <button type="submit" class="btn-save">SIMPAN PERUBAHAN</button>
            </form>
        </div>
    </div>
</body>
</html>