<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Product Categories
        </h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
           + Tambah Kategori
        </a>

        <table class="mt-4 w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Deskripsi</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td class="p-2 border">{{ $cat->name }}</td>
                    <td class="p-2 border">{{ $cat->description }}</td>
                    <td class="p-2 border space-x-2">
                        <a href="{{ route('categories.edit',$cat->id) }}"
                           class="bg-yellow-500 text-white px-2 py-1 rounded">
                           Edit
                        </a>

                        <form action="{{ route('categories.destroy',$cat->id) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-2 py-1 rounded"
                                    onclick="return confirm('Hapus?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
