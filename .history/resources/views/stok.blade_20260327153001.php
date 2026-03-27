public function halamanStok() {
    $inventory = Inventory::firstOrCreate(['nama_produk' => 'Salad Buah']);
    $stok = $inventory->stok;
    return view('stok', compact('stok'));
}