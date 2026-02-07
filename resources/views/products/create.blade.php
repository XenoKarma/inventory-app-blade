<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Product
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl">

        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <div class="mb-4">
                <label>Nama</label>
                <input type="text" name="name"
                       class="border rounded w-full p-2"
                       value="{{ old('name') }}">
                @error('name')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label>SKU (boleh kosong → auto generate)</label>
                <input type="text" name="sku"
                       class="border rounded w-full p-2"
                       value="{{ old('sku') }}">
            </div>

            <div class="mb-4">
                <label>Kategori</label>
                <select name="product_category_id"
                        class="border rounded w-full p-2">
                    <option value="">-- pilih --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label>Harga</label>
                <input type="number" name="price"
                       class="border rounded w-full p-2"
                       value="{{ old('price') }}">
            </div>

            <div class="mb-4">
                <label>Stok Awal</label>
                <input type="number" name="current_stock"
                       class="border rounded w-full p-2"
                       value="{{ old('current_stock',0) }}">
            </div>

            <div class="mb-4">
                <label>Minimum Stok</label>
                <input type="number" name="min_stock"
                       class="border rounded w-full p-2"
                       value="{{ old('min_stock',5) }}">
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Simpan
            </button>

            <a href="{{ route('products.index') }}"
               class="ml-2 text-gray-600">
               Batal
            </a>

        </form>

    </div>
</x-app-layout>
