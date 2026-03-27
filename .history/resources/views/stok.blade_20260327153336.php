<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Stok - Bazar App</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { 
            --primary: #4361ee; 
            --bg: #f8fafc; 
            --text: #1e293b; 
            --card-bg: #ffffff;
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: var(--bg); 
            margin: 0; 
            padding-bottom: 40px; 
            color: var(--text);
        }

        /* Navbar Konsisten */
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
            margin-bottom: 25px;
        }

        nav a { text-decoration: none; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 4px; }
        nav .nav-label { font-size: 10px; font-weight: 800; display: block; color: #64748b; }
        nav a.active .nav-label { color: var(--primary); }

        .container { max-width: 500px; margin: auto; padding: 0 20px; }

        /* Card Utama */
        .card { 
            background: var(--card-bg); 
            padding: 30px 20px; 
            border-radius: 30px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.03); 
            text-align: center; 
            border: 1px solid #edf2f7;
        }

        .icon-circle {
            width: 80px; height: 80px; background: #eef2ff;
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; margin: 0 auto 20px; font-size: 40px;
        }

        h2 { margin: 0; font-weight: 800; color: var(--text); }
        p { color: #64748b; font-size: 14px; margin: 10px 0 25px; }

        /* Input Styling */
        .input-group { position: relative; margin-bottom: 20px; }
        input[type="number"] { 
            width: 100%; padding: 20px; border-radius: 20px; 
            border: 2px solid #e2e8f0; font-size: 32px; text-align: center; 
            font-family: inherit; font-weight: 800; color: var(--primary); 
            background: #f8fafc; transition: 0.3s;
        }
        input:focus { outline: none; border-color: var(--primary); background: white; }

        /* Tombol Cepat (Quick Add) */
        .quick-add { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 25px; }
        .btn-qty { 
            background: white; border: 1.5px solid #e2e8f0; padding: 12px; 
            border-radius: 15px; font-weight: 700; color: var(--text); 
            cursor: pointer; transition: 0.2s; font-size: 14px;
        }
        .btn-qty:active { transform: scale(0.9); background: #f1f5f9; border-color: var(--primary); }

        /* Action Buttons */
        .btn-save { 
            background: var(--primary); color: white; border: none; 
            padding: 18px; width: 100%; border-radius: 18px; 
            font-weight: 700; font-size: 16px; cursor: pointer; 
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.25); 
            transition: 0.3s;
        }
        .btn-save:active { transform: scale(0.97); }

        .btn-reset {
            margin-top: 15px; background: transparent; border: none;
            color: #ef4444; font-weight: 600; font-size: 13px;
            text-decoration: underline; cursor: pointer; opacity: 0.7;
        }
    </style>
</head>
<body>
    <nav>
        <a href="/">
            <span>🏠</span>
            <span class="nav-label">KASIR</span>
        </a>
        <a href="/stok" class="active">
            <span>📦</span>
            <span class="nav-label" style="color: var(--primary);">STOK</span>
        </a>
        <a href="/laporan-keuntungan" style="opacity: 0.5;">
            <span>📊</span>
            <span class="nav-label">LABA</span>
        </a>
    </nav>

    <div class="container">
        <div class="card">
            <div class="icon-circle">🥗</div>
            <h2>Kelola Persediaan</h2>
            <p>Atur sisa porsi salad yang siap dijual hari ini.</p>

            <form action="/update-stok" method="POST" id="stokForm">
                @csrf
                <div class="input-group">
                    <input type="number" name="stok" id="stokInput" value="{{ $stok }}" required>
                </div>

                <div class="quick-add">
                    <button type="button" class="btn-qty" onclick="addStok(5)">+5</button>
                    <button type="button" class="btn-qty" onclick="addStok(10)">+10</button>
                    <button type="button" class="btn-qty" onclick="addStok(20)">+20</button>
                </div>

                <button type="submit" class="btn-save">SIMPAN STOK SEKARANG</button>
                
                <button type="button" class="btn-reset" onclick="resetStok()">Reset Stok ke 0</button>
            </form>
        </div>
    </div>

    <script>
        const input = document.getElementById('stokInput');

        // Fungsi menambah angka secara instan
        function addStok(val) {
            let currentVal = parseInt(input.value) || 0;
            input.value = currentVal + val;
            
            // Efek visual sedikit saat bertambah
            input.style.transform = 'scale(1.05)';
            setTimeout(() => { input.style.transform = 'scale(1)'; }, 100);
        }

        // Fungsi reset stok
        function resetStok() {
            if(confirm('Yakin ingin mereset stok menjadi nol?')) {
                input.value = 0;
            }
        }
    </script>
</body>
</html>