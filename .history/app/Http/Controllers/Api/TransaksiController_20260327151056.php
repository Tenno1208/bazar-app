<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Inventory;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
{
    $data = Transaksi::latest()->get();
    $total = Transaksi::sum('harga');
    $countQris = Transaksi::where('metode', 'qris')->count();
    $countCash = Transaksi::where('metode', 'cash')->count(); 
    
    
    $inventory = Inventory::firstOrCreate(['nama_produk' => 'Salad Buah']);
    $stok = $inventory->stok;

    return view('dashboard', compact('data', 'total', 'countQris', 'countCash', 'stok'));
}

    public function store(Request $request)
    {
        $inventory = Inventory::where('nama_produk', 'Salad Buah')->first();
    
        if ($inventory->stok <= 0) {
            return redirect('/')->with('error', 'Maaf, Stok Habis!');
        }    

        $request->validate([
            'harga' => 'required|numeric',
        ]);

        $transaksi = Transaksi::create([
            'produk' => $request->produk,
            'harga' => $request->harga,
            'metode' => $request->metode,
        ]);

        $inventory->decrement('stok');

        if ($request->metode == 'qris') {
            return redirect('/')->with('show_qris', true)->with('harga', $request->harga);
        }

        return redirect('/')->with('success', 'Transaksi Berhasil!');
    }

    public function updateStok(Request $request)
{
    $inventory = Inventory::where('nama_produk', 'Salad Buah')->first();
    $inventory->update(['stok' => $request->stok]);
    return redirect('/');
}

    public function destroy($id)
    {
        Transaksi::destroy($id);
        return redirect('/')->with('success', 'Transaksi berhasil dihapus');
    }

    // Fungsi laporan tetap ada jika Anda ingin akses via API/JSON
    public function laporan()
    {
        return response()->json([
            'total' => Transaksi::sum('harga'),
            'jumlah_transaksi' => Transaksi::count(),
            'qris_count' => Transaksi::where('metode', 'qris')->count()
        ]);
    }
}