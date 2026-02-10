@extends('layouts.app')

@section('title', 'Products')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800">
            Products
        </h2>

        <a href="{{ route('products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Product
        </a>
    </div>


    {{-- ================= SUCCESS MESSAGE ================= --}}
    @if(session('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    {{-- ================= TOP BAR ================= --}}
    <div class="bg-white p-4 rounded-xl shadow flex flex-wrap items-center justify-between gap-3">

        <div class="text-sm text-gray-600">
            Menampilkan
            {{ $products->firstItem() ?? 0 }}
            -
            {{ $products->lastItem() ?? 0 }}
            dari {{ $products->total() }} data
        </div>

        <form method="GET" class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Per halaman:</span>

            <div class="relative">
                <select name="per_page"
                        onchange="this.form.submit()"
                        class="border rounded-lg px-3 pr-8 py-1 text-sm bg-white appearance-none">
                    @foreach([10,20,30,40,50] as $n)
                        <option value="{{ $n }}"
                            {{ request('per_page',10)==$n ? 'selected' : '' }}>
                            {{ $n }}
                        </option>
                    @endforeach
                </select>

                <div class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                    ▼
                </div>
            </div>
        </form>

    </div>


    {{-- ================= FILTER ================= --}}
    <form method="GET"
          class="bg-white p-4 rounded-xl shadow flex flex-wrap gap-3 items-end">

        <div>
            <label class="text-xs text-gray-500">Search</label>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="nama / SKU"
                   class="border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="text-xs text-gray-500">Kategori</label>
            <select name="category" class="border rounded px-3 py-2 text-sm">
                <option value="">Semua</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}"
                        {{ request('category')==$c->id ? 'selected':'' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="bg-gray-800 text-white px-4 py-2 rounded">
            Filter
        </button>

    </form>


    {{-- ================= BULK DELETE FORM (HIDDEN) ================= --}}
    <form id="bulkDeleteForm" method="POST" action="{{ route('products.bulkDelete') }}">
        @csrf
        @method('DELETE')
    </form>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border text-center w-10">
                        <input type="checkbox" id="checkAll">
                    </th>

                    <th class="p-3 border text-center w-16">No</th>

                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">SKU</th>
                    <th class="p-3 border">Kategori</th>
                    <th class="p-3 border">Price</th>
                    <th class="p-3 border">Stock</th>
                    <th class="p-3 border">Edit</th>
                    <th class="p-3 border w-96">Aksi</th>
                </tr>
                </thead>


                <tbody>
                @forelse($products as $p)

                <tr class="hover:bg-gray-50 align-top">

                    <td class="p-3 border text-center">
                        <input type="checkbox" value="{{ $p->id }}" class="rowCheck">
                    </td>

                    <td class="p-3 border text-center font-semibold text-gray-600">
                        {{ $products->firstItem() + $loop->index }}
                    </td>

                    <td class="p-3 border font-medium">
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

                    <td class="p-3 border
                        {{ $p->current_stock < $p->min_stock
                            ? 'bg-red-200 font-bold text-red-800'
                            : '' }}">
                        {{ $p->current_stock }}
                        <div class="text-xs text-gray-400">
                            Min: {{ $p->min_stock }}
                        </div>
                    </td>
                    <td class="p-3 border">
                        <a href="{{ route('products.edit', $p->id) }}"
                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Edit
                        </a>
                    </td>


                    {{-- ================= ACTION ================= --}}
                    <td class="p-3 border space-y-2">

                        {{-- TAMBAH STOK --}}
                        <form method="POST"
                              action="{{ route('products.addStock',$p->id) }}"
                              class="flex flex-wrap gap-2 items-center">
                            @csrf
                            <input type="number" name="qty" required
                                   class="border rounded px-2 py-1 w-20"
                                   placeholder="qty">

                            <input type="text" name="reason" required
                                   class="border rounded px-2 py-1"
                                   placeholder="alasan">

                            <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                +Stok
                            </button>
                        </form>


                        {{-- KURANG STOK --}}
                        <form method="POST"
                              action="{{ route('products.reduceStock',$p->id) }}"
                              class="flex flex-wrap gap-2 items-center">
                            @csrf
                            <input type="number" name="qty" required
                                   class="border rounded px-2 py-1 w-20"
                                   placeholder="qty">

                            <input type="text" name="reason" required
                                   class="border rounded px-2 py-1"
                                   placeholder="alasan">

                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                -Stok
                            </button>
                        </form>


                        {{-- ARSIP --}}
                        <form method="POST"
                              action="{{ route('products.archive',$p->id) }}">
                            @csrf
                            <button class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800">
                                Arsip
                            </button>
                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="8" class="p-6 text-center text-gray-400">
                        Tidak ada data produk
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>


        {{-- ================= FOOTER ================= --}}
        <div class="p-4 border-t bg-gray-50 flex items-center justify-between">

            <button type="button"
                onclick="submitBulkDelete()"
                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Hapus Terpilih
            </button>

            {{ $products->appends(request()->query())->links() }}
        </div>

    </div>

</div>


{{-- ================= SCRIPT ================= --}}
<script>
document.getElementById('checkAll').addEventListener('click', function () {
    document.querySelectorAll('.rowCheck').forEach(cb => {
        cb.checked = this.checked;
    });
});

function submitBulkDelete() {
    let checked = document.querySelectorAll('.rowCheck:checked');

    if (checked.length === 0) {
        alert('Pilih produk dulu');
        return;
    }

    if (!confirm('Hapus produk terpilih?')) return;

    let form = document.getElementById('bulkDeleteForm');

    form.querySelectorAll('input[name="ids[]"]').forEach(e => e.remove());

    checked.forEach(cb => {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        form.appendChild(input);
    });

    form.submit();
}
</script>

@endsection
