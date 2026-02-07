@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

<div class="max-w-xl space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Kategori
        </h2>
        <p class="text-sm text-gray-500">
            Perbarui data kategori produk
        </p>
    </div>

    {{-- Card Form --}}
    <div class="bg-white p-6 rounded-xl shadow">

        <form method="POST"
              action="{{ route('categories.update',$category->id) }}"
              class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block mb-1 font-medium">
                    Nama
                </label>

                <input type="text"
                       name="name"
                       class="border rounded-lg w-full p-2
                              focus:ring-2 focus:ring-gray-900 focus:outline-none"
                       value="{{ old('name',$category->name) }}">

                @error('name')
                    <div class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block mb-1 font-medium">
                    Deskripsi
                </label>

                <textarea name="description"
                          rows="4"
                          class="border rounded-lg w-full p-2
                                 focus:ring-2 focus:ring-gray-900 focus:outline-none">{{ old('description',$category->description) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-4">

                <button class="bg-blue-600 text-white px-5 py-2 rounded-lg
                               hover:bg-blue-700 transition">
                    Update
                </button>

                <a href="{{ route('categories.index') }}"
                   class="text-gray-600 hover:text-black">
                   Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
