@extends('layouts.app')

@section('title', 'Product Categories')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">
                Product Categories
            </h2>
            <p class="text-sm text-gray-500">
                Kelola data kategori produk
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="bg-gray-900 text-white px-4 py-2 rounded-lg
                  hover:bg-black transition">
           + Tambah Kategori
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left w-48">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($categories as $cat)
                <tr class="hover:bg-gray-50">

                    <td class="p-3 font-medium">
                        {{ $cat->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $cat->description }}
                    </td>

                    <td class="p-3">

                        <div class="flex items-center gap-2">

                            <a href="{{ route('categories.edit',$cat->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded-lg
                                      hover:bg-yellow-600 transition text-xs">
                               Edit
                            </a>

                            <form action="{{ route('categories.destroy',$cat->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Hapus kategori ini?')"
                                    class="bg-red-600 text-white px-3 py-1 rounded-lg
                                           hover:bg-red-700 transition text-xs">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="3" class="p-6 text-center text-gray-500">
                        Belum ada kategori
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
