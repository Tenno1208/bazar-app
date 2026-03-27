<h1>Bazar Salad</h1>

<p>Total: {{ $total }}</p>

<form action="/tambah" method="POST">
@csrf
<input name="harga" placeholder="Harga">
<select name="metode">
  <option value="qris">QRIS</option>
  <option value="cash">Cash</option>
</select>
<button type="submit">Simpan</button>
</form>

<table>
@foreach($data as $d)
<tr>
<td>{{ $d->harga }}</td>
<td>{{ $d->metode }}</td>
</tr>
@endforeach
</table>