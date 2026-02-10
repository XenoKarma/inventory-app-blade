@extends('layouts.app')

@section('title', 'Products Archived')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-white p-6 rounded-2xl shadow flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800">
                🗄️ Products Archived
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Daftar produk yang sedang diarsipkan (tidak aktif)
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg
                  hover:bg-blue-700 transition shadow">
           ← Kembali ke Products
        </a>
    </div>


    {{-- Info Bar --}}
    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-sm">
        Produk yang diarsipkan tidak tampil di daftar utama, namun masih tersimpan di database dan bisa di-restore kapan saja.
    </div>


    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-4 border-b bg-gray-50 text-sm text-gray-600">
            Total archived: <span class="font-semibold">{{ $products->count() }}</span>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-3 border text-left">Nama Product</th>
                        <th class="p-3 border text-left">SKU</th>
                        <th class="p-3 border text-left">Kategori</th>
                        <th class="p-3 border text-center w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($products as $p)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="p-3 border font-medium text-gray-800">
                            {{ $p->name }}
                            <div class="text-xs text-gray-400">
                                Status: Archived
                            </div>
                        </td>

                        <td class="p-3 border font-mono text-gray-700">
                            {{ $p->sku }}
                        </td>

                        <td class="p-3 border">
                            <span class="px-2 py-1 rounded-md bg-gray-100 text-gray-700 text-xs">
                                {{ $p->category->name ?? '-' }}
                            </span>
                        </td>

                        <td class="p-3 border text-center">

                            <form method="POST"
                                  action="{{ route('products.restore',$p->id) }}">
                                @csrf
                                <button class="inline-flex items-center gap-2
                                               bg-green-600 text-white px-4 py-2 rounded-lg
                                               hover:bg-green-700 transition shadow text-sm">
                                    ♻️ Restore
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="p-10 text-center">

                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <div class="text-4xl">📦</div>
                                <div class="font-medium text-gray-500">
                                    Tidak ada product yang diarsipkan
                                </div>
                                <div class="text-sm">
                                    Semua product masih aktif
                                </div>
                            </div>

                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
