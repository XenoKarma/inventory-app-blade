<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Products
        </h2>
    </x-slot>

    <div class="p-6">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
           + Tambah Product
        </a>

        <table class="mt-4 w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">SKU</th>
                    <th class="p-2 border">Kategori</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Stok</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td class="p-2 border">{{ $p->name }}</td>
                    <td class="p-2 border">{{ $p->sku }}</td>
                    <td class="p-2 border">
                        {{ $p->category->name ?? '-' }}
                    </td>
                    <td class="p-2 border">
                        Rp {{ number_format($p->price) }}
                    </td>
                    <td class="p-2 border {{ $p->current_stock < $p->min_stock ? 'bg-red-300 font-bold' : '' }}">
                        {{ $p->current_stock }}
                    </td>
                    <td class="p-2 border space-x-2">
                    <!-- FORM TAMBAH STOK -->
                    <form method="POST"
                        action="{{ route('products.addStock',$p->id) }}"
                        class="inline">
                        @csrf
                        <input type="number" name="qty"
                            placeholder="qty"
                            class="border w-16 p-1" required>
                        <input type="text" name="reason"
                            placeholder="alasan"
                            class="border p-1" required>

                        <button class="bg-green-600 text-white px-2 py-1 rounded">
                            +Stok
                        </button>
                    </form>

                    <!-- FORM KURANG STOK -->
                    <form method="POST"
                        action="{{ route('products.reduceStock',$p->id) }}"
                        class="inline">
                        @csrf
                        <input type="number" name="qty"
                            placeholder="qty"
                            class="border w-16 p-1" required>
                        <input type="text" name="reason"
                            placeholder="alasan"
                            class="border p-1" required>

                        <button class="bg-red-600 text-white px-2 py-1 rounded">
                            -Stok
                        </button>
                    </form>

                </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
