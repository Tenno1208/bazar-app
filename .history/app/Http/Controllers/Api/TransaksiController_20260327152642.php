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
    $request->validate([
        'harga' => 'required|numeric',
        'modal' => 'required|numeric', // Tambahkan validasi modal
    ]);

    $inventory = Inventory::where('nama_produk', 'Salad Buah')->first();
    if ($inventory->stok <= 0) {
        return redirect('/')->with('error', 'Stok Habis!');
    }

    Transaksi::create([
        'produk' => $request->produk,
        'modal'  => $request->modal, // Ambil dari input modal
        'harga'  => $request->harga,
        'metode' => $request->metode,
    ]);

    $inventory->decrement('stok');

    if ($request->metode == 'qris') {
        return redirect('/')->with('show_qris', true)->with('harga', $request->harga);
    }

    return redirect('/');
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

    public function halamanLaporan()
{
    $data = Transaksi::latest()->get();
    $totalPendapatan = Transaksi::sum('harga');
    $totalModal = Transaksi::sum('modal');
    $totalLaba = $totalPendapatan - $totalModal;

    return view('laporan', compact('data', 'totalPendapatan', 'totalModal', 'totalLaba'));
}

public function downloadPDF()
{
    // Mengambil data urut dari yang paling awal transaksi
    $data = Transaksi::orderBy('created_at', 'asc')->get();
    
    // Pastikan nama view sesuai
    $pdf = Pdf::loadView('pdf_laporan', compact('data'));
    
    $namaFile = 'laporan-bazar-' . date('d-m-Y-His') . '.pdf';
    
    return $pdf->download($namaFile);
}
}