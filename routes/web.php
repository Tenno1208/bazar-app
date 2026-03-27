<?php

use App\Http\Controllers\Api\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/transaksi', [TransaksiController::class,'index']);
Route::post('/transaksi', [TransaksiController::class,'store']);
Route::get('/laporan', [TransaksiController::class,'laporan']);

Route::get('/', [TransaksiController::class, 'index']);
Route::post('/tambah', [TransaksiController::class, 'store']);
Route::get('/stok', [TransaksiController::class, 'halamanStok']);
Route::post('/update-stok', [TransaksiController::class, 'updateStok']);
Route::get('/laporan-keuntungan', [TransaksiController::class, 'halamanLaporan']);
Route::get('/download-pdf', [TransaksiController::class, 'downloadPDF']);
Route::delete('/hapus/{id}', [TransaksiController::class, 'destroy']);