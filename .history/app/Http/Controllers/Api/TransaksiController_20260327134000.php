<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return Transaksi::latest()->get();
    }

    public function store(Request $request)
    {
        $data = Transaksi::create([
            'produk' => $request->produk,
            'harga' => $request->harga,
            'metode' => $request->metode
        ]);

        return response()->json($data);
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
