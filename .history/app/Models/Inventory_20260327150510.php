<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan kolom diisi otomatis
    protected $fillable = ['nama_produk', 'stok'];
}