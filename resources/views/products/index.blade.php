@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800">
            Products
        </h2>

        <a href="{{ route('products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg
                  hover:bg-blue-700 transition">
           + Tambah Product
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    {{-- Table Card --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-3 border text-left">Nama</th>
                        <th class="p-3 border text-left">SKU</th>
                        <th class="p-3 border text-left">Kategori</th>
                        <th class="p-3 border text-left">Harga</th>
                        <th class="p-3 border text-left">Stok</th>
                        <th class="p-3 border text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($products as $p)
                <tr class="hover:bg-gray-50">

                    <td class="p-3 border">
                        {{ $p->name }}
                    </td>

                    <td class="p-3 border">
                        {{ $p->sku }}
                    </td>

                    <td class="p-3 border">
                        {{ $p->category->name ?? '-' }}
                    </td>

                    <td class="p-3 border">
                        Rp {{ number_format($p->price) }}
                    </td>

                    <td class="p-3 border {{ $p->current_stock < $p->min_stock ? 'bg-red-300 font-bold' : '' }}">
                        {{ $p->current_stock }}
                    </td>

                    <td class="p-3 border space-y-2">

                        {{-- FORM TAMBAH STOK --}}
                        <form method="POST"
                              action="{{ route('products.addStock',$p->id) }}"
                              class="flex flex-wrap gap-2 items-center">
                            @csrf
                            <input type="number" name="qty"
                                   placeholder="qty"
                                   class="border rounded px-2 py-1 w-20" required>

                            <input type="text" name="reason"
                                   placeholder="alasan"
                                   class="border rounded px-2 py-1" required>

                            <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                +Stok
                            </button>
                        </form>


                        {{-- FORM KURANG STOK --}}
                        <form method="POST"
                              action="{{ route('products.reduceStock',$p->id) }}"
                              class="flex flex-wrap gap-2 items-center">
                            @csrf
                            <input type="number" name="qty"
                                   placeholder="qty"
                                   class="border rounded px-2 py-1 w-20" required>

                            <input type="text" name="reason"
                                   placeholder="alasan"
                                   class="border rounded px-2 py-1" required>

                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                -Stok
                            </button>
                        </form>


                        {{-- FORM ARSIP --}}
                        <form method="POST"
                              action="{{ route('products.archive',$p->id) }}">
                            @csrf
                            <button class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800">
                                Arsip
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
