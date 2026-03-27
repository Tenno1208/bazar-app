<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Api\TransaksiController;

Route::get('/transaksi', [TransaksiController::class,'index']);
Route::post('/transaksi', [TransaksiController::class,'store']);
Route::get('/laporan', [TransaksiController::class,'laporan']);
