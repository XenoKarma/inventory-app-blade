@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="max-w-3xl space-y-6">

<div>
    <h2 class="font-semibold text-2xl text-gray-800">
        Edit Product
    </h2>
    <p class="text-sm text-gray-500">
        Perbarui data product
    </p>
</div>

<div class="bg-white p-8 rounded-2xl shadow">

<form method="POST"
      action="{{ route('products.update',$product->id) }}"
      class="space-y-6">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

{{-- NAMA --}}
<div class="md:col-span-2">
<label class="font-semibold text-sm">Nama</label>
<input type="text" name="name"
value="{{ old('name',$product->name) }}"
class="w-full border rounded-lg p-3">
</div>

{{-- SKU --}}
<div>
<label class="font-semibold text-sm">SKU</label>
<input type="text" name="sku"
value="{{ old('sku',$product->sku) }}"
class="w-full border rounded-lg p-3">
</div>

{{-- KATEGORI --}}
<div>
<label class="font-semibold text-sm">Kategori</label>
<select name="product_category_id"
class="w-full border rounded-lg p-3">
@foreach($categories as $c)
<option value="{{ $c->id }}"
{{ $product->product_category_id==$c->id?'selected':'' }}>
{{ $c->name }}
</option>
@endforeach
</select>
</div>

{{-- HARGA --}}
<div>
<label class="font-semibold text-sm">Harga</label>

<input type="text" id="price_display"
class="w-full border rounded-lg p-3">

<input type="hidden"
name="price"
id="price_real"
value="{{ old('price', $product->price) }}">

</div>

{{-- STOK --}}
<div>
<label class="font-semibold text-sm">Stok</label>
<input type="number"
name="current_stock"
value="{{ old('current_stock',$product->current_stock) }}"
class="w-full border rounded-lg p-3">
</div>

{{-- MIN STOK --}}
<div>
<label class="font-semibold text-sm">Min Stok</label>
<input type="number"
name="min_stock"
value="{{ old('min_stock',$product->min_stock) }}"
class="w-full border rounded-lg p-3">
</div>

</div>

<div class="pt-6 border-t flex gap-3">

<button class="bg-blue-600 text-white px-6 py-3 rounded-lg">
Update Product
</button>

<a href="{{ route('products.index') }}"
class="text-gray-600">
Batal
</a>

</div>

</form>
</div>
</div>


<script>
function formatRupiah(n) {
    return n.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

const real = document.getElementById('price_real');
const display = document.getElementById('price_display');

if (real.value) {
    display.value = 'Rp ' + formatRupiah(real.value);
}

display.addEventListener('input', function () {
    let raw = this.value.replace(/\D/g, '');
    real.value = raw;
    display.value = raw ? 'Rp ' + formatRupiah(raw) : '';
});
</script>


@endsection
