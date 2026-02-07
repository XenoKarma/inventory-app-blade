@extends('layouts.app')

@section('title', 'Products Archived')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800">
            Products Archived
        </h2>

        <a href="{{ route('products.index') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg
                  hover:bg-blue-700 transition">
           ← Kembali
        </a>
    </div>


    {{-- Table Card --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-3 border text-left">Nama</th>
                        <th class="p-3 border text-left">SKU</th>
                        <th class="p-3 border text-left">Kategori</th>
                        <th class="p-3 border text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($products as $p)
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

                            <form method="POST"
                                  action="{{ route('products.restore',$p->id) }}">
                                @csrf
                                <button class="bg-green-600 text-white px-4 py-1.5 rounded-lg
                                               hover:bg-green-700 transition">
                                    Restore
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="4"
                            class="p-6 text-center text-gray-400">
                            Tidak ada product yang diarsipkan
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
