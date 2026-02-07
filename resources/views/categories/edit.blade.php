<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl">

        <form method="POST"
              action="{{ route('categories.update',$category->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Nama</label>
                <input type="text"
                       name="name"
                       class="border rounded w-full p-2"
                       value="{{ old('name',$category->name) }}">
                @error('name')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block">Deskripsi</label>
                <textarea name="description"
                          class="border rounded w-full p-2">{{ old('description',$category->description) }}</textarea>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>

            <a href="{{ route('categories.index') }}"
               class="ml-2 text-gray-600">
               Batal
            </a>

        </form>

    </div>
</x-app-layout>
