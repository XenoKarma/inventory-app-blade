@extends('layouts.app')

@section('title', 'Tambah Product')

@section('content')

<div class="max-w-3xl space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="font-semibold text-2xl text-gray-800">
            Tambah Product
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Tambahkan data produk baru ke sistem inventory
        </p>
    </div>

    {{-- Global Error --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-lg">
            <div class="font-semibold mb-1">Terjadi kesalahan:</div>
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Card Form --}}
    <div class="bg-white p-8 rounded-2xl shadow">

        <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
            @csrf

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Nama --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-1">
                        Nama Product <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Contoh: Laptop Lenovo Thinkpad"
                           class="w-full border rounded-lg p-3
                           focus:ring-2 focus:ring-gray-900 focus:outline-none
                           @error('name') border-red-500 @enderror">

                    @error('name')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                {{-- SKU --}}
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        SKU
                    </label>

                    <input type="text"
                           name="sku"
                           value="{{ old('sku') }}"
                           placeholder="Kosongkan untuk auto generate"
                           class="w-full border rounded-lg p-3
                           focus:ring-2 focus:ring-gray-900 focus:outline-none">

                    <div class="text-xs text-gray-400 mt-1">
                        Jika kosong, sistem akan membuat otomatis
                    </div>
                </div>


                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>

                    <select name="product_category_id"
                        class="w-full border rounded-lg p-3
                        focus:ring-2 focus:ring-gray-900 focus:outline-none
                        @error('product_category_id') border-red-500 @enderror">

                        <option value="">-- pilih kategori --</option>

                        @foreach($categories as $c)
                            <option value="{{ $c->id }}"
                                {{ old('product_category_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('product_category_id')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Harga <span class="text-red-500">*</span>
                    </label>

                    {{-- tampilan rupiah --}}
                    <input type="text"
                        id="price_display"
                        placeholder="Rp 0"
                        class="w-full border rounded-lg p-3
                        focus:ring-2 focus:ring-gray-900 focus:outline-none
                        @error('price') border-red-500 @enderror">

                    {{-- nilai asli --}}
                    <input type="hidden"
                        name="price"
                        id="price_real"
                        value="{{ old('price') }}">

                    @error('price')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Stok Awal --}}
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Stok Awal
                    </label>

                    <input type="number"
                           name="current_stock"
                           value="{{ old('current_stock',0) }}"
                           class="w-full border rounded-lg p-3
                           focus:ring-2 focus:ring-gray-900 focus:outline-none">
                </div>


                {{-- Minimum Stok --}}
                <div>
                    <label class="block text-sm font-semibold mb-1">
                        Minimum Stok
                    </label>

                    <input type="number"
                           name="min_stock"
                           value="{{ old('min_stock',5) }}"
                           class="w-full border rounded-lg p-3
                           focus:ring-2 focus:ring-gray-900 focus:outline-none">

                    <div class="text-xs text-gray-400 mt-1">
                        Akan ditandai merah jika stok di bawah nilai ini
                    </div>
                </div>

            </div>


            {{-- ACTIONS --}}
            <div class="flex items-center gap-4 pt-6 border-t">

                <button class="bg-green-600 text-white px-6 py-3 rounded-lg
                               hover:bg-green-700 transition font-semibold shadow">
                    💾 Simpan Product
                </button>

                <a href="{{ route('products.index') }}"
                   class="px-4 py-3 text-gray-600 hover:text-black">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

<script>
function formatRupiah(angka) {
    let number_string = angka.replace(/[^,\d]/g, '').toString();
    let split = number_string.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    return 'Rp ' + rupiah;
}

const display = document.getElementById('price_display');
const real = document.getElementById('price_real');

display.addEventListener('input', function() {
    let raw = this.value.replace(/[^0-9]/g, '');
    real.value = raw;
    this.value = raw ? formatRupiah(raw) : '';
});


// preload nilai dari database
if (real.value) {
    display.value = formatRupiah(real.value);
}
</script>

@endsection
