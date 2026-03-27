<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
{
    $data = Transaksi::latest()->get();
    $total = Transaksi::sum('harga');

    return view('dashboard', compact('data','total'));
}

// Di TransaksiController.php bagian store
public function store(Request $request)
{
    $transaksi = Transaksi::create([
        'produk' => $request->produk,
        'harga' => $request->harga,
        'metode' => $request->metode,
    ]);

    // Jika metode QRIS, kirim pesan sukses khusus
    if ($request->metode == 'qris') {
        return redirect('/')->with('show_qris', true)->with('harga', $request->harga);
    }

    return redirect('/');
}

    public function laporan()
    {
        $total = Transaksi::sum('harga');

        return response()->json([
            'total' => $total,
            'jumlah_transaksi' => Transaksi::count()
        ]);
    }
}
