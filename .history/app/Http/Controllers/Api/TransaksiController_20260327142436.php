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

public function store(Request $request)
{
   Transaksi::create([
    'produk' => $request->produk,
    'harga' => $request->harga,
    'metode' => $request->metode,
]);
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
