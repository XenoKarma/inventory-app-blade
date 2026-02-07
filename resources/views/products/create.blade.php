@extends('layouts.app')

@section('title', 'Tambah Product')

@section('content')

<div class="max-w-xl space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Product
        </h2>
        <p class="text-sm text-gray-500">
            Tambahkan data produk baru ke inventory
        </p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white p-6 rounded-xl shadow">

        <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block mb-1 font-medium">
                    Nama
                </label>
                <input type="text" name="name"
                       class="border rounded-lg w-full p-2 focus:ring-2 focus:ring-gray-900 focus:outline-none"
                       value="{{ old('name') }}">

                @error('name')
                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- SKU --}}
            <div>
                <label class="block mb-1 font-medium">
                    SKU (boleh kosong → auto generate)
                </label>
                <input type="text" name="sku"
                       class="border rounded-lg w-full p-2 focus:ring-2 focus:ring-gray-900 focus:outline-none"
                       value="{{ old('sku') }}">
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block mb-1 font-medium">
                    Kategori
                </label>
                <select name="product_category_id"
                        class="border rounded-lg w-full p-2 focus:ring-2 focus:ring-gray-900 focus:outline-none">
                    <option value="">-- pilih --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Harga --}}
            <div>
                <label class="block mb-1 font-medium">
                    Harga
                </label>
                <input type="number" name="price"
                       class="border rounded-lg w-full p-2 focus:ring-2 focus:ring-gray-900 focus:outline-none"
                       value="{{ old('price') }}">
            </div>

            {{-- Stok Awal --}}
            <div>
                <label class="block mb-1 font-medium">
                    Stok Awal
                </label>
                <input type="number" name="current_stock"
                       class="border rounded-lg w-full p-2 focus:ring-2 focus:ring-gray-900 focus:outline-none"
                       value="{{ old('current_stock',0) }}">
            </div>

            {{-- Minimum Stok --}}
            <div>
                <label class="block mb-1 font-medium">
                    Minimum Stok
                </label>
                <input type="number" name="min_stock"
                       class="border rounded-lg w-full p-2 focus:ring-2 focus:ring-gray-900 focus:outline-none"
                       value="{{ old('min_stock',5) }}">
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-4">

                <button class="bg-green-600 text-white px-5 py-2 rounded-lg
                               hover:bg-green-700 transition">
                    Simpan
                </button>

                <a href="{{ route('products.index') }}"
                   class="text-gray-600 hover:text-black">
                   Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
